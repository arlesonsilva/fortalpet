<?php
/**
 * Ajax_scroll
 */

// no direct access
defined( '_JEXEC' ) or die;
error_reporting('E_ALL');

class plgSystemAjax_scroll extends JPlugin
{

	public function __construct(& $subject, $config)
	{
		parent::__construct($subject, $config);
		$this->loadLanguage();
	}


	public function onBeforeCompileHead ()
	{
	  	$app = JFactory::getApplication();
		$doc = JFactory::getDocument();

		if ($app->isAdmin())
		{
			return true;
		}

        $container = $this->params->get( 'container');
        $item = $this->params->get( 'item');
        $pagination = $this->params->get( 'pagination');
        $next = $this->params->get( 'next');
        $limit = $this->params->get( 'triggerPageThreshold');

        $doc->addScript(JURI::root(true) . '/media/ajax_scroll/assets/jquery-ias.js');
        $script = '
                    jQuery.ias({
                     container :  "'.$container.'",
                     item: "'.$item.'",
                     pagination: "'.$pagination.'",
                     next: "'.$next.'",
                     triggerPageThreshold: "'.$limit.'",
					 trigger: false,
					 history : false,
                     loader: "<img src=\"'.JURI::root(true).'/media/ajax_scroll/assets/ajax-loader.gif\"/>",
                     noneleft: false,
					 onRenderComplete: function () {
						 jQuery("#product_list.grid .layout .hasTooltip").tooltip("hide");
						 jQuery("#product_list img.lazy").lazyload({
							effect : "fadeIn"
						});
						  jQuery(function() {
							jQuery("#product_list div.prod-row").each(function() {        
							var tip = jQuery(this).find("div.count_holder_small");
					
							jQuery(this).hover(
								function() { tip.appendTo("body"); },
								function() { tip.appendTo(this); }
							).mousemove(function(e) {
								var x = e.pageX + 60,
									y = e.pageY - 50,
									w = tip.width(),
									h = tip.height(),
									dx = jQuery(window).width() - (x + w),
									dy = jQuery(window).height() - (y + h);
					
								if ( dx < 50 ) x = e.pageX - w - 60;
								if ( dy < 50 ) y = e.pageY - h + 130;
					
								tip.css({ left: x, top: y });
								});         
							});
							});
						  jQuery("html.no-touch #product_list .prod-row:odd , html.no-touch .category-view .cat_row:odd").addClass("animate_left");
								jQuery("html.no-touch #product_list .prod-row:even, html.no-touch .category-view .cat_row:even").addClass("animate_right");
												   
								jQuery("html.no-touch .animate_left").each(function () {
									jQuery(this).appear(function() {
										jQuery(this).delay(350).animate({opacity:1,left:"0px"},950);
									});
								});
								jQuery("html.no-touch .animate_right").each(function () {
									jQuery(this).appear(function() {
										jQuery(this).delay(350).animate({opacity:1,right:"0px"},900);
									});
								}); 
						  jQuery(".loadmore ul.layout .prod-row , .loadmore ul.layout2 .prod-row").each(function(indx, element){
							var my_product_id = jQuery(this).find(".count_ids").val();
							var my_year = jQuery(this).find(".my_year").val();
							var my_month = jQuery(this).find(".my_month").val();
							var my_data = jQuery(this).find(".my_data").val();
							//alert(my_data);
							if(my_product_id){
								jQuery("#CountSmallCategLayout"+my_product_id).countdown({
								until: new Date(my_year, my_month - 1, my_data), 
								labels: ["Years", "Months", "Weeks", "'.JText::_('DR_DAYS').'", "'.JText::_('DR_HOURS').'", "'.JText::_('DR_MINUTES').'", "'.JText::_('DR_SECONDS').'"],
								labels1:["Years","Months","Weeks","'.JText::_('DR_DAYS').'","'.JText::_('DR_HOURS').'","'.JText::_('DR_MINUTES').'","'.JText::_('DR_SECONDS').'"],
								compact: false});
							}
							
						});
						  window.addEvent("domready", function() {
							SqueezeBox.initialize({});
							SqueezeBox.assign($$("a.modal"), {
							parse: "rel"
							});
						 });
						 jQuery("ul.layout .product-box , ul.layout2 .product-box").each(function(indx, element){
								var my_product_id = jQuery(this).find(".quick_ids").val();
								jQuery(this).append("<div class=\"quick_btn\" onClick =\"quick_btn("+my_product_id+")\"><i class=\"icon-eye-open\"></i>"+show_quicktext+"</div>");
								jQuery(this).find(".quick_id").remove();
								Virtuemart.product(jQuery("form.product"));
							  jQuery("form.js-recalculate").each(function(){
								if (jQuery(this).find(".product-fields").length) {
								  var id= jQuery(this).find("input[name=\"virtuemart_product_id[]\"]").val();
								  Virtuemart.setproducttype(jQuery(this),id);
								}
							  });
						});
						
				}
						  });
        ';

        $doc->addCustomTag('<script type="text/javascript">'.$script.'</script>');
	}
}
?>