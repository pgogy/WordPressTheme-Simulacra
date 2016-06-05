<nav id="primary-navigation" class="site-navigation nav-menu-slide" role="navigation">
	<?php
	
		if ( has_nav_menu( "primary" ) ) {
		
			wp_nav_menu( 
					array( 
						'theme_location' => 'primary', 
						'menu_class' => 'nav-menu-slide',
						'walker' => new Walker_Menu_Slide(),
					)
				);
				
		}else{
		
			?><div style="height:30px"></div><?PHP
		
		}
	?>