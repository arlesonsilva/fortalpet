<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<?php if ($this->countModules('brand') ) : ?>

<div id="Customblock-brand">
<!-- NAV HELPER -->
<div class="container">
    <div class="row">
      <div class="wrap t3-brand<?php $this->_c('brand') ?>">
			<jdoc:include type="modules" name="<?php $this->_p('brand') ?>" style="T3Xhtml" />
        </div>
	</div>
</div>
<!-- //NAV HELPER -->
</div>
<?php endif ?>