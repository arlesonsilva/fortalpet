<?php defined ('_JEXEC') or die('Restricted access');
/**
 *
 * Layout for the shopping cart
 *
 * @package    VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 * @author Patrick Kohl
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 *
 */
//vmdebug('my cart prices in cartview ',$this->cart->cartPrices);
?>
<?php
	if (($this->cart->cartPrices['salesPrice'])>0) {  ?>
	<table
		class="cart-summary"
		cellspacing="0"
		cellpadding="0"
		border="0"
		width="100%">
		<tr>
			<th align="left"><?php echo JText::_('COM_VIRTUEMART_CART_NAME') ?></th>
			<th align="left"><?php echo JText::_('COM_VIRTUEMART_CART_SKU') ?></th>
			<th align="center"><?php echo JText::_('COM_VIRTUEMART_CART_PRICE') ?></th>
			<th	align="right"><?php echo JText::_('COM_VIRTUEMART_QUANTITY') ?></th>


			<?php if ( VmConfig::get('show_tax')) { ?>
                <th align="right" width="90px"><?php  echo "<span  class='priceColor2'>".JText::_('COM_VIRTUEMART_CART_SUBTOTAL_TAX_AMOUNT') ?></th>
            <?php } ?>
            <th align="right" width="90px"><?php echo "<span  class='priceColor2'>".JText::_('COM_VIRTUEMART_CART_SUBTOTAL_DISCOUNT_AMOUNT') ?></th>
				<th align="right" width="90px"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?></th>
			</tr>



		<?php
		$i=1;
		 	
           //print_r($this->cart->products);
					//$pModel->addImages($prow->cart_item_id,1); 

// 		vmdebug('$this->cart->products',$this->cart->products);
		foreach( $this->cart->products as $pkey =>$prow ) { ?>
			<tr valign="top" class="sectiontableentry<?php echo $i ?> check_row">
				<td align="center" width="240px" >
                <div class="wrapper">
					<?php
					if ( $prow->virtuemart_media_id) {  ?>
						<span class="cart-images">
						 <?php
						 
						 if(!empty($prow->images)) {
							 foreach($prow->images as $prowimage) {
								 echo '<a href="'.$prow->url.'" ><img src="'.$prowimage->file_url_thumb.'" /></a>';
								 }
						 } ?>
						</span>
					<?php } ?>
					<span class="cart-title"><?php echo JHTML::link($prow->url, $prow->product_name); ?>
                    <?php
					if ( $this->customfieldsModel->CustomsFieldCartDisplay ($prow)) 
					{
					echo $this->customfieldsModel->CustomsFieldCartDisplay ($prow);
					}
					?>
                    </span>
					
					
					</div>
				</td>
				<td class="color" align="center" ><?php  echo $prow->product_sku ?></td>
				<td align="center">
		<?php
		if (VmConfig::get ('checkout_show_origprice', 1) && $prow->prices['discountedPriceWithoutTax'] != $prow->prices['priceWithoutTax']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE) . '</span><br />';
		}
		if ($prow->prices['discountedPriceWithoutTax']) {
			echo $this->currencyDisplay->createPriceDiv ('discountedPriceWithoutTax', '', $prow->prices, FALSE, FALSE);
		} else {
			echo $this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, FALSE, FALSE);
		}
		// 					echo $prow->salesPrice ;
		?>
	</td>
				<td align="right" ><?php if ($prow->step_order_level)
					$step=$prow->step_order_level;
				else
					$step=1;
				if($step==0)
					$step=1;
				$alert=vmText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
				?>
               <script type="text/javascript">
				function check<?php echo $step?>(obj) {
 				// use the modulus operator '%' to see if there is a remainder
				remainder=obj.value % <?php echo $step?>;
				quantity=obj.value;
 				if (remainder  != 0) {
 					alert('<?php echo $alert?>!');
 					obj.value = quantity-remainder;
 					return false;
 				}
 				return true;
 				}
				</script>
             <input type="text" onblur="check<?php echo $step?>(this);"
				   onclick="check<?php echo $step?>(this);"
				   onchange="check<?php echo $step?>(this);"
				   onsubmit="check<?php echo $step?>(this);" title="<?php echo  vmText::_('COM_VIRTUEMART_CART_UPDATE') ?>" class="quantity-input js-recalculate" size="3" maxlength="4" name="quantity[<?php echo $pkey; ?>]" value="<?php echo $prow->quantity ?>" />

			<button type="submit" class="vmicon vm2-add_quantity_cart" name="update.<?php echo $pkey ?>"><i class="fa fa-check"></i><?php echo JText::_('DR_VIRTUEMART_CART_UPDATE'); ?></button>

			<button type="submit" class="vmicon vm2-remove_from_cart" name="delete.<?php echo $pkey ?>" title="<?php echo JText::_('DR_VIRTUEMART_CART_DELETE') ?>" ><i class="fa fa-times"></i><?php echo JText::_('DR_VIRTUEMART_CART_DELETE') ?></button>
					
				</td>

				<?php if ( VmConfig::get('show_tax')) { ?>
				<td class="color" align="center"><?php if ( !empty($prow->prices['taxAmount']) ) 
				{
					echo "<span class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('taxAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity)."</span>";
				} else 
				{
					echo "--";
				}
			?> 
			
			</td>
                                <?php } ?>
				<td class="color" align="center"><?php if ( !empty($prow->prices['discountAmount']) )
				{
				echo "<span class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('discountAmount', '', $prow->prices, FALSE, FALSE, $prow->quantity)."</span>";
				} else 
				{
					echo "--";
				}
				?></td>
				<td align="center">
				<?php
		if (VmConfig::get ('checkout_show_origprice', 1) && !empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceWithTax'] != $prow->prices['salesPrice']) {
			echo '<span class="line-through">' . $this->currencyDisplay->createPriceDiv ('basePriceWithTax', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
		}
		elseif (VmConfig::get ('checkout_show_origprice', 1) && empty($prow->prices['basePriceWithTax']) && $prow->prices['basePriceVariant'] != $prow->prices['salesPrice']) {
			echo '<span class="line-through">' .$this->currencyDisplay->createPriceDiv ('basePriceVariant', '', $prow->prices, TRUE, FALSE, $prow->quantity) . '</span><br />';
		}
		echo $this->currencyDisplay->createPriceDiv ('salesPrice', '', $prow->prices, FALSE, FALSE, $prow->quantity) ?></td>
			</tr>
			<?php
	$i = ($i==1) ? 2 : 1;
} ?>
<!--Begin of SubTotal, Tax, Shipment, Coupon Discount and Total listing -->
<?php if (VmConfig::get ('show_tax')) {
	$colspan = 3;
} else {
	$colspan = 2;
} ?>
		  <tr class="sectiontableentry1 price">
			<td colspan="4" align="right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_PRODUCT_PRICES_TOTAL'); ?>:</td>

                        <?php if ( VmConfig::get('show_tax')) { ?>
			<td align="center"><?php if ( !empty($prow->prices['taxAmount']) )
			{
			echo "<span  class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('taxAmount', '', $this->cart->cartPrices, FALSE)."</span>"; 
			} else 
				{
					echo "--";
				}
			?></td>
                        <?php } ?>
			<td align="center"><?php  if ( !empty($prow->prices['discountAmount']) ) 
			{
				echo "<span  class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('discountAmount', '', $this->cart->cartPrices, FALSE)."</span>";
			} else 
				{
					echo "--";
				}
			?></td>
			<td align="center"><?php echo "<span  class='total'>".$this->currencyDisplay->createPriceDiv ('salesPrice', '', $this->cart->cartPrices, FALSE)."</span>"; ?></td>
		  </tr>
        
        			<?php
				if (VmConfig::get ('coupons_enable')) {
					?>
				<tr class="sectiontableentry1 coupon-tr">
				<td colspan="<?php if (VmConfig::get ('show_tax')) { echo "4"; }else { echo"7";}?>" align="left">
					<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
					// echo JHTML::_('link', JRoute::_('index.php?view=cart&task=edit_coupon',$this->useXHTML,$this->useSSL), JText::_('COM_VIRTUEMART_CART_EDIT_COUPON'));
						echo $this->loadTemplate ('coupon');
					}
					?>
					<?php if (!empty($this->cart->cartData['couponCode'])) { ?>
						<?php
                        echo $this->cart->cartData['couponCode'];
                        echo $this->cart->cartData['couponDescr'] ? (' (' . $this->cart->cartData['couponDescr'] . ')') : '';
                        ?>
                    
                        </td>
                    
                         <?php if (VmConfig::get ('show_tax')) { ?>
                            <td align="center"><?php echo $this->currencyDisplay->createPriceDiv ('couponTax', '', $this->cart->cartPrices['couponTax'], FALSE); ?> </td>
                        <?php } ?>
                        <td align="center">--</td>
                        <td align="center"><?php echo $this->currencyDisplay->createPriceDiv ('salesPriceCoupon', '', $this->cart->cartPrices['salesPriceCoupon'], FALSE); ?> </td>
                    	<?php }else { ?>
							</td><td colspan="3" align="left">&nbsp;</td> 
                        <?php } } ?>			
		   


