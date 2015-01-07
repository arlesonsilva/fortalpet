<?php defined('_JEXEC') or die('Restricted access'); error_reporting('E_ALL'); 
JFactory::getLanguage()->load('com_comparelist');
    $items = JFactory::getApplication()->getMenu( 'site' )->getItems( 'component', 'com_comparelist' );
	//print_r($items);
    foreach ( $items as $item ) {
        if($item->query['view'] === 'comparelist'){
			//print_r($item->id);
            $itemid= $item->id;
			
        }
    }
?>
	
	<div class="vmgroup<?php echo $params->get('moduleclass_sfx') ?>" id="mod_compare">

    <div class="not_text compare"><?php echo JText::_('YOU_HAVE_NO_PRODUCT_TO_COMPARE');?></div>
<div class="vmproduct">
		<?php
		foreach ($prods as $product) {
			?>
			<div id="compare_prod_<?php echo $product->virtuemart_product_id; ?>" class="modcompareprod clearfix">
                    <div class="image fleft">
                    <a href="<?php echo JRoute::_('index.php?option=com_virtuemart&view=productdetails&virtuemart_product_id='.$product->virtuemart_product_id.'&virtuemart_category_id='.$product->virtuemart_category_id); ?>">
                    <img src="<?php if (!empty($product->file_url_thumb)){ echo JURI::base().$product->file_url_thumb;}else {echo JURI::base().'images/stories/virtuemart/noimage.gif';} ?>" alt="<?php echo $product->product_name; ?>" title="<?php echo $product->product_name; ?>" /></a>
                    </div>
                    <div class="extra-wrap">
                        <div class="name">
                              <?php echo JHTML::link($product->link, $product->product_name); ?> 
                        </div>
                        <div class="remcompare"><a class="tooltip-1" title="remove"  onclick="removeCompare('<?php echo $product->virtuemart_product_id ;?>');"><i class="fa fa-times"></i></a></div>
                    </div>
			</div>
            <div class="clear"></div>
	<?php }
?>
	</div>
  <div class="clear"></div>
  <div class="seldcomp" id="butseldcomp" > <a class="btn_compare" href="<?php echo JRoute::_('index.php?option=com_comparelist&Itemid='.$itemid.''); ?>"><i class="fa fa-files-o"></i><?php echo JText::_('COM_COMPARE_GO'); ?></a></div>
</div>
	
