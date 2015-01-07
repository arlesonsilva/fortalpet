<?php
/*======================================================================*\
|| #################################################################### ||
|| # Copyright ©2006-2009 Youjoomla LLC. All Rights Reserved.           ||
|| # ----------------     JOOMLA TEMPLATES CLUB      ----------- #      ||
|| # @license http://www.gnu.org/copyleft/gpl.html GNU/GPL            # ||
|| #################################################################### ||
\*======================================================================*/
defined('_JEXEC') or die('Restricted access'); 
$document = JFactory::getDocument();
?>
<?php if($type == 'logout') : ?>
<div id="logins">
	
	<span class="admin"><?php if ($params->get('greeting')) : ?>
	<?php echo JText::_('HINAME') ?> <?php 
	if($params->get('name') == 0 ){
		echo $user->get('username')."!!!";
	}else{
		echo $user->get('name')."!!!";
	}
		?>
	<?php endif; ?></span>
    <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" id="login-form2">
		<input type="submit" name="Submit" class="button" value="Logout" />
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.logout" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHTML::_( 'form.token' ); ?>
	</form>
</div>
<?php else : ?>

<!-- registration and login -->
<?php /*?><div class="poping_links"> <?php echo $params->get('pretext'); ?>
	<a href="#"  id="openLogin" data-toggle="modal" data-target="#myModal"><?php echo JText::_('LOGIN') ?></a>&nbsp;<?php echo JText::_('OR') ?>
    <?php $usersConfig = &JComponentHelper::getParams( 'com_users' ); if ($usersConfig->get('allowUserRegistration')) : ?>
	<a  href="index.php?option=com_virtuemart&view=user&layout=edit"  id="openReg"><?php echo JText::_('REGISTER'); ?></a> 
	<?php endif; ?>
</div><?php */?>
<div class="poping_links" style="margin-top:40px;">
	<?php echo $params->get('pretext'); ?> <br /> <a  href="index.php?option=com_virtuemart&view=user&layout=edit"  id="openReg" style="font-weight:bold; color:#666; padding-left:25px;">Clique para se cadastrar.</a>
</div>
<!-- login -->
<!-- registration  -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
       <span class="title"><?php echo JText::_('DR_LOG_IN') ?></span>
      </div>
      <div class="modal-body">
      	<?php if(JPluginHelper::isEnabled('authentication', 'openid')) : ?>
		<?php JHTML::_('script', 'openid.js'); ?>
        <?php endif; ?>

        <form action="<?php echo JRoute::_('index.php', true, $params->get('usesecure')); ?>" method="post" name="login" id="form-login" >
     
    	<div class="fleft log">
		<span><label for="yjpop_username"><?php echo JText::_('USERNAME') ?></label></span>
		<input id="yjpop_username" type="text" name="username" class="inputbox" alt="username" size="18" />
        </div>
        <div class="fleft log">
		<span><label for="yjpop_passwd"><?php echo JText::_('PASSWORD') ?></label></span>
		<input id="yjpop_passwd" type="password" name="password" class="inputbox" size="18" alt="password" />
        </div>
        <?php if(JPluginHelper::isEnabled('system', 'remember')) : ?>
		<div class="wrapper_remember">
        <input id="yjpop_remember" type="checkbox" name="remember" class="inputbox" value="yes" alt="Remember Me" />
		<label for="yjpop_remember"><?php echo JText::_('REMEMBER') ?></label>
		</div>
		<?php endif; ?>
         <div class="wrapper2 log button-log">
         <button class="button" type="submit"><?php echo JText::_('LOGIN') ?></button>
             <ul class="Forgot">
            <li><a href="<?php echo JRoute::_( 'index.php?option=com_users&view=reset' ); ?>"><?php echo JText::_('FORGOT_YOUR_PASSWORD') ?></a></li>
            <li><a href="<?php echo JRoute::_( 'index.php?option=com_users&view=remind' ); ?>"><?php echo JText::_('FORGOT_YOUR_USERNAME') ?></a></li>
			</ul>
         </div>
         <div class="clear"></div>
         <div class="create_customer">
         <span><?php echo JText::_('NEW_CUSTOMER'); ?></span>
		 <?php $usersConfig = &JComponentHelper::getParams( 'com_users' ); if ($usersConfig->get('allowUserRegistration')) : ?>
                <a class="reg_btn button reset"  href="index.php?option=com_virtuemart&view=user&layout=edit"  ><?php echo JText::_('REGISTER'); ?></a> 
         <?php endif; ?>
      	 </div>
		<?php echo $params->get('posttext'); ?>
		<input type="hidden" name="option" value="com_users" />
		<input type="hidden" name="task" value="user.login" />
		<input type="hidden" name="return" value="<?php echo $return; ?>" />
		<?php echo JHtml::_('form.token'); ?>
	</form>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- end registration and login -->
<?php endif; ?>
<script type="text/javascript" >

</script>
