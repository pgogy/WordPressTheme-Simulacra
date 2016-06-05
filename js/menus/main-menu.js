jQuery(document).ready( function($) {
		jQuery("nav.nav-menu-standard .caret")
			.on("click", function(event){
			
					depth = jQuery(event.currentTarget)
						.attr("menu_depth");
						
					jQuery("." + depth)
						.css("display", "none");
					
					if(depth == "menu-depth-0"){
						jQuery(".standard-menu")
							.css("display", "none");
					}
					
					jQuery(event.currentTarget)
						.parent()
						.next()
						.slideDown(500);
						
				}
			);
			
		jQuery(document)
			.on("click", function(event){
				if(!jQuery(event.target).hasClass("caret")){
					jQuery(".standard-menu")
						.css("display", "none");
				}
			});
	}
);
