<?php
/**
 * @author ITechnoDev, LLC
 * @copyright (C) 2014 - ITechnoDev, LLC
 * @license GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

// include the API of Joomla

define( '_JEXEC', 1 );

define( 'DS', DIRECTORY_SEPARATOR );
define( 'JPATH_BASE', realpath(dirname(__FILE__) .DS.'..'.DS.'..'.DS.'..'.DS.'..'.DS ) );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );
$app = JFactory::getApplication('site');
$app->initialise();
$lang =& JFactory::getLanguage();
$extension = 'com_virtuemart';
$base_dir = JPATH_SITE;
$language_tag = 'en-GB';
$reload = true;
$lang->load($extension, $base_dir, $language_tag, $reload);

// end of include the API of Joomla
// include the helper of the module to use its static functions
require_once (JPATH_BASE.DS.'modules'.DS.'mod_isotopemart'.DS.'helper.php');
// import needed files to load the module paramters
// import needed files to use some AdsManger functions like TRoute::
if (!class_exists ('VmConfig')) {
	require(JPATH_ADMINISTRATOR . DS . 'components' . DS . 'com_virtuemart' . DS . 'helpers' . DS . 'config.php');
}

// Load the language file of com_virtuemart.
VmConfig::loadConfig();
VmConfig::loadJLang('mod_isotopemart', true);
VmConfig::loadJLang('com_virtuemart', true);
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


$document = JFactory::getDocument();
$baseurl = JURI::base(); 

// start fetcher script

$page 	 = 0;
$start 	 = 0;
$perpage = 6 ;  
$modid 	 = 0 ;

if(isset($_GET['modid']))
{
	if(!empty($_GET['modid']))
	{
		$modid = (int)$_GET['modid'];
	}
	else
	{
		die();
	}
}
else
{
	die();
}

if($modid<=0)
{
	die();
}


if(isset($_GET['perpage']))
{
	if(!empty($_GET['perpage']))
	{
		if ((int)$_GET['perpage']>=1)
		{
			$perpage = (int)$_GET['perpage'];
		}
	}
}


if(isset($_GET['page']))
{
	if(!empty($_GET['page']))
	{
		$page = (int)$_GET['page'];
		$start = ($page * $perpage )-$perpage  ;
	}
	else
	{
		die();
	}
}
else
{
	die();
}
if($page<=1) // we know that we will start using this script only from the second page
{
	?>
<?php
	die();
}

 

$db			=&  JFactory::getDBO();

$query = 	'SELECT * '.
		'FROM  #__modules AS m '.
		'WHERE m.published=1 AND id='.$modid;


$db->setQuery($query);
$mod = $db->loadObjectList();

$modparams = (array) json_decode($mod[0]->params);


$category_id = 					$modparams['virtuemart_category_id'];  
$item_style = 	    			(int)$modparams['item_style'];       			//  1  
$show_price = 				   (bool) $modparams['show_price'];  				//  1   
$show_discounted_price =	    $modparams['show_discounted_price'];  			//  1  
$show_addtocart = 				(bool)$modparams['show_addtocart'];  			//  1    
$show_addtocart_custom_fields = $modparams['show_addtocart_custom_fields'];  	//  1 
$product_group = 				$modparams['product_group'];  					// 'featured' 
$itemWidth  	 = 				$modparams['itemWidth'];  						//  282 
$itemHeight      = 				$modparams['itemHeight'];  						//  427 
$imgHeight      = 				$modparams['imgHeight'];  						//  400 
$show_rating_stars = 			(bool)$modparams['show_rating_stars'];  		//  1  
$show_new_badge = 				(bool)$modparams['show_new_badge'];  			//  1  
$new_product_from = 			$modparams['new_product_from'];  				//  3 
$root_category = 				(bool)$modparams['root_category']; 				//  1   
$max_items = 					$modparams['max_items'];  						//  20   
$same_img_size = 				(bool)$modparams['same_img_size'];  			//  1    
$theme_style = 					$modparams['theme_style'];  					// 'blue' 
$show_sorting = 				(bool)$modparams['show_sorting'];  				//  1  
$show_ordering = 				(bool)$modparams['show_ordering'];  			//  1  
$show_sales_badge = 			(bool)$modparams['show_sales_badge'];  			//  1  
$enable_pagination = 			(bool)$modparams['enable_pagination'];  		//  0   
$per_page = 					(int)$modparams['per_page']; 
 
	 var_dump ($modparams);

$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
	/* Load  VM fonction */
	$vendorId = JRequest::getInt('vendorid', 1);
	$productModel  = VmModel::getModel('Product');
	$categoryModel = VmModel::getModel('Category');
	$products   = ModIsotopeMartHelper::getProductList($product_group, $max_items, true, true, false, true, $category_id,$start,$per_page);
    if (count($products))
    {
            $catAliasArray = array();
            $catNameArray = array();
            foreach ($products as $product)
            {    
                if (!in_array($product->virtuemart_category_id, $catAliasArray))
                {
                    $catAliasArray[] = $product->virtuemart_category_id;
                    $catNameArray[$product->virtuemart_category_id] = $product->category_name;
                }
            }
    }
	$productModel->addImages($products);
	$totalProd = 		count( $products);
	if(empty($products)) return false;
	$currency = CurrencyDisplay::getInstance( );
 
	if ($show_addtocart) 
	{
		vmJsApi::jQuery();
		vmJsApi::jPrice();
		vmJsApi::cssSite();
	}
 // Container By Style -->
       if($item_style == 0) { // begin Default ?>
 	<!-- Begin Container Default -->
    <div id="container" class="clearfix<?php if($enable_pagination) echo " infinite-scrolling";?> prod_box">
        <?php foreach ($products as $key=>$product){
			foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
			}
		$discont = $product->prices['discountAmount'];
		  $discont = abs($discont);
           // $url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);

        $ba = dirname(dirname(dirname(dirname(JURI::base()))));
		
		//$href2 = str_replace('modules/mod_isotopemart/assets/ajax/', '', JURI::base());
		
        $url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $virtuemart_category_id);
		
		$url2 = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url);
		
		 $url_ask = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component');
		
		$url2_ask= str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_ask);
		
           
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
            <div class="itemmart prod-row itVMElement<?php echo $modid . $catTag; ?> " data-category="<?php echo $catTag;?>" style="width:<?php echo $itemWidth; ?>px;height:<?php echo $itemHeight; ?>px;"  <?php echo $dataSort;?>>
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
                                $main_image_url1 = $ba.'/'.$images[0]->file_url_thumb;
                            }else {
                                $main_image_url1 = $ba.'/images/stories/virtuemart/noimage.gif';
                                }
                            if (!empty($images[1]->file_url_thumb)){
                                $main_image_url2 = $ba.'/'.$images[1]->file_url_thumb;
                            }else {
                                $main_image_url2 = $ba.'/images/stories/virtuemart/noimage.gif';
                                }
                            $image = '<img  src="'.$main_image_url1 .'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                            ?>
                
                               <?php
                                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                                        if(!empty($product->images[1])){
                                         $image2 = '<img  src="'.$main_image_url2 .'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy2 browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                                        } else {$image2 = '<img src="'.$main_image_url1 .'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy2 browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
                                        
                                        echo JHTML::_('link', $url2,'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
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
                    <?php echo JHTML::link($url2, shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
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
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo $url2_ask; ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			 <?php
                    echo ModIsotopeMartHelper::addtocartajax($product, $modparams);
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
        <?php } ?>
       
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
 
 	<div id="container" class="clearfix<?php if($enable_pagination) echo " infinite-scrolling";?> prod_box"> 
        <?php foreach ($products as $key=>$product){
			foreach ($product->categoryItem as $key=>$prod_cat) {
			$virtuemart_category_id=$prod_cat['virtuemart_category_id'];
			}
		$discont = $product->prices['discountAmount'];
		  $discont = abs($discont);
            //$url = JRoute::_ ('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $product->virtuemart_category_id);
            
        $ba = dirname(dirname(dirname(dirname(JURI::base()))));
        $url = $ba.'/index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $virtuemart_category_id;
        $url = JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id=' . $product->virtuemart_product_id . '&virtuemart_category_id=' . $virtuemart_category_id);
		
		$url2 = str_replace('modules/mod_isotopemart/assets/ajax/', '', $url);
		
		 $url_ask = JRoute::_('index.php?option=com_virtuemart&view=productdetails&task=askquestion&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$virtuemart_category_id.'&tmpl=component');
		
		$url2_ask= str_replace('modules/mod_isotopemart/assets/ajax/', '', $url_ask);

 
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
					
            <div class="itemmart prod-row view-<?php echo $cssClass;?> itVMElement<?php echo $modid . $catTag; ?> " data-category="<?php echo $catTag;?>" style="width:<?php echo $itemWidth; ?>px;height:<?php echo $itemHeight; ?>px;"  <?php echo $dataSort;?>>
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
                                $main_image_url1 = $ba.'/'.$images[0]->file_url_thumb;
                            }else {
                                $main_image_url1 = $ba.'/images/stories/virtuemart/noimage.gif';
                                }
                            if (!empty($images[1]->file_url_thumb)){
                                $main_image_url2 = $ba.'/'.$images[1]->file_url_thumb;
                            }else {
                                $main_image_url2 = $ba.'/images/stories/virtuemart/noimage.gif';
                                }
                            $image = '<img  src="'.$main_image_url1 .'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                            ?>
                
                               <?php
                                       // $image = $product->images[0]->displayMediaThumb('class="browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'" border="0"',false) ; 
                                        if(!empty($product->images[1])){
                                         $image2 = '<img  src="'.$main_image_url2 .'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy2 browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';
                                        } else {$image2 = '<img  src="'.$main_image_url1 .'"  title="'.$main_image_title.'"   alt="'.$main_image_alt. '" class="lazy2 browseProductImage featuredProductImageFirst" id="Img_to_Js_'.$product->virtuemart_product_id.'"/>';}
                                        
                                        echo JHTML::_('link', JRoute::_($url2),'<div class="front">'.$image.'</div><div class="back">'.$image2.'</div>');
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
                    <?php echo JHTML::link(JRoute::_($url2), shopFunctionsF::limitStringByWord($product->product_name,'30','...'), array('title' => $product->product_name)); ?>
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
                                     	<a class="call modal addtocart-button"  rel="{handler: 'iframe', size: {x: 460, y: 550}}" href="<?php echo $url2_ask; ?>" ><?php echo JText::_('COM_VIRTUEMART_PRODUCT_ASKPRICE') ?></a>
                                    </div>
									<?php } ?>

			 <?php
                   echo ModIsotopeMartHelper::addtocartstyleajax($product, $modparams);
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
                
            <div class="clear"></div>
			</div>
    	</div>
 					 
 </div>
            </div>
        <?php } ?>
    </div>
    
     <?php } // end style 1 
           //else if($item_style == 2){ // begin style 2         
      ?> 
