<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('user-12') || $this->countModules('user-14') ) : ?>

<div id="Slider">
<?php if ($this->countModules('user-12')) : ?>

<div class="container">
  <div class="row">
<!-- topslider -->
        <!-- HEADcustom -->
        <div class="col-md-12 slider-custom<?php $this->_c('user-12')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('user-12') ?>" style="raw" />
        </div>
        <!-- //HEADcustom -->
   

<!-- //topslider -->
</div>
</div>
    <?php endif ?>
    <div class="container">
<div class="row">
 <?php if ($this->countModules('user-14')) : ?>
 
        <!-- HEADcustom -->
        <div class="col-md-8 mod-left head-custom<?php $this->_c('user-14')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('user-14') ?>" style="raw" />
        </div>
        <!-- //HEADcustom -->  
    <?php endif ?>
     <?php if ($this->countModules('user-14-2')) : ?>
     <!-- HEADcustom -->
        <div class="col-md-4 head-custom<?php $this->_c('user-14-2')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('user-14-2') ?>" style="raw" />
        </div>
        <!-- //HEADcustom -->
        <?php endif ?>
  </div>
  </div></div>
<?php endif ?>
