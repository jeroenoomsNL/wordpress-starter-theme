<?php if ( has_nav_menu( 'social' ) || is_active_sidebar( 'sidebar-1' )  ) : ?>
<div class="sidebar">

		<?php if ( has_nav_menu( 'social' ) ) : ?>
			<nav class="social-navigation" role="navigation">
				<?php
					// Social links navigation menu.
					wp_nav_menu( array(
						'theme_location' => 'social',
						'depth'          => 1,
						'link_before'    => '<span class="screen-reader-text">',
						'link_after'     => '</span>',
					) );
				?>
			</nav>
		<?php endif; ?>

		<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
			<div class="widget-area" role="complementary">
				<?php dynamic_sidebar( 'sidebar-1' ); ?>
			</div>
		<?php endif; ?>

</div>
<?php endif; ?>
