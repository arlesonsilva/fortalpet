
<?php defined('_JEXEC') or die('Restricted access');
JHTML::_( 'behavior.modal' );

$show_prices = VmConfig::get ('show_prices', 1);
		if ($show_prices == '1') {
			if (!class_exists ('calculationHelper')) {
				require(JPATH_VM_ADMINISTRATOR . DS . 'helpers' . DS . 'calculationh.php');
			}
		}

		$doc = JFactory::getDocument ();
// Separator
if (!class_exists( 'CurrencyDisplay' )) require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart'.DS.'helpers'.DS.'currencydisplay.php');

$verticalseparator = " vertical-separator";
$ratingModel = VmModel::getModel('ratings');
$productModel = VmModel::getModel('product');


$products['latest']= $productModel->getProducts('latest', $latest_products_count);
$productModel->addImages($products['latest'],2);

$products['topten']= $productModel->getProducts('topten', $topTen_products_count);
$productModel->addImages($products['topten'],2);

$recent_products = $productModel->getProducts('recent');
$productModel->addImages($products['recent'],2);

$products['featured'] = $productModel->getProducts('featured', $featured_products_count);
$productModel->addImages($products['featured'],2);

$customfieldsModel = VmModel::getModel ('Customfields');
	if (!class_exists ('vmCustomPlugin')) {
		require(JPATH_VM_PLUGINS . DS . 'vmcustomplugin.php');
	}
