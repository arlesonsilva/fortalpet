<?php
/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Valerie Isaksen

 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default_relatedproducts.php 6431 2012-09-12 12:31:31Z alatak $
 */

// Check to ensure this file is included in Joomla!
defined ( '_JEXEC' ) or die ( 'Restricted access' );
	if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');
?>
<div class="product-related">

<h3 class="module-title"><?php  echo JText::_('COM_VIRTUEMART_RELATED_PRODUCTS'); ?></h3>
 <div class="product-related-products vmgroup_new">
    <?php
		$product_model = VmModel::getModel('product');
		$ratingModel = VmModel::getModel('ratings');
		$mainframe = Jfactory::getApplication();
		$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );

	$releted = array();
    foreach ($this->product->customfieldsSorted['related_products'] as $field) {
		//print_r($this);
		$releted[] = $field->customfield_value;
		//var_dump($releted);
	 } 
	 $prods_releted = $product_model->getProducts($releted);

		//var_dump ($releted);
		$product_model->addImages($prods_releted); 
		$currency = CurrencyDisplay::getInstance( );
	 ?>
			<div class="list_carousel responsive">
			<div class="slide_box_width">
				<div class="slide_box">
	
                
                <ul id="slider" class="vmproduct layout2 bxslider"> 
                <?php            
			 foreach($prods_releted as $product) { 
			 $this->product2 = $product;
			 if (isset($this->product2->step_order_level))
						$step=$this->product2->step_order_level;
					else
						$step=1;
					if($step==0)
						$step=1;
					$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
					$discont = $this->product2->prices['discountAmount'];
					$discont = abs($discont);
					foreach ($this->product2->categoryItem as $key=>$prod_cat) {
						$this->virtuemart_category_id=$prod_cat['virtuemart_category_id'];
					}
					$show_price = $currency->createPriceDiv('salesPrice', '', $this->product2->prices,true);
					//print_r ($show_price);

			 	if (!empty($this->product2->product_name)) {
			 ?>
             <li>
		<div class="prod-row">
          <?php if ($this->product2->prices['override'] == 1 && ($this->product2->prices['product_price_publish_down'] > 0)){
					 $data = $this->product2->prices['product_price_publish_down'];
					$data = explode(' ', $data);
					$time = explode(':', $data[1]);
					$data = explode('-', $data[0]);
					//var_dump($data);
					$year = $data[0];
					$month = $data[1];
					$data = $data[2];
						//var_dump($time);
							?>
							<div class="count_holder_small">
							<div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
							<div id="CountSmallFeatured<?php echo $this->product2->virtuemart_product_id ?>" class="count_border">
							 <script type="text/javascript">
							jQuery(function () {    
								jQuery('#CountSmallFeatured<?php echo $this->product2->virtuemart_product_id ?>').countdown({
									until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>), 
									labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
									labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
									compact: false});
							});
							 </script>
							 </div>
                             <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $product->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
							 </div>
						  <?php } ?>

         <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
          <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $this->product2->virtuemart_product_id ?>"/> 
    		<div class="browseImage ">
             <div class="lbl-box2">
			<?php
            $stockhandle = VmConfig::get ('stockhandle', 'none');
            if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($this->product2->product_in_stock - $this->product2->product_ordered) < 1) || 
                    (($this->product2->product_in_stock - $this->product2->product_ordered) < $this->product2->min_order_level ))  { ?>
                <div class="soldafter"></div>
                <div class="soldbefore"></div>
                <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
             <?php } ?>   
             </div>
    <div class="lbl-box">
    <?php if ($this->product2->prices['override'] == 1 && ($this->product2->prices['product_price_publish_down'] > 0)){ ?>
    <div class="offafter"></div>
        <div class="offbefore"></div>
    <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
      <?php } elseif($discont >0 && $this->product2->product_sales < 20 ) { ?>
       <div class="discafter"></div>
        <div class="discbefore"></div>
    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
		<?php } elseif ($this->product2->product_sales > 20) {?>
        <div class="hitafter"></div>
        <div class="hitbefore"></div>
          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
          <?php } ?>
          </div>
			<div class="img-wrapper">
            <?php 
            $images = $this->product2->images;
			$main_image_title = $images[0]->file_title;
			$main_image_alt = $images[0]->file_meta;
			if (!empty($images[0]->file_url_thumb)){
				$main_image_url1 = JURI::root().''.$images[0]->file_url_thumb;
			}else {
				$main_image_url1 = JURI::root().'images/stories/virtuemart/noimage.gif';
				}
			if (!empty($images[1]->file_url_thumb)){
				$main_image_url2 = JURI::root().''.$images[1]->file_url_thumb;
			}else {
				$main_image_url2 = JURI::root().'images/stories/virtuemart/noimage.gif';
				}
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$this->product2->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $this->product2->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$this->product2->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($this->product2->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$this->product2->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$this->product2->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$this->product2->virtuemart_product_id.'&virtuemart_category_id='.$this->virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($this->product2->product_in_stock - $this->product2->product_ordered <1){echo 'nostock';} elseif(($this->product2->product_in_stock - $this->product2->product_ordered )<= $this->product2->low_stock_notification){echo 'lowstock';} elseif(($this->product2->product_in_stock - $this->product2->product_ordered )> $this->product2->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>
    <div class="slide-hover">
    	<div class="wrapper">
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$this->product2->virtuemart_product_id.'&virtuemart_category_id='.$this->virtuemart_category_id), shopFunctionsF::limitStringByWord($this->product2->product_name,'30','...'), array('title' => $this->product2->product_name)); ?>
                    </div>
                   
				 <?php
				  $showRating = $ratingModel->showRating($this->product2->virtuemart_product_id);
										 if ($showRating=='true'){
                $rating = $ratingModel->getRatingByProduct($this->product2->virtuemart_product_id);
                if( !empty($rating)) {
                    $r = $rating->rating;
                } else {
                    $r = 0;
                }
                $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
								$ratingwidth = ( $r * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
					?>
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php }  ?>	
                 							
              <?php if (( !empty($this->product2->prices['salesPrice'])) && !$this->product2->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($this->product2->prices['basePriceWithTax']>0 && $discont >0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$this->product2->prices,true) . '</span>';
                if ($this->product2->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$this->product2->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php }  ?>
		</div>
            <div class="wrapper-slide">
           <?php  if (!empty($show_price)){

          		 if ((!VmConfig::get('use_as_catalog', 0) and !empty($this->product2->prices['salesPrice'])) && !$this->product2->images[0]->file_is_downloadable) {
					  if (isset($this->product2->step_order_level))
							$step=$this->product2->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($this->product2->product_in_stock - $this->product2->product_ordered) < 1) || 
			(
			 ($this->product2->product_in_stock - $this->product2->product_ordered) < $this->product2->min_order_level ))  { ?>
             							<span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$this->product2->virtuemart_product_id); ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
                                            </span>
										<?php } else { ?>
										<form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $this->product2->virtuemart_product_id ?>">
                                         <input name="quantity" type="hidden" value="<?php echo $step ?>" />
										<div class="addtocart-bar2">
                                        <script type="text/javascript">
												function check(obj) {
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
											<?php // Display the quantity box 
											 if (!empty($product->customfields)) {
													foreach ($product->customfields as $k => $custom) {
														if (!empty($custom->layout_pos)) {
															$product->customfieldsSorted[$custom->layout_pos][] = $custom;
															unset($product->customfields[$k]);
														}
													}
													$product->customfieldsSorted['normal'] = $product->customfields;
													unset($product->customfields);
												}
											$position = 'addtocart';
											if (!empty($product->customfieldsSorted[$position])) { ?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($this->product2->link, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
                                      	  </div>
										
										<?php } else { ?>
										<span class="quantity-box">
											<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);" value="<?php if (isset($this->product2->step_order_level) && (int)$this->product2->step_order_level > 0) {
			echo $this->product2->step_order_level;
		} else if(!empty($this->product2->min_order_level)){
			echo $this->product2->min_order_level;
		}else {
			echo '1';
		} ?>"/>
										</span>
										<span class="quantity-controls">
											<input type="button" class="quantity-controls quantity-plus" />
											<input type="button" class="quantity-controls quantity-minus" />
										</span>
										<?php // Add the button
											$button_lbl = JText::_('COM_VIRTUEMART_CART_ADD_TO');
											$button_cls = 'addtocart-button cart-click'; //$button_cls = 'addtocart_button';
										?>
											<?php // Display the add to cart button ?>
											<div class="clear"></div>
											<span class="addtocart_button2">
												<button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="<?php echo $button_cls ?>"><?php echo $button_lbl ?><span>&nbsp;</span></button>
											</span>
                                            
										<input type="hidden" class="pname" value="<?php echo $this->product2->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
										 <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $this->product2->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $this->virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
									</div>
        <?php }
     } else {
		 if ($this->product2->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$this->product2->virtuemart_product_id.'&virtuemart_category_id='.$this->virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php }
		 }?>
             <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl2.php")){  ?>
                 <div class="jClever compare_cat list_compare<?php echo $this->product2->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl2.php"); ?>
                 </div>
               <?php } ?>       


             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl2.php")){  ?>
                 <div class="wishlist list_wishlists<?php echo $this->product2->virtuemart_product_id;?>">
                    <?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl2.php"); ?>
                 </div>
               <?php } ?>       
                
            <div class="clear"></div>
			</div>
    	</div>
                
        
        </div>
	</div>
		</li>
			
		<?php } 
			 }
		?>
