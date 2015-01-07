jQuery(document).ready(function(){
		jQuery('html.no-touch .slide_box .prod-row:odd , html.no-touch .prod_box li >div:odd , html.no-touch .product-related-categories >div:odd,html.no-touch #product_list .prod-row:odd , html.no-touch .category-view .cat_row:odd').addClass('animate_left');
		jQuery('html.no-touch .slide_box .prod-row:even , html.no-touch .prod_box li >div:even , html.no-touch .product-related-categories >div:even ,html.no-touch #product_list .prod-row:even, html.no-touch .category-view .cat_row:even').addClass('animate_right');
		jQuery('html.no-touch .izotop #container').removeClass('animate_right');
		
		jQuery('html.no-touch .t3-footnav >div:odd').addClass('animate_ftr');
		jQuery('html.no-touch .t3-footnav >div:even').addClass('animate_ftl');
		jQuery('html.no-touch .k2ItemsBlock.homeblog .owl-item:odd , html.no-touch .t3-footnav-top >div:odd').addClass('animate_ftr');
		jQuery('html.no-touch .k2ItemsBlock.homeblog .owl-item:even , html.no-touch .t3-footnav-top >div:even').addClass('animate_ftl');
		jQuery('html.no-touch #tablist1-panel1 #vm2product li >div:odd').addClass('animate_top_tabs');
		jQuery('html.no-touch #tablist1-panel1 #vm2product li >div:even').addClass('animate_bot_tabs');
		jQuery('html.no-touch #brand_slider .owl-item:odd').addClass('animate_top_brand');
		jQuery('html.no-touch #brand_slider .owl-item:even').addClass('animate_bot_brand');
		jQuery('html.no-touch .banneritem:odd , html.no-touch #Customblock-Portfolio .gallery-list li:odd ').addClass('animate_ftr');
		jQuery('html.no-touch .banneritem:even , html.no-touch #Customblock-Portfolio .gallery-list li:even ').addClass('animate_ftl');
		jQuery('html.no-touch .animate_left').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(350).animate({opacity:1,left:"0px"},950);
			});
		});
		jQuery('html.no-touch .animate_right').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(350).animate({opacity:1,right:"0px"},900);
			});
		}); 
		jQuery('html.no-touch .animate_top').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(350).animate({opacity:1,top:"0px"},900);
			});
		});
		jQuery('html.no-touch .animate_bot').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(350).animate({opacity:1,bottom:"0px"},800);
			});
		});
		
		jQuery('html.no-touch .animate_ftl').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(400).animate({opacity:1,left:"0px"},900);
			});
		});
		jQuery('html.no-touch .animate_ftr').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(400).animate({opacity:1,right:"0px"},900);
			});
		}); 
		jQuery('html.no-touch .animate_top_brand').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(500).animate({opacity:1,right:"0px"},1250);
			});
		});
		jQuery('html.no-touch .animate_bot_brand').each(function () {
			jQuery(this).appear(function() {
				jQuery(this).delay(550).animate({opacity:1,left:"0px"},1350);
			});
		}); 


		 jQuery('#facebox .continue , #facebox div.close').live('click',function (e) {
			e.preventDefault();
			jQuery('#facebox').hide();
			jQuery('#facebox_overlay').remove();
			jQuery('#system_view_overlay').hide();
			return false;
		});	
		jQuery('#newsletter-popup div.close').live('click',function (e) {
			e.preventDefault();
			jQuery('div.fancybox-overlay').remove();
			jQuery("html").removeClass('fancybox-lock');
			jQuery("html").removeClass('fancybox-margin');
			return false;
		});
		jQuery('.wrapper_remember input , .remember input , #tosAccepted, input.terms-of-service ,#STsameAsBT,#register, .login-box-metod input , #agreed_field , #form-login-remember input , .formLabel input , .op_shipto_content #sachone, #genderm , #genderf , #shipments input , #payments input , .output-shipto input , #comments-form-subscribe').styler().trigger('refresh');	
		jQuery('.shoper select , .billing-box select , select#userID').styler().trigger('refresh');
		if( jQuery(".ssocial").hasClass("lider-custom")){
		jQuery(function() {
			var offset = jQuery("#social_slider").offset();
			var topPadding = 1;
			jQuery(window).scroll(function() {
				if (jQuery(window).scrollTop() > offset.top) {
				jQuery('.lider-custom').stop().animate({top:'20%'},500).addClass('fixed');
				}
				else {jQuery("#social_slider").stop().animate({marginTop: 0});
				jQuery('.lider-custom').removeClass('fixed'); 
				};
				//jQuery('.lider-custom').animate({top: 0}, 500); 
			});
			});	
		}
		jQuery(function() {
		var offset = jQuery("#t3-mainnav").offset();
		var topPadding = 0;
		jQuery(window).scroll(function() {
			if (jQuery(window).scrollTop() >250) {
				jQuery(".top-block").addClass("fix");
			}
			else {
				jQuery(".top-block").removeClass("fix");
			};
			});
		});
	   jQuery('.social .hasTooltip').tooltip();
		jQuery('li:last-child').addClass('lastItem');
		jQuery('li:first-child').addClass('firstItem');
		jQuery('.prod-row:last-child').addClass('lastItem');
		jQuery('.prod-row:first-child').addClass('firstItem'); 
		jQuery('.itemList > div:last-child').addClass('lastItem');
		jQuery('.itemList > div:first-child').addClass('firstItem'); 
		

	jQuery(document).ready(function($){
		jQuery('.header-button-languages , .header-button-currency , #vmCartModule , .header-button-wishlists, .header-button-compare').hover(function(){
		  jQuery(this).addClass('act')
		  },function(){
		  jQuery(this).removeClass('act')
		}); 
	});

	// hide #back-top first
	jQuery("#back-top").hide();
	
	// fade in #back-top
	jQuery(function () {
		jQuery(window).scroll(function () {
			if (jQuery(this).scrollTop() > 550) {
				jQuery('#back-top').fadeIn();
			} else {
				jQuery('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		jQuery('#back-top a').click(function () {
			jQuery('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

}); 
jQuery(document).ready(function() {
	jQuery(".gallery-list").owlCarousel({
	items : 3,
	autoPlay : 12000,
	 itemsDesktop : [1000,2], //5 items between 1000px and 901px
	itemsDesktopSmall : [900,2], // betweem 900px and 601px
	itemsTablet: [700,2], //2 items between 600 and 0
	itemsMobile : [460,1], // itemsMobile disabled - inherit from itemsTablet option
	stopOnHover : true,
	lazyLoad : false,
	navigation : true,
	 navigationText: [
		"<i class='fa fa-angle-left'></i>",
		"<i class='fa fa-angle-right'></i>"
	]
	}); 
});
jQuery(document).ready(function() {
	jQuery(".testimonial").owlCarousel({
	items : 1,
	autoPlay : 12000,
	 itemsDesktop : [1000,1], //5 items between 1000px and 901px
	itemsDesktopSmall : [900,1], // betweem 900px and 601px
	itemsTablet: [700,1], //2 items between 600 and 0
	itemsMobile : [460,1], // itemsMobile disabled - inherit from itemsTablet option
	stopOnHover : true,
	lazyLoad : false,
	navigation : true,
	 navigationText: [
		"<i class='fa fa-angle-left'></i>",
		"<i class='fa fa-angle-right'></i>"
	]
	}); 


});

  jQuery(document).ready(function(){
	jQuery('.sropen').on('click', function(){
		jQuery("#t3-mainnav").addClass('srcbg');
		jQuery("#t3-mainnav").removeClass('srend');
	});	
	jQuery('.srclose').on('click', function(){
		jQuery("#t3-mainnav").removeClass('srcbg');
		jQuery("#t3-mainnav").addClass('srend');
	});	
	 jQuery('body').append('<div id="system_view_overlay" style="display:none"></div><div class="AjaxPreloaderC" style="display:none"></div><div id="system_view"></div>');
		if( jQuery("#mod_compare .vmproduct .clearfix").hasClass("modcompareprod")) {
          jQuery("#mod_compare .not_text").addClass('displayNone');
    	 }
		 if( jQuery("#mod_compare .vmproduct .clearfix").hasClass("modcompareprod")) {
			 jQuery("#mod_compare #butseldcomp").removeClass('displayNone');
		 }else { jQuery("#mod_compare #butseldcomp").addClass('displayNone');}
		 
		 if( jQuery("#mod_wishlists .vmproduct .clearfix").hasClass("modwishlistsprod")) {
          jQuery("#mod_wishlists .not_text").addClass('displayNone');
    	 }
		 if( jQuery("#mod_wishlists .vmproduct .clearfix").hasClass("modwishlistsprod")) {
			 jQuery("#mod_wishlists #butseldwish").removeClass('displayNone');
		 }else { jQuery("#mod_wishlists #butseldwish").addClass('displayNone');}
	});
 function centerBox() {
      var boxWidth = 430;
    var winWidth = jQuery(window).width();
    var winHeight = jQuery(document).height();
    var scrollPos = jQuery(window).scrollTop();
     
     
    var disWidth = (winWidth - boxWidth) / 2
    var disHeight = scrollPos + 250;
     
    jQuery('#system_view').css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px'});
     
    return false;       
} 
jQuery(window).resize(centerBox);
jQuery(window).scroll(centerBox);
centerBox();  
 function centerBox2() {
      var boxWidth = 780;
    var winWidth = jQuery(window).width();
    var winHeight = jQuery(document).height();
    var scrollPos = jQuery(window).scrollTop();
     
     
    var disWidth = (winWidth - boxWidth) / 2
    var disHeight = scrollPos + 200;
     
    jQuery('#quick_view_popup').css({'width' : boxWidth+'px', 'left' : disWidth+'px', 'top' : disHeight+'px'});
     
    return false;       
} 
jQuery(window).resize(centerBox2);
jQuery(window).scroll(centerBox2);
centerBox2();  

  function addToCompare(product_id) { 
  jQuery('#system_view_overlay').show();
	  jQuery('.AjaxPreloaderC').show();
	jQuery.ajax({
		url: 'index.php?option=com_comparelist&task=add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json){
			 jQuery('.AjaxPreloaderC').hide();
			  // jQuery('#system_view_overlay').hide();
			if(json){
				jQuery('#system_view').show().html('<div class="success"><div class="wrapper successprod_'+product_id+'"><div class="success_compare_img">' + json.img_prod2 + '</div><div class="success_compare_left">' + json.title + json.btnrem + '</div></div><div class="success_compare">' + json.message + '</div><div class="wrapper2">'+ json.btncompareback + json.btncompare +'</div></div><div class="system_view_close"><i class="fa fa-times"></i></div>');
				jQuery('.success').fadeIn('slow');
				//jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 
				}
				
				if(json.product_ids>0){
					jQuery('.list_compare'+product_id+' a').addClass('go_to_compare active');
				}
				 if(json.totalcompare>0){
					 jQuery("#mod_compare #butseldcomp").removeClass('displayNone');
				}
				if(json.totalcompare){
					jQuery('#compare_total .compare_total span').html(json.totalcompare);
				}
				if(json.prod_name){
					jQuery('#mod_compare .vmproduct').append('<div id="compare_prod_'+product_id+'" class="modcompareprod clearfix">'+json.img_prod+json.prod_name+'</div>');
				}
				if( jQuery("#mod_compare .vmproduct .clearfix").hasClass("modcompareprod")) {
         			 jQuery("#mod_compare .not_text").addClass('displayNone');
    			 }

				 jQuery('#system_view_overlay, .system_view_close , #compare_continue').click(function () {
					jQuery('#system_view').hide();
					jQuery('#system_view_overlay').hide();
					//jQuery('.AjaxPreloader').hide();
                 });
			//alert(json.message);
				
			}
			
	});
}

 function removeCompare(remove_id) { 
	jQuery('#compare_cat'+remove_id+' a').removeClass('go_to_compare active');
	jQuery.ajax({
		url: 'index.php?option=com_comparelist&task=removed',
		type: 'post',
		data: 'remove_id=' + remove_id,
		dataType: 'json',
		success: function(json){
					 jQuery('.compare_prod_'+remove_id).remove();
					  jQuery('#compare_prod_'+remove_id).remove();
					  jQuery('.success .successprod_'+remove_id).remove();
					   jQuery('.success_compare span').remove();
					   jQuery('#system_view .success .success_compare').append('<span class="warning">'+json.rem+'</span>');
					 	jQuery('.list_compare'+remove_id+' a').removeClass('go_to_compare active');
					 if(json.totalrem<1){
						jQuery("#mod_compare .not_text").removeClass('displayNone');
						jQuery("#butseldcomp").addClass('displayNone');
						jQuery(".module-title.compare.no-products").addClass('displayBlock');
						jQuery(".browscompare_list").remove();
						
					}
					if(json.totalrem){
						jQuery('#compare_total .compare_total span').html(json.totalrem);
				}
				if(json.totalrem <1){
						jQuery('#compare_total .compare_total span').html('0');
				}
			}
	});
}


  function addToWishlists(product_id) { 
  jQuery('#system_view_overlay').show();
	  jQuery('.AjaxPreloaderC').show();
	jQuery.ajax({
		url: 'index.php?option=com_wishlists&task=add',
		type: 'post',
		data: 'product_id=' + product_id,
		dataType: 'json',
		success: function(json){
			
			 jQuery('.AjaxPreloaderC').hide();
			  // jQuery('#system_view_overlay').hide();
			  if(json.product_ids>0){
			 	 jQuery('.list_wishlists'+product_id+' a').addClass('go_to_compare active');
			  }
			if(json){
				jQuery('#system_view').show().html('<div class="success"><div class="wrapper successprod_'+product_id+'"><div class="success_wishlists_img">' + json.img_prod2 + '</div><div class="success_wishlists_left">' + json.title + json.btnrem + '</div></div><div class="success_wishlists">' + json.message + '</div><div class="wrapper2">'+ json.btnwishlistsback + json.btnwishlists +'</div></div><div class="system_view_close"><i class="fa fa-times"></i></div>');
				jQuery('.success').fadeIn('slow');
				//jQuery('html, body').animate({ scrollTop: 0 }, 'slow'); 
					
				}
			
				 
				 if(json.totalwishlists>0){
					 jQuery("#mod_wishlists #butseldwish").removeClass('displayNone');
				}
				if(json.totalwishlists){
					jQuery('#wishlist_total .wishlist_total span').html(json.totalwishlists);
				}
				if(json.prod_name){
					jQuery('#mod_wishlists .vmproduct').append('<div id="wishlists_prod_'+product_id+'" class="modwishlistsprod clearfix">'+json.img_prod+json.prod_name+'</div>');
				}
				if( jQuery("#mod_wishlists .vmproduct .clearfix").hasClass("modwishlistsprod")) {
         			 jQuery("#mod_wishlists .not_text").addClass('displayNone');
    				 }
				 jQuery('#system_view_overlay, .system_view_close , #wishlists_continue').click(function () {
					jQuery('#system_view').hide();
					jQuery('#system_view_overlay').hide();
					//jQuery('.AjaxPreloader').hide();
                 });
			//alert(json.message);
			}
	});
}

 function removeWishlists(remove_id) { 
	jQuery.ajax({
		url: 'index.php?option=com_wishlists&task=removed',
		type: 'post',
		data: 'remove_id=' + remove_id,
		dataType: 'json',
		success: function(json){
					   jQuery('.count_holder_small').remove();
					   jQuery('#wishlists_prod_'+remove_id).remove();
					   jQuery('.wishlists_prods_'+remove_id).remove();					  
					  jQuery('.success .successprod_'+remove_id).remove();
					   jQuery('.success_wishlists span').remove();
					   jQuery('#system_view .success .success_wishlists').append('<span class="warning">'+json.rem+'</span>');
					 	jQuery('.list_wishlists'+remove_id+' a').removeClass('go_to_compare active');
					 if(json.totalrem<1){
						jQuery("#mod_wishlists .not_text").removeClass('displayNone');
						jQuery("#butseldwish").addClass('displayNone');
						jQuery(".module-title.wishlists.no-products").addClass('displayBlock');
						jQuery(".category-wishlist").remove();
						
					}
					if(json.totalrem){
					jQuery('#wishlist_total .wishlist_total span').html(json.totalrem);
				}
				if(json.totalrem<1){
					jQuery('#wishlist_total .wishlist_total span').html('0');
				}
			}
	});
}
