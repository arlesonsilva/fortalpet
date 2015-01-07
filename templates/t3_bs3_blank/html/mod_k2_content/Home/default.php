<?php
/**
 * @version		$Id: default.php 1812 2013-01-14 18:45:06Z lefteris.kavadas $
 * @package		K2
 * @author		JoomlaWorks http://www.joomlaworks.net
 * @copyright	Copyright (c) 2006 - 2013 JoomlaWorks Ltd. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die;
?>

<div id="k2ModuleBox<?php echo $module->id; ?>" class="k2ItemsBlock<?php if($params->get('moduleclass_sfx')) echo ' '.$params->get('moduleclass_sfx'); ?>">

	<?php if(count($items)): ?>
  <ul id="k2slider">
    <?php foreach ($items as $key=>$item):	?>
    <li>
    <div class="blog-box">
	 <?php if($params->get('itemImage') || $params->get('itemIntroText')): ?>
      <div class="moduleItemIntrotext">
	      <?php if($params->get('itemImage') && isset($item->image)): ?>
	      <a class="moduleItemImage" href="<?php echo $item->link; ?>" title="<?php echo JText::_('K2_CONTINUE_READING'); ?> &quot;<?php echo K2HelperUtilities::cleanHtml($item->title); ?>&quot;">
	      	<img src="<?php echo $item->image; ?>" alt="<?php echo K2HelperUtilities::cleanHtml($item->title); ?>"/>
	      </a>
	      <?php endif; ?>
          <span class="fleft">
		 <?php if($params->get('itemTitle')): ?>
          <a class="moduleItemTitle" href="<?php echo $item->link; ?>"><?php echo $item->title; ?></a>
          <?php endif; ?>
             <?php if($params->get('itemDateCreated')): ?>
          <span class="moduleItemDateCreated"><?php echo JHTML::_('date', $item->created, JText::_('K2_DATE_FORMAT_LC2')); ?></span>
          <?php endif; ?>
      		
      	<?php if($params->get('itemIntroText')): ?>
      	<p class="moduleItemIntro"><?php 
		
		$string = strip_tags($item->introtext);
		$string = substr($string, 0, $params->get('itemIntroTextWordLimit'));
		$string = rtrim($string, '!,.-');
		$string = substr($string, 0, strrpos($string, ' '));
		echo $string.'...';
		?>
		</p>
      	<?php endif; ?>
        <?php if($params->get('itemReadMore') && $item->fulltext): ?>
			<a class="moduleItemReadMore" href="<?php echo $item->link; ?>">
				<?php echo JText::_('K2_READ_MORE'); ?>
			</a>
			<?php endif; ?>
        </span>
      </div>
      <?php endif; ?>

		</div>
      <div class="clr"></div>
    </li>
    <?php endforeach; ?>
  </ul>
  <?php endif; ?>
</div>
<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#k2slider").owlCarousel({
		items : 2,
		autoPlay : 12000,
		 itemsDesktop : [1000,2], //5 items between 1000px and 901px
		itemsDesktopSmall : [900,2], // betweem 900px and 601px
		itemsTablet: [700,2], //2 items between 600 and 0
		itemsMobile : [460,1], // itemsMobile disabled - inherit from itemsTablet option
		stopOnHover : true,
		lazyLoad : false,
		navigation : true,
		 navigationText: [
			"<i class='fa fa-angle-left'></i>",
			"<i class='fa fa-angle-right'></i>"
		]
		}); 
});
</script>

