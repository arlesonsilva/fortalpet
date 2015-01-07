<?php
defined('_JEXEC') or die( 'Direct Access to '.basename(__FILE__).' is not allowed.' );
/*
* featured/Latest/Topten/Random Products Module
*
* @version $Id: mod_virtuemart_product.php 2789 2011-02-28 12:41:01Z oscar $
* @package VirtueMart
* @subpackage modules
*
* 	@copyright (C) 2010 - Patrick Kohl
*
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* VirtueMart is Free Software.
* VirtueMart comes with absolute no warranty.
*
* www.virtuemart.net
*/

require('helper.php');
	if (!defined('DS')) define('DS', DIRECTORY_SEPARATOR);

if (!class_exists ('VmConfig')) {
		require(JPATH_ADMINISTRATOR  .'/components/com_virtuemart/helpers/config.php');
	}
VmConfig::loadConfig();

$lang = JFactory::getLanguage();
//$extension = 'mod_vm2_products';
//$lang->load($extension);//  when AJAX it needs to be loaded manually here >> in case you are outside virtuemart !!!


// Display the Feat Product?


$feat = 		(bool)$params->get( 'feat', 0 ); // Display the Product Price?
$layout_feat = $params->get('layout_feat','layout');
//print_r ($layout_feat);

$featTitle = $params->get( 'featTitle','featname' ); // Display the Random Product Name?
$max_items_feat = 		$params->get( 'max_items_feat', 2 ); //maximum number of items to display
$products_per_row_feat = $params->get( 'products_per_row_feat', 4 ); // Display X products per Row

$show_img_feat = 		(bool)$params->get( 'show_img_feat', 1 ); // Display the Product Images?
$show_title_feat = 		(bool)$params->get( 'show_title_feat', 1 ); // Display the Product Title?
$show_cat_feat = 		(bool)$params->get( 'show_cat_feat', 1 ); // Display the Product Categories?
$show_rating_feat = 		(bool)$params->get( 'show_rating_feat', 1 ); // Display the Product Rating?
$show_price_feat = 		(bool)$params->get( 'show_price_feat', 1 ); // Display the Product Price?
$show_details_feat = 		(bool)$params->get( 'show_details_feat', 1 ); // Display the Product Details?
$show_addcart_feat = 		(bool)$params->get( 'show_addcart_feat', 1 ); // Display the Product Addcart?
$show_desc_feat =         (bool)$params->get( 'show_desc_feat', 1 );
$row_desc_feat = $params->get    ('row_desc_feat', 40);

$stock_feat  = 		(bool)$params->get( 'stock_feat', 0 ); // Display the Product Images?
$headerText_feat = 		$params->get( 'headerText_feat', '' ); // Display a Header Text
$footerText_feat = 		$params->get( 'footerText_feat', ''); // Display a footerText
//$categories_id_feat = $params->get('Parent_Category_id_feat', 0);
$osrc = $params->get('featured_outsource');
if (!empty($osrc))
{
$oresource = implode(",", $params->get('featured_outsource'));
	if($oresource !=="null"){
		$resource = "null";
	}
} else {
	$oresource = "null";
}
$src = $params->get('featured_source');
if (!empty($src))
{
$resource = implode(",", $params->get('featured_source'));
	if($resource !=="null"){
		$oresource = "null";
	}
} else {
	$resource = "null";

}

$class_sfx_feat = 		$params->get( 'class_sfx_feat', 'feat'); // Display a footerText


// END Display the Feat Product?



// Display the New Product?
$new = 		     (bool)$params->get( 'new', 1 ); // Display the Random Product?
$layout_new = $params->get('layout_new','layout');
//print_r ($layout_new);

$newTitle = $params->get( 'newTitle', 'new prods' ); // Display the Random Product Name?
$max_items_new = 		$params->get( 'max_items_new', 2 ); //maximum number of items to display
$products_per_row_new = $params->get( 'products_per_row_new', 4 ); // Display X products per Row

