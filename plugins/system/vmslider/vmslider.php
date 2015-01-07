<?php
/*------------------------------------------------------------------------
# Plg_vmslider : Joomla Virtuemart images product Plugin
# ------------------------------------------------------------------------
# author: Lamvt Vinaora Team
# copyright Copyright (C) 2012 joomquery.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.joomquery.com
# Technical Support: http://joomquery.com/en/home/our-products/8215-vt-jqzoom-virtuemart-joomla-plugin.html
-------------------------------------------------------------------------*/
?>
<?php
defined('JPATH_BASE') or die;
class PlgSystemVmSlider extends JPlugin{
	function __construct($event,$params){
		parent::__construct($event,$params);
	}

	public function onBeforeRender() {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$view = JRequest::getVar('view');
		if ($app->isAdmin()){
					return true;
				}
			if ($view !='productdetails'){
				return true;
			}
		$pluginLivePath = JURI::root(true).'/plugins/system/vmslider/';
			
			$doc->addScript($pluginLivePath.'js/more_custom.js');
			$doc->addScript($pluginLivePath.'js/custom_js.js');
			$doc->addStyleSheet($pluginLivePath.'css/jquery.jqzoom.css');
			$doc->addStyleSheet($pluginLivePath.'css/fancybox/jquery.fancybox.css');	
		

	}
	public function onAfterRender() {
		$app = JFactory::getApplication();
		$doc = JFactory::getDocument();
		$view = JRequest::getVar('view');
		if ($app->isAdmin()){
				return true;
			}
		if ($view !='productdetails'){
			return true;
		}
						
		$buffer = JResponse::getBody();		
		$regx = '/<div class="main-image">([^`]*?)<\/div>/';
		$regx2 = '/<div class="floatleft">([^`]*?)<\/div>/';
		$regx3 = '/<div class="additional-images">/';
		$getMainImage = $this->getMainImage();
		$getAddImages = $this->getAddImages();
		
		$buffer = preg_replace($regx2,'',$buffer);		
		$buffer = preg_replace($regx3,$getAddImages,$buffer);		
		$buffer = preg_replace($regx,$getMainImage,$buffer);		
		JResponse::setBody($buffer);

		return true;
	}
	
	function getMainImage(){
		if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
		$config = VmConfig::loadConfig();
		$pluginLivePath = JURI::root(true).'/plugins/system/vmslider/';
		$product_model = VmModel::getModel('product');
		$virtuemart_product_id = JRequest::getInt('virtuemart_product_id', 0);
		$product = $product_model->getProduct($virtuemart_product_id);
		$product_model->addImages($product);
		$images = $product->images;
		//print_r($product->images);
		
		if ($images[0]->published !==0){
				$main_image_url = JURI::root(true).'/'.$images[0]->file_url;
			}else {
				$main_image_url = JURI::root(true).'/images/stories/virtuemart/noimage.gif';
				}
				
			if (!empty($images[0]->file_url_thumb)){
				$main_image_url2 = JURI::root(true).'/'.$images[0]->file_url_thumb;
			}else {
				$main_image_url2 = JURI::root(true).'/images/stories/virtuemart/noimage.gif';
				}
		
		$main_image_title = $images[0]->file_title;// [file_title][file_description][file_meta]
		$main_image_description = $images[0]->file_description;// [file_title][file_description][file_meta]
		$main_image_alt = $images[0]->file_meta;// [file_title][file_description][file_meta]
		$vm_id = $product->virtuemart_product_id;
		$discont = $product->prices['discountAmount'];
		$discont = abs($discont);
		
		$j = count($images);
		$imageWidth = 		trim($this->params->get('imageWidth',380));
		if($imageWidth==''){$imageWidth = 'auto';}
		$imageHeight = 		trim($this->params->get('imageHeight'));
		if($imageHeight==''){$imageHeight = 'auto';}
		
		//add HTML
		$html = "";
		$html .= "<div class=\"clearfix\">";
		$html .= "<div class=\"main-image\">";
		$html .= "<div class='zoomlupa photo'>";
		$html .= "</div>";
		$html .= "<div class='lbl-box2'>";
		$stockhandle = VmConfig::get ('stockhandle', 'none');
		if (($stockhandle == 'disableit' or $stockhandle == 'disableadd') and (($product->product_in_stock - $product->product_ordered) < 1) || 
				(($product->product_in_stock - $product->product_ordered) < $product->min_order_level ))  { 
			$html .= "<div class='soldafter'></div>";
			$html .= "<div class='soldbefore'></div>";
			$html .= "<div class='sold'>".JText::_('DR_SOLD')."</div>";
		  }    
		 $html .= "</div>";
		$html .= "<div class='lbl-box'>";
				if ($product->override == 1 && ($product->product_price_publish_down > 0)){ 
				$html .= "<div class='offafter'></div>";
					$html .= "<div class='offbefore'></div>";
				$html .= "<div class='discount limited'>".JText::_('DR_LIMITED_OFFER')."</div>";
				  } elseif($discont >0 && $product->product_sales < 20 ) { 
				   $html .= "<div class='discafter'></div>";
					$html .= "<div class='discbefore'></div>";
				$html .= "<div class='discount'>".JText::_('DR_SALE')."</div>";
					 } elseif ($product->product_sales > 20) {
					$html .= "<div class='hitafter'></div>";
					$html .= "<div class='hitbefore'></div>";
					 $html .= " <div class='hit'>".JText::_('DR_HOT')."</div>";
					   } 
          $html .= "</div>";

	 	$html .= "<img style='display:none!important;'  src='".$main_image_url2."'  class='big_img' id='Img_to_Js_".$vm_id."'/>";
		$html .= "<img width='".$imageWidth."' height='".$imageHeight."'  src='".$main_image_url."'  title='".$main_image_title."'   alt='".$main_image_alt."' class='big_img' id='Img_zoom2'/>";
		$html .= "</div>";
		$html .= "</div>";		
    return $html;
	}
	
