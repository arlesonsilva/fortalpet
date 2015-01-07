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
/**
 * @param	array	A named array
 * @return	array
 */
function Vm2tagsBuildRoute(&$query)
{
	$segments = array();
	if(isset($query['view']))
	{
		if(empty($query['Itemid'])) {
			$segments[] = $query['Itemid'];
		}
		if($query['view'] == 'productslist' ) {
			$segments[] = $query['view'];
		}
		unset($query['view']);
	}
	if(isset($query['tag']))
	{			
		$segments[] = $query['tag'];	
		//$segments[] = urlencode($query['tag']);	
		unset($query['tag']);
	}
	return $segments;
}

/**
 * @param	array	A named array
 * @param	array
 *
 * Formats:
 *
 * index.php?/vm2tags/task/id/Itemid
 *
 * index.php?/vm2tags/id/Itemid
 */
function Vm2tagsParseRoute($segments)
{
	$vars = array();
	// view is always the first element of the array
	$count = count($segments);
	if ($count)
	{
		if($segments[0] == 'productslist') {
			$vars['view'] = 'productslist';
			$vars['tag'] = $segments[1];
			
			
		}
		
	}
	return $vars;
}