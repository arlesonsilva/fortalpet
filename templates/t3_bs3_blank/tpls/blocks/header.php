<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// get params
$sitename  = $this->params->get('sitename');
$slogan    = $this->params->get('slogan', '');
$logotype  = $this->params->get('logotype', 'text');
$logoimage = $logotype == 'image' ? $this->params->get('logoimage', 'templates/' . T3_TEMPLATE . '/images/logo.png') : '';

if (!$sitename) {
	$sitename = JFactory::getConfig()->get('sitename');
}

?>
<header id="t3-header">
<div class="container">
<div class="row">
		<div class="logo col-md-6 mod-left">
			<div class="logo-<?php echo $logotype ?>">
           	 <h1>
             <?php if($logotype == 'image'){ ?>
				<a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
						<img class="logo-img" src="<?php echo JURI::base(true) . '/' . $logoimage ?>" alt="<?php echo strip_tags($sitename) ?>" />
				</a>
               <?php } else { ?>
               <a href="<?php echo JURI::base(true) ?>" title="<?php echo strip_tags($sitename) ?>">
					<span><?php echo $sitename ?></span>
				</a>
                <small class="site-slogan hidden-xs"><?php echo $slogan ?></small>
               <?php } ?>
				
                </h1>
			</div>
		</div>
        <div class="mod-right col-md-6">
        <div class="fright">
        <div class="fleft block1-custom<?php $this->_c('user-7')?>">   
        <jdoc:include type="modules" name="<?php $this->_p('user-7') ?>" style="raw" />
        </div>
        <div class="fleft block2-custom<?php $this->_c('user-8')?>">  
        <jdoc:include type="modules" name="<?php $this->_p('user-8') ?>" style="raw" />
        </div>
        <div class="fleft block3-custom<?php $this->_c('user-9')?>">  
        <jdoc:include type="modules" name="<?php $this->_p('user-9') ?>" style="raw" />
        </div>
        <div class="fleft block4-custom<?php $this->_c('user-10')?>">  
        <jdoc:include type="modules" name="<?php $this->_p('user-10') ?>" style="raw" />
        </div>
        <div class="fleft block5-custom<?php $this->_c('user-11')?>">  
        <jdoc:include type="modules" name="<?php $this->_p('user-11') ?>" style="raw" />
        </div>
        </div>
        </div>
    <div class="clear"></div>
    </div></div>
</header>