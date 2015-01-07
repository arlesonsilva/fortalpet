<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_footer
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// no direct access
defined('_JEXEC') or die;
$app		= JFactory::getApplication();
$date		= JFactory::getDate();
$cur_year	= $date->format('Y');
$csite_names	= '<span>'.$app->getCfg('sitename').'</span>';

if (is_int(JString::strpos(JText :: _('MOD_FOOTER_LINE1'), '%date%'))) {
	$line1 = str_replace('%date%', $cur_year, JText :: _('MOD_FOOTER_LINE1'));
}
else {
	$line1 = JText :: _('MOD_FOOTER_LINE1');
}

if (is_int(JString::strpos($line1, '%sitename%'))) {
	$lineones = str_replace('%sitename%', $csite_names, $line1);
}
else {
	$lineones = $line1;
}

$csite_name	= '<span>'.$app->getCfg('sitename').'</span>';

?>
<div class="module">
	<small><?php echo $lineones; ?> Designed by <a href="http://www.joomlart.com/" title="Visit Joomlart.com!" <?php echo method_exists('T3', 'isHome') && T3::isHome() ? '' : 'rel="nofollow"' ?>>JoomlArt.com</a>.</small>
</div>