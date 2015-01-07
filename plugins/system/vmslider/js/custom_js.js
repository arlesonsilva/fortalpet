jQuery(function(){
	jQuery('.productdetails-view .image_loader').addClass('loader');
	jQuery(window).load(function() {
		jQuery('.productdetails-view .image_loader').removeClass('loader'); // remove the loader when window gets loaded.
		jQuery('.productdetails-view .image_show').animate({opacity:1},1000);
	});
});
jQuery(document).ready(function() {
		jQuery("#Img_zoom2").elevateZoom({
			gallery:'gallery_02' , 
			cursor: 'pointer' , 
			zoomWindowPosition: 1, 
			zoomWindowOffetx: 10,
			zoomWindowHeight: 360, 
			 zoomWindowWidth:360,
			 zoomWindowFadeIn: 500,
			zoomWindowFadeOut: 500,
			lensFadeIn: 500,
			lensFadeOut: 500,
			showLens:true,
			zoomType:'window',
			containLensZoom :false,
			 easing : true, 
			 galleryActiveClass: 'zoomThumbActive active', 
			 loadingIcon: 'images/ajax-loader.gif'
			 }); 
		jQuery("#Img_zoom2").bind("click", function(e) {  
		  var ez =   jQuery('#Img_zoom2').data('elevateZoom');	
			jQuery.fancybox(ez.getGalleryList());
		  return false;
		});
		
});
(function($) {
    $(function() {
        $('#gallery_02').jcarousel({
			scroll:1					  
		 });
		$('.jcarousel-control-prev').addClass('jcarousel-prev');
		$('.jcarousel-control-next').addClass('jcarousel-next');

        $('.jcarousel-control-prev')
            .on('active.jcarouselcontrol', function() {
                $(this).removeClass('jcarousel-prev-disabled');
            })
            .on('inactive.jcarouselcontrol', function() {
                $(this).addClass('jcarousel-prev-disabled');
            })
            .jcarouselControl({
                target: '-=1'
            });

        $('.jcarousel-control-next')
            .on('active.jcarouselcontrol', function() {
                $(this).removeClass('jcarousel-next-disabled');
            })
            .on('inactive.jcarouselcontrol', function() {
                $(this).addClass('jcarousel-next-disabled');
            })
            .jcarouselControl({
                target: '+=1'
            });
    });
})(jQuery);
