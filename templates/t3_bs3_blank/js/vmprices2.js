var mQuickCart = jQuery.noConflict();

mQuickCart(document).ready(function($){
		customScrollbar();
});

function customScrollbar(){
	if( jQuery("#vmCartModule").hasClass("vmCartModule")) {
		var module_height_top = mQuickCart('#vmCartModule #cart_list').outerHeight();
			var module_height_all = mQuickCart('#vmCartModule .all').outerHeight();
		var module_height_text = mQuickCart('#vmCartModule .text-art').outerHeight();
		var module_height = module_height_top - module_height_all - module_height_text;
		if( show_scrollbar && module_height > height_scrollbar ){
			mQuickCart("#cart_list div.vm_cart_products").css('height',height_scrollbar+'px');
			mQuickCart("#cart_list div.vm_cart_products").mCustomScrollbar({
				scrollButtons:{
					enable:true
				}
			});
		}else{
			mQuickCart("#cart_list div.vm_cart_products").css('height','auto');
		}
	}
}

function remove_product_cart(elm) {
	var cart_id = jQuery(elm).children("span.product_cart_id").text();
	if(document.id('is_opc')) {
	    remove_product(elm.getChildren('span').get('text'));
	} else {
	new Request.HTML({
		'url':'index.php?option=com_virtuemart&view=cart&task=delete',
		'method':'post',
		'data':'cart_virtuemart_product_id='+cart_id,
		'evalScripts':false,
		'onSuccess':function(tree,elms,html,js) {
			mod=jQuery(".vmCartModule");
			jQuery.getJSON(vmSiteurl+"index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json"+vmLang,
				function(datas, textStatus) {
					if (datas.totalProduct >0) {
						mod.find(".vm_cart_products").html("");
						datas.products.reverse();
						jQuery.each(datas.products, function(key, val) {
						 	if (key<limitcount){	
								jQuery("#hiddencontainer .container").clone().appendTo(".vmCartModule .vm_cart_products");
								jQuery.each(val, function(key, val) {
									if (jQuery("#hiddencontainer .container ."+key)) mod.find(".vm_cart_products ."+key+":last").html(val) ;
									
								});
								if (key==0) { jQuery("#cart_list div#vm_cart_products").addClass('height').removeClass('heightnone').css('height','auto');}else{jQuery("#cart_list div#vm_cart_products").addClass('heightnone').removeClass('height');}
							}	
						});
						mod.find(".total").html(datas.billTotal);
						mod.find(".total").html(datas.billTotal);
						mod.find(".miniart .total2 strong").html(datas.billTotal);
						//mod.find(".total2").html(datas.billTotal);
						mod.find(".tot3").html(datas.taxTotal);
						mod.find(".tot4").html(datas.discTotal);
						mod.find("#cart_list .vmicon i").html(datas.cart_remove);
						mod.find(".show_cart").html(datas.cart_show);

					} else {
						mod.find(".text-art").html(datas.cart_empty_text);
						mod.find(".vm_cart_products").html("");
						mod.find(".total").html("");
						mod.find(".tot3").html("");
						mod.find(".tot4").html("");
						mod.find(".total2").html(datas.billTotal);
						mod.find(".show_cart").html("");
						//jQuery("#cart_list").css('display','none');
					}
					//if (datas.totalProduct == 1) { jQuery("#cart_list div.vm_cart_products").css('height','149px');}
					
					mod.find(".total_products").html(datas.totalProductTxt);
					customScrollbar();
					

				}
			)
		}
	}).send();
}
}
//if(typeof Virtuemart === "undefined")

		var Virtuemart = {};
			Virtuemart.setproducttype = function (form, id) {
				form.view = null;
				var $ = jQuery, datas = form.serialize();
				var prices = form.parent(".productdetails").find(".product-price");
				if (0 == prices.length) {
					prices = jQuery("#productPrice" + id);
				}
				datas = datas.replace("&view=cart", "");
				prices.fadeTo("fast", 0.75);
                //encodeURIComponent(datas);
                jQuery.getJSON(window.vmSiteurl + 'index.php?option=com_virtuemart&nosef=1&view=productdetails&task=recalculate&virtuemart_product_id='+id+'&format=json' + window.vmLang, datas,
					function (datas, textStatus) {
						prices.fadeTo("fast", 1);
						// refresh price
						for (var key in datas) {
							var value = datas[key];
							if (value!=0) prices.find("span.Price"+key).show().html(value);
							else prices.find(".Price"+key).html(0).hide();
						}
					});
				return false; // prevent reload
			},
			Virtuemart.productUpdate = function() {
				mod=jQuery(".vmCartModule");
				var $ = jQuery ;
				$.ajaxSetup({ cache: false })
				$.getJSON(window.vmSiteurl+"index.php?option=com_virtuemart&nosef=1&view=cart&task=viewJS&format=json"+window.vmLang,
					function(datas, textStatus) {
						if (datas.totalProduct >0) {
							mod.find(".vm_cart_products").html("");
							datas.products.reverse(); 
							$.each(datas.products, function(key, val) {
								if (key<limitcount){								
									$("#hiddencontainer .container").clone().appendTo(".vmCartModule .vm_cart_products");
									$.each(val, function(key, val) {
										if ($("#hiddencontainer .container ."+key)) mod.find(".vm_cart_products ."+key+":last").html(val) ;
									});
									if (key==0) { jQuery("#cart_list div#vm_cart_products").addClass('height').removeClass('heightnone').css('height','auto');}else{jQuery("#cart_list div#vm_cart_products").addClass('heightnone').removeClass('height');}
								}
								
							});
							//alert(datas.products);
							mod.find(".text-art").html(datas.cart_recent_text);
							mod.find(".total").html(datas.billTotal);
							mod.find(".tot3").html(datas.taxTotal);
							mod.find(".tot4").html(datas.discTotal);
							mod.find(".miniart .total2 strong").html(datas.billTotal);
							mod.find(".show_cart").html(datas.cart_show);
							mod.find("#cart_list .vmicon i").html(datas.cart_remove);
							
						}
						mod.find(".total_products").html(datas.totalProductTxt);
						customScrollbar();
					}
				);
			},
			Virtuemart.sendtocart = function (form){
				if (Virtuemart.addtocart_popup ==1) {
					Virtuemart.cartEffect(form) ;
					
				} else {
					form.append('<input type="hidden" name="task" value="add" />');
					form.submit();
				}
			},
			Virtuemart.cartEffect = function(form) {
				jQuery('.AjaxPreloaderC').show();
                var $ = jQuery ;
                $.ajaxSetup({ cache: false });
                var dat = form.serialize();

                if(usefancy){
                    $.fancybox.showActivity();
                }

                $.getJSON(vmSiteurl+'index.php?option=com_virtuemart&nosef=1&view=cart&task=addJS&format=json'+vmLang, dat,
                function(datas, textStatus) {
				jQuery('.AjaxPreloaderC').hide();
                    if(datas.stat ==1){
						var this_prod = form.find(".item_id").val() ;
						var img_url = document.getElementById('Img_to_Js_'+this_prod).src;
                        var txt = datas.msg+"<img width='80' height='auto' src='"+img_url+"' />";
                    } else if(datas.stat ==2){
						var this_prod = form.find(".item_id").val() ;
						var img_url = document.getElementById('Img_to_Js_'+this_prod).src;
                        var txt = datas.msg +"<H4>"+form.find(".pname").val()+"</H4><img width='80' height='auto' src='"+img_url+"' />";
                    } else {
                        var txt = "<H4>"+vmCartError+"</H4>"+datas.msg;
                    }
                    if(usefancy){
                        $.fancybox({
                                "titlePosition" : 	"inside",
                                "transitionIn"	:	"fade",
                                "transitionOut"	:	"fade",
                                "changeFade"    :   "fast",
                                "type"			:	"html",
                                "autoCenter"    :   true,
                                "closeBtn"      :   false,
                                "closeClick"    :   false,
                                "content"       :   txt
                            }
                        );
                    } else {
                        $.facebox.settings.closeImage = closeImage;
                        $.facebox.settings.loadingImage = loadingImage;
                        //$.facebox.settings.faceboxHtml = faceboxHtml;
                        $.facebox({ text: txt }, 'my-groovy-style2');
                    }


                    Virtuemart.productUpdate();
                });

                $.ajaxSetup({ cache: true });
			},
			Virtuemart.product = function(carts) {
			carts.each(function(){
			var cart = jQuery(this),
			step=cart.find('input[name="quantity"]'),
			addtocart = cart.find('button.addtocart-button'),
			plus   = cart.find('.quantity-plus'),
			minus  = cart.find('.quantity-minus'),
			select = cart.find('select'),
			radio = cart.find('input:radio'),
			virtuemart_product_id = cart.find('input[name="virtuemart_product_id[]"]').val(),
			quantity = cart.find('.quantity-input');
			var Ste = parseInt(step.val());
                    //Fallback for layouts lower than 2.0.18b
                    if(isNaN(Ste)){
                        Ste = 1;
                    }
			addtocart.die("click");
			addtocart.live('click' , function(e) { 
				Virtuemart.sendtocart(cart);
				return false;
			});
			plus.die("click");
			plus.live('click' , function() {
				var Qtt = parseInt(quantity.val());
				if (!isNaN(Qtt)) {
					quantity.val(Qtt + Ste);
				Virtuemart.setproducttype(cart,virtuemart_product_id);
				}
				
			});
			minus.die("click");
			minus.live('click' , function() {
				var Qtt = parseInt(quantity.val());
				if (!isNaN(Qtt) && Qtt>Ste) {
					quantity.val(Qtt - Ste);
				} else quantity.val(Ste);
				Virtuemart.setproducttype(cart,virtuemart_product_id);
			});
			select.change(function() {
				Virtuemart.setproducttype(cart,virtuemart_product_id);
			});
			radio.change(function() {
				Virtuemart.setproducttype(cart,virtuemart_product_id);
			});
			quantity.keyup(function() {
				Virtuemart.setproducttype(cart,virtuemart_product_id);
			});
		});

	}


