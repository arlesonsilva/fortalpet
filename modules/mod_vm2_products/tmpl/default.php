
<?php // no direct access
error_reporting('E_ALL');
JHtml::_('behavior.modal');
defined('_JEXEC') or die('Restricted access');
JHTML::stylesheet( 'modules/mod_vm2_products/assets/css/style.css' );
?>
<div class="mod_vm2products">
<div class="responsive-tabs vmgroup<?php echo $params->get( 'moduleclass_sfx' ) ?>">

<?php if($feat){ 
$col= 1 ;
$last = $max_items_feat-1;
//print_r($max_items_feat);
?>
<h2 class="mod-title"><?php echo $featTitle; ?></h2>
<div class="vmproduct_tabs <?php echo $params->get('class_sfx_feat'); ?>">
<?php if ($headerText_feat) { ?>
	<div class="vmheader"><?php echo $headerText_feat ?></div>
<?php } ?>
<?php if ($layout_feat == 'layout') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_feat'); ?> layout">
<li>
<?php  
if (!empty($prods_feat)) {
	$i_feat=0;
	foreach($prods_feat as $product) {
	if (!empty($product->product_name)){
		if ( $i_feat++ == $max_items_feat ) break;
		$discont = $product->prices['discountAmount'];
  		$discont = abs($discont);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
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
				<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>" class="count_border">
				 <script type="text/javascript">
				jQuery(function () {    
					jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>').countdown({
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
              <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_feat) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_feat) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_feat) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_feat) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_feat) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont >0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?>
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_feat) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_feat, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
           <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>
			<?php if ($show_addcart_feat) echo mod_vm2_products::addtocart($product);?>
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
                
			<?php if ($show_details_feat) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
            <div class="clear"></div>
			</div>
    	</div>
    </div>
	</div>
            
	<?php
    if ($col == $products_per_row_feat && $products_per_row_feat && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#artvmproduct div.prod-row').each(function() {        
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

<?php } ?>
<?php if ($layout_feat == 'layout2') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_feat'); ?> layout2">
<li>
<?php  
if (!empty($prods_feat)) {
	$i_feat=0;
	foreach($prods_feat as $product) {
	if (!empty($product->product_name)){
		if ( $i_feat++ == $max_items_feat ) break;
		$discont = $product->prices['discountAmount'];
  		$discont = abs($discont);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
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
				<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>" class="count_border">
				 <script type="text/javascript">
				jQuery(function () {    
					jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_feat' ); ?>').countdown({
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
              <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_feat) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_feat) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_feat) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_feat) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_feat) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont >0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?>
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_feat) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_feat, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_feat) echo mod_vm2_products::addtocart($product);?>
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
                
			<?php if ($show_details_feat) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
            <div class="clear"></div>
			</div>
    	</div>
    </div>
	</div>
            
	<?php
    if ($col == $products_per_row_feat && $products_per_row_feat && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>



<?php if ($footerText_feat) { ?>
	<div class="vmheader"><?php echo $footerText_feat ?></div>
<?php } ?>
</div>
<?php } ?>


<?php if($new){ 
$col= 1 ;
$last = $max_items_new-1;
//print_r ($max_items_new);
?>
<h2 class="mod-title"><?php echo $newTitle; ?></h2>
<div class="vmproduct_tabs <?php echo $params->get('class_sfx_new'); ?>">
<?php if ($headerText_new) { ?>
	<div class="vmheader"><?php echo $headerText_new ?></div>
<?php } ?>
<?php if ($layout_new == 'layout') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_new'); ?> layout">
<li>
<?php  
if (!empty($prods_new)) {
	$i_new=0;
	foreach($prods_new as $product) {
		//var_dump ($product);
	if (!empty($product->product_name)) {
		if ( $i_new++ == $max_items_new) break;

		//$j++;
		//var_dump($j.' - '.$max_items_new.'<br>');
		$discont_new = $product->prices['discountAmount'];
  		$discont_new = abs($discont_new);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}

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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_new' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_new' ); ?>').countdown({
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
     
     <div class="product-box hover spacer back_w <?php if ($discont_new>0) { echo 'disc';} ?> ">
         <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_new) { ?>
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
      <?php } elseif($discont_new >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_new) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_new) { ?>
                   <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_new) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_new) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_new>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_new) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_new, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_new) echo mod_vm2_products::addtocart($product);?>
            <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_new) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_new && $products_per_row_new && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($layout_new == 'layout2') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_new'); ?> layout2">
