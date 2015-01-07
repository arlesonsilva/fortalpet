<?php
/**
 * @author ITechnoDev, LLC
 * @copyright (C) 2014 - ITechnoDev, LLC
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

	defined ('_JEXEC') or  die('Direct Access to ' . basename (__FILE__) . ' is not allowed.');

	if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

	if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR  .'/components/com_virtuemart/helpers/config.php');
	}
	VmConfig::loadConfig ();
	// Load the language file of com_virtuemart.
	JFactory::getLanguage ()->load ('com_virtuemart');
	if (!class_exists ('calculationHelper')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'calculationh.php');
	}
	if (!class_exists ('CurrencyDisplay')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'currencydisplay.php');
	}
	if (!class_exists ('VirtueMartModelVendor')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models' . DS . 'vendor.php');
	}
	if (!class_exists ('VmImage')) {
		require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'image.php');
	}
	if (!class_exists ('shopFunctionsF')) {
		require(JPATH_SITE . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'shopfunctionsf.php');
	}
	if (!class_exists ('calculationHelper')) {
		require(JPATH_COMPONENT_SITE . DS . 'helpers' . DS . 'cart.php');
	}
	if (!class_exists ('VirtueMartModelProduct')) {
		JLoader::import ('product', JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'models');
	}

class ModIsotopeMartHelper 
{
	function addtocart ($product, $params) 
	{
		$currency = CurrencyDisplay::getInstance( );
		   $show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
			//print_r ($show_price);

if (!empty($show_price)){

          		 if ((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) {
					  if (isset($product->step_order_level))
							$step=$product->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
			$url_not = JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id);
			  $url2_not = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_not);
			?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo $url2_not; ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
                                            </span>
										<?php } else { ?>
										<form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
											if (!empty($product->customfieldsSorted[$position])) { 
											  $url_select = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
												$url2_select = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_select);

											?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($url2_select, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
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
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
											</span>
                                            
										<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
										 <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
									</div>
        <?php }
     } 
	}
	
	
	function addtocartajax ($product, $modparams)
	{
		$currency = CurrencyDisplay::getInstance( );
		   $show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
			//print_r ($show_price);

if (!empty($show_price)){

          		 if ((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) {
					  if (isset($product->step_order_level))
							$step=$product->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
			  $url_not = JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id);
			  $url2_not = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_not);

			?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo $url2_not; ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
                                            </span>
										<?php } else { ?>
										<form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
											if (!empty($product->customfieldsSorted[$position])) { 
											 $url_select = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
												$url2_select = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_select);
													
											?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($url2_select, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
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
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
											</span>
                                            
										<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
										 <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
									</div>
        <?php }
     } 
		}
		
	
	public static function getScript(&$params,$moduleId)
	{
		$baseurl = JURI::base();

		$imgpath = $baseurl.'modules/mod_isotopemart/assets/img/load.gif' ;		
		$perpage = (int) $params->get('per_page',6) ;
		
		
		$script	 = "(function($){\n";
		$script	 .=	"$(document).ready(function(){\n";
		
		  
		$script	 .= "$(\".itemmart\").hover(function(){";
		$script	 .= 	"$(this).find('.itNewBadge').hide();";
		$script	 .= "},function(){";
		$script	 .= 	"$(this).find('.itNewBadge').show();";
		$script	 .= "});";

		$script	 .= "$(\".itemmart\").hover(function(){";
		$script	 .= 	"$(this).find('.itSalesBadge').hide();";
		$script	 .= "},function(){";
		$script	 .= 	"$(this).find('.itSalesBadge').show();";
		$script	 .= "});";
		 
		
		$script	 .="$.Isotope.prototype._getCenteredMasonryColumns = function() {\n";
		$script	 .=	"this.width = this.element.width();\n";
		$script	 .=	"var parentWidth = this.element.parent().width();\n";
		$script	 .=	"var colW = this.options.masonry && this.options.masonry.columnWidth ||\n";
		$script	 .=	"this.\$filteredAtoms.outerWidth(true) ||\n";
		$script	 .=	"parentWidth;\n";
		$script	 .=	"var cols = Math.floor(parentWidth / colW);	\n";
		$script	 .=	"cols = Math.max(cols, 1);\n";
		$script	 .=	"this.masonry.cols = cols;\n";
		$script	 .=	"this.masonry.columnWidth = colW; \n";
		$script	 .="};\n";
		$script	 .="$.Isotope.prototype._masonryReset = function() {\n";
		$script	 .=	"this.masonry = {}; \n";
		$script	 .=	"this._getCenteredMasonryColumns();\n";
		$script	 .=	"var i = this.masonry.cols;	\n";
		$script	 .=	"this.masonry.colYs = [];\n";
		$script	 .=	"while (i--) {\n";
		$script	 .=		"this.masonry.colYs.push(0);\n";
		$script	 .=	"}\n";
		$script	 .="};\n";
		$script	 .="$.Isotope.prototype._masonryResizeChanged = function() {\n";
		$script	 .=	"var prevColCount = this.masonry.cols;\n";
		$script	 .=	"this._getCenteredMasonryColumns();\n";
		$script	 .=	"return (this.masonry.cols !== prevColCount);\n";
		$script	 .="};\n";
		$script	 .="$.Isotope.prototype._masonryGetContainerSize = function() {\n";
		$script	 .=	"var unusedCols = 0,\n";
		$script	 .=	"i = this.masonry.cols;\n";
		$script	 .=	"while (--i) { \n ";
		$script	 .=		"if (this.masonry.colYs[i] !== 0) {\n";
		$script	 .=			"break;\n";
		$script	 .=		"}\n";
		$script	 .=		"unusedCols++;\n";
		$script	 .=	"}\n";
		$script	 .=	"return {\n";
		$script	 .=		"height: Math.max.apply(Math, this.masonry.colYs),\n";
		$script	 .=		"width: (this.masonry.cols - unusedCols) * this.masonry.columnWidth \n ";
		$script	 .=	"};\n";
		$script	 .="};\n";

		
		$script .=			"var \$container = $('#container');\n" ;
		
		$script .= "\$container.imagesLoaded( function(){\n"; // new
		
		
		$script .="\$container.fadeIn(1000).isotope(\n";
		
		//$script .=			"\$container.isotope(\n"; // Orig
		$script .=			"{\n";
		$script .= 				    "resizable: false,\n" ;
		$script .= 					"masonry: { columnWidth: \$container.width() / 12 },\n";
		$script .=					"itemSelector : '.itemmart',\n";
		$script .=					"filter: '*',\n";
	    $script .=					"sortBy: 'created_on',\n";
	    $script .=					"sortAscending : false,\n";
		$script .=					"animationOptions: {\n";
		$script .=						"duration: 750,\n";
		$script .=						"easing: 'linear',\n";
		$script .=						"queue: false\n";
		$script .=					"},\n";
 	 
		$script .=					 "getSortData :\n"; //start change
		$script .=					  "{\n";
		$script .=						"product_name  : function ( \$elem )\n";
		$script .=						"{\n";
		$script .=						  "return \$elem.attr('data-pname').toLowerCase();\n";
		$script .=						"},\n";
		$script .=						"product_price : function ( \$elem )\n";
		$script .=						"{\n";
		$script .=						  "return parseFloat( \$elem.attr('data-pprice'));\n";
		$script .=						"},\n";
		$script .=						"product_ordered : function ( \$elem )\n";
		$script .=						"{\n";
		$script .=						  "return parseInt( \$elem.attr('data-pordered'),10);\n";
		$script .=						"},\n";
		$script .=						"created_on : function ( \$elem )\n";
		$script .=						"{\n";
		$script .=						  "return \$elem.attr('data-pcreated');\n";
		$script .=						"}\n";
		$script .=					  "}\n"; 			 //end change
	 
   
		$script .=			"});\n"; // end isotope config

	    $script .=			"});\n"; // end image loaded
		
		
		
		$script .=	 "$(window).smartresize(function(){\n";
		$script .=	 	"\$container.isotope({\n";
		$script .=	 		"masonry: { columnWidth: \$container.width() / 12 }\n";
		$script .=	 	"});\n";
		$script .=	 "});\n";


		$script .=			      "var \$optionSets = $('#options .option-set'),\n";
		$script .=				  "\$optionLinks = \$optionSets.find('a');\n";
		$script .=			"\$optionLinks.click(function()\n";
		$script .=			"{\n";
		$script .=				 "var \$this = $(this);\n";
		$script .=					"if ( \$this.hasClass('selected') ) {\n";
		$script .=					  "return false;\n";
		$script .=					"}\n";
		$script .=					"var \$optionSet = \$this.parents('.option-set');\n";
		$script .=					"\$optionSet.find('.selected').removeClass('selected');\n";
		$script .=					"\$this.addClass('selected');\n";
		$script .=				"var options = {},\n";
		$script .=					"key = \$optionSet.attr('data-option-key'),\n";
		$script .=					"value = \$this.attr('data-option-value');\n";
		$script .=				"value = value === 'false' ? false : value;\n";
		$script .=				"options[ key ] = value;\n";
		$script .=				"\$container.isotope( options );\n";
		$script .=			  "return false;\n";
		$script .=			"});\n";
		$script .= "\n";
 		
		if ((bool) $params->get('enable_pagination',0))
		{
			// Start pagination configuration
			
			$script .=	"\$container.infinitescroll({\n";
			$script .=        "navSelector  : '#page_nav',\n"    ;
			$script .=        "nextSelector : '#page_nav a',\n"   ;
			$script .=        "itemSelector : '.itemmart',\n"     ;
			//$script .=        "dataType: 'script',\n"     ;
			$script .=		"debug        : false,\n";
			$script .=		"path:[\"fetcher.php?modid=$moduleId&perpage=$perpage&page=\", \"\"],\n";
			$script .=	    "behavior: 'twitter',\n" ;
			$script .=        "loading: {\n";
			$script .=           " finishedMsg: '<p class=\"msg\">".JText::_('MOD_ISOTOPEMART_NO_MORE_PAGES')."</p>',\n";
			$script .=            "img: '$imgpath',\n";
			$script .=			"msgText: \"<em>".JText::_('MOD_ISOTOPEMART_LOADING_PAGES')."</em>\",\n";
			$script .=			"speed: 'slow'\n";
			$script .=         " }\n";
			$script .=       " },\n";
			$script .=			" function( newElements ) {\n";
			$script .=			 " \$container.isotope( 'insert', $( newElements ) );	\n"	  ;
			
			
			
			$script .="\nVirtuemart.product($( newElements ).find(\".product\"));\n";
			
			//$script .="console.log($( newElements ).find(\".product\"))\n";
			$script .=			"$(\"form.js-recalculate\").each(function(){\n";
			$script .=		"if ($(this).find(\".product-fields\").length && !$(this).find(\".no-vm-bind\").length) {\n";
			$script .=	"var id= $(this).find('input[name=\"virtuemart_product_id[]\"]').val();\n";
			$script .=	"Virtuemart.setproducttype($(this),id);\n";
			$script .=		"}\n";
			$script .=			"});\n";
			
			
			$script	 .= "$(\".itemmart\").hover(function(){";
			$script	 .= 	"$(this).find('.itNewBadge').hide();";
			$script	 .= "},function(){";
			$script	 .= 	"$(this).find('.itNewBadge').show();";
			$script	 .= "});";
			
			$script	 .= "$(\".itemmart\").hover(function(){";
			$script	 .= 	"$(this).find('.itSalesBadge').hide();";
			$script	 .= "},function(){";
			$script	 .= 	"$(this).find('.itSalesBadge').show();";
			$script	 .= "});";
			
			$script	 .= "$('.izotop ul.layout .prod-row , .izotop ul.layout2 .prod-row').each(function(indx, element){
			var my_product_id = $(this).find('.count_ids').val();
			var my_year = $(this).find('.my_year').val();
			var my_month = $(this).find('.my_month').val();
			var my_data = $(this).find('.my_data').val();
			if(my_product_id){
				$('#CountSmallIzotop'+my_product_id).countdown({
				until: new Date(my_year, my_month - 1, my_data), 
				labels: ['Years', 'Months', 'Weeks', '".JText::_('DR_DAYS')."', '".JText::_('DR_HOURS')."', '".JText::_('DR_MINUTES')."', '".JText::_('DR_SECONDS')."'],
				labels1:['Years','Months','Weeks','".JText::_('DR_DAYS')."','".JText::_('DR_HOURS')."','".JText::_('DR_MINUTES')."','".JText::_('DR_SECONDS')."'],
				compact: false});
			}
			
		});";
			//$script	 .= "Countdown();";
					 $script	 .= "$(function() {
					$('.layout div.prod-row, .layout2 div.prod-row').each(function() {        
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
					});";
		
			
					$script	 .= '
					 $("ul.layout .product-box , ul.layout2 .product-box").each(function(indx, element){
						var my_product_id = $(this).find(".quick_ids").val();
						//alert(my_product_id);
						if(my_product_id){
							$(this).append("<div class=\'quick_btn\' onClick =\'quick_btn("+my_product_id+")\'><i class=\'icon-eye-open\'></i>"+show_quicktext+"</div>");
						}
						$(this).find(".quick_id").remove();
					});
				' ;
				$script	 .= "window.addEvent('domready', function() {";
				$script	 .= "SqueezeBox.initialize({});";
				$script	 .= "SqueezeBox.assign($$('a.modal'), {";
				$script	 .= "parse: 'rel'";
				$script	 .= "});";
				$script	 .= "});";
 
			$script .=			" }	\n";
			$script .=		"  );\n";
			//$script .=		"	jQuery(window).unbind('.infscr');\n";
			//$script .=			"	jQuery('#page_nav a').click(function(){\n";
			//$script .=					"jQuery('#container').infinitescroll('retrieve');\n";
			//$script .=					"jQuery('#page_nav').show();\n";
			//$script .=				" return false;\n";
			//$script .=			"	});\n";
		}
 
		$script .=		"});	\n";
		$script .= 		"})(jQuery);" ;

		return $script ;

	}

	
	function addtocartstyle ($product, $params)
	{
				$currency = CurrencyDisplay::getInstance( );
		   $show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
			//print_r ($show_price);

if (!empty($show_price)){

          		 if ((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) {
					  if (isset($product->step_order_level))
							$step=$product->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
					  $url_not = JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id);
			  $url2_not = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_not);

			?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo $url2_not; ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
                                            </span>
										<?php } else { ?>
										<form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
											if (!empty($product->customfieldsSorted[$position])) { 
											 $url_select = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
												$url2_select = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_select);
											?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($url2_select, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
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
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
											</span>
                                            
										<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
										 <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
									</div>
        <?php }
     } 

		}
	
		
	function addtocartstyleajax ($product, $modparams)
	{
				$currency = CurrencyDisplay::getInstance( );
		   $show_price = $currency->createPriceDiv('salesPrice', '', $product->prices,true);
			//print_r ($show_price);

if (!empty($show_price)){

          		 if ((!VmConfig::get('use_as_catalog', 0) and !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) {
					  if (isset($product->step_order_level))
							$step=$product->step_order_level;
						else
							$step=1;
						if($step==0)
							$step=1;
						$alert=JText::sprintf ('COM_VIRTUEMART_WRONG_AMOUNT_ADDED', $step); ?>

                <div class="addtocart-area2">
										<?php $stockhandle = VmConfig::get ('stockhandle', 'none');
			if (
				($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
			(
			 ($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
			$url_not = JRoute::_('index.php?option=com_virtuemart&view=productdetails&layout=notify&virtuemart_product_id='.$product->virtuemart_product_id);
			  $url2_not = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_not);
			?>
           						  <span class="addtocart_button2">
											<a class="addtocart-button" href="<?php echo $url2_not; ?>" title="<?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?>"><?php echo JText::_('COM_VIRTUEMART_CART_NOTIFY') ?><span>&nbsp;</span></a>
                                            </span>
										<?php } else { ?>
										<form method="post" class="product" action="<?php echo JURI::getInstance()->toString(); ?>" id="addtocartproduct<?php echo $product->virtuemart_product_id ?>">
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
											if (!empty($product->customfieldsSorted[$position])) { 
											$url_select = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
												$url2_select = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_select);
												//print_r($url2_select);
											?>
											<span class="attributes"><b>*</b> Product has attributes</span>
                                            <div class="addtocart_button2">
											<?php echo JHTML::link($url2_select, JText::_('DR_VIRTUEMART_SELECT_OPTION').'<span>&nbsp;</span>', array('title' =>JText::_('DR_VIRTUEMART_SELECT_OPTION'),'class' => 'addtocart-button')); ?>
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
                    <span title="<?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT');?>" class="addtocart-button addtocart-button-disabled cart-click"><?php echo JText::_('COM_VIRTUEMART_ADDTOCART_CHOOSE_VARIANT'); ?></span>
                    <?php } ?>
											</span>
                                            
										<input type="hidden" class="pname" value="<?php echo $product->product_name ?>"/>
										<input type="hidden" name="option" value="com_virtuemart" />
										<input type="hidden" name="view" value="cart" />
										<noscript><input type="hidden" name="task" value="add" /></noscript>
										 <input type="hidden" class="item_id" name="virtuemart_product_id[]" value="<?php echo $product->virtuemart_product_id ?>"/>
										<input type="hidden" name="virtuemart_category_id[]" value="<?php echo $product->virtuemart_category_id ?>" />	
										<?php }?>
									</div>
									</form>
									<?php } ?>
									</div>
        <?php }
     } 

	}
				

	public static function getProductList ($group = FALSE, $nbrReturnProducts = FALSE, $withCalc = TRUE, $onlyPublished = TRUE, $single = FALSE, $filterCategory = TRUE, $category_id = 0, $start = 0, $limit = 6)
	{
		$productModel  = VmModel::getModel('Product');
		
		$app = JFactory::getApplication ();
		if ($app->isSite ()) {
			$front = TRUE;

			$user = JFactory::getUser();
			if (!($user->authorise('core.admin','com_virtuemart') or $user->authorise('core.manage','com_virtuemart'))) {
				$onlyPublished = TRUE;
				if ($show_prices = VmConfig::get ('show_prices', 1) == '0') {
					$withCalc = FALSE;
				}
			}
		}
		else {
			$front = FALSE;
		}
		
			$productModel->setFilter ();
		
			if ($filterCategory === TRUE)
			{
				if ($category_id)
				{
					$productModel->virtuemart_category_id = $category_id;
				}
			}
			else
			{
				$productModel->virtuemart_category_id = FALSE;
			}
		
			$ids = ModIsotopeMartHelper::sortSearchListQuery ($onlyPublished, $productModel->virtuemart_category_id, $group, $nbrReturnProducts, $start, $limit);
			$products = $productModel->getProducts ($ids, $front, $withCalc, $onlyPublished, $single);
			//print_r($products);
			return $products;
		}
 
 
	public static function sortSearchListQuery ($onlyPublished = TRUE, $virtuemart_category_id = FALSE, $group = FALSE, $nbrReturnProducts = FALSE, $start = 0, $limit = 6) 
	{			
		    $productModel  = VmModel::getModel('Product');
			$app = JFactory::getApplication ();

			$groupBy = ' group by p.`virtuemart_product_id` ';

			$joinCategory = FALSE;
			$joinMf = FALSE;
			$joinPrice = FALSE;
			$joinCustom = FALSE;
			$joinShopper = FALSE;
			$joinChildren = FALSE;
			$joinLang = TRUE;
			$orderBy = ' ';
		
			$where = array();
			$useCore = TRUE;
			
			if ($productModel->searchplugin !== 0) 
			{
				JPluginHelper::importPlugin ('vmcustom');
				$dispatcher = JDispatcher::getInstance ();
				$PluginJoinTables = array();
				$ret = $dispatcher->trigger ('plgVmAddToSearch', array(&$where, &$PluginJoinTables, $productModel->searchplugin));
				
				foreach ($ret as $r) 
				{
					if (!$r) 
					{
						$useCore = FALSE;
					}
				}
			}
		
			if ($useCore) 
			{
				$isSite = $app->isSite ();
	 
				if (!empty($productModel->searchcustoms)) 
				{
					$joinCustom = TRUE;
					foreach ($productModel->searchcustoms as $key => $searchcustom) 
					{
						$custom_search[] = '(pf.`virtuemart_custom_id`="' . (int)$key . '" and pf.`custom_value` like "%' . $productModel->_db->getEscaped ($searchcustom, TRUE) . '%")';
					}
					$where[] = " ( " . implode (' OR ', $custom_search) . " ) ";
				}
		
				if ($onlyPublished) 
				{
					$where[] = ' p.`published`="1" ';
				}
		
				if($isSite and !VmConfig::get('use_as_catalog',0)) 
				{
					if (VmConfig::get('stockhandle','none')=='disableit_children') 
					{
						$where[] = ' (p.`product_in_stock` - p.`product_ordered` >"0" OR children.`product_in_stock` - children.`product_ordered` > "0") ';
						$joinChildren = TRUE;
					} 
					else if (VmConfig::get('stockhandle','none')=='disableit') 
					{
						$where[] = ' p.`product_in_stock` - p.`product_ordered` >"0" ';
					}
				}
		
				if ($virtuemart_category_id > 0) 
				{
					$joinCategory = TRUE;
					$where[] = ' `pc`.`virtuemart_category_id` = ' . $virtuemart_category_id;
				}
		
				if ($isSite and !VmConfig::get('show_uncat_child_products',TRUE)) 
				{
					$joinCategory = TRUE;
					$where[] = ' `pc`.`virtuemart_category_id` > 0 ';
				}
		
				if ($productModel->product_parent_id) 
				{
					$where[] = ' p.`product_parent_id` = ' . $productModel->product_parent_id;
				}
		
				if ($isSite) 
				{
					$usermodel = VmModel::getModel ('user');
					$currentVMuser = $usermodel->getUser ();
					$virtuemart_shoppergroup_ids = (array)$currentVMuser->shopper_groups;
		
					if (is_array ($virtuemart_shoppergroup_ids)) 
					{
						$sgrgroups = array();
						foreach ($virtuemart_shoppergroup_ids as $key => $virtuemart_shoppergroup_id) 
						{
							$sgrgroups[] = 's.`virtuemart_shoppergroup_id`= "' . (int)$virtuemart_shoppergroup_id . '" ';
						}
						$sgrgroups[] = 's.`virtuemart_shoppergroup_id` IS NULL ';
						$where[] = " ( " . implode (' OR ', $sgrgroups) . " ) ";
		
						$joinShopper = TRUE;
					}
				}
		
				if ($productModel->virtuemart_manufacturer_id) 
				{
					$joinMf = TRUE;
					$where[] = ' `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` = ' . $productModel->virtuemart_manufacturer_id;
				}
		

				if ($productModel->search_type != '') 
				{
					$search_order = $productModel->_db->getEscaped (JRequest::getWord ('search_order') == 'bf' ? '<' : '>');
					switch ($productModel->search_type) 
					{
						case 'parent':
							$where[] = 'p.`product_parent_id` = "0"';
							break;
						case 'product':
							$where[] = 'p.`modified_on` ' . $search_order . ' "' . $productModel->_db->getEscaped (JRequest::getVar ('search_date')) . '"';
							break;
						case 'price':
							$joinPrice = TRUE;
							$where[] = 'pp.`modified_on` ' . $search_order . ' "' . $productModel->_db->getEscaped (JRequest::getVar ('search_date')) . '"';
							break;
						case 'withoutprice':
							$joinPrice = TRUE;
							$where[] = 'pp.`product_price` IS NULL';
							break;
						case 'stockout':
							$where[] = ' p.`product_in_stock`- p.`product_ordered` < 1';
							break;
						case 'stocklow':
							$where[] = 'p.`product_in_stock`- p.`product_ordered` < p.`low_stock_notification`';
							break;
					}
				}

				switch ($productModel->filter_order) 
				{
					case 'product_special':
						if($isSite){
							$where[] = ' p.`product_special`="1" '; 
							$orderBy = 'ORDER BY p.`created_on` ';
						} else {
							$orderBy = 'ORDER BY `product_special`';
						}
		
						break;
					case 'category_name':
						$orderBy = ' ORDER BY `category_name` ';
						$joinCategory = TRUE;
						break;
					case 'category_description':
						$orderBy = ' ORDER BY `category_description` ';
						$joinCategory = TRUE;
						break;
					case 'mf_name':
						$orderBy = ' ORDER BY `mf_name` ';
						$joinMf = TRUE;
						break;
					case 'pc.ordering':
						$orderBy = ' ORDER BY `pc`.`ordering` ';
						$joinCategory = TRUE;
						break;
					case 'product_price':
						$orderBy = ' ORDER BY `product_price` ';
						$joinPrice = TRUE;
						break;
					case 'created_on':
						$orderBy = ' ORDER BY p.`created_on` ';
						break;
					default;
					if (!empty($productModel->filter_order)) {
						$orderBy = ' ORDER BY ' . $productModel->filter_order . ' ';
					}
					else {
						$productModel->filter_order_Dir = '';
					}
					break;
				}
		

				if ($group) 
				{
					$latest_products_days = VmConfig::get ('latest_products_days', 7);
					$latest_products_orderBy = VmConfig::get ('latest_products_orderBy','created_on');
					$groupBy = 'group by p.`virtuemart_product_id` ';
					switch ($group) {
						case 'featured':
							$where[] = 'p.`product_special`="1" ';
							$orderBy = 'ORDER BY p.`created_on` ';
							break;
						case 'latest':
							$date = JFactory::getDate (time () - (60 * 60 * 24 * $latest_products_days));
							$dateSql = $date->toMySQL ();
							$where[] = 'p.`' . $latest_products_orderBy . '` > "' . $dateSql . '" ';
							$orderBy = 'ORDER BY p.`' . $latest_products_orderBy . '`';
							$productModel->filter_order_Dir = 'DESC';
							break;
						case 'random':
							$orderBy = ' ORDER BY p.`created_on` ';  
							break;
						case 'topten':
							$orderBy = ' ORDER BY p.`product_sales` '; 
							$where[] = 'pp.`product_price`>"0.0" ';
							$productModel->filter_order_Dir = 'DESC';
							break;
						case 'recent':
							$rSession = JFactory::getSession();
							$rIds = $rSession->get('vmlastvisitedproductids', array(), 'vm');  
							return $rIds;
					}
					$joinPrice = TRUE;
					$productModel->searchplugin = FALSE;
				}
			}

			if ($joinLang) 
			{
				$select = ' l.`virtuemart_product_id` FROM `#__virtuemart_products_' . VMLANG . '` as l';
				$joinedTables[] = ' JOIN `#__virtuemart_products` AS p using (`virtuemart_product_id`)';
			}
			else 
			{
				$select = ' p.`virtuemart_product_id` FROM `#__virtuemart_products` as p';
				$joinedTables[] = '';
			}
		
			if ($joinCategory == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_categories` as pc ON p.`virtuemart_product_id` = `pc`.`virtuemart_product_id`
			 LEFT JOIN `#__virtuemart_categories_' . VMLANG . '` as c ON c.`virtuemart_category_id` = `pc`.`virtuemart_category_id`';
			}
			if ($joinMf == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_manufacturers` ON p.`virtuemart_product_id` = `#__virtuemart_product_manufacturers`.`virtuemart_product_id`
			 LEFT JOIN `#__virtuemart_manufacturers_' . VMLANG . '` as m ON m.`virtuemart_manufacturer_id` = `#__virtuemart_product_manufacturers`.`virtuemart_manufacturer_id` ';
			}
		
			if ($joinPrice == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_prices` as pp ON p.`virtuemart_product_id` = pp.`virtuemart_product_id` ';
			}
			if ($productModel->searchcustoms) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_customfields` as pf ON p.`virtuemart_product_id` = pf.`virtuemart_product_id` ';
			}
			if ($productModel->searchplugin !== 0) 
			{
				if (!empty($PluginJoinTables)) 
				{
					$plgName = $PluginJoinTables[0];
					$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_custom_plg_' . $plgName . '` as ' . $plgName . ' ON ' . $plgName . '.`virtuemart_product_id` = p.`virtuemart_product_id` ';
				}
			}
			if ($joinShopper == TRUE) 
			{
				$joinedTables[] = ' LEFT JOIN `#__virtuemart_product_shoppergroups` ON p.`virtuemart_product_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_product_id`
			 LEFT  OUTER JOIN `#__virtuemart_shoppergroups` as s ON s.`virtuemart_shoppergroup_id` = `#__virtuemart_product_shoppergroups`.`virtuemart_shoppergroup_id`';
			}
		
			if ($joinChildren) 
			{
				$joinedTables[] = ' LEFT OUTER JOIN `#__virtuemart_products` children ON p.`virtuemart_product_id` = children.`product_parent_id` ';
			}
		
			if (count ($where) > 0) 
			{
				$whereString = ' WHERE (' . implode (' AND ', $where) . ') ';
			}
			else 
			{
				$whereString = '';
			}
			
			//$productModel->orderByString = $orderBy;
			
			 //var_dump($productModel->filter_order_Dir);
			 //die();
			
			
			$productModel->filter_order_Dir = 'DESC';
			
			/*
			if($productModel->_onlyQuery)
			{
				return (array($select,$joinedTables,$where,$orderBy));
			}
			*/
			
			$joinedTables = implode('',$joinedTables);
			$product_ids  = ModIsotopeMartHelper::exeSortSearchListQuery (2, $select, $joinedTables, $whereString, $groupBy, $orderBy, $productModel->filter_order_Dir, $nbrReturnProducts, $start, $limit);
			return $product_ids;
		
		}
		
		
	public static function exeSortSearchListQuery($object, $select, $joinedTables, $whereString = '', $groupBy = '', $orderBy = '', $filter_order_Dir = '', $nbrReturnProducts = false, $start = 0, $limit = 6)
	{
			    $productModel  = VmModel::getModel('Product');
			    $db			   =&  JFactory::getDBO();
				$joinedTables .= $whereString .$groupBy .$orderBy .$filter_order_Dir ;
 
			
				$productModel->_withCount = false;
			 
 
				$q = 'SELECT '.$select.$joinedTables;
			 
		 		//echo ($q);
		 		//die();
				
				$db->setQuery($q,$start,$limit);

				
				
				
			if($object == 2)
			{
				foreach($db->loadAssocList() as $productbd){
					$productModel->ids[] = $productbd['virtuemart_product_id'];
				}
				//var_dump ($productModel->ids);
			} 
		
 
			if(empty($productModel->ids))
			{
				$errors = $db->getErrorMsg();
				if( !empty( $errors))
				{
					vmdebug('exeSortSearchListQuery error in class '.get_class($productModel).' sql:',$db->getErrorMsg());
				}
				if($object == 2 or $object == 1)
				{
					$productModel->ids = array();
				}
			}
		
			return $productModel->ids;	
		}

}