<?php
foreach ($this->cart->cartData['DBTaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry<?php echo $i ?>">
	<td colspan="4" align="right"><?php echo $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>
	<?php } ?>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?></td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
} ?>

<?php

foreach ($this->cart->cartData['taxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry1 item">
	<td colspan="4" align="right"><?php echo $rule['calc_name'] ?> </td>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
	<?php } ?>
	<td align="right"><?php ?> </td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
}

foreach ($this->cart->cartData['DATaxRulesBill'] as $rule) {
	?>
<tr class="sectiontableentry1 item">
	<td colspan="4" align="right"><?php echo   $rule['calc_name'] ?> </td>

	<?php if (VmConfig::get ('show_tax')) { ?>
	<td align="right"></td>

	<?php } ?>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?>  </td>
	<td align="right"><?php echo $this->currencyDisplay->createPriceDiv ($rule['virtuemart_calc_id'] . 'Diff', '', $this->cart->cartPrices[$rule['virtuemart_calc_id'] . 'Diff'], FALSE); ?> </td>
</tr>
	<?php
	if ($i) {
		$i = 1;
	} else {
		$i = 0;
	}
} ?>


<?php if ( 	VmConfig::get('oncheckout_opc',true) or
	!VmConfig::get('oncheckout_show_steps',false) or
	(!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) and
		!empty($this->cart->virtuemart_shipmentmethod_id) )
) { ?>

	<tr class="sectiontableentry1 shipment color">
                    <?php if (!$this->cart->automaticSelectedShipment) { ?>

	<?php /*	<td colspan="2" align="right"><?php echo JText::_('COM_VIRTUEMART_ORDER_PRINT_SHIPPING'); ?> </td> */ ?>
				<td colspan="7" align="center">
				<div class="fleft"><?php echo $this->cart->cartData['shipmentName']; ?></div>
	<?php
	if (!empty($this->layoutName) and $this->layoutName == 'default') {
			if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				echo $this->loadTemplate('shipment');
				$this->setLayout($previouslayout);
			} else {
			echo '<div class="fright">'.JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=edit_shipment', $this->useXHTML, $this->useSSL), $this->select_shipment_text, 'class=""').'</div>';
		}
	} else {
		echo JText::_ ('COM_VIRTUEMART_CART_SHIPPING');
	}
} else {
	?>
	<td colspan="7" align="center">
		<?php echo $this->cart->cartData['shipmentName']; ?>
        
				</td>
                                 <?php } ?>

                                     <?php if ( VmConfig::get('show_tax')) { ?>
				<?php echo "<span  class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('shipmentTax', '', $this->cart->cartPrices['shipmentTax'], FALSE)."</span>"; ?> 
                                <?php } ?>
				<?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?>
				<?php echo $this->currencyDisplay->createPriceDiv ('salesPriceShipment', '', $this->cart->cartPrices['salesPriceShipment'], FALSE); ?></td>
		</tr>
