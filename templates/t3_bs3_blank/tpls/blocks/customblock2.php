<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('customblock2') ) : ?>

<div id="Customblock2">
<?php if ($this->countModules('customblock2')) : ?>

<div class="container">
  <div class="row">
<!-- topslider -->
        <!-- HEADcustom -->
        <div class="col-md-12 customblock-custom<?php $this->_c('customblock2')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('customblock2') ?>" style="T3Xhtml" />
        </div>
        <!-- //HEADcustom -->
   

<!-- //topslider -->
</div>
</div>
    <?php endif ?>

  </div>
<?php endif ?>
