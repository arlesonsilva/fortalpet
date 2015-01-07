<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
<div class="container cookies_height">
<div class="cookies<?php $this->_c('cookies')?>">
<jdoc:include type="modules" name="<?php $this->_p('cookie') ?>" />
</div>
</div>
<?php if ($this->checkSpotlight('topheader', 'user-1, user-3, user-9, user-10, user-5, user-6')) : ?>
<div class="header-top style2">
<div class="header-top-border">
<div class="container top-header">
    <?php $this->spotlight ('topheader', 'user-1, user-3, user-9, user-10, user-5, user-6') ?>
 </div>
</div>
</div>
<?php endif ?>