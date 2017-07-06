<?php
/**
 * Alizee functions and definitions
 *
 * @package Alizee
 */


if ( ! function_exists( 'alizee_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function alizee_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Alizee, use a find and replace
	 * to change 'alizee' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'alizee', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Set the content width based on the theme's design and stylesheet.
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 640; /* pixels */
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('alizee-thumb', 750);

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'alizee' ),
		'social' => __( 'Social', 'alizee' ),
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
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link'
	) );

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'alizee_custom_background_args', array(
		'default-color' => 'faf4f4',
		'default-image' => '',
	) ) );
}
endif; // alizee_setup
add_action( 'after_setup_theme', 'alizee_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function alizee_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'alizee' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer A', 'alizee' ),
		'id'            => 'sidebar-3',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer B', 'alizee' ),
		'id'            => 'sidebar-4',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	register_sidebar( array(
		'name'          => __( 'Footer C', 'alizee' ),
		'id'            => 'sidebar-5',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );	
	
	//Register the custom widgets
	register_widget( 'Alizee_Recent_Posts' );
	register_widget( 'Alizee_Recent_Comments' );
	register_widget( 'Alizee_Social_Profile' );
	register_widget( 'Alizee_Video_Widget' );	
}
add_action( 'widgets_init', 'alizee_widgets_init' );

/**
 * Load the custom widgets.
 */
require get_template_directory() . "/widgets/recent-posts.php";
require get_template_directory() . "/widgets/recent-comments.php";
require get_template_directory() . "/widgets/social-profile.php";
require get_template_directory() . "/widgets/video-widget.php";

/**
 * Enqueue scripts and styles.
 */
function alizee_scripts() {

	wp_enqueue_style( 'alizee-bootstrap', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), true );

	wp_enqueue_style( 'alizee-style', get_stylesheet_uri() );
	
	wp_enqueue_style( 'alizee-font-awesome', get_template_directory_uri() . '/fonts/font-awesome.min.css' );	
	
	//Load the fonts
	$headings_font = esc_html(get_theme_mod('headings_fonts'));
	$body_font = esc_html(get_theme_mod('body_fonts'));
	if( $headings_font ) {
		wp_enqueue_style( 'alizee-headings-fonts', '//fonts.googleapis.com/css?family='. $headings_font );	
	} else {
		wp_enqueue_style( 'alizee-headings-fonts', '//fonts.googleapis.com/css?family=Open+Sans+Condensed:700');
	}	
	if( $body_font ) {
		wp_enqueue_style( 'alizee-body-fonts', '//fonts.googleapis.com/css?family='. $body_font );	
	} else {
		wp_enqueue_style( 'alizee-body-fonts', '//fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700');
	}

	//Loads the necessary stylesheet for the home page
	if ( get_theme_mod('home_layout') == 'one_col' )  {
		wp_enqueue_style( 'alizee-one-col', get_template_directory_uri() . '/layouts/one-col.css' );
	} elseif ( get_theme_mod('home_layout') == 'two_col' )  {
		wp_enqueue_style( 'alizee-two-col', get_template_directory_uri() . '/layouts/two-col.css' );
	} elseif ( get_theme_mod('home_layout') == 'four_col' )  {
		wp_enqueue_style( 'alizee-two-col', get_template_directory_uri() . '/layouts/four-col.css' );
	}

	//Only loads the Masonry and imagesloaded scripts if the user selection for the home layout is different than one column
	if ( is_home() && get_theme_mod('home_layout') != 'one_col' )  {
		wp_enqueue_script( 'jquery-masonry' );

		wp_enqueue_script( 'alizee-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), true );

		wp_enqueue_script( 'alizee-masonry-init', get_template_directory_uri() . '/js/masonry-init.js', array('jquery'), true );
	}
		
	wp_enqueue_script( 'alizee-scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), true );

	wp_enqueue_script( 'alizee-fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', array('jquery'), true );

	if ( get_theme_mod('alizee_scroller') != 1 )  {
		
		wp_enqueue_script( 'alizee-nicescroll', get_template_directory_uri() . '/js/jquery.nicescroll.min.js', array('jquery'), true );	

		wp_enqueue_script( 'alizee-nicescroll-init', get_template_directory_uri() . '/js/nicescroll-init.js', array('jquery'), true );

	}
	
	wp_enqueue_script( 'alizee-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'alizee-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'alizee_scripts' );

/**
 * Change the excerpt length
 */
function alizee_excerpt_length( $length ) {
	if ( get_theme_mod('home_layout') != 'one_col' )  {
		return 30;
	} else {
		return 55;
	}
}
add_filter( 'excerpt_length', 'alizee_excerpt_length', 999 );

/**
 * Adds more contact methods in the User profile screen (links used for the author bio).
 */
function alizee_contactmethods( $contactmethods ) {
	
	$contactmethods['alizee_facebook'] = __( 'Author Bio: Facebook', 'alizee' );
	$contactmethods['alizee_twitter'] = __( 'Author Bio: Twitter', 'alizee' );	
	$contactmethods['alizee_googleplus'] = __( 'Author Bio: Google Plus', 'alizee' );
	$contactmethods['alizee_linkedin'] = __( 'Author Bio: Linkedin', 'alizee' );
	
	return $contactmethods;
}
add_filter( 'user_contactmethods', 'alizee_contactmethods', 10, 1);

/**
 * Load html5shiv
 */
function alizee_html5shiv() {
    echo '<!--[if lt IE 9]>' . "\n";
    echo '<script src="' . esc_url( get_template_directory_uri() . '/js/html5shiv.js' ) . '"></script>' . "\n";
    echo '<![endif]-->' . "\n";
}
add_action( 'wp_head', 'alizee_html5shiv' ); 

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
/**
 * Dynamic styles
 */
require get_template_directory() . '/styles.php';