<?php }?>

<?php if ($this->cart->pricesUnformatted['salesPrice']>0.0 and
	( 	VmConfig::get('oncheckout_opc',true) or
		!VmConfig::get('oncheckout_show_steps',false) or
		( (!VmConfig::get('oncheckout_opc',true) and VmConfig::get('oncheckout_show_steps',false) ) and !empty($this->cart->virtuemart_paymentmethod_id))
	)
) { ?>
<tr class="sectiontableentry1 payment color" valign="top">
	<?php if (!$this->cart->automaticSelectedPayment) { ?>

	<td colspan="7" align="center">
		<div class="fleft"><?php echo $this->cart->cartData['paymentName']; ?></div>
		<?php if (!empty($this->layoutName) && $this->layoutName == 'default') {
			if (VmConfig::get('oncheckout_opc', 0)) {
				$previouslayout = $this->setLayout('select');
				echo $this->loadTemplate('payment');
				$this->setLayout($previouslayout);
			} else {
				echo '<div class="fright automatick">'.JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=cart&task=editpayment', $this->useXHTML, $this->useSSL), $this->select_payment_text, 'class=""').'</div>';
			}
		} else {
		echo JText::_ ('COM_VIRTUEMART_CART_PAYMENT');
	} ?> 
	<?php } else { ?>
	<td colspan="7" align="left"><?php echo $this->cart->cartData['paymentName']; ?> </td>
	<?php } ?>
	<?php if (VmConfig::get ('show_tax')) { ?>
	<?php echo "<span  class='priceColor2'>" . $this->currencyDisplay->createPriceDiv ('paymentTax', '', $this->cart->cartPrices['paymentTax'], FALSE) . "</span>"; ?> 
	<?php } ?>
	<?php if($this->cart->cartPrices['salesPriceShipment'] < 0) echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?>
	<?php  echo $this->currencyDisplay->createPriceDiv ('salesPricePayment', '', $this->cart->cartPrices['salesPricePayment'], FALSE); ?> </td>
</tr>
<?php } ?>
		  <tr class="sectiontableentry1 bg_total">
			<td class="color2" colspan="4" align="right"><?php echo JText::_('COM_VIRTUEMART_CART_TOTAL') ?>: </td>

                        <?php if ( VmConfig::get('show_tax')) { ?>
			<td align="right"> <?php echo "<span  class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('billTaxAmount', '', $this->cart->cartPrices['billTaxAmount'], FALSE)."</span>" ?> </td>
                        <?php } ?>
			<td align="center"> <?php echo "<span  class='priceColor2'>".$this->currencyDisplay->createPriceDiv ('billDiscountAmount', '', $this->cart->cartPrices['billDiscountAmount'], FALSE)."</span>" ?> </td>
			<td align="center" class="color"><strong><?php echo $this->currencyDisplay->createPriceDiv ('billTotal', '', $this->cart->cartPrices['billTotal'], FALSE); ?></strong></td>
		  </tr>
			<?php
            if ($this->totalInPaymentCurrency) {
            ?>
            
            <tr class="sectiontableentry2">
                <td colspan="4" align="right"><?php echo vmText::_ ('COM_VIRTUEMART_CART_TOTAL_PAYMENT') ?>:</td>
            
                <?php if (VmConfig::get ('show_tax')) { ?>
                <td align="right"></td>
                <?php } ?>
                <td align="right"></td>
                <td align="right"><strong><?php echo $this->totalInPaymentCurrency;   ?></strong></td>
            </tr>
                <?php
            }
             ?>


	</table>
    
    
    

<?php } else {echo '<h3 class="module-title check-marg">'.JText::_('DR_VIRTUEMART_ADD_PRODUCT_TO').'</h3>';} ?>