</ul>
   </div></div>             
</div>
</div></div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		if( (jQuery("#t3-mainbody .row .t3-sidebar-left").hasClass("t3-sidebar")) || (jQuery("#t3-mainbody .row .t3-sidebar-right").hasClass("t3-sidebar")) ) {
			jQuery(".product-related #slider").owlCarousel({
			items : 3,
			autoPlay : 7000,
			 itemsDesktop : [1000,2], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // betweem 900px and 601px
			itemsTablet: [700,2], //2 items between 600 and 0
			itemsMobile : [460,1], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			navigation : true,
			 navigationText: [
				"<i class='fa fa-angle-left'></i>",
				"<i class='fa fa-angle-right'></i>"
			]
			}); 
			jQuery('.slide_box .layout .hasTooltip').tooltip('hide');	
			jQuery(".slide_box img.lazy").show().lazyload({
				effect : "fadeIn"
			});
	 }else {
		 jQuery(".product-related #slider").owlCarousel({
			items : 4,
			autoPlay : 7000,
			 itemsDesktop : [1000,3], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,3], // betweem 900px and 601px
			itemsTablet: [700,2], //2 items between 600 and 0
			itemsMobile : [460,1], // itemsMobile disabled - inherit from itemsTablet option
			stopOnHover : true,
			lazyLoad : false,
			navigation : true,
			 navigationText: [
				"<i class='fa fa-angle-left'></i>",
				"<i class='fa fa-angle-right'></i>"
			]
			}); 
			jQuery('.slide_box .layout .hasTooltip').tooltip('hide');	
			jQuery(".slide_box img.lazy").show().lazyload({
				effect : "fadeIn"
			});
	 }
	 	 jQuery(function() {
    	jQuery('.product-related div.prod-row').each(function() {        
        var tip = jQuery(this).find('div.count_holder_small');

        jQuery(this).hover(
            function() { tip.appendTo('body'); },
            function() { tip.appendTo(this); }
        ).mousemove(function(e) {
            var x = e.pageX + 60,
                y = e.pageY - 50,
                w = tip.width(),
                h = tip.height(),
                dx = jQuery(window).width() - (x + w),
                dy = jQuery(window).height() - (y + h);

            if ( dx < 50 ) x = e.pageX - w - 60;
            if ( dy < 50 ) y = e.pageY - h + 130;

            tip.css({ left: x, top: y });
        	});         
    	});
		});

});
</script>