<li>
<?php  
if (!empty($prods_new)) {
	$i_new=0;
	foreach($prods_new as $product) {
		//var_dump ($product);
	if (!empty($product->product_name)) {
		if ( $i_new++ == $max_items_new) break;

		//$j++;
		//var_dump($j.' - '.$max_items_new.'<br>');
		$discont_new = $product->prices['discountAmount'];
  		$discont_new = abs($discont_new);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}

	 ?>
	<div class="prod-row">
     <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_new' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_new' ); ?>').countdown({
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
     <div class="product-box hover spacer <?php if ($discont_new>0) { echo 'disc';} ?> ">
 <?php if ($show_img_new) { ?>
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
      <?php } elseif($discont_new >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>  
         
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_new) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_new) { ?>
                  <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_new) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_new) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_new>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_new) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_new, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_new) echo mod_vm2_products::addtocart($product);?>
            <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_new) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_new && $products_per_row_new && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else { echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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
<?php } ?>
<?php if ($footerText_new) { ?>
	<div class="vmheader"><?php echo $footerText_new ?></div>
<?php } ?>

</div>
<?php } ?>
<?php if($hit){ 
$col= 1 ;
$last = $max_items_hit-1;
?>
<h2 class="mod-title"><?php echo $hitTitle; ?></h2>
<div class="vmproduct_tabs <?php echo $params->get('class_sfx_hit'); ?>">
<?php if ($headerText_hit) { ?>
	<div class="vmheader"><?php echo $headerText_hit ?></div>
<?php } ?>
<?php if ($layout_hit == 'layout') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_hit'); ?> layout">
<li>
<?php 
if (!empty($prods_hit)) {
	$i_hit=0;
	foreach($prods_hit as $product) {
	if (!empty($product->product_name)){
		if ( $i_hit++ == $max_items_hit ) break;	
		$discont_hit = $product->prices['discountAmount'];
		$discont_hit = abs($discont_hit);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_hit' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_hit' ); ?>').countdown({
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
     
     <div class="product-box hover spacer back_w <?php if ($discont_hit>0) { echo 'disc';} ?> ">
         <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_hit) { ?>
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
      <?php } elseif($discont_hit >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_hit) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_hit) { ?>
                  <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_hit) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_hit) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_hit>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_hit) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_hit, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_hit) echo mod_vm2_products::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_hit) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_hit && $products_per_row_hit && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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
<?php } ?>
<?php if ($layout_hit == 'layout2') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_hit'); ?> layout2">
<li>
<?php 
if (!empty($prods_hit)) {
	$i_hit=0;
	foreach($prods_hit as $product) {
		if (!empty($product->product_name)){
			if ( $i_hit++ == $max_items_hit ) break;	
			$discont_hit = $product->prices['discountAmount'];
			$discont_hit = abs($discont_hit);
			foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
	 ?>
	<div class="prod-row">
     <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_hit' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_hit' ); ?>').countdown({
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
     <div class="product-box hover spacer <?php if ($discont_hit>0) { echo 'disc';} ?> ">
 <?php if ($show_img_hit) { ?>
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
      <?php } elseif($discont_hit >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_hit) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_hit) { ?>
                   <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_hit) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_hit) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_hit>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_hit) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_hit, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_hit) echo mod_vm2_products::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_hit) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_hit && $products_per_row_hit && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($footerText_hit) { ?>
	<div class="vmheader"><?php echo $footerText_hit ?></div>
<?php } ?>

</div>
<?php } ?>



