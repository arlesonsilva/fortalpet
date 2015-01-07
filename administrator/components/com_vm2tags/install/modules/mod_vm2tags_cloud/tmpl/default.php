<?php
/**
 * @version		$Id: default.php 
 * @package		Joomla.Site
 * @subpackage	mod_vm2tags_cloud
 * @copyright	Copyright (C) 2005 - 2012 Nordmograph.com, Inc. All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$min_font_size 	= $params->get( 'min_font', '10');
$max_font_size 	= $params->get( 'max_font', '25');
$limit 			= $params->get( 'limit', '50');

$cparams 					= JComponentHelper::getParams('com_vm2tags');
$mode	 					= $cparams->get('mode','1');
$vm2tags_itemid 			= $cparams->get('vm2tags_itemid');
if($vm2tags_itemid=='')
	$vm2tags_itemid = JFactory::getApplication()->input->get->get('Itemid','','int');

$minimum_count = 0;
$maximum_count = 0;
$array = array();
$thelist ='';
if(count($list)>0)
{
	foreach($list as $set_tag)
	{
		$sep_tags = str_replace('product_tags="','',$set_tag->customfield_params);
		$sep_tags = str_replace('"|','',$sep_tags);
		$thelist .= $sep_tags.',';
	}
	$thelist = strtolower($thelist);
	//$thelist = str_replace(' ','',$thelist);
	$thelist = substr($thelist,0,-1);
	$expls = explode(",", $thelist);
	$x = array_count_values($expls);

	foreach ($expls as $expl) //loop through the object and find the highest and lowest values
	{
		if(isset($x[$expl])){
			if ($minimum_count > $x[$expl]) 
				$minimum_count = $x[$expl];
			if ($maximum_count < $x[$expl])
				$maximum_count = $x[$expl];	
		}
	}
	$spread = $maximum_count - $minimum_count; //figure out the difference between the highest and lowest values
	if($spread == 0) 
		$spread = 1;
	$i=0;

	echo '<div class="mod_tagsvm2" >';
	while (list($key, $value) = each($x))
	{
		$i++;
		$size = $min_font_size + ( $value - $minimum_count) * ($max_font_size - $min_font_size) / $spread;
		if ($value>0 && $i <= $limit && $key!=''){
			if($mode==1)
				$tag_url = JRoute::_('index.php?option=com_vm2tags&view=productslist&tag='.$key.'&Itemid='.$vm2tags_itemid  );
			else
				$tag_url = JRoute::_('index.php?searchword='.$key.'&ordering=newest&searchphrase=exact&option=com_search&Itemid='.$vm2tags_itemid  );
			echo ' <a class="vm_tag" href="'.$tag_url.'"><span style="font-size:'. floor($size) .'px" title="'.$value.'">'.$key.'</span></a>';
		}
	}
	echo '</div>';
}
?>