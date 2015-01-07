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
	
<div class="mod-compare">
    <div id="cur-lang" class="header-button-compare">
           <div id="compare_total"><a class="compare_total heading" href="<?php echo JRoute::_('index.php?option=com_comparelist&Itemid='.$itemid.''); ?>">
            <i class="fa fa-files-o"></i>
            <span>
		   <?php
		   		echo count($_SESSION['ids']); 
		   ?></span></a></div>
    </div>
 </div>