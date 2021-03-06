<article id="post-<?php the_ID(); ?>" <?php post_class("home-page"); ?> style="<?php simulacra_post_thumbnail_background(); ?>" >
	<div class="article-holder">
		<div class="article-inside" >
			<header class="entry-header">
				<?php
					if ( is_single() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					endif;
				?>
			</header><!-- .entry-header -->

			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
					the_content( sprintf(
						__( 'Continue reading %s', 'simulacra' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );
				?>
			</div><!-- .entry-content -->
			
			<footer class="entry-footer">
				<?php simulacra_entry_meta(); ?>
				<?php edit_post_link( __( 'Edit', 'simulacra' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
		</div>
	</div>
</article><!-- #post-## -->