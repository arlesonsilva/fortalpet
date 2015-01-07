<?php
/**
 * plg_vmcustom_vm2tags
 * @copyright Copyright (C) Adrien Roussel www.nordmograph.com
 * @license http://www.nordmograph.com/en/licence.html GNU GENERAL PUBLIC LICENSE Version 3
 * Virtuemart3
 */
defined('_JEXEC') or 	die( 'Direct Access to ' . basename( __FILE__ ) . ' is not allowed.' ) ;
if (!class_exists('vmCustomPlugin')) require(JPATH_VM_PLUGINS . '/vmcustomplugin.php');
class plgVmCustomVm2tags extends vmCustomPlugin {
	function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$varsToPush = array(
			'product_tags'=>array('','string')
		);
		$this->setConfigParameterable ('customfield_params', $varsToPush);
	}
	/*protected function getVmPluginCreateTableSQL() {
		return $this->createTableSQL('Product Tags Table');
	}	*/
	/*function getTableSQLFields() {
		$SQLfields = array(
	    'id' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
	    'virtuemart_product_id' => 'int(11) UNSIGNED DEFAULT NULL',
	    'virtuemart_custom_id' => 'int(11) UNSIGNED DEFAULT NULL'
		);
		return $SQLfields;
	}*/
	/*function plgVmOnDisplayProductVariantFE($field,&$row,&$group) {
		return '';
	}*/
	function plgVmOnProductEdit($field, $product_id, &$row,&$retValue)
	{
		if ($field->custom_element != $this->_name) return '';
		$doc				= JFactory::getDocument();
		$doc->addScript('../plugins/vmcustom/vm2tags/js/jquery.tagsinput.js');
		$doc->addStyleSheet('../plugins/vmcustom/vm2tags/css/jquery.tagsinput.css');
		$tag_script="jQuery(function() { 	jQuery('#product_tags".$row."').tagsInput({}); 	});";
		$doc->addScriptDeclaration($tag_script);
		if (empty($field->product_tags) )
			$product_tags = '';
		else
			$product_tags = $field->product_tags;
		
		$html = JText::_('VMCUSTOM_VM2TAGS_SEPARATEDTAGS');
		$html ='<fieldset><legend><i class="icon-tags"></i>  '. JText::_('VMCUSTOM_VM2TAGS_SEPARATEDTAGS') .'</legend><table class="admintable">';
		//$html .= VmHTML::row('input','','customfield_params['.$row.'][product_tags]',$product_tags,' size="80"');
		$html .= '<tr><td></td><td><input type="text" size="80" id="product_tags'.$row.'" name="customfield_params['.$row.'][product_tags]" maxlength="255" value="'.$product_tags.'">';	
		$html .='</td></tr></table></fieldset>';
		$retValue .= $html  ;
		$row++;
		return true  ;
	}



	function plgVmOnDisplayProductFEVM3( $product, &$group)
	{
		$html = '';
		$cparams 					= JComponentHelper::getParams('com_vm2tags');
		$mode	 					= $cparams->get('mode','1');
		$vm2tags_itemid 			= $cparams->get('vm2tags_itemid');
		if($vm2tags_itemid=='')
			$vm2tags_itemid = JFactory::getApplication()->input->get('Itemid','', 'int');
		$product_tags = &$group->product_tags;
		
		$sep_tags = explode(',',$product_tags);
		$product_tags_html = '';
			
		foreach($sep_tags as $sep_tag)
		{
			$sep_tag = strtolower($sep_tag);
			if($mode==1)
				$tag_url = JRoute::_('index.php?option=com_vm2tags&view=productslist&tag='.$sep_tag.'&Itemid='.$vm2tags_itemid  );
			else
				$tag_url = JRoute::_('index.php?searchword='.$sep_tag.'&ordering=newest&searchphrase=exact&option=com_search&Itemid='.$vm2tags_itemid  );
			if($sep_tag!='')
				$product_tags_html .= '<a class="btx" href="'.$tag_url.'">'.$sep_tag.'</a> ';
		}
		$html .= '<div style="padding:5px 0 3px 0">';
		$html .= '<i class="icon-tags"></i> ';
		$html .= $product_tags_html ;
		$html .= '</div>';

		if($product_tags_html !=''){
			$group->display .= $html;
			return true;
		}
    }

	function plgVmOnStoreProduct($data,$plugin_param){
		$this->tableFields = array ( 'id', 'virtuemart_product_id', 'virtuemart_custom_id' );

		return $this->OnStoreProduct($data,$plugin_param);
	}
	
	
	
	
	/*
	 * (only to add if you want Searchable Plugin)
	*
	* Render the search in category
	* @ $selectList the list contain all the possible plugin(+customparent_id)
	* @ &$searchCustomValues The HTML to render as search fields
	*
	
	public function plgVmSelectSearchableCustom(&$selectList,&$searchCustomValues,$virtuemart_custom_id)
	{
		$db =JFactory::getDBO();
		$db->setQuery('SELECT `virtuemart_custom_id`, `custom_title` FROM `#__virtuemart_customs` WHERE `custom_element` ="'.$this->_name.'"');
		if ($this->selectList = $db->loadAssocList() ) {
			foreach ($this->selectList as $selected_custom_id) {
				if ($virtuemart_custom_id == $selected_custom_id['virtuemart_custom_id']) {
					$searchCustomValues.='<input type="text" value="" size="20" class="inputbox" name="custom_specification_name1" style="height:16px;vertical-align :middle;">';
				}
			}

			$selectList = array_merge((array)$this->selectList,$selectList);
		}
		return true;
	}*/
	/*
	 * (only to add if you want Searchable Plugin)
	*
	* Extend the search in category
	* @ $where the list contain all the possible plugin(+customparent_id)
	* @ $PluginJoinTables The plg_name table to join on the search
	* (in normal case must be = to $this->_name)
	*/
	public function plgVmAddToSearch(&$where,&$PluginJoinTables,$custom_id)
	{
		if ($keyword = vRequest::uword('vm2tags', null, ' '))
		{		
			if ($this->_name != $this->GetNameByCustomId($custom_id)) return;
			
			$db = JFactory::getDBO();
			
			$keyword = '"%' . $db->escape( $keyword, true ) . '%"' ;
			
			$where[] = ' SUBSTRING('.$this->_name .'.`customfield_params`,14) LIKE '.$keyword;
			
			$PluginJoinTables[] = $this->_name ;
		}
		return true;
	}
	
	
	
	
	/**
	 * We must reimplement this triggers for joomla 1.7
	 * vmplugin triggers note by Max Milbers
	 */
	protected function plgVmOnStoreInstallPluginTable($psType) {
		return $this->onStoreInstallPluginTable($psType);
	}

	function plgVmSetOnTablePluginParamsCustom($name, $id, &$table){
		return $this->setOnTablePluginParams($name, $id, $table);
	}

	function plgVmDeclarePluginParamsCustom($psType,$name,$id, &$data){
		return $this->declarePluginParams($psType, $name, $id, $data);
	}

	/**
	 * Custom triggers note by Max Milbers
	 */
	function plgVmOnDisplayEdit($virtuemart_custom_id,&$customPlugin){
		return $this->onDisplayEditBECustom($virtuemart_custom_id,$customPlugin);
	}

	function plgVmDeclarePluginParamsCustomVM3(&$data){
	  return $this->declarePluginParams('custom', $data);
	}
	function plgVmGetTablePluginParams($psType, $name, $id, &$xParams, &$varsToPush){
	  return $this->getTablePluginParams($psType, $name, $id, $xParams, $varsToPush);
	}
}
// No closing tag