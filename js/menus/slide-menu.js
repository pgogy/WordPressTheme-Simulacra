jQuery(document).ready( function($) {
		jQuery("nav.nav-menu-slide .caret")
			.on("click", function(event){
			
					depth = jQuery(event.currentTarget)
						.attr("menu_depth");
						
					jQuery("." + depth)
						.css("display", "none");
						
					jQuery("." + depth + " ul")
						.css("display", "none");
					
					if(depth == "menu-depth-0"){
						jQuery(".slide-menu")
							.css("display", "none");
					}
					
					jQuery(event.currentTarget)
						.parent()
						.next()
						.show("slide", { direction: "left" }, 500);
						
				}
			);
			
		jQuery(document)
			.on("click", function(event){
				if(!jQuery(event.target).hasClass("caret")){
					jQuery(".nav-slide-menu")
						.css("display", "none");
				}
			});
	}
);
