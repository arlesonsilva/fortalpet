<?php
/**
 * @version     1.0.0
 * @package     com_vm2tags
 * @copyright   Copyright (C) 2014. Adrien ROUSSEL Nordmograph.com All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Nordmograph <contact@nordmograph.com> - http://www.nordmograph.com./extensions
 */
defined( '_JEXEC' ) or die( 'Restricted access' ); 
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');
/**
* Method to install the component
* 
* @param  mixed    $parent     The class calling this method
* @return void
*/

// Text should use language file strings which are defined in the administrator languages folder section in the XX-XX.com_lendr.sys.ini
class com_vm2tagsInstallerScript
{
	
	function install($parent) 
	{
		echo '<h1><img src="components/com_vm2tags/assets/img/logo_90x90.png" alt="logo" width="90" height="90" style="vertical-align:center" /> VM2Tags Component Installation</h1>';	
		$app = JFactory::getApplication();			
		$error = 0;		
		$cache =  JFactory::getCache();
		$cache->clean( null, 'com_vm2tags' );
		$db	= JFactory::getDBO();
		jimport('joomla.filesystem.folder');
		jimport('joomla.filesystem.file');		
					
		/************************************************************************
		 *
		 *                              START INSTALL
		 *
		 *************************************************************************/
		$install = '<table class="table table-condensed table-striped"><tbody>
		<tr><td><span class="icon-ok"></span> VM2Tags Component installed successfully</td></tr>';
		

		$module_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_vm2tags/install/modules/mod_vm2tags_cloud';
		if( $module_installer->install( $file_origin ) )
		{
			$q = "UPDATE #__modules SET ordering='1', published='1' WHERE `module`='mod_vm2tags_cloud'";
			$db->setQuery( $q );
			$db->query();	
			$install .= '<tr><td><span class="icon-ok"></span> VM2tags Cloud module Installed successfully</td></tr>';
		} else $error++;
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_vm2tags/install/plugins/vmcustom/plg_vmcustom_vm2tags';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='plg_vmcustom_vm2tags'";
			$db->setQuery( $q );
			$db->query();
			$install .= '<tr><td><span class="icon-ok"></span> VM2tags VMcustom plugin Installed successfully. Create the Product Tags custom field in Virtuemart backend and add it to your products with comma separated tags</td></tr>';
		}
		else $error++;
		
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_vm2tags/install/plugins/search/plg_search_vm2tagsearch';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$q = "UPDATE #__extensions SET  enabled='1' WHERE `element`='plg_search_vm2tagsearch'";
			$db->setQuery( $q );
			$db->query();
			$install .= '<tr><td><span class="icon-ok"></span> VM2tags Joomla Search plugin Installed and enabled successfully.</td></tr>';
		}
		else $error++;
		
		
		$install .= '</tbody></table>';
		
		$install .='<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FNordmograph-Web-marketing-and-Joomla-expertise%2F368385633962&amp;width&amp;layout=button_count&amp;action=recommend&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=739550822721946" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>';
		
		$install .='<div style="text-align:center;padding:0 0 100px; 0"><h3>Start here:</h3><br /><a href="index.php?option=com_config&view=component&component=com_vm2tags" class="btn btn-success btn-large"><span class="icon-cog"></span> VM2Tags Component Settings</a></div>';
		
		echo $install;
	}
	/**
	* Method to update the component
	* 
	* @param  mixed  $parent   The class calling this method
	* @return void
	*/
function update($parent) 
{  
	$app = JFactory::getApplication();			
		$error = 0;		
		$cache =  JFactory::getCache();
		$cache->clean( null, 'com_vm2tags' );
		$db	= JFactory::getDBO();
		jimport('joomla.filesystem.folder');
				jimport('joomla.filesystem.file');	
				
				
		$update ='';
	
		$module_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_vm2tags/install/modules/mod_vm2tags_cloud';
		if( $module_installer->install( $file_origin ) )
		{
			$q = "UPDATE #__modules SET ordering='1', published='1' WHERE `module`='mod_vm2tags_cloud'";
			$db->setQuery( $q );
			$db->query();	
			$update .= '<div class="alert alert-success" >Installing/updating module was also successfull.</div>';
		}
		else $error++;
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_vm2tags/install/plugins/vmcustom/plg_vmcustom_vm2tags';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$update .= '<div class="alert alert-success" > VM2tags VMcustom plugin updateded successfully. Create the Product Tags custom field In Virtuemart backend and add it to your products with comma separated tags</div>';
		}
		else $error++;
		
		
		$plugin_installer = new JInstaller;
		$file_origin = JPATH_ADMINISTRATOR.'/components/com_vm2tags/install/plugins/search/plg_search_vm2tagsearch';
		if( $plugin_installer->install( $file_origin ) )
		{	
			$update .= '<div class="alert alert-success" > VM2tags Joomla Search plugin updated successfully.</div>';
		}
		else $error++;
		
		
		
		
		

  $update .='<iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FNordmograph-Web-marketing-and-Joomla-expertise%2F368385633962&amp;width&amp;layout=button_count&amp;action=recommend&amp;show_faces=false&amp;share=false&amp;height=21&amp;appId=739550822721946" scrolling="no" frameborder="0" style="border:none; overflow:hidden; height:21px;" allowTransparency="true"></iframe>';
  $update .='<div style="text-align:center;padding:0 0 100px; 0"><br /><a href="index.php?option=com_config&view=component&component=com_vm2tags" class="btn btn-success btn-large"><span class="icon-location"></span> VM2Tags Settings</a></div>';
  echo $update;
}
/**
* method to run before an install/update/uninstall method
*
* @param  mixed  $parent   The class calling this method
* @return void
*/
function preflight($type, $parent) 
{
 // ...
}
 
function postflight($type, $parent)
{
  //...
}

}