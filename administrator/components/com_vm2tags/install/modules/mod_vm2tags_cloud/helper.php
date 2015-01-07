<?php
/**
 * @package		VM2Tags
 * @subpackage	mod_vm2tags_cloud
 * @copyright	Copyright (C) 2010 - 2014 Nordmograph.com. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;
class modVm2tagsCloudHelper
{		
	static function &getList(&$params)
	{
		$limit 			= $params->get( 'limit', '50');
		$catfilter		= $params->get( 'catfilter', 0);
		$db = JFactory::getDBO();
		$option = JRequest::getVar('option');
		$virtuemart_category_id = '';
		if($option=='com_virtuemart')
		{
			$virtuemart_category_id = JRequest::getVar('virtuemart_category_id'); 
		}
		
		if($catfilter=='2')
		{ // get children cats from current cat.
			$children = array();
			function categoryChild($id)
			{
    			$db = JFactory::getDBO();

				$q ="SELECT `category_child_id` FROM `#__virtuemart_category_categories` 
				WHERE `category_parent_id` ='".$id."'  ";
				$db->setQuery($q);
				$cats = $db->loadObjectList();
				$children = array();
				$children[] =  $id   ;				
				$i = 0;
				if(count($cats) > 0)
				{
					foreach($cats as $cat)
					{
						
						# Add the child to the list of children, and get its subchildren
						//array_push( $children ,  $cat->category_child_id ,  categoryChild( $cat->category_child_id )  );
					# It has children, let's get them.
						$children[] = $cat->category_child_id ;
						$children[] = implode( ',' , categoryChild( $cat->category_child_id ) );						
						$i++;
						}
					}
				$children = implode("," ,$children);
				$children = explode("," ,$children);
				return array_unique($children);
			}
			$traverse = categoryChild( $virtuemart_category_id );
			$traverse = implode("," , $traverse);
		}
		
		
		$q ="SELECT vpcust.`customfield_params` 
		FROM `#__virtuemart_product_customfields` vpcust ";
		
		if($catfilter && $virtuemart_category_id!=''  && $virtuemart_category_id!='0')
		{
			$q .=" JOIN `#__virtuemart_product_categories` vpcat ON vpcat.`virtuemart_product_id` = vpcust.`virtuemart_product_id` ";
		}
		$q .=" JOIN `#__virtuemart_products` vpprod ON vpprod.`virtuemart_product_id` = vpcust.`virtuemart_product_id` ";
		
		$q .="WHERE vpcust.`customfield_value`='vm2tags'  
		AND vpcust.`customfield_params` !=' '
		AND vpcust.`customfield_params` !=''
		";
		$q .=" AND vpprod.published='1' "; 
		if($catfilter==1 && $virtuemart_category_id!='' && $virtuemart_category_id!='0')
		{
			$q .=" AND vpcat.`virtuemart_category_id` = '".$virtuemart_category_id."'  ";
		}
		if($catfilter==2 && $virtuemart_category_id!='' && $virtuemart_category_id!='0')
		{
			$q .=" AND vpcat.`virtuemart_category_id` IN($traverse)  ";
		}
		$q .="ORDER BY RAND() 
		LIMIT ".$limit;
		$db->setQuery($q);
		$rows = $db->loadObjectList();
		return $rows;
	}
}