$show_img_new = 		(bool)$params->get( 'show_img_new', 1 ); // Display the Product Images?
$show_title_new = 		(bool)$params->get( 'show_title_new', 1 ); // Display the Product Title?
$show_cat_new = 		(bool)$params->get( 'show_cat_new', 1 ); // Display the Product Categories?
$show_rating_new = 		(bool)$params->get( 'show_rating_new', 1 ); // Display the Product Rating?
$show_price_new = 		(bool)$params->get( 'show_price_new', 1 ); // Display the Product Price?
$show_details_new = 		(bool)$params->get( 'show_details_new', 1 ); // Display the Product Details?
$show_addcart_new = 		(bool)$params->get( 'show_addcart_new', 1 ); // Display the Product Addcart?
$show_desc_new  =         (bool)$params->get( 'show_desc_new', 1 );
$row_desc_new  = $params->get    ('row_desc_new', 40);

$stock_new  = 		(bool)$params->get( 'stock_new', 0 ); // Display the Product Images?
$headerText_new = 		$params->get( 'headerText_new', '' ); // Display a Header Text
$footerText_new = 		$params->get( 'footerText_new', ''); // Display a footerText
$osrc = $params->get('new_outsource');
if (!empty($osrc))
{
$oresourcenew = implode(",", $params->get('new_outsource'));
	if($oresourcenew !=="null"){
		$resourcenew = "null";
	}
} else {
	$oresourcenew = "null";
}
$src = $params->get('new_source');
if (!empty($src))
{
$resourcenew = implode(",", $params->get('new_source'));
	if($resourcenew !=="null"){
		$oresourcenew = "null";
	}
} else {
	$resourcenew = "null";

}


$class_sfx_new = 		$params->get( 'class_sfx_rand', 'new'); // Display a footerText


//END Display the New Product?


// Display the Hit Product?

$hit = 		(bool)$params->get( 'hit', 0 ); // Display the Product Price?
$layout_hit = $params->get('layout_hit','layout');
//print_r ($layout_hit);

$hitTitle = $params->get( 'hitTitle', 'Hit Products' ); // Display the Random Product Name?
$max_items_hit = 		$params->get( 'max_items_hit', 2 ); //maximum number of items to display
$products_per_row_hit = $params->get( 'products_per_row_hit', 4 ); // Display X products per Row

$show_img_hit = 		(bool)$params->get( 'show_img_hit', 1 ); // Display the Product Images?
$show_title_hit = 		(bool)$params->get( 'show_title_hit', 1 ); // Display the Product Title?
$show_cat_hit = 		(bool)$params->get( 'show_cat_hit', 1 ); // Display the Product Categories?
$show_rating_hit = 		(bool)$params->get( 'show_rating_hit', 1 ); // Display the Product Rating?
$show_price_hit = 		(bool)$params->get( 'show_price_hit', 1 ); // Display the Product Price?
$show_details_hit = 		(bool)$params->get( 'show_details_hit', 1 ); // Display the Product Details?
$show_addcart_hit = 		(bool)$params->get( 'show_addcart_hit', 1 ); // Display the Product Addcart?
$show_desc_hit =         (bool)$params->get( 'show_desc_hit', 1 );
$row_desc_hit = $params->get    ('row_desc_hit', 40);

$stock_hit  = 		(bool)$params->get( 'stock_hit', 0 ); // Display the Product Images?
$headerText_hit = 		$params->get( 'headerText_hit', '' ); // Display a Header Text
$footerText_hit = 		$params->get( 'footerText_hit', ''); // Display a footerText

$class_sfx_hit = 		$params->get( 'class_sfx_hit', 'hit'); // Display a footerText

$osrc = $params->get('hit_outsource');
if (!empty($osrc))
{
$oresourcehit = implode(",", $params->get('hit_outsource'));
	if($oresourcehit !=="null"){
		$resourcehit = "null";
	}
} else {
	$oresourcehit = "null";
}
$src = $params->get('hit_source');
if (!empty($src))
{
$resourcehit = implode(",", $params->get('hit_source'));
	if($resourcehit !=="null"){
		$oresourcehit = "null";
	}
} else {
	$resourcehit = "null";

}

//END Display the Hit Product?


