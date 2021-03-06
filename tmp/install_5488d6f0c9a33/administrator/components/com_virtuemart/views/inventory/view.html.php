<?php
/**
 *
 * Description
 *
 * @package	VirtueMart
 * @subpackage
 * @author
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: view.html.php 7821 2014-04-08 11:07:57Z Milbo $
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

// Load the view framework
if(!class_exists('VmView'))require(JPATH_VM_ADMINISTRATOR.DS.'helpers'.DS.'vmview.php');

/**
 * HTML View class for the VirtueMart Component
 *
 * @package		VirtueMart
 * @author
 */
class VirtuemartViewInventory extends VmView {

	function display($tpl = null) {


		//Load helpers

		if (!class_exists('CurrencyDisplay'))
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'currencydisplay.php');

		if (!class_exists('VmHTML'))
			require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'html.php');

		// Get the data
		$model = VmModel::getModel('product');

		// Create filter
		$this->addStandardDefaultViewLists($model);

		$inventorylist = $model->getProductListing();

		$pagination = $model->getPagination();
		$this->assignRef('pagination', $pagination);

		// Apply currency
		$currencydisplay = CurrencyDisplay::getInstance();

		//vmdebug('my product',$inventorylist[0]);
		foreach ($inventorylist as $virtuemart_product_id => $product) {

			//TODO oculd be interesting to show the price for each product, and all stored ones $product->product_in_stock
			$price = isset($product->allPrices[$product->selectedPrice]['product_price'])? $product->allPrices[$product->selectedPrice]['product_price']:0;

			$product->product_instock_value = $currencydisplay->priceDisplay($price,'',$product->product_in_stock,false);
			$product->product_price_display = $currencydisplay->priceDisplay($price,'',1,false);

			$product->weigth_unit_display= ShopFunctions::renderWeightUnit($product->product_weight_uom);
		}
		$this->assignRef('inventorylist', $inventorylist);


		$options = array();
		$options[] = JHtml::_('select.option', '', vmText::_('COM_VIRTUEMART_DISPLAY_STOCK').':');
		$options[] = JHtml::_('select.option', 'stocklow', vmText::_('COM_VIRTUEMART_STOCK_LEVEL_LOW'));
		$options[] = JHtml::_('select.option', 'stockout', vmText::_('COM_VIRTUEMART_STOCK_LEVEL_OUT'));
		$this->lists['stockfilter'] = JHtml::_('select.genericlist', $options, 'search_type', 'onChange="document.adminForm.submit(); return false;"', 'value', 'text', vRequest::getVar('search_type'));
		$this->lists['filter_product'] = vRequest::getVar('filter_product');
		// $this->assignRef('lists', $lists);

		/* Toolbar */
		$this->SetViewTitle('PRODUCT_INVENTORY');
		JToolBarHelper::publish();
		JToolBarHelper::unpublish();

		parent::display($tpl);
	}

}
// pure php no closing tag
