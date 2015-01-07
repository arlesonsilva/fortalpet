<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('tabs') ) : ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('html.no-touch .box-paralax2').parallax("50%", 0.1, true);
	});
</script>
<div id="Tabs" class="box-paralax2">
<?php if ($this->countModules('tabs')) : ?>
<div class="container">
  <div class="row">
<!-- topslider -->
        <!-- HEADcustom -->
        <div class="col-md-12 customblock-custom<?php $this->_c('tabs')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('tabs') ?>" style="T3Xhtml" />
        </div>
        <!-- //HEADcustom -->
   

<!-- //topslider -->
</div>
</div>
    <?php endif ?>

  </div>
<?php endif ?>
