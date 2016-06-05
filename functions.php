<?php

function simulacra_setup() {

	load_theme_textdomain( 'simulacra', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );

	add_theme_support( 'title-tag' );

	if ( ! isset( $content_width ) ) $content_width = 900;

	add_theme_support( 'post-thumbnails' );
	
	$chargs = array(
		'width' => 980,
		'height' => 300,
		'uploads' => true,
	);
	
	add_theme_support( 'custom-header', $chargs );
	
	set_post_thumbnail_size( 825, 510, true );

	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'simulacra' ),
		'social'  => __( 'Social Links Menu', 'simulacra' ),
	) );

	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

}
add_action( 'after_setup_theme', 'simulacra_setup' );

function simulacra_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'simulacra' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'simulacra' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'simulacra_widgets_init' );

function my_plugin_image_selected($html, $id) {

    ?>
    <script type="text/javascript">
    /* <![CDATA[ */
    var win = window.dialogArguments || opener || parent || top;
	console.log("here I am");
                 
    win.jQuery( '#default_image' ).val('<?php echo $id;?>');
    // submit the form
    win.jQuery( '#shiba-gallery_options' ).submit();
    /* ]]> */
	
    </script>
    <?php
    exit();
}
add_filter('media_send_to_editor', 'my_plugin_image_selected', 10, 3);
 
function simulacra_scripts_admin() {

	wp_enqueue_style('thickbox');		
	wp_enqueue_script('thickbox');
	
	wp_enqueue_script('jquery');
	wp_enqueue_script( 'simulacra-picture-remove', get_template_directory_uri() . '/js/category/picture-remove.js', array( 'jquery' ) );
} 
 
function simulacra_scripts() {

	wp_enqueue_style( 'simulacra-style', get_template_directory_uri() . '/css/main.css' );
	wp_enqueue_style( 'simulacra-style-mobile-768', get_template_directory_uri() . '/css/mobile768.css' );
	wp_enqueue_style( 'simulacra-style-mobile-400', get_template_directory_uri() . '/css/mobile400.css' );
	wp_enqueue_style( 'simulacra-main-menu-style', get_template_directory_uri() . '/css/menu/main-menu.css' );
	wp_enqueue_style( 'simulacra-slide-menu-style', get_template_directory_uri() . '/css/menu/slide-menu.css' );

	wp_enqueue_script( 'simulacra-main-menu', get_template_directory_uri() . '/js/menus/main-menu.js', array( 'jquery' ) );
	wp_enqueue_script( 'simulacra-slide-menu', get_template_directory_uri() . '/js/menus/slide-menu.js', array( 'jquery' ) );
	wp_enqueue_script( 'simulacra-search-form', get_template_directory_uri() . '/js/search/search-form.js', array( 'jquery' ) );
	wp_enqueue_script( 'jquery-effects-core', array( 'jQuery' ) );
	wp_enqueue_script( 'jquery-effects-slide', array( 'jQuery-effects-core' ) );
	
}
add_action( 'wp_enqueue_scripts', 'simulacra_scripts' );
add_action( 'admin_enqueue_scripts', 'simulacra_scripts_admin' );

function simulacra_category_edit_form_fields ($term) {
	$term_id = $term->term_id;
	$post = get_default_post_to_edit( 'post', true );
	$post_ID = $post->ID;
	?>
        <tr class="form-field">
			<th>Featured Image for this category</th>
            <td>
            	<div id="postimagediv" class="postbox" style="width:95%;" >
                    <div class="inside">
                        <?php wp_enqueue_media( array('post' => $post_ID) ); ?>
                        <?php
							$thumbnail_id = get_option( 'simulacra_'.$term_id.'_thumbnail_id', 0 );
                            echo _wp_post_thumbnail_html( $thumbnail_id, $post_ID );
                        ?>
                    </div>
                    <input type="hidden" name="simulacra_post_id" id="simulacra_post_id" value="<?php echo $post_ID; ?>" />
                    <input type="hidden" name="simulacra_term_id" id="simulacra_term_id" value="<?php echo $term_id; ?>" />
                </div>
        	</td>
		</tr>
	<?php	
}
add_action('category_edit_form_fields','simulacra_category_edit_form_fields');
add_action('post_tag_edit_form_fields','simulacra_category_edit_form_fields');

