<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Fifteen
 * @since Twenty Fifteen 1.0
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Sorry, something can\'t be found', 'simulacra' ); ?></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Try a search?', 'simulacra' ); ?></p>

					<?php get_template_part("parts/search-form/standard"); ?>
				</div><!-- .page-content -->
				<?PHP
					simulacra_tag_cloud(_x('Try the tag cloud', 'tag cloud', "simulacra"), simulacra_posts_content("s", "a"));
				?>
			</section><!-- .error-404 -->

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_footer(); ?>
