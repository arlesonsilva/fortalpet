<?php
/**
 * @package   T3 Blank
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
?>
	<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6') || $this->checkSpotlight('footnav-top', 'foot1-style2, foot2-style2, foot3-style2, foot4-style2, foot5-style2, foot6-style2') || $this->countModules('footer') ) : ?>

<!-- FOOTER -->
<footer id="t3-footer" class="wrap t3-footer">
 <p id="back-top">
    	<a href="#top" title="Go to Top"><i class="fa fa-angle-up"></i></a>
 </p>
	<?php if ($this->checkSpotlight('footnav-top', 'foot1-style2, foot2-style2, foot3-style2, foot4-style2, foot5-style2, foot6-style2')) : ?>
    <aside class="t3footnav t3footnav-top">
		<!-- FOOT NAVIGATION -->
		<div class="container">
			<?php $this->spotlight('footnav-top', 'foot1-style2, foot2-style2, foot3-style2, foot4-style2, foot5-style2, foot6-style2') ?>
		</div>
		<!-- //FOOT NAVIGATION -->
        </aside>

	<?php endif ?>
	<?php if ($this->checkSpotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6')) : ?>
    <aside class="t3footnav">
		<!-- FOOT NAVIGATION -->
		<div class="container">
			<?php $this->spotlight('footnav', 'footer-1, footer-2, footer-3, footer-4, footer-5, footer-6') ?>
		</div>
		<!-- //FOOT NAVIGATION -->
        </aside>

	<?php endif ?>
    <?php if ($this->countModules('footer')) : ?>
	<section class="t3-copyright">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<jdoc:include type="modules" name="<?php $this->_p('footer') ?>" />
				</div>
				<?php /*?><?php if ($this->getParam('t3-rmvlogo', 1)): ?>
					<div class="col-md-4 poweredby text-hide">
						<a class="t3-logo t3-logo-color" href="http://t3-framework.org" title="Powered By T3 Framework"
						   target="_blank" <?php echo method_exists('T3', 'isHome') && T3::isHome() ? '' : 'rel="nofollow"' ?>>Powered by <strong>T3 Framework</strong></a>
					</div>
				<?php endif; ?><?php */?>
			</div>
		</div>
	</section>
<?php endif ?>
</footer>
<?php endif ?>
<!-- //FOOTER -->