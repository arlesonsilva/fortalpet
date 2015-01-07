<?php
/**
 * JS Social Tabs Slider
 * @license    GNU/GPL http://www.gnu.org/copyleft/gpl.html
 * @link       http://facebooklikebox.net
 */
 
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

class modSlideLikebox {
	function getLikebox( $params )   {
		global $mainframe;
			
?>
<div id="social_slider">
<?php
if (trim( $params->get( 'click' ) ) == "click")
					{?>
					<script type="text/javascript">
							jQuery(function (){
								jQuery('.fa-facebook').toggle(function() {
								jQuery('#likebox_1');
								jQuery('#likebox_1').animate({right: 0}, 500); 
								jQuery('#fblink').toggleClass('close', 'open'); 
								jQuery('#fblink').html(''); 
								},
							function() {
								jQuery('#likebox_1').css('z-index',10009);
								jQuery('#likebox_1').animate({right: -<?php echo $params->get( 'fbwidth' )+0; ?>}, 500); 
								jQuery('#fblink').toggleClass('close', 'open'); 
								jQuery('#fblink').html(''); 
							});
							jQuery('.fa-twitter').toggle(function() {
								jQuery('#polecam_1');
								jQuery('#polecam_1').animate({right: 0}, 500); 
								jQuery('#twlink').toggleClass('close', 'open'); 
								jQuery('#twlink').html(''); 
								},
							function() {
								jQuery('#polecam_1').css('z-index',10008);
								jQuery('#polecam_1').animate({right: -<?php echo $params->get( 'twwidth' )+2; ?>}, 500); 
								jQuery('#twlink').toggleClass('close', 'open'); 
								jQuery('#twlink').html(''); 
							});
							jQuery('.fa-youtube').toggle(function() {
								jQuery('#youtube_1');
								jQuery('#youtube_1').animate({right: 0}, 500); 
								jQuery('#ylink').toggleClass('close', 'open'); 
								jQuery('#ylink').html(''); 
								},
							function() {
								jQuery('#youtube_1').css('z-index',10006);
								jQuery('#youtube_1').animate({right: -<?php echo $params->get( 'ytwidth' )+1; ?>}, 500); 
								jQuery('#ylink').toggleClass('close', 'open'); 
								jQuery('#ylink').html(''); 
							});
							jQuery('.fa-envelope-o').toggle(function() {
								jQuery('#contactus_1');
								jQuery('#contactus_1').animate({right: 0}, 500); 
								jQuery('#clink').toggleClass('close', 'open'); 
								jQuery('#clink').html(''); 
								},
							function() {
								jQuery('#contactus_1').css('z-index',10007);
								jQuery('#contactus_1').animate({right: -266}, 500); 
								jQuery('#clink').toggleClass('close', 'open'); 
								jQuery('#clink').html(''); 
							});
							});
						</script>
					<?php }

if (trim( $params->get( 'facebook' ) ) == 1) {
				
						echo '<div id="likebox_1" style="right:-'.trim($params->get( 'fbwidth' )+0).'px;top: '.trim($params->get( 'fbtop' )).'px;"/><i class="fa fa-facebook"></i><div id="likebox_1_1" style="text-align:left;width:'.trim( $params->get( 'fbwidth' )-2).'px;height:'.trim( $params->get( 'fbheight'  )-2).'px;"/><a class="open" id="fblink" href="#"></a><iframe src="http://www.facebook.com/plugins/likebox.php?id='.trim( $params->get( 'profile_id' ) ).'&amp;locale='.trim( $params->get( 'locale' ) ).'&amp;width='.trim( $params->get( 'fbwidth' )).'&amp;height='.trim( $params->get( 'fbheight' )).'&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream='.trim( $params->get( 'stream' ) ).'&amp;header=false" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.trim( $params->get( 'fbwidth' )).'px; height:'.trim( $params->get( 'fbheight' )).'px;" allowTransparency="true"></iframe></div></div>';
					}	
			else if (trim( $params->get( 'facebook' ) ) == 0) {
						echo' ';
			}
				
		if (trim( $params->get( 'twitter' ) ) == 1) {
?>					
				<div id="polecam_1" style="top:<?php echo $params->get( 'twtop' )-25; ?>px; right:-<?php echo $params->get( 'twwidth' )+2; ?>px;height:<?php echo $params->get( 'twheight' ); ?>px;"/><i class="fa fa-twitter"></i><div id="polecam_1_1" style="width:<?php echo $params->get( 'twwidth' ); ?>px;height:<?php echo $params->get( 'twheight' ); ?>px;"/><a class="open" id="twlink" href="#"></a>		
			<a class="twitter-timeline" width="<?php echo $params->get( 'twwidth' ); ?>" height="<?php echo $params->get( 'twheight' ); ?>" data-theme="<?php echo $params->get( 'twtheme' ); ?>"  href="https://twitter.com/<?php echo $params->get( 'twitter_login' ); ?>" data-widget-id="<?php echo $params->get( 'twwidgetid' ); ?>">Tweets by @<?php echo $params->get( 'twitter_login' ); ?></a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>

				</div></div>
			
<?php	}	
else if (trim( $params->get( 'twitter' ) ) == 0) {
			echo ' ';
						}
						

	
			if (trim( $params->get( 'contactus' ) ) == 1) {
?>	<script type="text/javascript">
jQuery(document).ready(function($){

	$('#contactform').submit(function(){

		var action = $(this).attr('action');
		
		$("#message").slideUp(750,function() {
		$('#message').hide();

 		$('#submit')
			.after('<img src="<?php echo JURI::root() ?>modules/mod_js_social_tabs_slider/tmpl/images/ajax-loader.gif" class="loader" />')
			.attr('disabled','disabled');

		$.post(action, {
			name: $('#name').val(),
			email: $('#email').val(),
			subject: $('#subject').val(),
			comments: $('#comments').val(),
			verify: $('#verify').val()
		},
			function(data){
				document.getElementById('message').innerHTML = data;
				$('#message').slideDown('slow');
				$('#contactform img.loader').fadeOut('slow',function(){$(this).remove()});
				$('#submit').removeAttr('disabled');
				if(data.match('success') != null) $('#contactform').slideUp('slow');

			}
		);

		});

		return false;

	});

});</script>
			<div id="contactus_1" style="top:<?php echo $params->get( 'contacttop' ); ?>px; width:265px; right:-266px;"><i class="fa fa-envelope-o"></i><div id="contactus_1_1"><a class="open" id="clink" href="#"></a>		
			<div id="contact">
			<div id="message"></div>
			<form method="post" action="<?php echo JURI::root() ?>modules/mod_js_social_tabs_slider/tmpl/form/contact.php" name="contactform" id="contactform">
			<h3 class="module-title"><?php echo $params->get( 'contactheader' ); ?></h3>
			<input name="name" type="text" id="name" class="contact_input" size="30" value="" placeholder="<?php echo $params->get( 'contactname' ); ?>" />
			<input name="email" type="text" id="email" size="30" class="contact_input" value="" placeholder="<?php echo $params->get( 'contactmail' ); ?>" />
			<input name="subject" type="text" id="subject" size="30" class="contact_input" value="" placeholder="<?php echo $params->get( 'contactsubject' ); ?>" />
			<textarea name="comments" cols="40" rows="3" id="comments"></textarea>
			<p><span class="required"><i>*</i> <?php echo $params->get( 'contacthuman' ); ?></span></p>
			<p class="wrapper">
			<label class="verify" for="verify" accesskey="V">11 - 3 =</label> <input name="verify" type="text" id="verify" class="contact_input" size="4" value=""  />
			</p>
			<input type="submit" class="submit button reset2" id="submit" value="<?php echo $params->get( 'contactbutton' ); ?>" />


			</form>

	</div></div>
			</div>
<?php	}	
else if (trim( $params->get( 'contactus' ) ) == 0) {
			echo ' ';
						}
						
						 		if (trim( $params->get( 'youtube' ) ) == 1) {
			echo '<div id="youtube_1" style=" top: '.trim($params->get( 'yttop' )-0).'px; right:-'.trim($params->get( 'ytwidth' )+1).'px; width:'.trim($params->get( 'ytwidth' )).'px;height:'.trim($params->get( 'ytheight' )+5).'px;"><i class="fa fa-youtube"></i><div id="youtube_1_1" style="width:'.trim($params->get( 'ytwidth' )).'px;height:'.trim($params->get( 'ytheight' )+5).'px;"><a class="open" id="ylink" href="#"></a><iframe width="'.trim( $params->get( 'ytwidth' )-5 ).'" height="'.trim( $params->get( 'ytheight' ) -5).'" src="//www.youtube.com/embed/'.trim( $params->get( 'ytvideolink' ) ).'" frameborder="0" allowfullscreen></iframe></div></div>';
			}
			else if (trim( $params->get( 'youtube' ) ) == 0) {   
			echo ' ';
						} ?>

	</div>		
<?php } } ?>
