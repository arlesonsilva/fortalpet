<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('portfolio') ) : ?>

<div id="Customblock-Portfolio">
<div class="container">
  <div class="row">
<!-- topslider -->
        <!-- HEADcustom -->
        <div class="col-md-12 portfolio-custom<?php $this->_c('portfolio')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('portfolio') ?>" style="T3Xhtml" />
        </div>
        <!-- //HEADcustom -->
   

<!-- //topslider -->
</div>
</div>
  </div>
<?php endif ?>
