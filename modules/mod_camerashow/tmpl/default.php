<?php 

/**
 * @package	Joomla.Tutorials
 * @subpackage	Module
 * @copyright	Copyright (C) 2005 - 2010 Open Source Matters, Inc. All rights reserved.
 * @license	License GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$document = JFactory::getDocument();
$document->addStyleSheet(JURI::root(true).'/modules/mod_camerashow/css/camera.css');
?>

        <div class="camera_wrap camera_azure_skin" id="camera_wrap_1">		
		<?php		
		$j=$params->get('mod_total_image');	
		
		for ($i=1; $i<=$j; $i++)
			{ ?>
            <div data-thumb="<?php if($params->get('mod_thumb_'.$i.'_image')!=null){echo JURI::root(true).'/'.$params->get('mod_thumb_'.$i.'_image');}else { echo JURI::root(true).'/modules/mod_camerashow/images/slides/thumbs/image'.$i.'.jpg';}?>" data-src="<?php if($params->get('mod_'.$i.'_image')!=null){echo $params->get('mod_'.$i.'_image');}else { echo JURI::root(true).'/modules/mod_camerashow/images/slides/image'.$i.'.jpg';}?>">
                <div class="container camera_caption fadeFromTop">
                   <div class="row"><?php echo $params->get('mod_image_'.$i.'_para'); ?></div>
                </div>
            </div>
			<?php }
        ?>
        </div>
    <div style="clear:both; display:block; height:0px"></div>
	
	<script>
		jQuery(function(){
			
			jQuery('#camera_wrap_1').camera({
				thumbnails			: true,
				slicedCols			: <?php echo $params->get('mod_Slice_Cols');?>,
				slicedRows			: <?php echo $params->get('mod_Slice_Rows');?>,
				easing				: '<?php echo $params->get('mod_easing_effect');?>',
				fx					: '<?php echo $params->get('mod_slide_design');?>',
				time				: <?php echo $params->get('mod_image_show_time');?>,
				transPeriod			: <?php echo $params->get('mod_image_transition_time');?>,
				loader				: '<?php echo $params->get('mod_loader_type');?>',
				pieDiameter			: <?php echo $params->get('mod_Pie_Diameter');?>,
				piePosition			: '<?php echo $params->get('mod_pie_position');?>',
				barPosition			: '<?php echo $params->get('mod_bar_position');?>',
				barDirection		: '<?php echo $params->get('mod_bar_direction');?>',
				loaderColor			: '<?php echo $params->get('mod_loader_color');?>',
				loaderBgColor		: '<?php echo $params->get('mod_loader_background_color');?>',
				loaderStroke		: <?php echo $params->get('mod_loader_stroke');?>,
				loaderPadding		: <?php echo $params->get('mod_loader_padding');?>,
				loaderOpacity		: <?php echo $params->get('mod_loader_opacity');?>,
				height				: '<?php echo $params->get('mod_Image_Heihgt');?>',
				navigation			: <?php echo $params->get('mod_navigation');?>,
				navigationHover		: <?php echo $params->get('mod_navigationHover');?>,
				mobileNavHover		: <?php echo $params->get('mod_navigationHover');?>,
				playPause			: <?php echo $params->get('mod_playPause');?>,
				hover				: <?php echo $params->get('mod_Image_Hover');?>,
				pauseOnClick		: <?php echo $params->get('mod_pause_click');?>,
				autoAdvance			: <?php echo $params->get('mod_Image_AutoAdvance');?>,
				mobileAutoAdvance	: <?php echo $params->get('mod_Image_AutoAdvance');?>,
				alignment			: '<?php echo $params->get('mod_Image_Position');?>',
				pagination			: <?php echo $params->get('mod_pagination');?>
			});

		});
	</script>
	<script type="text/javascript" src="modules/mod_camerashow/js/camera.min.js"></script>
	
<style media="screen" type="text/css">
		.camera_wrap {
			width: <?php echo $params->get('mod_Image_Width');?>;
			float: <?php echo $params->get('mod_slide_pos');?>;
			display: none;
			margin: 0 auto;
			z-index: 0;
			box-shadow: <?php echo $params->get('mod_horizontal_shadow');?>px <?php echo $params->get('mod_vertical_shadow');?>px <?php echo $params->get('mod_blur_distance');?>px <?php echo $params->get('mod_shadow_size');?>px <?php echo $params->get('mod_shadow_color');?>;
			border: <?php echo $params->get('mod_border_width');?>px <?php echo $params->get('mod_border_type');?> <?php echo $params->get('mod_border_color');?>;
		}
		#back_to_camera {
			clear: both;
			display: block;
			height: 80px;
			line-height: 40px;
			padding: 20px;
		}
		.camera_pag {
			visibility: <?php echo $params->get('mod_thumbnails');?>;
		}
		.camera_prev, .camera_next, .camera_commands {
			cursor: pointer;
			position: absolute;
			top: <?php echo $params->get('mod_position');?>;
			z-index: 2;
		}

</style>