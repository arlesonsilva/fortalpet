<?php
/**
 * JS Social Tabs Slider
 * @license    GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link       http://facebooklikebox.net
 */

error_reporting(0);
ini_set("display_errors","0");
 
define( '_JEXEC', 1 );
define( 'JPATH_BASE', realpath(dirname(__FILE__))."/../../../..");
define( 'DS', DIRECTORY_SEPARATOR );
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' );
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' );

$mainframe = JFactory::getApplication('site');
$mainframe->initialise();
$user = JFactory::getUser();
$session = JFactory::getSession();
jimport( 'joomla.application.module.helper' );

$db = JFactory::getDBO();
$db->setQuery("SELECT params FROM #__modules WHERE module = 'mod_js_social_tabs_slider'");
$module = $db->loadObject();
$moduleParams = new JRegistry();
$moduleParams->loadString($module->params);


if(!$_POST) exit;

function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$name     = $_POST['name'];
$email    = $_POST['email'];
$subject  = $_POST['subject'];
$comments = $_POST['comments'];
$verify   = $_POST['verify'];

$address = $moduleParams->get('contactemail');
$contactsent = $moduleParams->get('contactsent');
$contactthanks = $moduleParams->get('contactthanks');
$contactmsgsubmitted = $moduleParams->get('contactmsgsubmitted');
$errorname = $moduleParams->get('errorname');
$erroremail = $moduleParams->get('erroremail');
$erroremailinvalid = $moduleParams->get('erroremailinvalid');
$errorsubject = $moduleParams->get('errorsubject');
$errorcomments = $moduleParams->get('errorcomments');
$errorcaptcha = $moduleParams->get('errorcaptcha');
$errorcaptchainvalid = $moduleParams->get('errorcaptchainvalid');


if(trim($name) == '') {
	echo '<div class="error_message">' . $errorname . '</div>';
	exit();
} else if(trim($email) == '') {
	echo '<div class="error_message">' . $erroremail . '</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="error_message">' . $erroremailinvalid . '</div>';
	exit();
}

if(trim($subject) == '') {
	echo '<div class="error_message">' . $errorsubject . '</div>';
	exit();
} else if(trim($comments) == '') {
	echo '<div class="error_message">' . $errorcomments . '</div>';
	exit();
} else if(!isset($verify) || trim($verify) == '') {
	echo '<div class="error_message">' . $errorcaptcha . '</div>';
	exit();
} else if(trim($verify) != '8') {
	echo '<div class="error_message">' . $errorcaptchainvalid . '</div>';
	exit();
}

if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}

$e_subject = 'You\'ve been contacted by ' . $name . '.';

$e_body = "You have been contacted by $name with regards to $subject, their additional message is as follows." . PHP_EOL . PHP_EOL;
$e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
$e_reply = "You can contact $name via email, $email";

$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(mail($address, $e_subject, $msg, $headers)) {

	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h1> $contactsent </h1>";
	echo "<p>$contactthanks <strong>$name</strong>, $contactmsgsubmitted $address</p>";
	echo "</div>";
	echo "</fieldset>";

} else {

	echo 'ERROR!';

}

