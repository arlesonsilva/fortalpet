<?php
/**
 * @version     1.0.0
 * @package     com_vm2tags
 * @copyright   Copyright (C) Nordmograph 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Adrien Roussel <contact@nordmograph.com> - http://www.nordmograph.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * XXX_UCFIRST_INTERNAL_NAME_XXX controller class.
 */
class Vm2tagsControllerLegacyswitch extends JControllerLegacy
{	
	function convertTags()
	{
		$db = JFactory::getDBO();
		$q = "SELECT  virtuemart_product_id, customfield_params 
		FROM #__virtuemart_product_customfields 
		WHERE customfield_value='vm2tags' 
		AND SUBSTRING(customfield_params,16)='{\"product_tags\":\"'  ";	
		$db->setQuery($q);
		$products = $db->loadObjectList();
		foreach($products as $product)
		{
			$tags = str_replace('{"product_tags":"','',$product->customfield_params );
			$tags = str_replace('"}','',$tags );
			
			$customfield_params = 'product_tags="'.$tags.'"|';
			
			$q = "UPDATE  #__virtuemart_product_customfields 
			SET customfield_params='".$customfield_params."' 
			WHERE virtuemart_product_id='".$product->virtuemart_product_id."' 7
			AND customfield_value='vm2tags' ";
			$db->setQuery($q);
			if (!$db->query()) die($db->stderr(true));	
		}
	}
}