<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<?PHP
	get_template_part( 'parts/header/main');
?>
<body <?php body_class(simulacra_body_class()); ?>>
<div id="page" class="hfeed site">
	<?PHP
		switch(get_theme_mod('header_text')){
			case 'text_centre' : get_template_part( 'parts/header/text_centre'); break;
			case 'text_left' : get_template_part( 'parts/header/text_left'); break;
			case 'text_outside_centre' : get_template_part( 'parts/header/text_outside_centre'); break;
			case 'text_outside_left' : get_template_part( 'parts/header/text_outside_left'); break;
			default : get_template_part( 'parts/header/text_centre');  break;
		}
		
		switch(get_theme_mod('menu_type')){
			case 'menu_standard' : get_template_part( 'parts/header/menu/standard'); break;
			case 'menu_slide' : get_template_part( 'parts/header/menu/slide'); break;
			default : get_template_part( 'parts/header/menu/standard');  break;
		}
		
		get_template_part( 'parts/search-form/standard');
		
		?></nav>
	<div id="content" class="site-content">
