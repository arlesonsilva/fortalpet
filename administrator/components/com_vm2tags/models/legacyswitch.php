<?php

/**
 * @version     1.0.0
 * @package     vm2tags
 * @copyright   Copyright (C) 2014. Adrien ROUSSEL Nordmograph.com All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Nordmograph <contact@nordmograph.com> - http://www.nordmograph.com./extensions
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

class Vm2tagsModelLegacyswitch extends JModelList {
	static function countToboconverted()
	{
		$db = JFactory::getDBO();
		$q ="SELECT COUNT( DISTINCT(virtuemart_product_id 	) ) 
		FROM #__virtuemart_product_customfields 
		WHERE customfield_value='vm2tags' AND SUBSTRING(customfield_params,16)='{\"product_tags\":\"' 
		GROUP BYvirtuemart_product_id ";
		$db->setQuery($q);
		$count = $db->loadResult();
		return $count;	
	}

}
