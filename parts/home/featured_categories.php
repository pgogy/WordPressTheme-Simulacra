<?php 

	$post_categories = get_categories( array('exclude' => get_option("simulacra_featured"), 'hide_empty' => 0) );

	foreach($post_categories as $c){
		$cat = get_category( $c );
		
		if(get_theme_mod("category_" . $c->term_id)=="on"){
		
		?><article style="<?php simulacra_category_thumbnail_background($c->term_id); ?>" >
			<div class="article-holder">
				<div class="article-inside" >
					<header class="entry-header">
						<h1 class="entry-title">
							<a href="<?PHP echo get_category_link($c); ?>">
								<?PHP echo $cat->name; ?>
							</a>
						</h1>
						
					</header><!-- .entry-header -->
					<div class="entry-content"><?PHP
						echo $cat->description;
					?></div><!-- .entry-content -->
				</div>
			</div>
		</article><!-- #post-## --><?PHP
		
		}
		
	}
	
?>