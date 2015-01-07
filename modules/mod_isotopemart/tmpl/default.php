<?php
/**
 * @author ITechnoDev, LLC
 * @copyright (C) 2014 - ITechnoDev, LLC
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/


// no direct access
defined('_JEXEC') or die ;
JHtml::_('behavior.modal');
$document->addStyleSheet($baseurl.'modules/mod_isotopemart/assets/css/isotope.css');
$document->addCustomTag('<!--[if lt IE 9]>');
$document->addCustomTag('<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>');
$document->addCustomTag('<![endif]-->');
	if ($params->get('loadjQuery', 1)) 
	{
		// Load JQuery only if it's not inside virtuemart
		if (JRequest::getCmd('option')!="com_virtuemart")
		{
			// load jQuery, if not loaded before
			if (!JFactory::getApplication()->get('jquery'))
			{
				//JFactory::getApplication()->set('jquery', true);
        		$document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery-1.7.1.min.js', "text/javascript");
        		$document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery-noConflict.js', "text/javascript");
			}
		}
	}
    $document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery.isotope.min.js', "text/javascript");
    $document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/jquery.infinitescroll.min.js');
    $document->addScript(JURI::base().'modules/mod_isotopemart/assets/js/manual-trigger.js');    
	$document->addScriptDeclaration($script);
	// manage the visibility of the module in VirtueMart views
	if (JRequest::getCmd('option')=="com_virtuemart")
	{
		$cmds = array(  "category",
						"productdetails",
						"manufacturer",
						"user",
						"vendor",
						"cart",
						"orders");
	
		if ((int)$params->get('hide_views'))
		{
			if ( in_array(JRequest::getCmd('view'), $cmds) || in_array(JRequest::getCmd('task'), $cmds) )
			{
				return ;
			}
		}
	
		if (JRequest::getCmd('view')=="virtuemart")
		{
			if ((int)$params->get('hide_front'))
			{
				// get the document object.
				$doc = JFactory::getDocument();
				// get the buffer
				$buffer = $doc->getBuffer('component');
				// reset the buffer and delete the component content
				$doc->setBuffer('', 'component');
			}
		}
	} // end manage the visibility
	
?>
<div id="itVMModuleBox<?php echo $module->id; ?>" class="itVMProductBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">
		<!-- Options -->
        <section id="options" class="options">
			 <?php if($show_filtering==1) {?>			
		   <!-- Filters -->
		   <ul id="filters" class="option-set" data-option-key="filter">
                <li><a href="#filter" data-option-value="*" class="selected"><?php echo JText::_('MOD_ISOTOPEMART_SHOW_ALL'); ?></a></li>
                <?php foreach($catNameArray as $catAlias => $catName): 
				//print_r ($catNameArray);
				?>
                <?php 
                	$res = $categoryModel->getCategory($catAlias);
                	if ($root_category)
                	{
                		if (count($res->parents)==1)
                		{
                			?>	
                			<li><a href="#filter" data-option-value=".categoryid-<?php echo $catAlias; ?>"><?php echo $catName; ?></a></li>
                			<?php 
                		}
                	}
                	else 
					{
                ?>
                    <li><a href="#filter" data-option-value=".categoryid-<?php echo $catAlias; ?>"><?php echo $catName; ?></a></li>
             <?php } endforeach; ?>
            </ul>
            <?php }?>
<div class="clear"></div>
            <?php if($show_sorting) {?>			
			<!-- Sort by-->
			 <ul id="sort-by" class="option-set" data-option-key="sortBy">
			<!-- 	 <li><a href="#sortBy=original-order"     data-option-value="original-order" class="selected" >original</a></li>  -->
				 <li><a href="#sortBy=created_on"         data-option-value="created_on" class="selected"><?php echo JText::_('MOD_ISOTOPEMART_SORT_DATE'); ?></a></li>			
				 <li><a href="#sortBy=product_name"       data-option-value="product_name" ><?php echo JText::_('MOD_ISOTOPEMART_SORT_NAME'); ?></a></li>
				 <li><a href="#sortBy=product_price"      data-option-value="product_price"><?php echo JText::_('MOD_ISOTOPEMART_SORT_PRICE'); ?></a></li>
				 <li><a href="#sortBy=product_ordered"    data-option-value="product_ordered"><?php echo JText::_('MOD_ISOTOPEMART_SORT_SALES'); ?></a></li>
			</ul>
			<?php }?>
            <?php if($show_ordering) {?>	
			<!-- Sort Direction-->
            <ul id="sort-direction" class="option-set" data-option-key="sortAscending">
                <li><a href="#sortAscending=false" data-option-value="false" class="selected"><?php echo JText::_("▼"); ?></a></li>
                <li><a href="#sortAscending=true" data-option-value="true" ><?php echo JText::_("▲"); ?></a></li>
            </ul>
            <?php }?>
        </section>
 <div style="clear:both;"></div>
 <!-- Container By Style -->
     <?php if($item_style == 0) { // begin Default?>
 	<!-- Begin Container Default -->
    <div class="prod_box">
 	 <ul class="vmproduct layout">
	<li>
    <div id="container" class="clearfix<?php if($enable_pagination) echo " infinite-scrolling";?>">
       
        <?php foreach ($products as $key=>$product):
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
		}
		
		$discont = $product->prices['discountAmount'];
		  $discont = abs($discont);
            $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $virtuemart_category_id);
            if (!empty($product->images[0]))
            {
            	if($same_img_size)
            	{
            		$image = '<img src="'.$product->images[0]->file_url.'" height="'.$imgHeight.'" width="'.$itemWidth.'">';            		
            	}
            	else 
				{
					$image = '<img src="'.$product->images[0]->file_url.'" alt="'.$product->product_name.'" width="'.$itemWidth.'">';
				}
            }
            else
            {
                $image = '';
            }
            if ($show_rating_stars)
            {
                $rating = VmModel::getModel('ratings')->getRatingByProduct($product->virtuemart_product_id);
            }
            if (PHP_MAJOR_VERSION>=5 && PHP_MINOR_VERSION>=3) {
                $dateDiff = date_diff(date_create(), date_create($product->product_available_date));
            } else {
                $start = new DateTime($product->product_available_date);
                $end = new DateTime();
                $dateDiff = round(($end->format('U') - $start->format('U')) / (60*60*24));
            }
            $priceDiff = false;
            ?>
				<!-- Categories tag -->
				
				<?php 
				   $catTag=" ";
				   $currentCat = $categoryModel->getCategory($virtuemart_category_id);
					foreach($currentCat->parents as $catParent)
					{
						$catTag .= "categoryid-".$catParent->virtuemart_category_id . " ";
					}
					// sortby  data tag 
					$price = $product->prices['salesPrice'];
					$dataSort= " data-pname=\"$product->product_name\" data-pprice=\"$price\" data-pordered=\"$product->product_ordered\" data-pcreated=\"$product->created_on\"";
					?>
            <div class="itemmart prod-row itVMElement<?php echo $module->id . $catTag; ?> " data-category="<?php echo $catTag;?>" style="width:<?php echo $itemWidth; ?>px;height:<?php echo $itemHeight; ?>px;"  <?php echo $dataSort;?>>
            <?php 
			//if(!$enable_pagination) {
			if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
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
                <input type="hidden" class="count_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
                <input type="hidden" class="my_year" name="virtuemart_product_id" value="<?php echo $year ?>"/>
                <input type="hidden" class="my_month" name="virtuemart_product_id" value="<?php echo $month ?>"/>
                <input type="hidden" class="my_data" name="virtuemart_product_id" value="<?php echo $data ?>"/>
				<div class="count_holder_small">
				<div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
				<div id="CountSmallIzotop<?php echo $product->virtuemart_product_id; ?>" class="count_border">
				 </div>
                 <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $product->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
				 </div>
			  <?php } ?>
              <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
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
                                        
                                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
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
                    <div class="Title">
                    <?php 
					print_r($product->categoryItem['virtuemart_category_id']); ?>
                    <?php 
					echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
				 	<?php
					$ratingModel = VmModel::getModel('ratings');
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
           		 <?php }  ?>					
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
		</div>
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			 <?php
                    echo ModIsotopeMartHelper::addtocart($product, $params);
                ?>
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
                
			<?php if ($show_details) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
            <div class="clear"></div>
			</div>
    	</div>	 
            </div>
            </div>
        <?php endforeach; ?>
    </div>
    </li>
        </ul>
        </div>
    <!-- End Container Default -->
    
     <?php } // end Default 
           else if(($item_style>=1) && ($item_style<=11)){ // begin style 1 => style 11
			
			$cssClass = "";
			
			switch ($item_style) 
			{
				case 1:
					$cssClass = "first";
				break;
				
				case 2:
					$cssClass = "second";
					break;
					
				case 3:
					$cssClass = "third";
					break;

				case 4:
					$cssClass = "fourth";
					break;
							
							
				case 5:
					$cssClass = "fifth";
					break;
								
				case 6:
					 $cssClass = "sixth";
					 break;
									
				case 7:
					$cssClass = "seventh";
					break;
										
				case 8:
					$cssClass = "eighth";
					break;

				case 9:
					$cssClass = "ninth";
					break;
						
						
				case 10:
					$cssClass = "tenth";
					break;

					
				default:
					$cssClass = "first";
				break;
			}
	
      ?> 
 	
 	<!-- Begin Container Style 1-->
 
 	<div class="prod_box">
 	 <ul class="vmproduct layout2">
	<li>
    <div id="container" class="clearfix<?php if($enable_pagination) echo " infinite-scrolling";?>">
       
        <?php foreach ($products as $key=>$product):
		foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
			}
		$discont = $product->prices['discountAmount'];
		  $discont = abs($discont);
            $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $virtuemart_category_id);
            if (!empty($product->images[0]))
            {
            	if($same_img_size)
            	{
            		$image = '<img src="'.$product->images[0]->file_url.'" height="'.$imgHeight.'" width="'.$itemWidth.'">';            		
            	}
            	else 
				{
					$image = '<img src="'.$product->images[0]->file_url.'" alt="'.$product->product_name.'" width="'.$itemWidth.'">';
				}
            }
            else
            {
                $image = '';
            }
            if ($show_rating_stars)
            {
                $rating = VmModel::getModel('ratings')->getRatingByProduct($product->virtuemart_product_id);
            }
            if (PHP_MAJOR_VERSION>=5 && PHP_MINOR_VERSION>=3) {
                $dateDiff = date_diff(date_create(), date_create($product->product_available_date));
            } else {
                $start = new DateTime($product->product_available_date);
                $end = new DateTime();
                $dateDiff = round(($end->format('U') - $start->format('U')) / (60*60*24));
            }
            $priceDiff = false;
            ?>
			
		 
			
				<!-- Categories tag -->
				
				<?php 
				
				   $catTag=" ";
				
				   $currentCat = $categoryModel->getCategory($product->virtuemart_category_id);
					
					foreach($currentCat->parents as $catParent)
					{
						$catTag .= "categoryid-".$catParent->virtuemart_category_id . " ";
					}
					
					// sortby  data tag 
					$price = $product->prices['salesPrice'];
					$dataSort= " data-pname=\"$product->product_name\" data-pprice=\"$price\" data-pordered=\"$product->product_ordered\" data-pcreated=\"$product->created_on\"";
						
					?>
					
            <div class="itemmart prod-row itVMElement<?php echo $module->id . $catTag; ?> " data-category="<?php echo $catTag;?>" style="width:<?php echo $itemWidth; ?>px;height:<?php echo $itemHeight; ?>px;"  <?php echo $dataSort;?>>
            <?php 
			//if(!$enable_pagination) {
			if ($product->prices['override'] == 1 && ($product->prices['product_price_publish_down'] > 0)){
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
                <input type="hidden" class="count_ids" name="virtuemart_product_id" value="<?php echo $product->virtuemart_product_id ?>"/>
                <input type="hidden" class="my_year" name="virtuemart_product_id" value="<?php echo $year ?>"/>
                <input type="hidden" class="my_month" name="virtuemart_product_id" value="<?php echo $month ?>"/>
                <input type="hidden" class="my_data" name="virtuemart_product_id" value="<?php echo $data ?>"/>
				<div class="count_holder_small">
				<div class="count_info"><?php echo JText::_('DR_LIMITED2')?></div>
				<div id="CountSmallIzotop<?php echo $product->virtuemart_product_id; ?>" class="count_border">
				 </div>
                 <div class="bzSaleTimerDesc"><?php echo JText::_('DR_HURRY'); ?><div>&nbsp;<strong><?php echo $product->product_in_stock ?></strong>&nbsp;<?php echo JText::_('DR_HURRY_ITEMS'); ?></div></div>
				 </div>
			  <?php } ?>
              <div class="product-box hover back_w spacer <?php if ($discont>0) { echo 'disc';} ?> ">
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
                                        
                                        echo JHTML::_('link', JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
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
                    <div class="Title">
                    <?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
                    </div>
				 	<?php
					$ratingModel = VmModel::getModel('ratings');
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
           		 <?php }  ?>					
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
		</div>
            <div class="wrapper-slide">
                       <?php 
		   if ($product->prices['salesPrice']<=0 and VmConfig::get ('askprice', 1) ) { ?>
									<div class="call-a-question">
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id.'&tmpl=component'); ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			 <?php
				echo ModIsotopeMartHelper::addtocart($product, $params);
                ?>
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
                
			<?php if ($show_details) { ?>
			<div class="Details">
				<?php echo JHTML::link(JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id), JText::_('DR_DETAILS')); ?><?php ?> 
			</div>
			<?php } ?>
            <div class="clear"></div>
			</div>
    	</div>	 
            </div>
            </div>
        <?php endforeach; ?>
    </div>
    </li>
        </ul>
        </div>
   
    
    <!-- End Container Style 1 -->
 
 	  <?php } // end style 1 
           //else if($item_style == 2){ // begin style 2         
      ?> 
<?php
	
if($enable_pagination){
    $moduleId = $module->id;
	$fetcherPath = "modules/mod_isotopemart/assets/ajax/fetcher.php?modid=$moduleId&perpage=$per_page&page=2";
?>
<nav id="page_nav">
	<a id="next" class="button reset" href="<?php echo $baseurl.''.$fetcherPath?>"><?php echo JText::_('MOD_ISOTOPEMART_LOAD_MORE'); ?></a>
 </nav>
 
 <?php }?>
 </div>
  <script type="text/javascript">
jQuery(document).ready(function() {
		jQuery('.itVMProductBlock .layout .hasTooltip').tooltip('hide');	
		jQuery(".itVMProductBlock img.lazy").show().lazyload({
			effect : "fadeIn"
		});
	});
	jQuery(document).ready(function () {
		 jQuery(".izotop ul.layout .prod-row , .izotop ul.layout2 .prod-row").each(function(indx, element){
			var my_product_id = jQuery(this).find(".count_ids").val();
			var my_year = jQuery(this).find(".my_year").val();
			var my_month = jQuery(this).find(".my_month").val();
			var my_data = jQuery(this).find(".my_data").val();
			//alert(my_data);
			if(my_product_id){
				jQuery('#CountSmallIzotop'+my_product_id).countdown({
				until: new Date(my_year, my_month - 1, my_data), 
				labels: ['Years', 'Months', 'Weeks', '<?php echo JText::_('DR_DAYS')?>', '<?php echo JText::_('DR_HOURS')?>', '<?php echo JText::_('DR_MINUTES')?>', '<?php echo JText::_('DR_SECONDS')?>'],
				labels1:['Years','Months','Weeks','<?php echo JText::_('DR_DAYS')?>','<?php echo JText::_('DR_HOURS')?>','<?php echo JText::_('DR_MINUTES')?>','<?php echo JText::_('DR_SECONDS')?>'],
				compact: false});
			}
			
		});
	});
	jQuery(document).ready(function($) {
		 $(function() {
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

		});

	});
</script>
 
 