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
					$content = get_the_content();
					$output = substr(strip_tags($content),0,500);
					$words = explode(" ", $output);
					array_pop($words);
					echo implode(" ", $words) . '... <a href="' . get_post_permalink() . '">' . _x("read more", "Read more", "simulacra") . "</a>";
				?>
			</div><!-- .entry-content -->
		</div>
	</div>
</article><!-- #post-## -->