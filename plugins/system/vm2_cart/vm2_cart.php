<?php
defined('_JEXEC') or die('Restricted access');
class plgSystemVM2_Cart extends JPlugin {
	
	function __construct(& $subject, $config){
		parent::__construct( $subject, $config );
		$this->loadLanguage();
		 $this->_baseurl   = str_replace('modules/mod_virtuemart_cart/', '', JURI::base());
		 		error_reporting('E_ERROR');


	}
	function onAfterInitialise() {
				error_reporting('E_ERROR');

		if(JFactory::getApplication()->isAdmin()) {
			return;
		}
		if(JRequest::getCmd('option')=='com_virtuemart' && JRequest::getCmd('view')=='cart' && JRequest::getCmd('task')=='viewJS' && JRequest::getCmd('format')=='json') {
			if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR . '/components/com_virtuemart/helpers/config.php');
			require(JPATH_ADMINISTRATOR . '/components/com_virtuemart/helpers/image.php');
			if(!class_exists('VirtueMartCart')) require(JPATH_VM_SITE.'/helpers/cart.php');
			
			JFactory::getLanguage()->load('mod_virtuemart_cart');
			
			$cart=$this->prepareAjaxData();
			
			if ($cart->totalProduct > 1)
			    $cart->totalProductTxt = JText::sprintf('ART_VIRTUEMART_CART_X_PRODUCTS', $cart->totalProduct);
			else if ($cart->totalProduct == 1)
			    $cart->totalProductTxt = JText::_('ART_VIRTUEMART_ITEM');
			else
			    $cart->totalProductTxt = JText::_('ART_VIRTUEMART_EMPTY_CART');
				$cart->totalProductTxt = '<span class="cart_num"><span class="art-text">'.JText::_('ART_VIRTUEMART_NOW_IN_YOUR_CART').'</span><a href="' . JRoute::_('index.php?option=com_virtuemart&view=cart') . '">' . $cart->totalProductTxt . '</a></span>';
			if ($cart->dataValidated == true) {
			    $taskRoute = '&task=confirm';
			    $linkName = JText::_('COM_VIRTUEMART_CART_CONFIRM');
			} else {
			    $taskRoute = '';
			    $linkName = JText::_('COM_VIRTUEMART_CART_SHOW');
			}
			$linkName2 = JText::_('COM_VIRTUEMART_VIEW_CART');
			$linkName3 = JText::_('COM_VIRTUEMART_CHECKOUT');

			$cart->cart_show = '<a class="button" href="' . JRoute::_("index.php?option=com_virtuemart&view=cart" . $taskRoute, true, VmConfig::get('useSSL', 0)) . '">' . $linkName . '</a>';
			$cart->cart_show = '
			<form id="cart_post" action="'  .JRoute::_("index.php?option=com_virtuemart&view=cart").'" method="post">
			<button type="submit" name="bascket" value="true" class="button reset">'.$linkName2.'<span>&nbsp;</span></button>
			</form>
			<a class="button" href="'  .JRoute::_("index.php?option=com_virtuemart&view=cart" . $taskRoute, true, VmConfig::get('useSSL', 0)) . '">' . $linkName3 . '</a>';
			$cart->billTotal = '<div class="total2"><span>'.JText::_('COM_VIRTUEMART_CART_TOTAL').':</span>'.'<strong>' . $cart->billTotal . '</strong></div>';
			
			$cart->taxTotal = '<div class="total3"><span>'.JText::_('ART_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT').':</span>'.'<strong>' . $cart->taxTotal . '</strong></div>';
			$cart->discTotal = '<div class="total4"><span>'.JText::_('ART_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT').':</span>'.'<strong>' . $cart->discTotal . '</strong></div>';

			echo json_encode($cart);
			//var_dump($cart);
			jexit();
		}
	}
	// Render the code for Ajax Cart
	function prepareAjaxData(){
		error_reporting('E_ERROR');
		$this->_cart = VirtueMartCart::getCart(false);
		$this->_cart->prepareCartData(false);
		$weight_total = 0;
		$weight_subtotal = 0;

		//of course, some may argue that the $this->data->products should be generated in the view.html.php, but
		//
		$data = new stdClass();
		$data->products = array();
		$data->totalProduct = 0;
		$i=0;
		
		if (!class_exists('CurrencyDisplay'))
               			if (!class_exists('CurrencyDisplay')) require(JPATH_ROOT .'/administrator/components/com_virtuemart/helpers/currencydisplay.php');
						$currency = CurrencyDisplay::getInstance( );

		
		foreach ($this->_cart->products as $priceKey=>$product){
			//var_dump ($product);
			
			$category_id = $this->_cart->getCardCategoryId($product->virtuemart_product_id);
			//Create product URL
			$url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$category_id);
			// @todo Add variants
			$data->products[$i]['product_cart_id']= $priceKey;
			
			$data->products[$i]['product_name'] = JHTML::link($url, $product->product_name).'</br>'.JText::_('ART_VIRTUEMART_CART_CODE').' :&nbsp;&nbsp;'.$product->product_sku;
			

			// Add the variants
			
			if(!class_exists('VirtueMartModelCustomfields'))require(JPATH_VM_ADMINISTRATOR.'/models/customfields.php');
				//  custom product fields display for cart
				$data->products[$i]['product_attributes'] = VirtueMartModelCustomfields::CustomsFieldCartModDisplay($product);
				
			$data->products[$i]['product_sku'] = '&nbsp;&nbsp;'.$product->product_sku;
			// product Price total for ajax cart
			$data->products[$i]['prices'] = $currency->priceDisplay($product->allPrices[$product->selectedPrice]['salesPrice']);
			//$data->products[$i]['prices'] = $currencyDisplay->priceDisplay( $product->allPrices[$product->selectedPrice]['subtotal']);
			
			// other possible option to use for display
			$data->products[$i]['subtotal'] = $product->allPrices[$product->selectedPrice]['subtotal'];
			
			$data->products[$i]['subtotal_tax_amount'] = $product->allPrices[$product->selectedPrice]['subtotal_tax_amount'];
			$data->products[$i]['subtotal_discount'] = $product->allPrices[$product->selectedPrice]['subtotal_discount'];
			$data->products[$i]['subtotal_with_tax'] = $product->allPrices[$product->selectedPrice]['subtotal_with_tax'];
			/**
            Line for adding images to minicart
            **/
            //$data->products[$i]['image']='<img src="'.JFactory::getUri()->base().$product->image->file_url_thumb.'" />';

			// UPDATE CART / DELETE FROM CART
			$data->products[$i]['quantity'] = $product->quantity."&nbsp;x&nbsp;";
			$data->totalProduct += $product->quantity ;
			$productModel = VmModel::getModel('Product');
            $product_images = $productModel->getProduct($product->virtuemart_product_id, true, false,true,$product->quantity);
            $productModel->addImages($product_images,1);

            //print_r ($product_images);
            //$data->model->addImages($product_images,1);
            

            //$data->products[$i]['image']            = $this->_baseurl.$product_images->images[0]->file_url;
            
            $data->products[$i]['image']='<img src="'.$this->_baseurl.$product_images->images[0]->file_url_thumb.'" />';
			
			$i++;
		}
		if($this->_cart->products){
			$data->billTotal = $currency->priceDisplay( $this->_cart->cartPrices['billTotal'] );
		} else {
			$data->billTotal = $currency->priceDisplay('0.0');
		}

		$data->billTotal = $currency->priceDisplay( $this->_cart->cartPrices['billTotal'] );
		$data->taxTotal = $currency->priceDisplay( $this->_cart->cartPrices['billTaxAmount'] );
		$data->discTotal = $currency->priceDisplay( $this->_cart->cartPrices['billDiscountAmount'] );

		$data->cart_empty_text  = JText::_('ART_VIRTUEMART_CART_EMPTY');
		$data->cart_recent_text  = JText::_('ART_VIRTUEMART_CART_ADD_RECENTLY');
		$data->cart_remove  = JText::_('ART_VIRTUEMART_CART_REMOVE');
		//$data->dataValidated = $this->_dataValidated ;
		$data->dataValidated=false;
		return $data;
	}
}
?>