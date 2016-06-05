<?php 

	$the_query = new WP_Query( array('category__and' => get_option("simulacra_featured")) );
	
	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part( 'parts/content/content-index', get_post_format() );
		}
		
		get_template_part('parts/pagination/pagination');
		
	} 
	
	wp_reset_postdata();

?>