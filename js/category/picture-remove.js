jQuery(document).ready( function($) {

	if( $('#simulacra_post_id').length > 0 && $('#simulacra_term_id').length > 0 ){	
				 
		$(".handlediv").click(function(){
			var p = $(this).parent('.postbox');			
			p.toggleClass('closed');
		});
		
		WPSetThumbnailHTML = function(html){
			$('.inside', '#postimagediv').html(html);
		};
		
		WPRemoveThumbnail = function(nonce){
			var post_ID = 0;
			var term_ID = 0;
			
			if( $('#simulacra_post_id').length > 0 ){
				post_ID = $('#simulacra_term_id').val();
			}
			
			if( $('#simulacra_term_id').length > 0 ){
				term_ID = $('#simulacra_term_id').val();
			}
			
			if( post_ID < 1 || term_ID < 1 ){
				return;
			}
			
			$.post( ajaxurl, 
				{ 
					action: "simulacra-category-remove-image", 
					post_id: post_ID, 
					thumbnail_id: -1,
					term_id: term_ID,
					_ajax_nonce: nonce, 
					cookie: encodeURIComponent(document.cookie)
				}, 
				function(str){
					WPSetThumbnailHTML(str);
				}
			 );
		};
	}
	
});
