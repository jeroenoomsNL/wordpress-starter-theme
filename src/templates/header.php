<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div class="site">

    <!--[if lt IE 10]>
        <div class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and your life.</div>
    <![endif]-->
	
	<header class="site-header" role="banner">
		<div class="site-header-content">
			<div class="site-branding">
				<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php
				$description = get_bloginfo( 'description', 'display' );
				if ( $description ) : ?>
					<p class="site-description"><?php echo $description; ?></p>
				<?php endif;?>
			</div>

			<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<nav class="site-navigation" id="toggleMenu" role="navigation">
				<?php
					// Primary navigation menu.
					wp_nav_menu( array(
						'menu_class'     => 'nav-menu',
						'theme_location' => 'primary',
						'container'		 => ''
					) );
				?>
			</nav>
			<button class="navigation-toggle" id="toggleButton"><?php _e( 'Menu and widgets', 'startertheme' ); ?></button>
			<?php endif; ?>
		</div>
	</header>
	
	<div class="site-content">
