<?php
/**
*
* Layout for the login
*
* @package	VirtueMart
* @subpackage User
* @author Max Milbers, George Kostopoulos
*
* @link http://www.virtuemart.net
* @copyright Copyright (c) 2004 - 2010 VirtueMart Team. All rights reserved.
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
* VirtueMart is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* @version $Id: cart.php 4431 2011-10-17 grtrustme $
*/

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');
error_reporting('E_ALL');

if (!isset( $this->show )) $this->show = TRUE;
if (!isset( $this->from_cart )) $this->from_cart = FALSE;
if (!isset( $this->order )) $this->order = FALSE ;

if (empty($this->url)){
	$url = vmURI::getCleanUrl();
} else{
	$url = $this->url;
}

$user = JFactory::getUser();

if ($this->show and $user->id == 0  ) {
JHtml::_('behavior.formvalidation');
JHtml::_ ( 'behavior.modal' );



//$uri = JFactory::getURI();
//$url = $uri->toString(array('path', 'query', 'fragment'));


	//Extra login stuff, systems like openId and plugins HERE
       if (JPluginHelper::isEnabled('authentication', 'openid')) {
        $lang = JFactory::getLanguage();
        $lang->load('plg_authentication_openid', JPATH_ADMINISTRATOR);
        $langScript = '
//<![CDATA[
'.'var JLanguage = {};' .
                ' JLanguage.WHAT_IS_OPENID = \'' . vmText::_('WHAT_IS_OPENID') . '\';' .
                ' JLanguage.LOGIN_WITH_OPENID = \'' . vmText::_('LOGIN_WITH_OPENID') . '\';' .
                ' JLanguage.NORMAL_LOGIN = \'' . vmText::_('NORMAL_LOGIN') . '\';' .
                ' var comlogin = 1;
//]]>
                ';
        $document = JFactory::getDocument();
        $document->addScriptDeclaration($langScript);
        JHtml::_('script', 'openid.js');
    }

    $html = '';
    JPluginHelper::importPlugin('vmpayment');
    $dispatcher = JDispatcher::getInstance();
    $returnValues = $dispatcher->trigger('plgVmDisplayLogin', array($this, &$html, $this->from_cart));

    if (is_array($html)) {
		foreach ($html as $login) {
		    echo $login.'<br />';
		}
    }
    else {
		echo $html;
    }


    //end plugins section

    //anonymous order section
    if ($this->order  ) {
    	?>

	    <div class="order-view">
        <div class="login-box">

	    <h3 class="module-title"><?php echo JText::_('COM_VIRTUEMART_ORDER_ANONYMOUS') ?></h3>

	    <form action="<?php echo JRoute::_( 'index.php', 1, $this->useSSL); ?>" method="post" name="com-login" >
			
	    	<div class="control-group floatleft width50" id="com-form-order-number">
	    		<label for="order_number"><?php echo JText::_('COM_VIRTUEMART_ORDER_NUMBER') ?></label>
	    		<input type="text" id="order_number" name="order_number" class="inputbox" size="18" alt="order_number" />
	    	</div>
	    	<div class="control-group floatleft width50">
	    		<label for="order_pass"><?php echo JText::_('COM_VIRTUEMART_ORDER_PASS') ?></label>
	    		<input type="text" id="order_pass" name="order_pass" class="inputbox" size="18" alt="order_pass" value="p_"/>
	    	</div>
			<div class="clear"></div>
	    	<div class="controls" id="com-form-order-submit">
	    		<input type="submit" name="Submitbuton" class="button" value="<?php echo JText::_('COM_VIRTUEMART_ORDER_BUTTON_VIEW') ?>" />
	    	</div>
	    	<div class="clr"></div>
	    	<input type="hidden" name="option" value="com_virtuemart" />
	    	<input type="hidden" name="view" value="orders" />
	    	<input type="hidden" name="layout" value="details" />
	    	<input type="hidden" name="return" value="" />

	    </form>
</div>
	    </div>

<?php   }


    ?>
     <div class="order-view">
        <div class="login-box">
    <form id="com-form-login" action="<?php echo JRoute::_('index.php', $this->useXHTML, $this->useSSL); ?>" method="post" name="com-login" >
	<?php if (!$this->from_cart ) { ?>
	<div>
		<p><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></p>
	</div>
<div class="clear"></div>
<?php } else { ?>
        <p><?php echo vmText::_('COM_VIRTUEMART_ORDER_CONNECT_FORM'); ?></p>
<?php }   ?>
		<div class="width100">	
        <div class="userdata">
		<div id="form-login-username" class="control-group floatleft width50"> 
			<div class="controls">
				<div class="input">
					<label for="modlgn-username" class="label"><?php echo vmText::_('COM_VIRTUEMART_USERNAME'); ?></label>
                    <div class="clear"></div>
                    <input id="modlgn-username" type="text" name="username" class="inputbox" tabindex="1" size="18" />
                     <div class="clear"></div>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=remind'); ?>" rel="nofollow" class="remind" ><?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_USERNAME'); ?></a>
				</div>
			</div>
            
		</div>
		<div id="form-login-password" class="control-group floatleft width50">
			<div class="controls">
				<div class="input">
					<label for="modlgn-passwd" class="label"><?php echo JText::_('JGLOBAL_PASSWORD'); ?></label>
                    <div class="clear"></div>
                    <input id="modlgn-passwd" type="password" name="password" class="inputbox" tabindex="2" size="18" />
                     <div class="clear"></div>
                    <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>" rel="nofollow" class="reset"><?php echo vmText::_('COM_VIRTUEMART_ORDER_FORGOT_YOUR_PASSWORD'); ?></a>
				</div>
			</div>
		</div>
        <div class="clear"></div>
		<div class="width100 remember">
           	<?php if (JPluginHelper::isEnabled('system', 'remember')) : ?>
            <input  style="float:left;" class="rememberinputbox" type="checkbox" id="remember" name="remember"  value="yes"/>
            <label style="float:left; margin-left:10px;" class="control-label" for="remember"><?php echo $remember_me = vmText::_('JGLOBAL_REMEMBER_ME'); ?></label>
             <div class="clear"></div>
            <?php endif; ?>
			</div>
            <div class="clear"></div>
            <div id="form-login-submit">
			<div class="controls">
				<button type="submit" tabindex="3" name="Submit" class="button"><?php echo vmText::_('JLOGIN') ?></button>
			</div>
		</div>
		<input type="hidden" name="task" value="user.login" />
        <input type="hidden" name="option" value="com_users" />
        <input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
        <?php echo JHtml::_('form.token'); ?>
	</div>
    </div>
        <div class="clr"></div>
    </form>
</div>
</div>
<?php  }else if ($user->id  ){ ?>
 <div class="order-view">
        <div class="login-box">
   <form action="<?php echo JRoute::_('index.php', $this->useXHTML, $this->useSSL); ?>" method="post" name="login" id="form-login">
        <?php echo vmText::sprintf( 'COM_VIRTUEMART_HINAME', $user->name ); ?>
		<div id="form-login-submit">
			<div class="controls">
				<button style="margin-top:10px;" type="submit" tabindex="3" name="Submit" class="button"><?php echo vmText::_( 'COM_VIRTUEMART_BUTTON_LOGOUT'); ?></button>
			</div>
		</div>
         <div class="clear"></div>
         <input type="hidden" name="option" value="com_users" />

        <input type="hidden" name="task" value="user.logout" />

         <?php echo JHtml::_('form.token'); ?>
	<input type="hidden" name="return" value="<?php echo base64_encode($url) ?>" />
    </form>
    
</div>
</div>
<?php }

?>

