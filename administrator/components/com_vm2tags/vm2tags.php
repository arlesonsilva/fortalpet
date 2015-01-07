<?php
/**
 * @version     1.0.0
 * @package     com_vm2tags
 * @copyright   Copyright (C) Nordmograph 2012. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Adrien Roussel <contact@nordmograph.com> - http://www.nordmograph.com
 */


// no direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_vm2tags')) {
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

JToolBarHelper::title(   JText::_( 'VM2Tags - The tagging solution for Virtuemart2' ), 'cpanel.png' );
JToolBarHelper::preferences('com_vm2tags', 600, 860);


// Include dependancies
/*jimport('joomla.application.component.controller');

$controller	= JController::getInstance('Vm2tags');
$controller->execute(JRequest::getCmd('task'));
$controller->redirect();*/

echo '<div style="width:100%;text-align:center;"><a href="http://www.nordmograph.com/index.php?option=com_kunena&view=category&catid=86&Itemid=108" target="_blank">Support</a></div>';