function simulacra_taxonomies_save_meta( $term ) {

	if ( isset( $_POST['simulacra_post_id'] ) && $_POST['simulacra_post_id'] !=""  ) {
		$default = $_POST['simulacra_post_id'];
	}else if ( isset( $_POST['simulacra_term_id'] ) ) {
		$default = $_POST['simulacra_term_id'];
	}
	
	$thumbnail = get_post_meta( $default, '_thumbnail_id', true );

	if($thumbnail){
		update_option( 'simulacra_' . $term . '_thumbnail_id', $thumbnail );
	}
}
add_action('edited_category', 'simulacra_taxonomies_save_meta', 10, 2 );  
add_action('edited_post_tag', 'simulacra_taxonomies_save_meta', 10, 2 );    

function simulacra_ajax_set_post_thumbnail() {

	delete_option( 'simulacra_' . $_POST['term_id'] . '_thumbnail_id' );
		
	$return = _wp_post_thumbnail_html( null, $_POST['post_id']);

	echo $return;
	
	die(0);
	
}
add_action('wp_ajax_simulacra-category-remove-image', 'simulacra_ajax_set_post_thumbnail' );  

function simulacra_hex2rgb($hex) {
   $hex = str_replace("#", "", $hex);

   if(strlen($hex) == 3) {
      $r = hexdec(substr($hex,0,1).substr($hex,0,1));
      $g = hexdec(substr($hex,1,1).substr($hex,1,1));
      $b = hexdec(substr($hex,2,1).substr($hex,2,1));
   } else {
      $r = hexdec(substr($hex,0,2));
      $g = hexdec(substr($hex,2,2));
      $b = hexdec(substr($hex,4,2));
   }
   $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
   return $rgb; // returns an array with the rgb values
}

function simulacra_extra_style(){

	?><style>
	
		html{
			background-color: <?PHP echo get_theme_mod('site_allsite_background_colour'); ?>;
			color: <?PHP echo get_theme_mod('site_allsite_colour'); ?>;
		}
		
		footer#colophon
		{
			color: <?PHP echo get_theme_mod('site_footer_colour'); ?>;
			background-color: <?PHP echo get_theme_mod('site_footer_background_colour'); ?>;
		}
		
		.site-navigation ul li a{
			color :  <?PHP echo get_theme_mod('site_menu_text_colour'); ?>;
		}
		
		.site-navigation li:hover a, 
		.site-navigation li:focus a{
			color: <?PHP echo get_theme_mod('site_menu_text_hover_colour'); ?>;
		}
		
		.site-navigation li:hover, 
		.site-navigation li:focus {
			background-color: <?PHP echo get_theme_mod('site_menu_background_hover_colour'); ?>;
		}

		<?PHP
			$hex = simulacra_hex2rgb(get_theme_mod('site_menu_background_colour'));
		?>

		.site-navigation{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 1); 
		}
		
		.site-navigation ul{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.8); 
		}
		
		.nav-menu-slide ul{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 1); 
		}
	
		header#masthead{
			background-color: <?PHP echo get_theme_mod('site_header_colour'); ?>; 
		}		
		
		h1, h2, h3, h4, h5, h6, summary,
		#bodyContent h1,
		#bodyContent h2,
		#bodyContent h3,
		#bodyContent h4,
		#bodyContent h5,
		#bodyContent h6{
			color: <?PHP echo get_theme_mod('site_menu_background_colour'); ?>;
		}

		a{
			color: <?PHP echo get_theme_mod('site_alllink_colour'); ?>;
		}
		
		.home .page-footer h1 span{
			background-color: <?PHP echo get_theme_mod('site_post_background_colour'); ?>;
		}
		
		#content a:hover,
		#content a:focus{
			color: <?PHP echo get_theme_mod('site_alllink_hover_colour'); ?>;
		}
		
		.site-navigation ul li .current-menu-item a{
			background: <?PHP echo get_theme_mod('site_menu_background_current_colour'); ?>;  
			background-color: <?PHP echo get_theme_mod('site_menu_background_current_colour'); ?>;  
		}
		
		<?PHP
			$hex = simulacra_hex2rgb(get_theme_mod('site_content_background_colour'));
		?>
		
		footer.page-footer h1.page-title span.more{
			border-right: 2px solid <?PHP echo get_theme_mod('site_allsite_colour'); ?>;
		}
		
		.page-footer h1 a{
			color: <?PHP echo $hex; ?>;
			background-color: <?PHP echo get_theme_mod('site_allsite_colour'); ?>;
		}
		
		input[type=submit]{
			color: <?PHP echo get_theme_mod('site_allsite_colour'); ?>;
		}
		
		article{
			background-color: <?PHP echo get_theme_mod('site_post_background_colour'); ?>;
		}
		
		article .entry-header .entry-title,
		article .entry-content,
		article .entry-footer h6,
		.page-header .taxonomy-description,
		section.not-found .page-content,
		.page-footer .taxonomy-description{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.8);
		}
		
		nav form input[type=submit]{
			background-color: <?PHP echo get_theme_mod("site_title_colour"); ?>;
			border-color: <?PHP echo get_theme_mod("site_title_colour"); ?>;
			color: <?PHP echo get_theme_mod('site_allsite_colour'); ?>;
		}
		
		header#masthead h1 a,
		header#masthead p a{
			color: <?PHP echo get_theme_mod("site_title_colour"); ?>;
		}
		
		<?PHP
			$hex = simulacra_hex2rgb(get_theme_mod('site_title_colour'));
		?>
		
		footer#colophon div div div aside,
		footer#colophon div div nav{
			background-color: <?PHP echo get_theme_mod('site_allsite_colour'); ?>;
		}	
		
		.entry-footer div h6.meta_label,
		.comments-title,
		.comment-reply-title,
		input[type=submit],
		.page-header .page-title,
		.page-footer .page-title{
			background-color: rgba(<?PHP echo $hex[0] . "," . $hex[1] . "," . $hex[2]; ?>, 0.8);
		}
		
		.page-footer .pagination,
		li.pingback div.comment-body,
		.comment-respond{
			background-color: <?PHP echo get_theme_mod("site_post_background_colour"); ?>;
		}
		
		.widget-title{
			color: <?PHP echo get_theme_mod("site_post_background_colour"); ?>;
		}
		
		#page #sidebar{
			background-color: <?PHP echo get_theme_mod("site_header_colour"); ?>;
		}
		
	</style><?PHP

}
add_action("wp_head", "simulacra_extra_style");

