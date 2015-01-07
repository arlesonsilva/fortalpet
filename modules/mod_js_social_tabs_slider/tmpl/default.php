<?php 
/**
 * JS Social Tabs Slider
 * @license    GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link       http://facebooklikebox.net
 */
 
	defined( '_JEXEC' ) or die( 'Restricted access' );	
	$document = & JFactory::getDocument();
	$document->addStyleSheet('modules/mod_js_social_tabs_slider/tmpl/css/gplight.css');
	if ($params->get('position') == 1) {
		$document->addStyleSheet(JURI::root() . 'modules/mod_js_social_tabs_slider/tmpl/css/style2'.'.css', 'text/css', null, array() ); }
	else if ($params->get('position') == 0){
		$document->addStyleSheet(JURI::root() . 'modules/mod_js_social_tabs_slider/tmpl/css/style1'.'.css', 'text/css', null, array() ); }
	echo $slidelikebox;
	if (trim( $params->get( 'loadjquery' ) ) == 1) {
	$document->addScript("https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js");
	}
	else if (trim( $params->get( 'loadjquery' ) ) == 0) {
	$slidelikebox .= ' ';
					}
	
?>    