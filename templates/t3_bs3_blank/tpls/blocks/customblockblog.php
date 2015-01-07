<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('blog') || $this->countModules('say') ) : ?>
<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('html.no-touch .box-paralax').parallax("50%", 0.1, true);
	});
</script>
<div id="Customblock-blog" class="box-paralax">
<div class="container">
  <div class="row">
<!-- topslider -->
        <!-- HEADcustom -->
        <div class="col-md-6 blog-custom<?php $this->_c('blog')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('blog') ?>" style="T3Xhtml" />
        </div>
        <div class="col-md-6 say-custom<?php $this->_c('say')?>">     
          <jdoc:include type="modules" name="<?php $this->_p('say') ?>" style="T3Xhtml" />
        </div>
        <!-- //HEADcustom -->
   

<!-- //topslider -->
</div>
</div>
  </div>
<?php endif ?>