<?php if($disc){ 
//var_dump ($rows);
$col= 1 ;
$last = $max_items_disc-1;
?>
<h2 class="mod-title"><?php echo $discTitle; ?></h2>
<div class="vmproduct_tabs <?php echo $params->get('class_sfx_disc'); ?>">
<?php if ($headerText_disc) { ?>
	<div class="vmheader"><?php echo $headerText_disc ?></div>
<?php } ?>

<?php if ($layout_disc == 'layout') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_disc'); ?> layout">
<li>
<?php 
if (!empty($prods_disc)) {
	$i_disc=0;
	foreach($prods_disc as $product) {
		//var_dump ($product);
		if ($product->allPrices >0){
		//var_dump ($product);
		if (!empty($product->product_name)){
			if ( $i_disc++ == $max_items_disc ) break;	
			$discont_disc = $product->prices['discountAmount'];
			$discont_disc = abs($discont_disc);
			foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_disc' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_disc' ); ?>').countdown({
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
     
     <div class="product-box hover spacer back_w <?php if ($discont_disc>0) { echo 'disc';} ?> ">
         <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_disc) { ?>
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
      <?php } elseif($discont_disc >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_disc) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_disc) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_disc) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_disc) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_disc>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_disc) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_disc, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_disc) echo mod_vm2_products::addtocart($product);?>
            <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_disc) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_disc && $products_per_row_disc && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($layout_disc == 'layout2') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_disc'); ?> layout2">
<li>
<?php 
if (!empty($prods_disc)) {
	$i_disc=0;
	foreach($prods_disc as $product) {
		if ($product->product_price >0){
		if (!empty($product->product_name)){
			if ( $i_disc++ == $max_items_disc ) break;	
			$discont_disc = $product->prices['discountAmount'];
			$discont_disc = abs($discont_disc);
			foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
	 ?>
	<div class="prod-row">
     <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_disc' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_disc' ); ?>').countdown({
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
     <div class="product-box hover spacer <?php if ($discont_disc>0) { echo 'disc';} ?> ">
 <?php if ($show_img_disc) { ?>
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
      <?php } elseif($discont_disc >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_disc) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_disc) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_disc) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } } ?>								
			<?php } ?>
            <?php if ($show_price_disc) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_disc>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_disc) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_disc, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_disc) echo mod_vm2_products::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_disc) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_disc && $products_per_row_disc && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>


<?php if ($footerText_disc) { ?>
	<div class="vmheader"><?php echo $footerText_disc ?></div>
<?php } ?>

</div>
<?php } ?>

<?php if($rand){ 
$col= 1 ;
$last = $max_items_random-1;
?>
<h2 class="mod-title"><?php echo $randTitle; ?></h2>
<div class="vmproduct_tabs <?php echo $params->get('class_sfx_rand'); ?>">
<?php if ($headerText_rand) { ?>
	<div class="vmheader"><?php echo $headerText_rand ?></div>
<?php } ?>

<?php if ($layout_rand == 'layout') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_rand'); ?> layout">
<li>
<?php  
if (!empty($prods_rand)) {
	$i_rand=0;
	foreach($prods_rand as $product) {
		//var_dump ($product);
	if (!empty($product->product_name)) {
		if ( $i_rand++ == $max_items_random) break;

		//$j++;
		//var_dump($products_per_row_random);
		$discont_rand = $product->prices['discountAmount'];
  		$discont_rand = abs($discont_rand);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}

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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rand' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rand' ); ?>').countdown({
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
     
     <div class="product-box hover spacer back_w <?php if ($discont_rand>0) { echo 'disc';} ?> ">
         <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_rand) { ?>
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
      <?php } elseif($discont_rand >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_rand) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_rand) { ?>
                   <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_rand) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } }?>								
			<?php } ?>
            <?php if ($show_price_rand) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_rand>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_rand) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_rand, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_rand) echo mod_vm2_products::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_rand) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_random && $products_per_row_random && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($layout_rand == 'layout2') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_rand'); ?> layout2">
<li>
<?php  
if (!empty($prods_rand)) {
	$i_rand=0;
	foreach($prods_rand as $product) {
		//var_dump ($product);
	if (!empty($product->product_name)) {
		if ( $i_rand++ == $max_items_random) break;

		//$j++;
		//var_dump($j.' - '.$max_items_rand.'<br>');
		$discont_rand = $product->prices['discountAmount'];
  		$discont_rand = abs($discont_rand);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}

	 ?>
	<div class="prod-row">
     <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rand' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rand' ); ?>').countdown({
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
     <div class="product-box hover spacer <?php if ($discont_rand>0) { echo 'disc';} ?> ">
 <?php if ($show_img_rand) { ?>
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
      <?php } elseif($discont_rand >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_rand) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_rand) { ?>
                   <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_rand) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } }?>								
			<?php } ?>
            <?php if ($show_price_rand) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_rand>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_rand) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_rand, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_rand) echo mod_vm2_products::addtocart($product);?>
             <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_rand) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_random && $products_per_row_random && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($footerText_rand) { ?>
	<div class="vmheader"><?php echo $footerText_rand ?></div>
<?php } ?>

