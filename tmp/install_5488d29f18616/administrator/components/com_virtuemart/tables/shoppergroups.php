<?php
/**
 * Shopper group data access object.
 *
 * @package	VirtueMart
 * @subpackage ShopperGroup
 * @author Markus �hler
 * @copyright Copyright (c) 2009 VirtueMart Team. All rights reserved.
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

if(!class_exists('VmTable'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmtable.php');

/**
 * Shopper group table.
 *
 * This class is a template.
 *
 * @author Markus Öhler
 * @author Max Milbers
 * @package	VirtueMart
 */
class TableShoppergroups extends VmTable
{
	/** @var int primary key */
	var $virtuemart_shoppergroup_id	 = 0;

	/** @var int Vendor id */
	var $virtuemart_vendor_id = 0;

	/** @var string Shopper group name; no more than 32 characters */
	var $shopper_group_name  = '';

	/** @var string Shopper group description */
	var $shopper_group_desc  = '';

	var $sgrp_additional = 0;
	var $custom_price_display = 0;
	var $price_display		= '';
    /** @var int default group that new customers are associated with. There can only be one
     * default group per vendor. */
	var $default = 0;

	var $published = 0;


	/**
	 * @author Markus �hler
	 * @author Max Milbers
	 * @param JDataBase $db
	 */
	function __construct(&$db)
	{
		parent::__construct('#__virtuemart_shoppergroups', 'virtuemart_shoppergroup_id', $db);

		$this->setUniqueName('shopper_group_name');

		$this->setLoggable();
		$this->setTableShortCut('sg');

		$myfields = array('basePrice',
			'variantModification','basePriceVariant',
			'basePriceWithTax','basePriceWithTax','discountedPriceWithoutTax',
			'salesPrice','priceWithoutTax',
			'salesPriceWithDiscount','discountAmount','taxAmount','unitPrice');

		$varsToPushParam = array('show_prices' => array(0,'int'));
		foreach($myfields as $field){
			$varsToPushParam[$field] = array(1,'int');
			$varsToPushParam[$field.'Text'] = array(1,'int');
			$varsToPushParam[$field.'Rounding'] = array(-1,'int');
		}

		$this->setParameterable('price_display',$varsToPushParam);

	}


//	/**
//	 * Validates the shopper group record fields.
//	 *
//	 * @author Markus Öhler
//	 * @return boolean True if the table buffer contains valid data, false otherwise.
//	 */
	function check(){

		if (empty($this->shopper_group_name) ){
			vmError(vmText::_('COM_VIRTUEMART_SHOPPERGROUP_RECORDS_MUST_HAVE_NAME'));
			return false;
		} else {

			if(function_exists('mb_strlen') ){
				if (mb_strlen($this->shopper_group_name) > 128) {
					vmError(vmText::_('COM_VIRTUEMART_SHOPPERGROUP_NAME_LESS_THAN_32_CHARACTERS'));
					return false;
				}
			} else {
				if (strlen($this->shopper_group_name) > 128) {
					vmError(vmText::_('COM_VIRTUEMART_SHOPPERGROUP_NAME_LESS_THAN_32_CHARACTERS'));
					return false;
				}
			}
		}

		if($this->virtuemart_shoppergroup_id==1){
			$this->default=2;
			$this->sgrp_additional = 0;
		}
		if($this->virtuemart_shoppergroup_id==2){
			$this->default=1;
			$this->sgrp_additional = 0;
		}

		return parent::check();

}
}
// pure php no closing tag
