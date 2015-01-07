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
<header id="t3-header" class="style2">
<div class="container">
<div class="row">
		<div class="logo col-lg-2 col-md-4 col-sm-12 col-xs-12 mod-left">
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
        <div class="logo col-lg-3 col-md-4 col-sm-12 col-xs-12 mod-left">
        	<?php if ($this->countModules('cadastro_visitante')) : ?>  
                  <jdoc:include type="modules" name="<?php $this->_p('cadastro_visitante') ?>" style="raw"/>
            <?php endif ?>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-12 col-xs-12 mod-right">
        <div class="fleft block1-custom<?php $this->_c('user-2')?>" style="margin-top:145px">   
        	<jdoc:include type="modules" name="<?php $this->_p('user-2') ?>" style="raw" />
        </div>
        </div>
         <?php /*?><div class="fleft search-custom<?php $this->_c('head-search')?>"> 
      	  <jdoc:include type="modules" name="<?php $this->_p('head-search') ?>" style="raw" />
        </div><?php */?>
        <?php /*?><div class="fright"><?php */?>
        <?php /*?></div><?php */?>
        <?php /*?><div class="clear"></div><?php */?>
        <div class="col-lg-5 col-md-4 col-sm-12 col-xs-12 mod-right">
            <?php if($type != 'logout') : ?>
                <?php if ($this->countModules('banner_cadastro_todo')) : ?>
            		<jdoc:include type="modules" name="<?php $this->_p('banner_cadastro_todo') ?>" style="raw" />
                <?php endif ?>
            <?php elseif ($type == 'logout') : ?>
            	<?php if ($this->countModules('banner_cadastro')) : ?>
                	<jdoc:include type="modules" name="<?php $this->_p('banner_cadastro') ?>" style="raw" />
                <?php endif ?>
           <?php endif ?>
        </div>
    	</div>
        <?php /*?><div class="clear"></div><?php */?>
        </div>
    </div>
    
</header>