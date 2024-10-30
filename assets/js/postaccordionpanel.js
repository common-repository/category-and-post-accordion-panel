if((typeof jQuery === 'undefined') && window.jQuery) {
	jQuery = window.jQuery;
} else if((typeof jQuery !== 'undefined') && !window.jQuery) {
	window.jQuery = jQuery;
}
var flg_v1 = 0; 	
function APCP_loadMorePosts(category_id,limit,elementId,total,request_obj){
	if(flg_v1==1) return;
	jQuery(document).ready(function($){ 
			var root_element = $("#"+elementId).parent();
			if($("#"+elementId).parent().parent().hasClass("lt-tab"))
				root_element = $("#"+elementId).parent().parent(); 
			 
			if((category_id==='undefined')) category_id = 0; 
 			$(root_element).find(".item-posts").find(".ik-post-load-more").html("<div align='center'>"+$(".wp-load-icon").html()+"</div>");
			flg_v1 = 1;
			$.ajax({
				url: postaccordionpanel.apcp_ajax_url, 
				data: {'action':'getMorePosts',security: postaccordionpanel.apcp_security,'limit_start' : limit,'total' : total,'category_id' : category_id,'hide_post_title' : request_obj.hide_post_title,'post_title_color' : request_obj.post_title_color,'category_tab_text_color' : request_obj.category_tab_text_color,'category_tab_background_color' : request_obj.category_tab_background_color,'header_text_color' : request_obj.header_text_color,'header_background_color' : request_obj.header_background_color,'display_title_over_image' : request_obj.display_title_over_image,'number_of_post_display' : request_obj.number_of_post_display,'vcode' : request_obj.vcode	},
				success:function(data) {     
					APCP_printData(elementId,data,"loadmore");
				},error: function(errorThrown){ console.log(errorThrown);}
			});
	});
}
function APCP_fillPosts(elementId,category_id,request_obj,flg_pr){
	if(flg_v1==1) return;
 	jQuery(document).ready(function($){
	
			if($("#"+elementId).hasClass('pn-active') && flg_pr==1){
				$("#"+elementId).removeClass("pn-active");
				$("#"+elementId).parent().find(".item-posts").slideUp(600);
				return;
			}
			
			var root_element = $("#"+elementId).parent();
			if($("#"+elementId).parent().parent().hasClass("lt-tab"))
				root_element = $("#"+elementId).parent().parent();  
			 
			$("#"+elementId).addClass("pn-active");	
			 
			if(flg_pr==2){
				$(root_element).find(".ik-search-button").html("<br />"+$(".wp-load-icon").html()); 
			}
			else{  
				$("#"+elementId).find(".ik-load-content,.ik-post-no-items").remove();
				$("#"+elementId).find(".ld-pst-item-text").html("<div class='ik-load-content'>"+$(".wp-load-icon").html()+"</div>");
			}	 
			if((category_id==='undefined')) category_id = 0; 
 			flg_v1 = 1;
		 	$.ajax({
				url: postaccordionpanel.apcp_ajax_url,
				security: postaccordionpanel.apcp_security,
				data: {'action':'getPosts',security: postaccordionpanel.apcp_security,flg_pr:flg_pr,'category_id' : category_id,'hide_post_title' : request_obj.hide_post_title,'post_title_color' : request_obj.post_title_color,'category_tab_text_color' : request_obj.category_tab_text_color,'category_tab_background_color' : request_obj.category_tab_background_color,'header_text_color' : request_obj.header_text_color,'header_background_color' : request_obj.header_background_color,'display_title_over_image' : request_obj.display_title_over_image,'number_of_post_display' : request_obj.number_of_post_display,'vcode' : request_obj.vcode},
				success:function(data) { 
					APCP_printData(elementId,data,"fillpost"); 
				},error: function(errorThrown){ console.log(errorThrown);}
			});   
	});		

	;(function($){
		$(window).resize(function(){
			$(".wea_content .item-posts").each(function(){
				var root_element = $(this).parent();
				var cnt_width = $(this).parent().width();
				$(this).find(".ik-post-item").each(function(){
					if(cnt_width > 1024)		
						$(this).css("width","230px");
					else if(cnt_width <= 1024 && cnt_width > 768)	
						$(this).css("width","19%");
					else if(cnt_width <= 858 && cnt_width > 640)	
						$(this).css("width","24%");
					else if(cnt_width <= 640 && cnt_width > 480)	
						$(this).css("width","32%"); 
					else if(cnt_width <= 480 && cnt_width > 260)	
						$(this).css("width","49%");  
					else if(cnt_width <= 260)	
						$(this).css("width","99%");     
				}); 
			});
		});
	})(jQuery);	
}
function APCP_printData(elementId,data,flg){
	jQuery(document).ready(function($){
		
	  	var root_element = $("#"+elementId).parent();
		if($("#"+elementId).parent().parent().hasClass("lt-tab"))
			root_element = $("#"+elementId).parent().parent(); 
		 
		if(flg=="loadmore"){
			$(root_element).find(".item-posts").find(".wp-load-icon").remove();
			$(root_element).find(".item-posts").find(".clr").remove();
			$(root_element).find(".item-posts").find(".ik-post-load-more").remove(); 
			$(root_element).find(".item-posts").append(data).fadeIn(400); 
			$(root_element).find(".item-posts").append("<div class='clr'></div>");
		}else{ 
			$("#"+elementId).find(".ik-load-content,.ik-post-no-items").remove();
			//$(root_element).find(".item-posts").fadeOut(1);
			//$(root_element).parent().find(".item-posts").fadeOut(1);
			$(root_element).find(".item-posts").html(data).fadeIn(400);  
		}
		
		var cnt_width = $("#"+elementId).parent().parent().width();
		var prod_item_height = [];
		$(root_element).find(".item-posts").find(".ik-post-item").each(function(){		
			
			if(cnt_width > 1024)		
				$(this).css("width","230px");
			else if(cnt_width <= 1024 && cnt_width > 768)	
				$(this).css("width","19%");
			else if(cnt_width <= 858 && cnt_width > 640)	
				$(this).css("width","24%");
			else if(cnt_width <= 640 && cnt_width > 480)	
				$(this).css("width","32%"); 
			else if(cnt_width <= 480 && cnt_width > 260)	
				$(this).css("width","49%");  
			else if(cnt_width <= 260)	
				$(this).css("width","99%");  	 
				
			prod_item_height.push($(this).find(".ik-post-name").height()); 
		}); 
		
		if(cnt_width > 260)
		$(root_element).find(".item-posts").find(".ik-post-item").find(".ik-post-name").css("height",(Math.max.apply(Math,prod_item_height))+"px");
		
		flg_v1 = 0;	
	});	  
}
var flg_ms_hover = 0;
function apcp_pr_item_image_mousehover(ob_pii){ 
	if(flg_ms_hover == 1) return;
	jQuery(document).ready(function($){
		$(ob_pii).find(".ov-layer").show();  
		$(ob_pii).find(".ov-layer").css("visibility","visible"); 
		$(ob_pii).find(".ov-layer").css("top","40");  
		flg_ms_hover = 1;
		if($.trim($(ob_pii).find(".ov-layer").html())!="")
			$(ob_pii).find(".ov-layer").animate({opacity:0.9,top:0},0); 
		else
			$(ob_pii).find(".ov-layer").animate({opacity:0.5,top:0},0); 
	});
} 
function apcp_pr_item_image_mouseout(ob_pii){
	jQuery(document).ready(function($){ 
		$(ob_pii).find(".ov-layer").animate({opacity:0,top:40},0);
		flg_ms_hover = 0;
		$(ob_pii).find(".ov-layer").hide();
		$(ob_pii).find(".ov-layer").css("visibility","hidden");  
	});
}

function apcp_cat_tab_ms_out(ob_ms_eff){
	jQuery(document).ready(function($){ 
		$(ob_ms_eff).removeClass("pn-active-bg"); 	
	});
}
function apcp_cat_tab_ms_hover(ob_ms_eff){
	jQuery(document).ready(function($){ 
		$(ob_ms_eff).addClass("pn-active-bg"); 	
	});
}