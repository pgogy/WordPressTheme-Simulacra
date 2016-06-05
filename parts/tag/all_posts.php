<?php if ( have_posts() ) : 

	simulacra_archive_title();
	
	while ( have_posts() ) : the_post();

		get_template_part( 'parts/content/content-tag');

	endwhile;
	
	simulacra_featured_posts_content("tag", $_GET['tag']);
	
	simulacra_tag_cloud(_x('Tag cloud', "Tag cloud", "simulacra"),simulacra_posts_content("tag", $_GET['tag']));
	
	simulacra_post_authors("tag", $_GET['tag']);
	
	get_template_part('parts/pagination/pagination');
	
else :

	get_template_part( 'content', 'none' );

endif;
