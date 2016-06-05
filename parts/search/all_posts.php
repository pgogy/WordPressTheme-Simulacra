<?php 

	if ( have_posts() ) : 
			
		while ( have_posts() ) : the_post(); 

			get_template_part( 'parts/content/content-search' );

		endwhile;

		get_template_part('parts/pagination/pagination');

		simulacra_tag_cloud(_x('Tag cloud', "Tag Cloud", "simulacra"),simulacra_posts_content("s", $_GET['term']));
	
		simulacra_post_authors("s", $_GET['term']);
			
	else :
			
		get_template_part( 'content', 'none' );

	endif;
	
?>