<?php
/**
 * @version $Id: manual.php 7952 2014-05-18 13:54:04Z alatak $
 *
 * @author Valérie Isaksen
 * @package VirtueMart
 * @copyright Copyright (c) 2004 - 2012 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 */
defined ('JPATH_BASE') or die();

/**
 * Renders a label element
 */

class JElementManual extends JElement {

	/**
	 * Element name
	 *
	 * @access    protected
	 * @var        string
	 */
	var $_name = 'Manual';

	function fetchElement ($name, $value, &$node, $control_name) {

		$jlang = JFactory::getLanguage ();
		$lang = $jlang->getTag ();
		$langArray = explode ("-", $lang);
		$lang = strtolower ($langArray[1]);
		$getSofortLang='eng-DE';
		 if ($lang=='de') {
			 $getSofortLang = "ger-DE";
	}



// SOFORT Banking (EN): https://www.sofort.com/integrationCenter-eng-DE/content/view/full/4947
	//	SOFORT Banking (DE): https://www.sofort.com/integrationCenter-ger-DE/content/view/full/4947
		if ($lang=='de') {
			$manualLink="https://www.sofort.com/integrationCenter-ger-DE/content/view/full/4947";
		} else {
			$manualLink="https://www.sofort.com/integrationCenter-eng-DE/content/view/full/4947";
		}
		$html = '<div><a target="_blank" href="'.$manualLink.'" id="getsogort_link" ">' . vmText::_ ('VMPAYMENT_SOFORT_DOCUMENTATION') . '</a>';
		$html .= '</div>';

		return $html;
	}



}