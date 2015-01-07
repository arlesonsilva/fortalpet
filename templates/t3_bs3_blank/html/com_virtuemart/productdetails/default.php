<?php

/**
 *
 * Show the product details page
 *
 * @package	VirtueMart
 * @subpackage
 * @author Max Milbers, Eugen Stranz
 * @author RolandD,
 * @todo handle child products
 * @link http://www.virtuemart.net
 * @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
 * VirtueMart is free software. This version may have been modified pursuant
 * to the GNU General Public License, and as distributed it includes or
 * is derivative of works licensed under the GNU General Public License or
 * other free or open source software licenses.
 * @version $Id: default.php 5444 2012-02-15 15:31:35Z Milbo $
 */
// Check to ensure this file is included in Joomla!
//error_reporting('E_ALL');

defined('_JEXEC') or die('Restricted access');
echo shopFunctionsF::renderVmSubLayout('askrecomjs',array('product'=>$this->product));
vmJsApi::jDynUpdate();
$document = JFactory::getDocument();
$document->addScriptDeclaration("
//<![CDATA[
// GALT: Start listening for dynamic content update.
jQuery(document).ready(function() {
	// If template is aware of dynamic update and provided a variable let's
	// set-up the event listeners.
	if (Virtuemart.container)
		Virtuemart.updateDynamicUpdateListeners();
});
//]]>
");

if(vRequest::getInt('print',false)){
?>
<body onLoad="javascript:print();">
<?php }

//JHtml::_('behavior.modal');
error_reporting('E_ALL');
// addon for joomla modal Box
// JHTML::_('behavior.tooltip');

if(VmConfig::get('usefancy',0)){
	vmJsApi::js( 'fancybox/jquery.fancybox-1.3.4.pack');
	vmJsApi::css('jquery.fancybox-1.3.4');
	$box = "$.fancybox({
				href: '" . $this->askquestion_url . "',
				type: 'iframe',
				height: '550'
			});";
} else {
	vmJsApi::js( 'facebox' );
	vmJsApi::css( 'facebox' );
	$box = "$.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|550'
			});";
}
$document = JFactory::getDocument();
$document->addScriptDeclaration("
	jQuery(document).ready(function($) {
		$('a.ask-question2').click( function(){
			$.facebox({
				iframe: '" . $this->askquestion_url . "',
				rev: 'iframe|550|460'
			});
			return false ;
		});
	/*	$('.additional-images a').mouseover(function() {
			var himg = this.href ;
			var extension=himg.substring(himg.lastIndexOf('.')+1);
			if (extension =='png' || extension =='jpg' || extension =='gif') {
				$('.main-image img').attr('src',himg );
			}
			console.log(extension)
		});*/
	});
");
/* Let's see if we found the product */
if (empty($this->product)) {
    echo JText::_('COM_VIRTUEMART_PRODUCT_NOT_FOUND');
    echo '<br /><br />  ' . $this->continue_link_html;
    return;
}
$this->row = 0;
?>
<div id="productdetailsview" class="productdetails-view layout2">

	<?php
    // PDF - Print - Email Icon
    if (VmConfig::get('show_emailfriend') || VmConfig::get('show_printicon') || VmConfig::get('pdf_button_enable')) {
	?>
        <div class="icons">
	    <?php
	    //$link = (JVM_VERSION===1) ? 'index2.php' : 'index.php';
	    $link = 'index.php?tmpl=component&option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->virtuemart_product_id;
	    $MailLink = 'index.php?option=com_virtuemart&view=productdetails&task=recommend&virtuemart_product_id=' . $this->product->virtuemart_product_id . '&virtuemart_category_id=' . $this->product->virtuemart_category_id . '&tmpl=component';

	    if (VmConfig::get('pdf_icon', 1) == '1') {
		echo '<div class="icons-pdf">'.$this->linkIcon($link . '&format=pdf', 'COM_VIRTUEMART_PDF', 'pdf_button', 'pdf_button_enable', false).'</div>';
	    }
	    echo '<div class="icons-print">'.$this->linkIcon($link . '&print=1', 'COM_VIRTUEMART_PRINT', 'printButton', 'show_printicon').'</div>';
	    echo '<div class="icons-recomend">'.$this->linkIcon($MailLink, 'COM_VIRTUEMART_EMAIL', 'emailButton', 'show_emailfriend').'</div>';
		 echo '<div class="icons-edit">'.$this->edit_link.'</div>';
	    ?>
    	<div class="clear"></div>
        </div>
    <?php } // PDF - Print - Email Icon END
    ?>
<div class="wrapper2">
	 
	<div class="fleft image_loader">
    <div class="image_show">
		<?php
			echo $this->loadTemplate('images');
		?>
        <div class="share_box">
        <div class="share">
          <!-- AddThis Button BEGIN -->
                <span class='st_facebook_large' displayText='Facebook'></span>
                <span class='st_twitter_large' displayText='Tweet'></span>
                <span class='st_linkedin_large' displayText='LinkedIn'></span>
                <span class='st_pinterest_large' displayText='Pinterest'></span>
                <span class='st_email_large' displayText='Email'></span>
                <span class='st_sharethis_large' displayText='ShareThis'></span>

            <!-- AddThis Button END -->
           
            </div>
             <div class="clear"></div>
            </div>
        </div>    
	</div>
    <div class="fright">
    	
		 <?php // Product Title  ?>
			<h1 class="title"><?php echo $this->product->product_name ?></h1>
		<?php // Product Title END  ?>
		<div class="rating">
			<?php
			$ratingModel = VmModel::getModel('ratings');

			 $showRating = $ratingModel->showRating($this->product->virtuemart_product_id);
			 if ($showRating=='true'){
					$rating = $ratingModel->getRatingByProduct($this->product->virtuemart_product_id);
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
			</div>
            
            <?php
				// Manufacturer of the Product
				if (VmConfig::get('show_manufacturers', 1) && !empty($this->product->virtuemart_manufacturer_id)) {
				  echo  $this->loadTemplate('manufacturer');
				}
				if ($this->product->product_in_stock >=1) {
				echo '<div class="stock"><span class="bold">'.JText::_('DR_AVAILABILITY_NEW').':</span><i class="green">'.JText::_('DR_IN_STOCK_NEW').'</i>&nbsp;<b>'.$this->product->product_in_stock.'&nbsp;'.JText::_('DR_ITEMS_NEW').'</b></div>';
				}else {
				echo '<div class="stock"><span class="bold">'.JText::_('DR_AVAILABILITY_NEW').':</span><i class="red">'.JText::_('DR_OUT_STOCK_NEW').'</i>&nbsp;<b>'.$this->product->product_in_stock.'&nbsp;'.JText::_('DR_ITEMS_NEW').'</b></div>';
				}
				echo '<div class="code"><span class="bold">'.JText::_('DR_PRODUCT_CODE_NEW').':</span>'.$this->product->product_sku.'</div>';
			?>
           <?php if (($this->product->product_length > 0) || ($this->product->product_width > 0) || ($this->product->product_height > 0) || ($this->product->product_weight > 0) || ($this->product->product_packaging > 0)) { ?>
            <div class="Dimensions">
				
                <h4><?php echo JText::_('COM_VIRTUEMART_PRODUCT_DIMENSIONS_AND_WEIGHT') ?></h4>
                
                <?php
                if ($this->product->product_length > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_LENGTH').': ' .$this->product->product_length.$this->product->product_lwh_uom.'</div>';
                }
                if ($this->product->product_width > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_WIDTH').': ' .$this->product->product_width.$this->product->product_lwh_uom.'</div>';
                }
                if ($this->product->product_height > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_HEIGHT').': ' .$this->product->product_height.$this->product->product_lwh_uom.'</div>';
                }
                if ($this->product->product_weight > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_WEIGHT').': ' .$this->product->product_weight.$this->product->product_weight_uom.'</div>';
                }
                if ($this->product->product_packaging > 0) {
                echo '<div>'.JText::_('COM_VIRTUEMART_PRODUCT_PACKAGING').': ' .$this->product->product_packaging.$this->product->product_unit.'</div>';
                }
                
                if ($this->product->product_box) {
                ?>
                    <div class="product-box">
                    
                    <?php
                        echo JText::_('COM_VIRTUEMART_PRODUCT_UNITS_IN_BOX').$this->product->product_box;
                    ?>
                    </div>
               <?php } // Product Packaging END
                ?>
            </div>
             <?php } // Product Packaging END
                ?>
            <?php
			//print_r($this->product->product_price_publish_down);
			if (!($this->product->prices['product_price_publish_down'] > 0)){?>
            <div class="price">
				<?php
					echo $this->loadTemplate('showprices');
				?>
             </div> 
              <?php } // Product Packaging END
                ?>
                <?php if ($this->product->prices['override']  == 1 && ($this->product->prices['product_price_publish_down'] > 0)){
					//print_r($this->product->prices['product_price_publish_down']);
					?>
                <div class="time-box">
                                <div class="indent">
                              
                               
                                      
                                <?php if (( !empty($this->product->prices['salesPrice'])) && !$this->product->images[0]->file_is_downloadable) { ?>
                                <div class="price">
                                    <div class="product-price" id="productPrice<?php echo $this->product->virtuemart_product_id ?>">
                                     
                                    <?php
                                        if ($this->product->prices['salesPrice']>0) { ?>
                                    <span class="price-sale">
                                    <span class="text"><?php echo JText::_('DR_SPECIAL_DEAL_PRICE'); ?>:</span>
									<?php echo '<span class="sales">' . $this->currency->createPriceDiv('salesPrice','',$this->product->prices) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                    <?php
                                        if ($this->product->prices['basePriceWithTax']>0) { ?>
                                    <span class="price-old">
                                    <span class="text"><?php echo JText::_('DR_OLD_PRICE'); ?>:</span>
									<?php echo '<span class="WithoutTax">' . $this->currency->createPriceDiv('basePriceWithTax','',$this->product->prices) . '</span>';?>
                                    </span>
                                    <?php } ?>
                                       
                                    <span class="price_save">
                                     <span class="text"><?php echo JText::_('DR_YOU_ARE_SAVING'); ?>:</span>
									<?php echo '<span class="discount">' . $this->currency->createPriceDiv('discountAmount','',$this->product->prices) . '</span>'; ?>
                                    </span>
                                   
                                    <div class="clear" ></div>
                                    </div>
                                    </div>
                                <?php } ?> 
                                <div  class="bzSaleTimer">
                                    <?php
                                     $data = $this->product->prices['product_price_publish_down'];
                                    $data = explode(' ', $data);
                                    $time = explode(':', $data[1]);
                                    $data = explode('-', $data[0]);
                                    //var_dump($data);
                                     $year = $data[0];
                                     $month = $data[1];
                                     $data = $data[2];
                                    //var_dump($time);
                                        ?>
                                        <div class="count_holder">
                                        <div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
                                        <div id="CountSmallDet<?php echo $this->product->virtuemart_product_id ?>" class="count_border">
                                         <script type="text/javascript">
                                        jQuery(function () {    
                                            jQuery('#CountSmallDet<?php echo $this->product->virtuemart_product_id ?>').countdown({
                                                until: new Date(<?php echo $year; ?>, <?php echo $month; ?> - 1, <?php echo $data; ?>),
												labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
												labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
												compact: false});
                                        });
                                         </script>
                                         </div>
                                         </div>
                                      </div>
                                </div>
                                <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;&nbsp;<?php echo $this->product->product_in_stock ?>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
                                <div class="bzSaleTimerDesc2"><div><?php echo $this->product->product_ordered ?></div>&nbsp;&nbsp;<?php echo JText::_('DR_BOOKED'); ?> </div>
                                <div class="clear" ></div>
                                </div>
            <?php } ?>
            
          	<?php  if ($this->product->product_s_desc) { ?>
                <div class="short_desc">
                 <?php echo $this->product->product_s_desc; ?>
                </div>
			<?php } ?>   
		<div class="product-box2">
				
		<?php
		    echo $this->loadTemplate('addtocart');
		?>
   <div class="clear"></div>
    	
		</div>
		
	</div>
  </div> 
  <?php
		// Availability Image
		$stockhandle = VmConfig::get('stockhandle', 'none');
		if (($this->product->product_in_stock - $this->product->product_ordered) < 1) {
			if ($stockhandle == 'risetime' and VmConfig::get('rised_availability') and empty($this->product->product_availability)) {
			?>	<div class="availability">
			    <?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability'))) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . VmConfig::get('rised_availability', '7d.gif'), VmConfig::get('rised_availability', '7d.gif'), array('class' => 'availability')) : VmConfig::get('rised_availability'); ?>
			</div>
		    <?php
			} else if (!empty($this->product->product_availability)) {
			?>
			<div class="availability">
			<?php echo (file_exists(JPATH_BASE . DS . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability)) ? JHTML::image(JURI::root() . VmConfig::get('assets_general_path') . 'images/availability/' . $this->product->product_availability, $this->product->product_availability, array('class' => 'availability')) : $this->product->product_availability; ?>
			</div>
			<?php
			}
		}
		?>
  	<div class="clear"></div>	
	  
    
    <?php
    // Product Files
    // foreach ($this->product->images as $fkey => $file) {
    // Todo add downloadable files again
    // if( $file->filesize > 0.5) $filesize_display = ' ('. number_format($file->filesize, 2,',','.')." MB)";
    // else $filesize_display = ' ('. number_format($file->filesize*1024, 2,',','.')." KB)";

    /* Show pdf in a new Window, other file types will be offered as download */
    // $target = stristr($file->file_mimetype, "pdf") ? "_blank" : "_self";
    // $link = JRoute::_('index.php?view=productdetails&task=getfile&virtuemart_media_id='.$file->virtuemart_media_id.'&virtuemart_product_id='.$this->product->virtuemart_product_id);
    // echo JHTMl::_('link', $link, $file->file_title.$filesize_display, array('target' => $target));
    // }
   
    
    ?>
 <div class="example2 loader">
 <div class="tabs_show">
 <div class="responsive-tabs">
 	 <?php  if ($this->product->product_desc) { ?>
        <h2> <?php echo JText::_('COM_VIRTUEMART_PRODUCT_DESC_TITLE'); ?></h2>
        <div>
       	 <?php echo '<div class="desc">' .$this->product->product_desc.'</div>'; ?>
         <?php
			 if (!empty($this->product->customfieldsSorted['tags'])) {
			$this->position = 'tags';
			echo '<div class="tags">' .$this->loadTemplate('tags').'</div>';
			 }
		// Product custom ?>
         
        </div>
	<?php } ?>
    
    <?php  if (!empty($this->product->customfieldsSorted['filter']) || !empty($this->product->customfieldsSorted['normal']) ) { ?>
        <h2> <?php echo JText::_('COM_VIRTUEMART_PRODUCT_SPECIFICATIONS'); ?></h2>
        <div>
       	 <?php
					   if (!empty($this->product->customfieldsSorted['filter']) || !empty($this->product->customfieldsSorted['normal'])) { ?>
                       <div class="filter">
						   <?php
						 if (!empty($this->product->customfieldsSorted['filter'])) {
							 $this->position = 'filter';
							 echo $this->loadTemplate('filter');
							 echo '</br>';
						 }
						 if (!empty($this->product->customfieldsSorted['normal'])) {
							 $this->position = 'normal';
							 echo $this->loadTemplate('customfields');
						 } ?>
							</div>
						<?php } // Product custom ?>
        </div>
	<?php } ?>
    
    
	   <?php if ($this->allowRating || $this->showReview) { ?>
			<h2><?php echo  JText::_ ('COM_VIRTUEMART_REVIEWS'); ?></h2>
			<div>
				<?php echo $this->loadTemplate('reviews');  ?>	
			</div>
	 <?php } ?>	
     <?php if ($this->allowRating || $this->showReview) { ?>
                <h2><?php echo  JText::_ ('COM_VIRTUEMART_COMENTS'); ?></h2>
                 <div>    
                   <?php // onContentAfterDisplay event
						echo $this->product->event->afterDisplayContent; 
						
						$comments = JPATH_ROOT . '/components/com_jcomments/jcomments.php';
							if (file_exists($comments)) {
								require_once($comments);
								echo JComments::showComments($this->product->virtuemart_product_id, 'com_virtuemart', $this->product->product_name);
							}
						?>
                 </div>  
      <?php } ?>
      <?php if (!empty($this->product->customfieldsSorted['custom'])) { ?>
      <h2> <?php echo  JText::_ ('COM_VIRTUEMART_CUSTOM_TAB'); ?></h2>
      <div>
      	 <?php
			$this->position = 'custom';
			echo '<div class="custom">' .$this->loadTemplate('custom').'</div>';
		// Product custom ?>
      </div>
      <?php } ?>
      
        <?php if (!empty($this->product->customfieldsSorted['video'])) { ?>
      <h2>  <?php echo  JText::_ ('COM_VIRTUEMART_VIDEO'); ?></h2>
      <div>
      	  <?php
			$this->position = 'video';
			echo '<div class="video">' .$this->loadTemplate('video').'</div>';
		// Product custom ?>
      </div>
      <?php } ?>
     
		</div>
  </div>
   </div>
 <div class="clear"></div>
        <?php if ($this->product->customfieldsSorted['related_categories']) { ?>
         <div class="related_categories">
	
			<h3 class="module-title"><?php echo  JText::_('COM_VIRTUEMART_RELATED_CATEGORIES') ; ?></h3>
			<div>
				 <?php 	echo $this->loadTemplate('relatedcategories');?>
			</div>
            </div>
      <?php } ?> 
					
 <?php
 if ($this->product->customfieldsSorted['related_products']) {
	echo $this->loadTemplate('relatedproducts');
 }
		echo $this->loadTemplate('recently');

?>	
 </div>

<?php // Back To Category Button
	if ($this->product->virtuemart_category_id) {
		$catURL =  JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$this->product->virtuemart_category_id);
		$categoryName = $this->product->category_name ;
	} else {
		$catURL =  JRoute::_('index.php?option=com_virtuemart');
		$categoryName = jText::_('COM_VIRTUEMART_SHOP_HOME');
	}
	?>
	
	<div class="back-to-category left" style="padding-top:20px;">
    	<a style="display:inline-block;" href="<?php echo $catURL ?>" class="button_back button reset2" title="<?php echo $categoryName ?>"><i class="fa fa-reply"></i><?php echo JText::sprintf('COM_VIRTUEMART_CATEGORY_BACK_TO',$categoryName) ?></a>
           <?php     // Product Navigation
    if (VmConfig::get('product_navigation', 1)) { ?>
	 <div class="product-neighbour">
     	<ul class="pagers">
	    <?php
	$product_models = VmModel::getModel('product');

		$next = JText::_('VIRTUEMART_NEXTPRODUCT').'<i class="icon-angle-right"></i>';
		$prev = ' <i class="icon-angle-left"></i>'.JText::_('VIRTUEMART_PREVPRODUCT');

	    if (!empty($this->product->neighbours ['previous'][0])) {
		$prev_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['previous'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		$neighbours_id_prev = $this->product->neighbours ['previous'][0] ['virtuemart_product_id'];
		$neighbours_id_p = array();
		$neighbours_id_p[] = $neighbours_id_prev;
		
		$prods_neighbours_p = $product_models->getProducts($neighbours_id_p);
		$product_models->addImages($prods_neighbours_p); 
		//print_r($product_model->file_url_thumb);
		//print_r($neighbours_id_prev);
		
		
		echo '<li class="previous button reset2">';
		 foreach($prods_neighbours_p as $product) { 
			if (!empty($product->images[0]->file_url_thumb)){
			 $neig_prev=$this->_baseurl.$product->images[0]->file_url_thumb;
		 }else{
			 $neig_prev=$this->_baseurl.'images/stories/virtuemart/noimage.gif';
			 }
			echo '<div class="img_n"><img src="'.$neig_prev.'" /></div>';
		 }
		echo JHTML::_('link', $prev_link, $prev);
		echo '</li>';
	    }
	    if (!empty($this->product->neighbours ['next'][0])) {
		$next_link = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $this->product->neighbours ['next'][0] ['virtuemart_product_id'] . '&virtuemart_category_id=' . $this->product->virtuemart_category_id);
		$neighbours_id_next = $this->product->neighbours ['next'][0] ['virtuemart_product_id'];
		$neighbours_id_n = array();
		$neighbours_id_n[] = $neighbours_id_next;
		
		$prods_neighbours_n = $product_models->getProducts($neighbours_id_n);
		$product_models->addImages($prods_neighbours_n); 
		//print_r($product_model->file_url_thumb);
		//print_r($neighbours_id_prev);
		
		
		echo '<li class="next button reset2">';
		 foreach($prods_neighbours_n as $product) { 
			if (!empty($product->images[0]->file_url_thumb)){
			 $neig_next=$this->_baseurl.$product->images[0]->file_url_thumb;
		 }else{
			 $neig_next=$this->_baseurl.'images/stories/virtuemart/noimage.gif';
			 }
			echo '<div class="img_n"><img src="'.$neig_next.'" /></div>';
		 }
		echo JHTML::_('link', $next_link, $next);
		echo '</li>';

	    }
	    ?>
        </ul>
    	<div class="clear"></div>
        </div>
    <?php } // Product Navigation END
    ?>

	</div>
    	<div class="clear"></div>

 <?php 
$app= & JFactory::getApplication();
$template = $app->getTemplate();
$gpath = $this->baseurl."/templates/".$template ;
?>  
<script type="text/javascript" src="<?php echo $gpath ?>/html/com_virtuemart/productdetails/responsiveTabs.min.js"></script>
<script type="text/javascript">
			jQuery(document).ready(function()
			{
				RESPONSIVEUI.responsiveTabs();
				jQuery(function() {
				  jQuery('.product-custom select').styler().trigger('refresh');
				});
				jQuery('.productdetails-view.layout2 .hasTooltip').tooltip();
			});
			jQuery(function(){
				jQuery('.productdetails-view .example2').addClass('loader');
				jQuery(window).load(function() {
					jQuery('.productdetails-view .example2').removeClass('loader'); // remove the loader when window gets loaded.
					jQuery('.tabs_show').show().animate({opacity:1},1000);
				});
			});

	</script>
    <script type="text/javascript">var switchTo5x=true;</script>
	<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
    <script type="text/javascript">stLight.options({publisher: "", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
