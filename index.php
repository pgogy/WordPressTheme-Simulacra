<?php

get_header(); 

?>
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main"><?PHP

		switch(get_theme_mod('home_page')){
			case 'all_posts' : get_template_part( 'parts/home/all_posts'); break;
			case 'featured_posts' : get_template_part( 'parts/home/featured_posts'); break;
			case 'all_categories' : get_template_part( 'parts/home/all_categories'); break;
			case 'featured_c' : get_template_part( 'parts/home/featured_categories'); break;
			case 'featured_c_and_p' : get_template_part( 'parts/home/featured_categories'); get_template_part( 'parts/home/featured_posts_as_well'); break;
			case 'featured_p_and_c' : get_template_part( 'parts/home/featured_posts_as_well'); get_template_part( 'parts/home/featured_categories'); break;
			default : get_template_part( 'parts/home/all_posts');  break;
		}
		
		?>
		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
