<?php if ( have_posts() ) : 

	simulacra_author_title();
	
	while ( have_posts() ) : the_post();

		get_template_part( 'parts/content/content-author');

	endwhile;
	
	simulacra_featured_posts_content("author", $_GET['author']);
	
	simulacra_tag_cloud(_x('Author', 'Author', "simulacra"), simulacra_posts_content("author", $_GET['author']));
	
	get_template_part('parts/pagination/pagination');
	
else :

	get_template_part( 'content', 'none' );

endif;

?>