	function getAddImages(){
		if (!class_exists( 'VmConfig' )) require(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_virtuemart'.DS.'helpers'.DS.'config.php');
		$config = VmConfig::loadConfig();
		$pluginLivePath = JURI::root(true).'/plugins/system/vmslider/';
		$product_model = VmModel::getModel('product');
		$virtuemart_product_id = JRequest::getInt('virtuemart_product_id', 0);
		$product = $product_model->getProduct($virtuemart_product_id);
		$product_model->addImages($product);

		$images = $product->images;
		$main_image_url = JURI::root(true). $images[0]->file_url;// [file_title][file_description][file_meta]
		if (!empty($images[0]->file_url_thumb)){
			$main_image_url_th = JURI::root(true).'/'. $images[0]->file_url_thumb;
		}else {
			$main_image_url_th=JURI::root(true).'/images/stories/virtuemart/noimage.gif';
		}
		$main_image_title = $images[0]->file_title;// [file_title][file_description][file_meta]
		$main_image_description = $images[0]->file_description;// [file_title][file_description][file_meta]
		$main_image_alt = $images[0]->file_meta;// [file_title][file_description][file_meta]

		//$j = count($images);
		$thumbimageWidth = 		trim($this->params->get('thumbimageWidth',78));
		if($thumbimageWidth==''){$thumbimageWidth = 'auto';}
		$thumbimageHeight = 		trim($this->params->get('thumbimageHeight',78));
		if($thumbimageHeight==''){$thumbimageHeight = 'auto';}
		//add HTML
       			 $j = count($images);
                //add HTML
                if($j <= 3){ $class='none';}else{$class='';}
				 if($j == 1){ $classimg=' noneimg';}else{$classimg='';}
				if($j >0){
                
		$html = "";
		$html .= "<div class=\"jcarousel-container gfdgdf clearfix ".$class.$classimg."\">";	
		$html .= "<div id=\"gallery_02\" class=\"jcarousel jcarousel-container  additional-images ".$class."\">";
		$html .= "<ul id='carousel2' class='paginat'>";	
			 for($i=0; $i<$j; $i++){
				$html .= "<li class=\"floatleft\"><a class=\"thumb\" href='#' data-image='".JURI::root().''.$images[$i]->file_url."' data-zoom-image='".JURI::root().''.$images[$i]->file_url."' ><img style=\"width:".$thumbimageWidth."px !important;height:".$thumbimageHeight."px !important;\" title='".$images[$i]->file_meta."'  src='".JURI::root().''.$images[$i]->file_url_thumb."'></a></li>";
			}	
		$html .= "</ul>";
				$html .= "<img title='".$main_image_title."'   alt='".$main_image_alt."' style=\"width:".$thumbimageWidth."px !important;height:".$thumbimageHeight."px !important; visibility:hidden!important;\" src='".$main_image_url_th."'>";

			$html .= "<div class='clear'></div>";
		
		$html .= "</div>";
		$html .= "<a href='#' class='jcarousel-control-prev'><span class='fa fa-angle-left'></span></a>";
        $html .= "<a href='#' class='jcarousel-control-next'><span class='fa fa-angle-right'></span></a>";
		}
    return $html;
	
	}
	
	
}

?>
