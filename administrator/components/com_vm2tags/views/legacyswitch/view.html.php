<?php
/**
 * @version     1.0.0
 * @package     com_geommunity3js
 * @copyright   Copyright (C) 2014. Adrien ROUSSEL Nordmograph.com All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Nordmograph <contact@nordmograph.com> - http://www.nordmograph.com./extensions
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of Geommunity3js.
 */
class Vm2tagsViewLegacyswitch extends JViewLegacy
{

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		
		// Check for errors.
		if (count($errors = $this->get('Errors'))) {
			throw new Exception(implode("\n", $errors));
		}
        
		$this->counttobeconverted = get('countToboconverted');
	}   
}