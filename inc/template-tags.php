<?php

function simulacra_get_categories($id){

	$post_categories = wp_get_post_categories($id);
	$cats = array();
		
	foreach($post_categories as $c){
		$cat = get_category( $c );
		$cats[] = array( 'name' => $cat->name, 'slug' => $cat->slug, 'link' => get_category_link($c) );
	}
	
	return $cats;

}

function simulacra_get_categories_links($id){

	$html = array();
	$cats = simulacra_get_categories($id);
	
	foreach($cats as $cat){
		$html[] = "<a href='" . $cat['link'] ."'>" . $cat['name'] . "</a>";
	}
	
	
	if(count($html)==0){
		$html[] = _x("No Categories", "No Categories", "simulacra");
	}
	
	return $html;

}

function simulacra_body_class(){

	if(is_author()){
		return "author";
	}
	
}

function simulacra_get_tags($id){

	echo the_tags(" ", "/", " ");

}

function simulacra_get_tags_links($id){

	$cats = simulacra_get_tags($id);

}

function simulacra_entry_meta() {
	
	global $post;
	
	?><div>
		<?PHP $author_id = get_the_author_meta('ID'); ?>
		<h6 class='meta_label'><?PHP echo _x('Author', "Author", 'simulacra'); ?></h6>
		<h6><a href="<?php echo get_author_posts_url($author_id); ?>"><?php echo ucfirst(get_the_author_meta( 'display_name' )); ?></a> 
		<?PHP echo get_the_author_posts(); echo " " . _x('Posts', "Posts", 'simulacra'); ?> </h6>
	</div>
	<div>
		<h6 class='meta_label'><?PHP echo _x('Published', "Published", 'simulacra'); ?></h6><h6><?PHP echo get_the_date( "Y-n-d G:i:s A", $post->ID ); ?></h6>
	</div>
	<div>
		<h6 class='meta_label'><?PHP echo _x('Categories', "Categories", 'simulacra'); ?></h6><h6><?PHP echo implode(" / ", simulacra_get_categories_links(get_the_ID())); ?></h6>
	</div>
	<div>
		<h6 class='meta_label'><?PHP echo _x('Tags', "Tags", 'simulacra'); ?></h6><h6><?PHP echo simulacra_get_tags_links(get_the_ID()); ?></h6>
	</div><?PHP
	
}

function simulacra_post_thumbnail_background() {

	if(get_post_thumbnail_id(get_the_ID())!=""){
		
		$id = get_the_ID();

		?> background:url('<?PHP echo wp_get_attachment_url(get_post_thumbnail_id($id)); ?>') 0px 0px / cover no-repeat; <?PHP
	
	}else{
	
		?> 
			background: <?PHP echo get_theme_mod('site_post_background_colour'); ?>; 
			border-top: 2px solid <?PHP echo get_theme_mod('site_title_colour'); ?>; 
			border-bottom: 2px solid <?PHP echo get_theme_mod('site_title_colour'); ?>; 
		<?PHP
	
	}

}

function simulacra_category_thumbnail_background($term) {

	$thumbnail = get_option( 'simulacra_' . $term . '_thumbnail_id', 0 );
	
	if($thumbnail){
		
		?> background:url('<?PHP echo wp_get_attachment_url($thumbnail); ?>') 0px 0px / cover no-repeat; <?PHP
	
	}else{
	
		?> 
			background: <?PHP echo get_theme_mod('site_post_background_colour'); ?>; 
			border-top: 2px solid <?PHP echo get_theme_mod('site_title_colour'); ?>; 
			border-bottom: 2px solid <?PHP echo get_theme_mod('site_title_colour'); ?>; 
		<?PHP
	
	}

}

function simulacra_header_image(){
	
	if(get_header_image()!=""){

		?> style="background:url('<?PHP header_image(); ?>') 0px 0px / cover no-repeat; height:300px" <?PHP
	
	}
	
}

function simulacra_archive_title(){

	if(isset($_GET['cat'])){
		$term = $_GET['cat'];
	}else{
		$term = get_term_by( "slug", $_GET['tag'], "post_tag" );
		$term = $term->term_id;
	}

	?><header class="page-header">
		<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			$thumbnail = get_option( 'simulacra_' . $term . '_thumbnail_id', 0 );
			if($thumbnail){
				$html = 'background:url(' . wp_get_attachment_url($thumbnail) . ') 0px 0px / cover no-repeat;';
				the_archive_description( '<div class="taxonomy-description"><div class="taxonomy_picture" style="' . $html . '"></div><div class="taxonomy_content">', '</div></div>' );
			}else{
				the_archive_description( '<div class="taxonomy-description">', '</div>' );
			}
		?>
	</header><?PHP

}

function simulacra_author_title(){

	?><header class="page-header">
		<?php
			echo '<h1 class="page-title">' . ucfirst(get_the_author_meta("user_nicename")) . '</h1>';
			echo '<div class="taxonomy-description">' . get_the_author_meta("description") . '</div>';
		?>
	</header><?PHP

}