// Display the Specials Product?

$disc = 		(bool)$params->get( 'disc', 0 ); // Display the Product Price?
$layout_disc = $params->get('layout_disc','layout');
//print_r ($layout_disc);

$discTitle = $params->get( 'discTitle', 'Specials Products' ); // Display the Random Product Name?
$max_items_disc = 		$params->get( 'max_items_disc', 2 ); //maximum number of items to display
$products_per_row_disc = $params->get( 'products_per_row_disc', 4 ); // Display X products per Row

$show_img_disc = 		(bool)$params->get( 'show_img_disc', 1 ); // Display the Product Images?
$show_title_disc = 		(bool)$params->get( 'show_title_disc', 1 ); // Display the Product Title?
$show_cat_disc = 		(bool)$params->get( 'show_cat_disc', 1 ); // Display the Product Categories?
$show_rating_disc = 		(bool)$params->get( 'show_rating_disc', 1 ); // Display the Product Rating?
$show_price_disc = 		(bool)$params->get( 'show_price_disc', 1 ); // Display the Product Price?
$show_details_disc = 		(bool)$params->get( 'show_details_disc', 1 ); // Display the Product Details?
$show_addcart_disc = 		(bool)$params->get( 'show_addcart_disc', 1 ); // Display the Product Addcart?
$show_desc_disc =         (bool)$params->get( 'show_desc_disc', 1 );
$row_desc_disc = $params->get    ('row_desc_disc', 40);

$stock_disc  = 		(bool)$params->get( 'stock_disc', 0 ); // Display the Product Images?
$headerText_disc = 		$params->get( 'headerText_disc', '' ); // Display a Header Text
$footerText_disc = 		$params->get( 'footerText_disc', ''); // Display a footerText
//$categories_id_disc = $params->get('Parent_Category_id_disc', 0);

$class_sfx_disc = 		$params->get( 'class_sfx_disc', 'disc'); // Display a footerText

$osrc = $params->get('disc_outsource');
if (!empty($osrc))
{
$oresourcedisc = implode(",", $params->get('disc_outsource'));
	if($oresourcedisc !=="null"){
		$resourcedisc = "null";
	}
} else {
	$oresourcedisc = "null";
}
$src = $params->get('disc_source');
if (!empty($src))
{
$resourcedisc = implode(",", $params->get('disc_source'));
	if($resourcedisc !=="null"){
		$oresourcedisc = "null";
	}
} else {
	$resourcedisc = "null";

}

//END Display the Specials Product?
// Display the Random Product?
$rand = 		     (bool)$params->get( 'rand', 0 ); // Display the Random Product?
$layout_rand = $params->get('layout_rand','layout');
//print_r ($layout_hit);

$randTitle = $params->get( 'randTitle', 'Random Products' ); // Display the Random Product Name?
$max_items_random = 		$params->get( 'max_items_random', 2 ); //maximum number of items to display
$products_per_row_random = $params->get( 'products_per_row_random', 4 ); // Display X products per Row

$show_img_rand = 		(bool)$params->get( 'show_img_rand', 1 ); // Display the Product Images?
$show_title_rand = 		(bool)$params->get( 'show_title_rand', 1 ); // Display the Product Title?
$show_cat_rand = 		(bool)$params->get( 'show_cat_rand', 1 ); // Display the Product Categories?
$show_rating_rand = 		(bool)$params->get( 'show_rating_rand', 1 ); // Display the Product Rating?
$show_price_rand = 		(bool)$params->get( 'show_price_rand', 1 ); // Display the Product Price?
$show_details_rand = 		(bool)$params->get( 'show_details_rand', 1 ); // Display the Product Details?
$show_addcart_rand = 		(bool)$params->get( 'show_addcart_rand', 1 ); // Display the Product Addcart?
$show_desc_rand =         (bool)$params->get( 'show_desc_rand', 1 );
$row_desc_rand = $params->get    ('row_desc_rand', 40);