foreach ($this->products as $type => $productList ) {
// Calculating Products Per Row
$products_per_row = VmConfig::get ( $type.'_products_per_row', 1 ) ;

// Category and Columns Counter
$col = 1;
$nb = 1;

$productTitle = JText::_('COM_VIRTUEMART_'.$type.'_PRODUCT');

?>

<div class="<?php echo $type ?>-view">
	<h3 class="module-title"><?php echo $productTitle ?></h3>
<div id="product_list" class="grid ">
					<?php // Category and Columns Counter
					$counter = 0;
					$iBrowseCol = 1;
					$iBrowseProduct = 1;
					
					// Calculating Products Per Row
					$BrowseProducts_per_row = 1;
					$Browsecellwidth = ' width'.floor ( 100 / $BrowseProducts_per_row );
					
					// Separator
					$verticalseparator = " vertical-separator";
					?>
					<ul id="slider" class="vmproduct layout">
					<li>
					<?php // Start the Output
					foreach ( $productList as $product ) { 
					if (isset($product->step_order_level))
							$step=$product->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step);
					$discont = $product->prices['discountAmount'];
					$discont = abs($discont);
					foreach ($product->categoryItem as $key=>$prod_cat) {
						$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
					}
					$show_price = $this->currency->createPriceDiv('salesPrice','',$product->prices);
					//print_r($this);
					?>
					 
                     <div class="prod-row">
 							 <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
								 $data = $product->prices['product_price_publish_down'];
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
                                    <div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$type ?>" class="count_border">
                                	 <script type="text/javascript">
                                    jQuery(function () {    
                                        jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$type ?>').countdown({
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

						<div class="product-box front_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
                            <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

                            <div class="browseImage ">
                             <div class="lbl-box2">
								<?php
                                $stockhandle = VmConfig::get ('stockhandle', 'none');
                                if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
                                        (($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { ?>
                                    <div class="soldafter"></div>
                                    <div class="soldbefore"></div>
                                    <div class="sold"><?php echo JText::_('DR_SOLD');?></div>
                                 <?php } ?>   
                                 </div>
                                    <div class="lbl-box">
                                    <?php if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){ ?>
                                    <div class="offafter"></div>
                                        <div class="offbefore"></div>
                                    <div class="discount limited"><?php echo JText::_('DR_LIMITED_OFFER');?></div>
                                      <?php } elseif($discont >0 && $product->product_sales < 20 ) { ?>
                                       <div class="discafter"></div>
                                        <div class="discbefore"></div>
                                    <div class="discount"><?php echo JText::_('DR_SALE');?></div>
                                        <?php } elseif ($product->product_sales > 20) {?>
                                        <div class="hitafter"></div>
                                        <div class="hitbefore"></div>
                                          <div class="hit"><?php echo JText::_('DR_HOT');?></div>
                                          <?php } ?>
                                          </div>
                                            <div class="img-wrapper">
                                            <?php 
                                            $images = $product->images;
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
                                            $image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                                            ?>
                                
                                               <?php
                                                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                                                        if(!empty($product->images[1])){
                                                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                                                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_virtuemart_product/js/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
                                                        
                                                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                                                ?>
                                                </div>
                                    </div>
                                    <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
                                    <div class="slide-hover">
                                        <div class="wrapper">
                                             <div class="Title">
													<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                                   			 </div>
                                            
                                                 <?php
                                                  $showRating = $ratingModel->showRating($product->virtuemart_product_id);
                                                                         if ($showRating=='true'){
                                                $rating = $ratingModel->getRatingByProduct($product->virtuemart_product_id);
                                                if( !empty($rating)) {
                                                    $r = $rating->rating;
                                                } else {
                                                    $r = 0;
                                                }
                                                $maxrating = VmConfig::get('vm_maximum_rating_scale',5);
                                                                $ratingwidth = ( $r * 100 ) / $maxrating;//I don't use round as percetntage with works perfect, as for me
                                                    ?>
                                                                                
                                                        <?php  if( !empty($rating)) {  ?>                        
                                                <span class="vote">
                                                    <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                                        <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                                        </span>
                                                    </span>
                                                    <span class="rating-title"><?php echo JText::_('COM_VIRTUEMART_RATING').' '.round($rating->rating, 2) . '/'. $maxrating; ?></span>
                                                </span>
                                           <?php } else { ?>
                                              <span class="vote">
                                                    <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                                        <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                                        </span>
                                                    </span>
                                                    <span class="rating-title"><?php echo JText::_('COM_VIRTUEMART_RATING').' '.JText::_('COM_VIRTUEMART_UNRATED') ?></span>
                                               </span>
                                                 <?php } } ?>								
													<?php // Product Short Description
                                                if(!empty($product->product_s_desc)) { ?>
                                                <div class="desc1"><?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, 250, '...') ?></div>
                                           	 <?php } ?>
                                   <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
										<div class="Price product-price marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>">
											<?php
											
												if( $product->product_unit && VmConfig::get('vm_price_show_packaging_pricelabel')) {
													echo "<strong>". JText::_('COM_VIRTUEMART_CART_PRICE_PER_UNIT').' ('.$product->product_unit."):</strong>";
												}
												
												//print_r($product->prices);
												if ($discont > 0) {
													echo $this->currency->createPriceDiv('basePriceWithTax','',$product->prices);
												}
												echo $this->currency->createPriceDiv('salesPrice','',$product->prices);
												//echo $this->currency->createPriceDiv('discountAmount','COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT',$product->prices);
												
												//echo $this->currency->createPriceDiv('salesPrice','COM_VIRTUEMART_PRODUCT_SALESPRICE',$product->prices);
												//echo $this->currency->createPriceDiv('priceWithoutTax','COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX',$product->prices);
												
												//echo $this->currency->createPriceDiv('variantModification','COM_VIRTUEMART_PRODUCT_VARIANT_MOD',$product->prices);
												//echo $this->currency->createPriceDiv('basePriceWithTax','COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX',$product->prices);
												//echo $this->currency->createPriceDiv('discountedPriceWithoutTax','COM_VIRTUEMART_PRODUCT_DISCOUNTED_PRICE',$product->prices);
												//echo $this->currency->createPriceDiv('salesPriceWithDiscount','COM_VIRTUEMART_PRODUCT_SALESPRICE_WITH_DISCOUNT',$product->prices);
												//echo $this->currency->createPriceDiv('taxAmount','COM_VIRTUEMART_PRODUCT_TAX_AMOUNT',$product->prices);
											 ?>
										</div>
                                        <?php } else {
									if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } } ?> 
                                        </div>
			<div class="wrapper-slide">
            <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
										<div class="Price product-price list marginbottom12" id="productPrice<?php echo $product->virtuemart_product_id ?>">
											<?php
											
												if( $product->product_unit && VmConfig::get('vm_price_show_packaging_pricelabel')) {
													echo "<strong>". JText::_('COM_VIRTUEMART_CART_PRICE_PER_UNIT').' ('.$product->product_unit."):</strong>";
												}
												
												//print_r($product->prices);
												if ($discont > 0) {
													echo $this->currency->createPriceDiv('basePriceWithTax','',$product->prices);
												}
												echo $this->currency->createPriceDiv('salesPrice','',$product->prices);
												//echo $this->currency->createPriceDiv('discountAmount','COM_VIRTUEMART_PRODUCT_DISCOUNT_AMOUNT',$product->prices);
												
												//echo $this->currency->createPriceDiv('salesPrice','COM_VIRTUEMART_PRODUCT_SALESPRICE',$product->prices);
												//echo $this->currency->createPriceDiv('priceWithoutTax','COM_VIRTUEMART_PRODUCT_SALESPRICE_WITHOUT_TAX',$product->prices);
												
												//echo $this->currency->createPriceDiv('variantModification','COM_VIRTUEMART_PRODUCT_VARIANT_MOD',$product->prices);
												//echo $this->currency->createPriceDiv('basePriceWithTax','COM_VIRTUEMART_PRODUCT_BASEPRICE_WITHTAX',$product->prices);
												//echo $this->currency->createPriceDiv('discountedPriceWithoutTax','COM_VIRTUEMART_PRODUCT_DISCOUNTED_PRICE',$product->prices);
												//echo $this->currency->createPriceDiv('salesPriceWithDiscount','COM_VIRTUEMART_PRODUCT_SALESPRICE_WITH_DISCOUNT',$product->prices);
												//echo $this->currency->createPriceDiv('taxAmount','COM_VIRTUEMART_PRODUCT_TAX_AMOUNT',$product->prices);
											 ?>
										</div>
                                        <?php } else {
									if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question list">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } } ?> 
                                    <?php  if (!empty($show_price)){
                                  if (((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['basePrice'])) && !$product->images[0]->file_is_downloadable )) { ?>
									<div class="addtocart-area2">
										<?php 
							$stockhandle = VmConfig::get ('stockhandle', 'none');
if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || (($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  {
			 ?>
											<a class="addtocart-button " title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id); ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span></span></a>
										<?php } else { ?>
										<form method="post" class="product" action="index.php" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
											//print_r($product->customfieldsSorted[$position]);
										if (!empty($product->customfieldsSorted[$position])) { ?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($product->link, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
                                      	  </div>
										
										<?php } else { ?>
										<span class="quantity-box">
											<input type="text" class="quantity-input js-recalculate" name="quantity[]" onblur="check(this);" value="<?php if (isset($product->step_order_level) && (int)$product->step_order_level > 0) {
			echo $product->step_order_level;
		} else if(!empty($product->min_order_level)){
			echo $product->min_order_level;
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
												<?php if ($product->orderable) { ?>
                                                <button type="submit" value="<?php echo $button_lbl ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO');?>" class="addtocart-button cart-click"><?php echo JText::_('COM_VIRTUEMART_CART_ADD_TO'); ?><span>&nbsp;</span></button>
                                                <?php }else { ?>
                                                <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT_DR'); ?></span>
                                                <?php } ?>
											</span>
                                            
										<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
                                        <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
                                    </div>
							<?php } }?>
                                     
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?> 
                                    <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>            
            <div class="clear"></div>
			</div>
    	</div>
                      <div class="clear"></div></div>
                            </div>
					<?php } ?>
					</li>
					</ul>
                    <div class="clear"></div> 
</div>

</div>

<?php } ?>
<?php 
$app= & JFactory::getApplication();
$template = $app->getTemplate();
$gpath = $this->baseurl."/templates/".$template ;
?>  
<script type="text/javascript" src="<?php echo $gpath ?>/html/com_virtuemart/virtuemart/Cookie.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function($) {
	$("#product_list img.lazy").lazyload({
		effect : "fadeIn"
	});

		$('#product_list .hasTooltip').tooltip('hide');
		 $(function() {

    	$('#product_list div.prod-row').each(function() {        
        var tip = $(this).find('div.count_holder_small');

        $(this).hover(
            function() { tip.appendTo('body'); },
            function() { tip.appendTo(this); }
        ).mousemove(function(e) {
            var x = e.pageX + 60,
                y = e.pageY - 50,
                w = tip.width(),
                h = tip.height(),
                dx = $(window).width() - (x + w),
                dy = $(window).height() - (y + h);

            if ( dx < 50 ) x = e.pageX - w - 60;
            if ( dy < 50 ) y = e.pageY - h + 130;

            tip.css({ left: x, top: y });
        	});         
    	});

		});

	});
</script>
