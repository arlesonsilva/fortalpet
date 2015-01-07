<?php
/**
 * Facebook Slide FanBox
 * @license    GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link       http://facebooklikebox.net
 */
 
//no direct access
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
// include the helper file
require_once(dirname(__FILE__).DS.'helper.php');

$slidelikebox = modSlideLikebox::getLikebox( $params );
require( JModuleHelper::getLayoutPath( 'mod_js_social_tabs_slider' ) );

?>