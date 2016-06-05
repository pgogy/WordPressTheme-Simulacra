<?php

function simulacra_customize_register_modify( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
	
	$wp_customize->get_section( 'header_image' )->title = __( 'Site Image', 'simulacra' );
	$wp_customize->remove_section( 'colors' );
	
}

function simulacra_customize_register_home_page_layout( $wp_customize ){

	$wp_customize->add_section( 'home_page_layout' , array(
		'title'      => __( 'Home Page', 'simulacra' ),
		'priority'   => 2,
	) );

	$wp_customize->add_setting(
		'home_page',
		array(
			'default' => 'all_posts',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	 
	$wp_customize->add_control(
		'home_page',
		array(
			'type' => 'radio',
			'label' => 'Home page layout',
			'section' => 'home_page_layout',
			'choices' => array(
				'all_posts' => 'All Posts',
				'all_categories' => 'All Categories',			
				'featured_posts' => 'Featured Posts',			
				'featured_c' => 'Selected Categories (see below)',
				'featured_c_and_p' => 'Selected Categories (see below) and featured posts',		
				'featured_p_and_c' => 'Selected Categories (see below) and featured posts',		
			),
		)
	);
	
	$post_categories = get_categories( array('exclude' => get_option("simulacra_featured"), 'hide_empty' => 0) );
	
	foreach($post_categories as $c){
	
		$cat = get_category( $c );
				
		$wp_customize->add_setting(
			'category_' . $c->term_id,
			array(
				'default' => 'on',
				'sanitize_callback' => 'simulacra_sanitize_text'
			)
		);
		 
		$wp_customize->add_control(
			'category_' . $c->term_id,
			array(
				'type' => 'radio',
				'label' => 'Display Category - ' . $cat->name,
				'section' => 'home_page_layout',
				'choices' => array(
					"on" => "Display",
					"off" => "Don't display"
				),
			)
		);

	}
	
}

function simulacra_customize_register_page_layout( $wp_customize ){

	$wp_customize->add_section( 'page_layout' , array(
		'title'      => __( 'Page Layout', 'simulacra' ),
		'priority'   => 2,
	) );

	$wp_customize->add_setting(
		'header_text',
		array(
			'default' => 'text_centre',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	 
	$wp_customize->add_control(
		'header_text',
		array(
			'type' => 'radio',
			'label' => 'Header layout',
			'section' => 'page_layout',
			'choices' => array(
				'text_centre' => 'Text Centred',
				'text_left' => 'Text Left',
				'text_outside_centre' => 'Text outside the angled area but centred',
				'text_outside_left' => 'Text outside the angled area but left align'			
			),
		)
	);
	
	$wp_customize->add_setting(
		'menu_type',
		array(
			'default' => 'menu_standard',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	 
	$wp_customize->add_control(
		'menu_type',
		array(
			'type' => 'radio',
			'label' => 'Menu Type',
			'section' => 'page_layout',
			'choices' => array(
				'menu_standard' => 'Menu standard drop down',
				'menu_slide' => 'Menu slides in from left'		
			),
		)
	);
	
	$wp_customize->add_setting(
		'pagination',
		array(
			'default' => 'on',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	 
	$wp_customize->add_control(
		'pagination',
		array(
			'type' => 'radio',
			'label' => 'Display pagination',
			'section' => 'page_layout',
			'choices' => array(
				'on' => 'On',
				'off' => 'Off'		
			),
		)
	);
	
	$wp_customize->add_setting(
		'search',
		array(
			'default' => 'on',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	 
	$wp_customize->add_control(
		'search',
		array(
			'type' => 'radio',
			'label' => 'Display Search',
			'section' => 'page_layout',
			'choices' => array(
				'on' => 'On',
				'off' => 'Off'		
			),
		)
	);
	
}

function simulacra_customize_register_fav_icon( $wp_customize ){
	
	$wp_customize->add_section( 'fav_icon' , array(
		'title'      => __( 'Fav Icon', 'simulacra' ),
		'priority'   => 2,
	) );

	$wp_customize->add_setting(
		'fav_icon_url',
		array(
			'sanitize_callback' => 'simulacra_sanitize_text'
		)	
	);
	 
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'fav_icon_url',
			array(
				'label' => 'Fav Icon',
				'section' => 'fav_icon',
				'settings' => 'fav_icon_url'
			)
		)
	);
	
}

function simulacra_customize_register_add_site_colours( $wp_customize ) {
	
	$wp_customize->add_section( 'site_colours' , array(
		'title'      => __( 'Site Colours', 'simulacra' ),
		'priority'   => 30,
	) );
	
	$wp_customize->add_setting(
		'site_allsite_background_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_allsite_background_colour',
			array(
				'label' => 'Site background colour',
				'section' => 'site_colours',
				'settings' => 'site_allsite_background_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_alllink_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_alllink_colour',
			array(
				'label' => 'Site Link Colour',
				'section' => 'site_colours',
				'settings' => 'site_alllink_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_alllink_hover_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_setting(
		'site_post_background_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_post_background_colour',
			array(
				'label' => 'Site Post Background Colour',
				'section' => 'site_colours',
				'settings' => 'site_post_background_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_content_background_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_content_background_colour',
			array(
				'label' => 'Site Content Background Colour',
				'section' => 'site_colours',
				'settings' => 'site_content_background_colour'
			)
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_alllink_hover_colour',
			array(
				'label' => 'Site Link hover Colour',
				'section' => 'site_colours',
				'settings' => 'site_alllink_hover_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_alltext_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_alltext_colour',
			array(
				'label' => 'Site Text Colour',
				'section' => 'site_colours',
				'settings' => 'site_alltext_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_footer_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_footer_colour',
			array(
				'label' => 'Site Footer Text Colour',
				'section' => 'site_colours',
				'settings' => 'site_footer_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_menu_background_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_menu_background_colour',
			array(
				'label' => 'Site Menu Background Colour',
				'section' => 'site_colours',
				'settings' => 'site_menu_background_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_menu_background_hover_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_menu_background_hover_colour',
			array(
				'label' => 'Site Menu Background Hover Colour',
				'section' => 'site_colours',
				'settings' => 'site_menu_background_hover_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_menu_background_current_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_menu_background_current_colour',
			array(
				'label' => 'Site Menu Current Page Colour',
				'section' => 'site_colours',
				'settings' => 'site_menu_background_current_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_menu_text_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_menu_text_colour',
			array(
				'label' => 'Site Menu Text Colour',
				'section' => 'site_colours',
				'settings' => 'site_menu_text_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_menu_text_hover_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_menu_text_hover_colour',
			array(
				'label' => 'Site Menu Text Hover Colour',
				'section' => 'site_colours',
				'settings' => 'site_menu_text_hover_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_header_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_header_colour',
			array(
				'label' => 'Site Header Background Colour',
				'section' => 'site_colours',
				'settings' => 'site_header_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_header_text_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_header_text_colour',
			array(
				'label' => 'Site Header Text Colour',
				'section' => 'site_colours',
				'settings' => 'site_header_text_colour'
			)
		)
	);
	
	$wp_customize->add_setting(
		'site_title_colour',
		array(
			'default' => '',
			'transport' => 'postMessage',
			'sanitize_callback' => 'simulacra_sanitize_text'
		)
	);
	
	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'site_title_colour',
			array(
				'label' => 'Site Title Colour',
				'section' => 'site_colours',
				'settings' => 'site_title_colour'
			)
		)
	);
	
}

function simulacra_sanitize_text($str){
	return sanitize_text_field($str);
}

function simulacra_customize_register( $wp_customize ) {

	simulacra_customize_register_modify( $wp_customize );
	simulacra_customize_register_add_site_colours( $wp_customize );
	simulacra_customize_register_page_layout( $wp_customize );
	simulacra_customize_register_home_page_layout( $wp_customize );
	simulacra_customize_register_fav_icon( $wp_customize );
	
}
add_action( 'customize_register', 'simulacra_customize_register' );


function simulacra_customize_preview_js() {
	wp_enqueue_script( 'simulacra_customizer', get_template_directory_uri() . '/js/simulacra_customiser.js', array( 'customize-preview' ), '20131205', true );
}
add_action( 'customize_preview_init', 'simulacra_customize_preview_js' );

