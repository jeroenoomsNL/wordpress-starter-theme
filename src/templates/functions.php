<?php

if ( ! function_exists( 'startertheme_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function startertheme_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on startertheme, use a find and replace
	 * to change 'startertheme' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'startertheme', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 900, 350, true );

	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu',      'startertheme' ),
		'social'  => __( 'Social Links Menu', 'startertheme' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
	) );

	/*
	 * Enable support for Post Formats.
	 *
	 * See: https://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
	) );
}
endif;
add_action( 'after_setup_theme', 'startertheme_setup' );

/**
 * Register widget area
 */
function startertheme_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Widget Area', 'startertheme' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Add widgets here to appear in your sidebar.', 'startertheme' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'startertheme_widgets_init' );

if ( ! function_exists( 'startertheme_fonts_url' ) ) :
/**
 * Register Google fonts for theme
 */
function startertheme_fonts_url() {
	$fonts_url = '';
	$fonts     = array();
	$subsets   = 'latin,latin-ext';

	$fonts[] = 'Open Sans:400italic,700italic,400,700';
	$fonts[] = 'Droid Serif:400italic,700italic,400,700';
	
	if ( $fonts ) {
		$fonts_url = add_query_arg( array(
			'family' => urlencode( implode( '|', $fonts ) ),
			'subset' => urlencode( $subsets ),
		), 'https://fonts.googleapis.com/css' );
	}

	return $fonts_url;
}
endif;

/**
 * Enqueue scripts and styles
 */
function startertheme_scripts() {
	// Add custom fonts, used in the main stylesheet
	wp_enqueue_style( 'startertheme-fonts', startertheme_fonts_url(), array(), null );

	// Load our main stylesheet
	wp_enqueue_style( 'startertheme-style', get_stylesheet_uri() );

	// Load Font Awesome 
	wp_enqueue_style( 'fontawesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), null );

	// Load our scripts
	wp_enqueue_script( 'startertheme-script', get_template_directory_uri() . '/scripts/scripts.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'startertheme_scripts' );

/**
 * Disable emoji support
 */
function disable_wp_emojicons() {

  // all actions related to emojis
  remove_action( 'admin_print_styles', 'print_emoji_styles' );
  remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
  remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
  remove_action( 'wp_print_styles', 'print_emoji_styles' );
  remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
  remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
  remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

  // filter to remove TinyMCE emojis
  add_filter( 'tiny_mce_plugins', 'disable_emojicons_tinymce' );
}
add_action( 'init', 'disable_wp_emojicons' );

function disable_emojicons_tinymce( $plugins ) {
  if ( is_array( $plugins ) ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
  } else {
    return array();
  }
}


/**
 * Remove useless classes from post article tag
 */
function remove_useless_classed($classes) {
    $matched_classes = preg_grep("/^(tag-|category-|post_format-).*/", $classes);

    foreach($matched_classes as $match_value) {
    	foreach($classes as $key => $class_value) {
    		if($match_value == $class_value) {
    			unset( $classes[ $key ] );
    		}
    	}
    }
 
    return $classes;
}
add_filter('post_class','remove_useless_classed');