jQuery.noConflict();
jQuery(document).ready(function($) {
								
	Virtuemart.product($(".product"));
	$("form.js-recalculate").each(function(){
		if ($(this).find(".product-fields").length && !$(this).find(".no-vm-bind").length) {
			var id= $(this).find('input[name="virtuemart_product_id[]"]').val();
			Virtuemart.setproducttype($(this),id);

		}
	});
});

/**
 * list country.js: General Javascript Library for VirtueMart Administration
 *
 *
 * @package	VirtueMart
 * @subpackage Javascript Library
 * @author Patrick Kohl
 * @copyright Copyright (c) 2011VirtueMart Team. All rights reserved.
 * @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
 */

(function($){
	var undefined,
	methods = {
		list: function(options) {
			var dest = options.dest;
			var ids = options.ids;
			var prefix = options.prefiks;
            methods.update(this,dest,ids,prefix);
			$(this).change( function() { methods.update(this,dest,ids,prefix)});

		},
		update: function(org,dest,ids,prefix) {
			var opt = $(org),
				optValues = opt.val() || [],
				byAjax = [] ;
			if (!$.isArray(optValues)) optValues = jQuery.makeArray(optValues);
			if ( typeof  oldValues !== "undefined") {
				//remove if not in optValues
				$.each(oldValues, function(key, oldValue) {
					if ( ($.inArray( oldValue, optValues )) < 0 ) $("#"+prefix+"group"+oldValue).remove();
				});
			}
			//push in 'byAjax' values and do it in ajax
			$.each(optValues, function(optkey, optValue) {
				if( opt.data( 'd'+optValue) === undefined ) byAjax.push( optValue );
			});

			if (byAjax.length >0) {
				$.getJSON('index.php?option=com_virtuemart&view=state&format=json&virtuemart_country_id=' + byAjax,
						function(result){
						
						// Max Bitte Testen
						var virtuemart_state_id = $('#'+prefix+'virtuemart_state_id');
						var status = virtuemart_state_id.attr('required');
						
						if(status == 'required') {
							if( result[byAjax].length > 0 ) {
								virtuemart_state_id.attr('required','required');
							} else {
								virtuemart_state_id.removeAttr('required');
							}
						}
						
						// ENDE

						$.each(result, function(key, value) {
							if (value.length >0) {
								opt.data( 'd'+key, value );	
							} else { 
								opt.data( 'd'+key, 0 );		
							}
						});
						methods.addToList(opt,optValues,dest,prefix);
						if ( typeof  ids !== "undefined") {
							var states =  ids.length ? ids.split(',') : [] ;
							$.each(states, function(k,id) {
								$(dest).find('[value='+id+']').attr("selected","selected");
							});
						}
						$(dest).trigger("liszt:updated");
						$('.shoper select , .billing-box select').styler().trigger('refresh');
					}
				);
			} else {
				methods.addToList(opt,optValues,dest,prefix)
				$(dest).trigger("liszt:updated");
				$('.shoper select , .billing-box select').styler().trigger('refresh');
			}
			oldValues = optValues ;
			
		},
		addToList: function(opt,values,dest,prefix) {
			$.each(values, function(dataKey, dataValue) { 
				var groupExist = $("#"+prefix+"group"+dataValue+"").size();
				if ( ! groupExist ) {
					var datas = opt.data( 'd'+dataValue );
					if (datas.length >0) {
					var label = opt.find("option[value='"+dataValue+"']").text();
					var group ='<optgroup id="'+prefix+'group'+dataValue+'" label="'+label+'">';
					$.each( datas  , function( key, value) {
						if (value) group +='<option value="'+ value.virtuemart_state_id +'">'+ value.state_name +'</option>';
					});
					group += '</optgroup>';
					$(dest).append(group);
					
					}
				}
			});
		}
	};

	$.fn.vm2front = function( method ) {

		if ( methods[method] ) {
		  return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
		} else if ( typeof method === 'object' || ! method ) {
			return methods.init.apply( this, arguments );
		} else {
		  $.error( 'Method ' +  method + ' does not exist on Vm2 front jQuery library' );
		}    
	
	};
})(jQuery)