$stock_rand  = 		(bool)$params->get( 'stock_rand', 0 ); // Display the Product Images?
$headerText_rand = 		$params->get( 'headerText_rand', '' ); // Display a Header Text
$footerText_rand = 		$params->get( 'footerText_rand', ''); // Display a footerText
$categories_id_rand = $params->get('Parent_Category_id_rand', 0);

$class_sfx_rand = 		$params->get( 'class_sfx_rand', 'random'); // Display a footerText

$osrc = $params->get('rand_outsource');
if (!empty($osrc))
{
$oresourcerand = implode(",", $params->get('rand_outsource'));
	if($oresourcerand !=="null"){
		$resourcerand = "null";
	}
} else {
	$oresourcerand = "null";
}
$src = $params->get('rand_source');
if (!empty($src))
{
$resourcerand = implode(",", $params->get('rand_source'));
	if($resourcerand !=="null"){
		$oresourcerand = "null";
	}
} else {
	$resourcerand = "null";

}

//END Display the Random Product?
//END Display the Rating Product?


$rank = 		(bool)$params->get( 'rank', 0 ); // Display the Product Price?
$layout_rank = $params->get('layout_rank','layout');
//print_r ($layout_rank);

$rankTitle = $params->get( 'rankTitle', 'Rating Products' ); // Display the Random Product Name?
$max_items_rank = 		$params->get( 'max_items_rank', 2 ); //maximum number of items to display
$products_per_row_rank = $params->get( 'products_per_row_rank', 4 ); // Display X products per Row

$show_img_rank = 		(bool)$params->get( 'show_img_rank', 1 ); // Display the Product Images?
$show_title_rank = 		(bool)$params->get( 'show_title_rank', 1 ); // Display the Product Title?
$show_cat_rank = 		(bool)$params->get( 'show_cat_rank', 1 ); // Display the Product Categories?
$show_rating_rank = 		(bool)$params->get( 'show_rating_rank', 1 ); // Display the Product Rating?
$show_price_rank = 		(bool)$params->get( 'show_price_rank', 1 ); // Display the Product Price?
$show_details_rank = 		(bool)$params->get( 'show_details_rank', 1 ); // Display the Product Details?
$show_addcart_rank = 		(bool)$params->get( 'show_addcart_rank', 1 ); // Display the Product Addcart?
$show_desc_rank =         (bool)$params->get( 'show_desc_rank', 1 );
$row_desc_rank = $params->get    ('row_desc_rank', 40);

$headerText_rank = 		$params->get( 'headerText_rank', '' ); // Display a Header Text
$footerText_rank = 		$params->get( 'footerText_rank', ''); // Display a footerText

$class_sfx_rank = 		$params->get( 'class_sfx_rank', 'rating'); // Display a footerText

//END Display the Rating Product?

$product_model = VmModel::getModel('product');
$ratingModel = VmModel::getModel('ratings');
$mainframe = Jfactory::getApplication();
$virtuemart_currency_id = $mainframe->getUserStateFromRequest( "virtuemart_currency_id", 'virtuemart_currency_id',JRequest::getInt('virtuemart_currency_id',0) );
$db =& JFactory::getDBO();


