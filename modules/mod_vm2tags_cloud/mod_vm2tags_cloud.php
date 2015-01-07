<?php
/**
 * @version		$Id:mod_vm2tags_cloud.php 
 * @package		Joomla.Site
 * @subpackage	mod_vm2tags_cloud
 * @copyright	Copyright (C) 2010 - 2014 Nordmograph.com, Inc. All rights reserved.
 * @license		GNU General Public License version 3 or later; see LICENSE.txt
 */
// no direct access
defined('_JEXEC') or die;
// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
$list = modVm2tagsCloudHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_vm2tags_cloud', $params->get('layout', 'default'));