function simulacra_excerpt_more( $excerpt ) {
	$parts = explode(" ", $excerpt);
	array_pop($parts);
	$replace ='<a href="' . get_post_permalink() . '">' . _x("read more", "read more", "simulacra") . "</a>";
	return implode(" ", $parts) . "... " . $replace;
}
add_filter( 'excerpt_more', 'simulacra_excerpt_more' );

function simulacra_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'simulacra_excerpt_length', 999 );

function simulacra_init(){

	if(!get_option("simulacra_setup")){
	
		set_theme_mod('header_text','text_centre');
		set_theme_mod('site_allsite_background_colour','#fefefe');
		set_theme_mod('site_allsite_colour','#ffffff');
		set_theme_mod('site_footer_colour','#ffffff');
		set_theme_mod('site_footer_background_colour','#000000');
		set_theme_mod('site_menu_text_colour','#0a0a0a');
		set_theme_mod('site_menu_text_hover_colour','#ff0044');
		set_theme_mod('site_menu_background_hover_colour','#d1d1d1');
		set_theme_mod('site_header_colour','#000000');
		set_theme_mod('site_menu_background_colour','#ffffff');
		set_theme_mod('site_menu_background_current_colour','#ededed');
		set_theme_mod('site_alllink_colour','#06007f');
		set_theme_mod('site_alllink_hover_colour','#ff0044');
		set_theme_mod('site_content_background_colour','#888888');
		set_theme_mod('site_angle_colour','#000000');
		set_theme_mod('menu_type','menu_standard');
		set_theme_mod('home_page','all_posts');
		set_theme_mod('site_title_colour','#b50c00');
		set_theme_mod('pagination','on');
		set_theme_mod('search','on');
		set_theme_mod('site_post_background_colour','#0a0000');
		
		add_option("simulacra_setup", 1);
	
	}

}
add_action("init", "simulacra_init");

function simulacra_featured_category_create(){

	if(!get_option("simulacra_featured")){

		$id = wp_create_category(_x("Featured Content", "Featured Content", "simulacra"));
		add_option("simulacra_featured", $id);
	
	}
		
}
add_action("admin_head", "simulacra_featured_category_create");

require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/menus/Walker_Menu.php';
require get_template_directory() . '/inc/menus/Walker_Menu_Slide.php';