$key = $max_items_random.'.'.$products_per_row_random.'.'.$show_img_rand.'.'.$show_title_rand.'.'.$show_cat_rand.'.'.$show_rating_rand.'.'.$show_price_rand.'.'.$show_details_rand.'.'.$show_addcart_rand.'.'.$virtuemart_currency_id.'.'.$rand.'.'.$max_items_new.'.'.$products_per_row_new.'.'.$show_img_new.'.'.$show_title_new.'.'.$show_cat_new.'.'.$show_rating_new.'.'.$show_price_new.'.'.$show_details_new.'.'.$show_addcart_new.'.'.$new.'.'.$max_items_hit.'.'.$products_per_row_hit.'.'.$show_img_hit.'.'.$show_title_hit.'.'.$show_cat_hit.'.'.$show_rating_hit.'.'.$show_price_hit.'.'.$show_details_hit.'.'.$show_addcart_hit.'.'.$hit.'.'.$max_items_disc.'.'.$products_per_row_disc.'.'.$show_img_disc.'.'.$show_title_disc.'.'.$show_cat_disc.'.'.$show_rating_disc.'.'.$show_price_disc.'.'.$show_details_disc.'.'.$show_addcart_disc.'.'.$disc.'.'.$max_items_rank.'.'.$products_per_row_rank.'.'.$show_img_rank.'.'.$show_title_rank.'.'.$show_cat_rank.'.'.$show_rating_rank.'.'.$show_price_rank.'.'.$show_details_rank.'.'.$show_addcart_rank.'.'.$rank;
$cache	= JFactory::getCache('mod_vm2_productst', 'output');
if (!($output = $cache->get($key))) {
	ob_start();

if($feat){
$where = 'product_special = 1'; $order = 'RAND()';

if($stock_feat=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resource;
//echo $oresource;

if($resource !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resource.')';
}
if($oresource !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresource.')';
}

$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
	if ($rows) {
		$prod = array();
			foreach ($rows as $key => $row) {
			
				$prod[] = $rows[$key]->virtuemart_product_id;
			}

			// $prods_feat = $product_model->getProducts($prod);
			$prods_feat = array();
			foreach ($prod as $id) {
				if ($product = $product_model->getProduct ((int)$id, TRUE, $show_price_feat, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
					$prods_feat[] = $product;
				}
			}
				//var_dump ($prods_feat);
				$product_model->addImages($prods_feat); 
			
			$currency = CurrencyDisplay::getInstance( );

		}

}
if($new){

$where = 'a.virtuemart_product_id > 0'; $order = 'a.created_on DESC';

if($stock_new=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcenew;
//echo $oresourcenew;

if($resourcenew !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resourcenew.')';
}
if($oresourcenew !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresourcenew.')';
}

$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
		 
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id
		"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
	if ($rows) {
		$prod = array();
		
			foreach ($rows as $key => $row) {
				
				$prod[] = $rows[$key]->virtuemart_product_id;
				//echo $rows[$key]->virtuemart_product_id;
			}
			// $prods_new = $product_model->getProducts($prod);
			$prods_new = array();
			foreach ($prod as $id) {
				if ($product = $product_model->getProduct ((int)$id, TRUE, $show_price_new, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
					$prods_new[] = $product;
				}
			}
				//var_dump ($prods);
				$product_model->addImages($prods_new); 
			
			$currency = CurrencyDisplay::getInstance( );

		}
}



if($rand){
$where = 'a.virtuemart_product_id > 0'; $order = 'RAND()';
if($stock_rand=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcerand;
//echo $oresourcerand;

if($resourcerand !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resourcerand.')';
}
if($oresourcerand !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresourcerand.')';
}

$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
//var_dump ($rows);
	if ($rows) {
		$prod = array();
			foreach ($rows as $key => $row) {
				$prod[] = $rows[$key]->virtuemart_product_id;
				//echo $rows[$key]->virtuemart_product_id;
			}
			// $prods_rand = $product_model->getProducts($prod);
			$prods_rand = array();
			foreach ($prod as $id) {
				if ($product = $product_model->getProduct ((int)$id, TRUE, $show_price_rand, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
					$prods_rand[] = $product;
				}
			}
				//var_dump ($prods);
				$product_model->addImages($prods_rand); 
			
			$currency = CurrencyDisplay::getInstance( );

		}
}
if($hit){
$where = 'product_sales > 20'; $order = 'product_sales DESC';
if($stock_hit=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcehit;
//echo $oresourcehit;

if($resourcehit !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resourcehit.')';
}
if($oresourcehit !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresourcehit.')';
}


$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, 
  		 a.created_on as created, '2' AS browsernav
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
//var_dump ($rows);
	if ($rows) {
		$prod = array();
			foreach ($rows as $key => $row) {
				$prod[] = $rows[$key]->virtuemart_product_id;
				//echo $rows[$key]->virtuemart_product_id;
			}
				// $prods_hit = $product_model->getProducts($prod);
			$prods_hit = array();
			foreach ($prod as $id) {
				if ($product = $product_model->getProduct ((int)$id, TRUE, $show_price_hit, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
					$prods_hit[] = $product;
				}
			}
				//var_dump ($prods);
				$product_model->addImages($prods_hit); 
			
			$currency = CurrencyDisplay::getInstance( );

		}

}
if($rank ){
$db =&JFactory::getDBO();
		$db->setQuery('select rating ,ratingcount, rates, virtuemart_product_id   from #__virtuemart_ratings');
		$products = $db->loadAssocList();
		arsort($products);
		$prod = array();
		 
		foreach($products as $product){
			$prod[] = $product['virtuemart_product_id'];
		}
		
		//var_dump ($products);
		//var_dump ($prod);

		// $prods_rank = $product_model->getProducts($prod);
		$prods_rank = array();
		foreach ($prod as $id) {
			if ($product = $product_model->getProduct ((int)$id, TRUE, $show_price_rank, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$prods_rank[] = $product;
			}
		}
			//var_dump ($prods_rank);
			$product_model->addImages($prods_rank); 
			$currency = CurrencyDisplay::getInstance( );
}
if($disc){
	$where = 'prices.product_override_price < prices.product_price AND prices.override != 0'; 
	$order = 'RAND()';
	if($stock_disc=="1") 
{
	$where = $where.' AND product_in_stock > 0';
}
//echo $resourcedisc;
//echo $oresourcedisc;

if($resourcedisc !=="null")
{
	$where = $where.' AND b.virtuemart_category_id IN ('.$resourcedisc.')';
}
if($oresourcedisc !== "null" )
{
$where = $where.' AND b.virtuemart_category_id NOT IN ('.$oresourcedisc.')';
}


$query = "SELECT DISTINCT CONCAT( p.product_name,' ' ) AS title, product_sales AS sales_count, product_in_stock AS in_stock, a.virtuemart_product_id, b.virtuemart_category_id , media.file_url AS product_full_image, p.product_s_desc AS text, product_special AS featured, product_in_stock AS stock, b.category_name as section, prices.override AS discount, prices.product_price AS price, prices.product_override_price AS disc_price, prices.product_discount_id AS discount_id
  		 
  		FROM #__virtuemart_products AS a
  		LEFT JOIN #__virtuemart_products_".VMLANG." p ON p.virtuemart_product_id = a.virtuemart_product_id 
		LEFT JOIN #__virtuemart_product_prices AS prices ON a.virtuemart_product_id = prices.virtuemart_product_id
  		LEFT JOIN #__virtuemart_product_categories AS xref ON xref.virtuemart_product_id = a.virtuemart_product_id
  		LEFT JOIN #__virtuemart_categories_".VMLANG." AS b ON b.virtuemart_category_id = xref.virtuemart_category_id 
		LEFT JOIN #__virtuemart_product_medias AS pm ON pm.virtuemart_product_id = (SELECT IF(a.product_parent_id>0, a.product_parent_id, p.virtuemart_product_id))
		LEFT JOIN #__virtuemart_medias AS media ON pm.virtuemart_media_id = media.virtuemart_media_id"

. ' WHERE ' . $where
  .' GROUP BY a.virtuemart_product_id '
	. ' ORDER BY ' . $order
	;

$db->setQuery($query, 0);
$rows = $db->loadObjectList();
//var_dump ($rows);
	if ($rows) {
		$prod = array();
		foreach ($rows as $key => $row) {
			$prod[] = $rows[$key]->virtuemart_product_id;
			//echo $rows[$key]->virtuemart_product_id;
		}
		// $prods_disc = $product_model->getProducts($prod);
		$prods_disc = array();
		foreach ($prod as $id) {
			if ($product = $product_model->getProduct ((int)$id, TRUE, $show_price_disc, TRUE, 1, FALSE, $virtuemart_shoppergroup_ids)) {
				$prods_disc[] = $product;
			}
		}
		$product_model->addImages($prods_disc); 
		
		$currency = CurrencyDisplay::getInstance();
		//var_dump($prods_disc);
	}

}
require(JModuleHelper::getLayoutPath('mod_vm2_products','default'));

$output = ob_get_clean();
	$cache->store($output, $key);
}
echo $output;
?>
