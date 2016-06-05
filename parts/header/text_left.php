<div id="sidebar" class="sidebar sidebar-left">
	<header id="masthead" class="site-header" role="banner" <?PHP simulacra_header_image(); ?>>
		<div class="site-branding">
			<?php
				if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?PHP echo get_bloginfo('name'); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?PHP echo get_bloginfo('name'); ?></a></p>
				<?php endif;
			?>
		</div><!-- .site-branding -->
	</header><!-- .site-header -->
</div><!-- .sidebar -->