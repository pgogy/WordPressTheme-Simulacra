<article id="post-<?php the_ID(); ?>" <?php post_class("home-page"); ?> >
	<div class="article-holder">
		<div class="article-inside" style="<?php simulacra_post_thumbnail_background(); ?>">
			<div class="inside-angle-header">
				<div class="wrapper">
				</div>
			</div>
			<header class="entry-header">
				<?php
					if ( is_single() ) :
						the_title( '<h1 class="entry-title">', '</h1>' );
					else :
						the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' );
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

					wp_link_pages( array(
						'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'simulacra' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'simulacra' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					) );
				?>
			</div><!-- .entry-content -->

			<?php
				// Author bio.
				if ( is_single() && get_the_author_meta( 'description' ) ) :
					get_template_part( 'author-bio' );
				endif;
			?>

			<footer class="entry-footer">
				<?php //simulacra_entry_meta(); ?>
				<?php //edit_post_link( __( 'Edit', 'simulacra' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-footer -->
			<div class="bottom-inside-angle-header">
				<div class="wrapper">
				</div>
			</div>
		</div>
	</div>
</article><!-- #post-## -->