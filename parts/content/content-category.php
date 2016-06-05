<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="<?php simulacra_post_thumbnail_background(); ?>" >
	<div class="article-holder">
		<div class="article-inside" >
			<header class="entry-header">
				<h2 class="entry-title">
					<a href="<?PHP echo get_permalink(); ?>" rel="bookmark"><?PHP echo the_title(); ?></a>
				</h2>
			</header><!-- .entry-header -->
			<div class="entry-content">
				<?php
					/* translators: %s: Name of current post */
					the_excerpt( sprintf(
						__( 'Continue reading %s', 'simulacra' ),
						the_title( '<span class="screen-reader-text">', '</span>', false )
					) );
				?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->