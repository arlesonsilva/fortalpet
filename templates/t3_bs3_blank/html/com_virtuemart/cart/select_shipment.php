<?php
/**
 *
 * Template for the shipment selection
 *
 * @package	VirtueMart
 * @subpackage Cart
 * @author Max Milbers
 *
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: cart.php 2400 2010-05-11 19:30:47Z milbo $
 */
// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
?>

<?php
if (VmConfig::get('oncheckout_show_steps', 1)) {
    echo '<div class="checkoutStep" id="checkoutStep2">' . JText::_('COM_VIRTUEMART_USER_FORM_CART_STEP2') . '</div>';
}

	if ($this->layoutName!='default') {
		$headerLevel = 3;
		if($this->cart->getInCheckOut()){
			$buttonclass = 'button vm-button-correct';
		} else {
			$buttonclass = 'button vm-button-correct';
		}
		?>
<form method="post" id="userForm" name="chooseShipmentRate" action="<?php echo JRoute::_('index.php'); ?>" class="form-validate">
	<?php
	} else {
		$headerLevel = 3;
		$buttonclass = 'vm-button-correct button';
	}


	echo "<h".$headerLevel." class='module-title'><span>".JText::_('COM_VIRTUEMART_CART_SELECT_SHIPMENT')."</span></h".$headerLevel.">";
	?>
	
<?php
	   echo "<div class='login-box-metod'>\n";

    if ($this->found_shipment_method OR (VmConfig::get('oncheckout_opc', 0)) ) { 

	
	// if only one Shipment , should be checked by default
	    foreach ($this->shipments_shipment_rates as $shipment_shipment_rates) {
		if (is_array($shipment_shipment_rates)) { 
		
		    foreach ($shipment_shipment_rates as $shipment_shipment_rate) { ?>
			<div class="wrapper">
			<?php 
			echo $shipment_shipment_rate."<br />\n";
			?>
			</div>
		  <?php  }
			
		 } 
		
		
	    }
    } else {
	 echo "<p>".$this->shipment_not_found_text."</p>";
    }

    ?>

	<div class="buttonBar-right">
   <button class="<?php echo $buttonclass ?>" type="submit" ><?php echo JText::_('COM_VIRTUEMART_SAVE'); ?></button>  &nbsp;
   <?php   if ($this->layoutName!='default') { ?>
	<button class="<?php echo $buttonclass ?> reset2" type="reset" onClick="window.location.href='<?php echo JRoute::_('index.php?option=com_virtuemart&view=cart'); ?>'" ><?php echo JText::_('COM_VIRTUEMART_CANCEL'); ?></button>
    <?php } ?>
	</div>
    <div class="clear"></div>
<?php 
	    echo "</div>\n";

if ($this->layoutName!='default') {
?> <input type="hidden" name="option" value="com_virtuemart" />
    <input type="hidden" name="view" value="cart" />
    <input type="hidden" name="task" value="setshipment" />
    <input type="hidden" name="controller" value="cart" />
    
</form>
<?php
}
?>

