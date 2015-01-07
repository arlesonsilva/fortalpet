<?php

/**
 * @version		$Id: virtuemart.php 2789 2011-02-28 12:41:01Z oscar $
 * @package		Joomla
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters. All rights reserved.
 * @license		GNU/GPL, see LICENSE.php
 * Joomla! is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * See COPYRIGHT.php for copyright notices and details.
 */
// no direct access
defined('_JEXEC') or die('Restricted access');
class plgSearchVm2tagsearch extends JPlugin
{
	/**
	 * @return array An array of search areas
	 */
	function onContentSearchAreas ()
	{
		$this->loadLanguage();
		static $areas = array(
			'vm2tags' => 'Product Tags'
		);
		return $areas;
	}
	

	/**
	 * VM2tags Products Search method
	 *
	 * The sql must return the following fields that are used in a common display
	 * routine: href, title, section, created, text, browsernav
	 * @param string Target search string
	 * @param string mathcing option, exact|any|all
	 * @param string ordering option, newest|oldest|popular|alpha|category
	 */
	function onContentSearch($text, $phrase='', $ordering='', $areas=null)
	{
		$db				= JFactory::getDbo();
		$app			= JFactory::getApplication();
		$user 			= JFactory::getUser();
		$groups			= implode(',', $user->getAuthorisedViewLevels());
		$tag 			= JFactory::getLanguage()->getTag();
		
		$cparams 					= JComponentHelper::getParams('com_vm2tags');
		$vm_itemid	 					= $cparams->get('vm_itemid');
		
		
		$searchText 	= $text;

		if (is_array($areas))
		{
			if (!array_intersect($areas, array_keys($this->onContentSearchAreas())))
			{
				return array();
			}
		}

		$limit 		= $this->params->get('search_limit', 50);
		if (!class_exists( 'VmConfig' ))
			require JPATH_ADMINISTRATOR.'/components/com_virtuemart/helpers/config.php';
		VmConfig::loadConfig();
		$text = trim($text);
		if ($text == '')
		{
			return array();
		}
		$section = JText::_('ProductTags');
		$wheres = array();
		switch ($phrase)
		{
			case 'exact':
				$text = $db->Quote('%' . $db->escape($text, true) . '%', false);
				$wheres2 = array();
				$wheres2[] = 'SUBSTRING(vpc.customfield_params,14) LIKE '.$text  ;
				$where = '(' . implode(') OR (', $wheres2) . ')';
				break;
			case 'all':
			case 'any':
			default:
				$words = explode(' ', $text);
				$wheres = array();
				foreach ($words as $word)
				{
					$word = $db->Quote('%' . $db->escape($word, true) . '%', false);
					$wheres2 = array();
						
					$wheres2[] = 'SUBSTRING(vpc.customfield_params,14) LIKE '.$word  ;
					$wheres[] = implode(' OR ', $wheres2);
				}
				$where = '(' . implode(($phrase == 'all' ? ') AND (' : ') OR ('), $wheres) . ')';
				break;
		}
		switch ($ordering)
		{
			case 'alpha':
				$order = 'a.product_name ASC';
				break;

			case 'category':
				$order = 'b.category_name ASC, a.product_name ASC';
				break;

			case 'popular':
				$order = 'a.product_name ASC';
				break;
			case 'newest':
				$order = 'p.created_on DESC';
				break;
			case 'oldest':
				$order = 'p.created_on ASC';
				break;
			default:
				$order = 'a.product_name DESC';
		}
		//$text = $db->Quote('%' . $db->escape($text, true) . '%', false);
		$q = "SELECT DISTINCT CONCAT( a.product_name,' (',p.product_sku,')' ) AS title,
		a.virtuemart_product_id ,  a.product_s_desc   AS text,
		b.category_name as section, b.virtuemart_category_id ,
		p.created_on as created, '2' AS browsernav , vpc.customfield_params 
		FROM `#__virtuemart_products_".VMLANG."` AS a
		JOIN `#__virtuemart_products` as p using (`virtuemart_product_id`)
		LEFT JOIN `#__virtuemart_product_categories` AS xref ON xref.`virtuemart_product_id` = a.`virtuemart_product_id` 
		LEFT JOIN `#__virtuemart_product_customfields` AS vpc ON vpc.`virtuemart_product_id` =  a.`virtuemart_product_id` 
		LEFT JOIN `#__virtuemart_categories_".VMLANG."` AS b ON b.`virtuemart_category_id` = xref.`virtuemart_category_id`
		WHERE " . $where . " and p.published=1 and b.virtuemart_category_id>0
		GROUP BY a.virtuemart_product_id 
		ORDER BY " . $order ;
		$db->setQuery($q, 0, $limit);

		$rows = $db->loadObjectList();
		if ($rows)
		{
			foreach ($rows as $key => $row)
			{
				$rows[$key]->href = 'index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $row->virtuemart_product_id . '&virtuemart_category_id=' . $row->virtuemart_category_id.'&Itemid='.$vm_itemid;
					// $rows[$key]->text = $text;
			}
		}
		return $rows;
	}
}