function simulacra_child_categories(){

	?><footer class="page-footer">
		<h1 class="page-title"><?PHP echo _x('Related Categories', "Related Categories", 'simulacra'); ?></h1>
		<div class="taxonomy-description"><?PHP
		
			$category = get_category($_GET['cat']);
			
			$childcats = get_categories('child_of=' . $category->parent . '&hide_empty=1&exclude=' . $_GET['cat']);
			$output = array();
			foreach ($childcats as $childcat) {
				if (cat_is_ancestor_of($ancestor, $childcat->cat_ID) == false){
					$output[] = '<a href="'.get_category_link($childcat->cat_ID).'">' . $childcat->cat_name . '</a>';
					$ancestor = $childcat->cat_ID;
				}
			}
			
			echo implode(" / ", $output);
			
		?></div>
	</footer><?PHP

}

function simulacra_posts_authors_list($type, $id){

	$the_query = new WP_Query( array($type => $id, 'posts_per_page' => 99) );
	
	$authors = array();

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$authors[] = get_the_author_meta('ID');
		}
	} 

	$authors = array_unique($authors);
	
	wp_reset_postdata();
	
	return $authors;
	
}

function simulacra_posts_authors_html($type, $id){

	$authors = array_unique(simulacra_posts_authors_list($type, $id));
	$output = array();
	foreach($authors as $author){
		$output[] = "<a href='" . get_author_posts_url($author) . "'>" . ucfirst(get_the_author_meta( 'display_name', $author )) . "</a>";
	}
	
	echo implode(" / ", $output);

}

function simulacra_post_authors($type, $id){
	?><footer class="page-footer">
		<h1 class="page-title"><?PHP echo _x('Authors', "Authors", 'simulacra'); ?></h1>
		<div class="taxonomy-description" id='tag_cloud'><?PHP
		
			simulacra_posts_authors_html($type, $id);
			
		?></div>
	</footer><?PHP
}

function simulacra_posts_content($type, $id){

	$the_query = new WP_Query( array($type => $id, 'posts_per_page' => 99) );
	
	$content = "";

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			$content .= str_replace(".", "", preg_replace("/(?![=$'%-])\p{P}/u", " ", strip_tags(strtolower(get_the_content()))));
		}
	} 
	
	wp_reset_postdata();
	
	return $content;
	
}

function simulacra_tag_cloud($title, $content){
	?><footer class="page-footer">
		<h1 class="page-title"><?PHP echo $title; ?></h1>
		<div class="taxonomy-description" id='tag_cloud'><?PHP
		
			simulacra_tag_cloud_tags($content);
			
		?></div>
	</footer><?PHP
}

function simulacra_tag_cloud_tags($content){
	
	$words = explode(" ", $content);
	$words = array_filter($words);
	
	?>
	<script src="<?PHP echo get_template_directory_uri(); ?>/js/tagcloud/d3.lib.js"></script>
	<script src="<?PHP echo get_template_directory_uri(); ?>/js/tagcloud/d3.tagcloud.js"></script>
	<script src="<?PHP echo get_template_directory_uri(); ?>/js/tagcloud/d3.click.js"></script>
	<script>
	  var fill = d3.scale.category20();
	  half_width = (jQuery('#tag_cloud').width()/2);
	  d3.layout.cloud().size([jQuery('#tag_cloud').width(), 300])
		  .words([
			<?PHP
				foreach($words as $word){
					echo '"' . trim($word) . '",';
				}
			?>
			].map(function(d) {
			return {text: d, size: 10 + Math.random() * 90};
		  }))
		  .padding(5)
		  .rotate(function() { return ~~(Math.random() * 2) * 90; })
		  .fontSize(function(d) { return d.size; })
		  .on("end", draw)
		  .start();
	  function draw(words) {
		d3.select("#tag_cloud").append("svg")
			.attr("width", jQuery('#tag_cloud').width())
			.attr("height", 300)
		  .append("g")
			.attr("transform", "translate(" + half_width + ",150)")
		  .selectAll("text")
			.data(words)
		  .enter()
		  .append("text")
			.style("font-size", function(d) { return d.size + "px"; })
			.style("cursor", "pointer")
			.attr("text-anchor", "middle")
			.attr("transform", function(d) {
			  return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
			})
			.text(function(d) { return d.text; });
	  }
	</script><?PHP
	
}

function simulacra_head_extra_js(){
	?>
		<script>
			var search_url = "<?PHP echo home_url() . "?s="; ?>";
		</script>
	<?PHP
}

function simulacra_featured_posts_content($type, $id){
	?><footer class="page-footer">
		<h1 class="page-title"><?PHP echo _x('Featured Content', "Featured Content", 'simulacra'); ?></h1>
		<div class="featured-content"><?PHP
			
			simulacra_featured_posts_content_html($type, $id);
			
		?></div>
	</footer><?PHP
}

function simulacra_featured_posts_content_html($type, $id){

	if($type == "category"){
		$new_type = "category__and";
		$id = array($id, get_option("simulacra_featured"));
		$the_query = new WP_Query( array($new_type => $id, 'posts_per_page' => 99) );
	}else{
		$the_query = new WP_Query( array($type => $id, 'posts_per_page' => 99, 'category__and' => get_option("simulacra_featured")) );
	}

	if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
			$the_query->the_post();
			get_template_part("parts/content/content-" . $type);
		}
	} 
	
	wp_reset_postdata();
	
}