</div>
<?php } ?>


<?php if($rank){ 
$col= 1 ;
$last = $max_items_rank-1;
?>
<h2 class="mod-title"><?php echo $rankTitle; ?></h2>
<div class="vmproduct_tabs <?php echo $params->get('class_sfx_rank'); ?>">
<?php if ($headerText_rank) { ?>
	<div class="vmheader"><?php echo $headerText_rank ?></div>
<?php } ?>

<?php if ($layout_rank == 'layout') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_rank'); ?> layout">
<li>
<?php  
if (!empty($prods_rank)) {
	$i_rank=0;
	foreach($prods_rank as $product) {
		//var_dump ($product);
	if (!empty($product->product_name)) {
		if ( $i_rank++ == $max_items_rank) break;

		//$j++;
		//var_dump($j.' - '.$max_items_new.'<br>');
		$discont_rank = $product->prices['discountAmount'];
  		$discont_rank = abs($discont_rank);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}

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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rank' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rank' ); ?>').countdown({
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
     <div class="product-box hover spacer back_w <?php if ($discont_rank>0) { echo 'disc';} ?> ">
         <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/> 

 <?php if ($show_img_rank) { ?>
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
      <?php } elseif($discont_rank >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_rank) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_rank) { ?>
                    <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_rank) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } }?>								
			<?php } ?>
            <?php if ($show_price_rank) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_rank>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_rank) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_rank, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_rank) echo mod_vm2_products::addtocart($product);?>
            <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_rank) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_rank && $products_per_row_rank && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else {  echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($layout_rank == 'layout2') { ?>
<ul id="vm2product" class="<?php echo $params->get('class_sfx_rank'); ?> layout2">
<li>
<?php  
if (!empty($prods_rank)) {
	$i_rank=0;
	foreach($prods_rank as $product) {
		//var_dump ($product);
	if (!empty($product->product_name)) {
		if ( $i_rank++ == $max_items_rank) break;

		//$j++;
		//var_dump($j.' - '.$max_items_rank.'<br>');
		$discont_rank = $product->prices['discountAmount'];
  		$discont_rank = abs($discont_rank);
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}

	 ?>
	<div class="prod-row">
     <input type="hidden" class="quick_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
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
			<div id="CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rank' ); ?>" class="count_border">
			 <script type="text/javascript">
			jQuery(function () {    
				jQuery('#CountSmallFeatured<?php echo $product->virtuemart_product_id.$params->get( 'class_sfx_rank' ); ?>').countdown({
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
     <div class="product-box hover spacer <?php if ($discont_rank>0) { echo 'disc';} ?> ">
 <?php if ($show_img_rank) { ?>
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
      <?php } elseif($discont_rank >0 && $product->product_sales < 20 ) { ?>
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
			$image = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
			?>

			   <?php
                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                        if(!empty($product->images[1])){
                         $image2 = '<img data-original="'.$main_image_url2 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                        } else {$image2 = '<img data-original="'.$main_image_url1 .'"  src="modules/mod_vm2_products/assets/images/preloader.gif"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
						
                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
                ?>
                </div>
                 <?php if ( VmConfig::get ('display_stock', 1)) { ?>
						<!-- 						if (!VmConfig::get('use_as_catalog') and !(VmConfig::get('stockhandle','none')=='none')){?> -->
						<div class="paddingtop8">
							<span class="vmicon vm2-<?php if ($product->product_in_stock - $product->product_ordered <1){echo 'nostock';} elseif(($product->product_in_stock - $product->product_ordered )<= $product->low_stock_notification){echo 'lowstock';} elseif(($product->product_in_stock - $product->product_ordered )> $product->low_stock_notification){echo 'normalstock';}  ?>"></span>
							<span class="stock-level"><?php echo vmText::_ ('COM_VIRTUEMART_STOCK_LEVEL_DISPLAY_TITLE_TIP') ?></span>
						</div>
					<?php } ?>
	</div>        
    <div class="slide-hover">
    	<div class="wrapper">
			  <?php if ($show_title_rank) { ?>
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
            <?php } ?>	
             <?php if ($show_cat_rank) { ?>
                   <div class="Categories">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=category&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->category_name,'40','...'), array('title' => $product->category_name)); ?>
                    </div>
            <?php } ?>	
			<?php if ($show_rating_rank) { ?>
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
                                                
                        <span class="vote">
                            <span title="" class="vmicon ratingbox" style="display:inline-block;">
                                <span class="stars-orange" style="width:<?php echo $ratingwidth;?>%">
                                </span>
                            </span>
                        </span>
           		 <?php } }?>								
			<?php } ?>
            <?php if ($show_price_rank) { ?>	
              <?php if (( !empty($product->prices['salesPrice'])) && !$product->images[0]->file_is_downloadable) { ?>
        <div class="Price">
        <?php
				 if ($product->prices['basePriceWithTax']>0 && $discont_rank>0) 
                    echo '<span class="WithoutTax">' . $currency->createPriceDiv('basePriceWithTax','',$product->prices,true) . '</span>';
                if ($product->prices['salesPrice']>0)
                    echo '<span class="sales">' . $currency->createPriceDiv('salesPrice','',$product->prices,true) . '</span>';
               
        ?>			
        </div>
	<?php } ?> 
    <?php } ?> 
		</div>
         
		<?php if ($show_desc_rank) { ?>
			<div class="description">
				<?php echo shopFunctionsF::limitStringByWord($product->product_s_desc, $row_desc_rank, '...') ?>
			</div>
		<?php } ?>	
		
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			<?php if ($show_addcart_rank) echo mod_vm2_products::addtocart($product);?>
            <?php if(is_file(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php")){  ?>
                            		 <div class="wishlist list_wishlists<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_wishlists/template/wishlists.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
                                     <?php if(is_file(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php")){  ?>
                            		 <div class="jClever compare_cat list_compare<?php echo $product->virtuemart_product_id;?>">
										<?php require(JPATH_BASE.DS."components/com_comparelist/template/comparelist.tpl.php"); ?>
                                     </div>
                           		   <?php } ?>       
			<?php if ($show_details_rank) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
			</div>
    	</div>
    </div>
	</div>
            

	<?php
    if ($col == $products_per_row_rank && $products_per_row_rank && $last) {
        echo "</li><li>";
        $col= 1 ;
    } else {
        $col++;
    }
    $last--; 
} } } else { echo '<h3 class="module-title no-products"><i class="fa fa-info-circle"></i>'.JText::_('PRODUCTS_FILTER_NO').'</h3>';  } ?>	
	 
</li>
<div class="clear"></div>
</ul>
<script type="text/javascript">
	jQuery(document).ready(function($) {
		 $(function() {
    	$('#vm2product div.prod-row').each(function() {        
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

<?php } ?>

<?php if ($footerText_rank) { ?>
	<div class="vmheader"><?php echo $footerText_rank ?></div>
<?php } ?>

</div>
<?php } ?>

</div>
</div>
<script type="text/javascript" src="modules/mod_vm2_products/assets/js/responsiveTabs.min.js"></script>
<script type="text/javascript">
	jQuery(document).ready(function() {
		RESPONSIVEUI.responsiveTabs();
		jQuery('.mod_vm2products .layout .hasTooltip').tooltip('hide');	
		jQuery("#vm2product img.lazy").show().lazyload({
			effect : "fadeIn",
			event : "sporty"
		});
	});
	jQuery(window).bind("load", function() {
    var timeout = setTimeout(function() {
        jQuery("#vm2product img.lazy").trigger("sporty");
		jQuery('html.no-touch .animate_top_tabs').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(250).animate({opacity:1,left:"0px"},550);
			});
		});
		jQuery('html.no-touch .animate_bot_tabs').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(250).animate({opacity:1,right:"0px"},550);
			});
		}); 
    }, 1000);
});
jQuery(function(){
	jQuery('.mod_vm2products').addClass('loader');
	jQuery(window).load(function() {
		jQuery('.mod_vm2products').removeClass('loader'); // remove the loader when window gets loaded.
		jQuery('.vmgroup_vm2products').show();
	});
});
</script>
