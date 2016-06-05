jQuery(document).ready(
	function(){
		jQuery(".simulacra_search_box")
			.on("focus", function(event){
					jQuery(event.target).attr("value","");
				}
			);
	}
);