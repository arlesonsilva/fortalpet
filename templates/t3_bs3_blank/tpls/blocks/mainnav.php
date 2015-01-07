<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="container">
<!-- MAIN NAVIGATION -->
<nav id="t3-mainnav" class="wrap navbar navbar-default t3-mainnav">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
        
		<div class="navbar-header">
		<?php  if ($this->getParam('navigation_type') == 'megamenu') {?> 
			<?php if ($this->getParam('navigation_collapse_enable', 1) && $this->getParam('responsive', 1)) : ?>
				<?php $this->addScript(T3_URL.'/js/nav-collapse.js'); ?>
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".t3-navbar-collapse">
					<i class="fa fa-bars"></i>
                    <span class="menu_title"><?php echo JText::_('DR_MENU_TITLE'); ?></span>
				</button>
                
			<?php endif ?>
			<?php } ?>
			<?php if ($this->getParam('addon_offcanvas_enable')) : ?>
				<?php $this->loadBlock ('off-canvas') ?>
			<?php endif ?>

		</div>
		
		<?php if ($this->getParam('navigation_collapse_enable')) : ?>
			<div class="t3-navbar-collapse navbar-collapse collapse"></div>
		<?php endif ?>
		 <?php  if ($this->getParam('navigation_type') == 'megamenu') {?> 

		<div class="t3-navbar navbar-collapse collapse">
			<jdoc:include type="<?php echo $this->getParam('navigation_type', 'megamenu') ?>" name="<?php echo $this->getParam('mm_type', 'mainmenu') ?>" />
            <div class="search-custom<?php $this->_c('head-search')?>"> 
    		<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
            </div>
		</div>
		<?php } else { ?>
		<div id="joom-mainnav" class="t3-mainnav">
			<jdoc:include type="modules" name="<?php $this->_p('mainnav') ?>" style="raw" />
             <div class="search-custom<?php $this->_c('head-search')?>"> 
    		<jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
            </div>
		</div>
			<?php }?> 
	</div>
</nav>
<!-- //MAIN NAVIGATION -->
</div>