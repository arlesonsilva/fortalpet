<?php
/**
 * @version     1.0.0
 * @package     com_vm2tags
 * @copyright   Copyright (C) 2014. Adrien ROUSSEL Nordmograph.com All rights reserved.
 * @license     GNU General Public License version 3 or later; see LICENSE.txt
 * @author      Nordmograph <contact@nordmograph.com> - http://www.nordmograph.com./extensions
 */

// no direct access
defined('_JEXEC') or die;


if($this->counttobeconverted >0)
{
	?>
    <div class="well"><?php echo JText::_('COM_VM2TAGS_CONVERTOLDTAGS');  ?></div>
	<form  method="post" name="adminForm" id="adminForm">
	<input type="submit" class="btn btn-primary" />
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
	</form>        
	<?php
}
else
	echo JText::_('COM_VM2TAGS_NOOLDTAGSFOUND');