<?php if ( have_posts() ) :

	simulacra_archive_title();

	while ( have_posts() ) : the_post();

		get_template_part( 'parts/content/content-category');

	endwhile;
	
	get_template_part('parts/pagination/pagination');
	
	simulacra_featured_posts_content("category", $_GET['cat']);
	
	simulacra_tag_cloud(_x('Tag cloud','Tag Cloud', "simulacra"), simulacra_posts_content("category", $_GET['cat']));
	
	simulacra_post_authors("category", $_GET['cat']);
	
	simulacra_child_categories();
	
else :

	get_template_part( 'content', 'none' );

endif;

?>