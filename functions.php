<?php

/* ------------------------------------------------------------------------------------
 * ... Wordpress Theme
 * ------------------------------------------------------------------------------------*/


/* ------------------------------------------------------------------------------------
 * Load Theme Translation Domain
 * ------------------------------------------------------------------------------------*/
load_theme_textdomain('framework', TEMPLATEPATH . '/languages');


/* ------------------------------------------------------------------------------------
 * Define PHP file constants.
 * ------------------------------------------------------------------------------------*/
$theme_data = get_theme( get_current_theme() );

define( 'GS_DIR', TEMPLATEPATH );
define( 'GS_LIB', GS_DIR . '/includes' );
define( 'THEME_VERSION', $theme_data['Version'] );


/* ------------------------------------------------------------------------------------
 * Cleaning up the Wordpress Head
 * ------------------------------------------------------------------------------------*/
function gs_theme_head_cleanup() {
  remove_action( 'wp_head', 'feed_links_extra', 3 );                    // Category Feeds
  //remove_action( 'wp_head', 'feed_links', 2 );                        // Post and Comment Feeds
  remove_action( 'wp_head', 'rsd_link' );                               // EditURI link
  remove_action( 'wp_head', 'wlwmanifest_link' );                       // Windows Live Writer
  remove_action( 'wp_head', 'index_rel_link' );                         // index link
  remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );            // previous link
  remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );             // start link
  remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); // Links for Adjacent Posts
  remove_action( 'wp_head', 'wp_generator' );                           // WP version
}
add_action('init', 'gs_theme_head_cleanup');


/* ------------------------------------------------------------------------------------
 * Remove Admin Bar
 * ------------------------------------------------------------------------------------*/
add_filter( 'show_admin_bar', '__return_false' );


/* ------------------------------------------------------------------------------------
 * Configure WP Functions & Theme Support
 * ------------------------------------------------------------------------------------*/
function gs_theme_support() {

  if ( function_exists( 'add_theme_support' ) ) {

    //Adding Post-Thumbnail Support
    add_theme_support('post-thumbnails');                   
    set_post_thumbnail_size(50, 50, true); //Normal post thumbnails
    /* include more thumbnail sizes
    ... */ 

    //Post Formats supported
    add_theme_support( 'post-formats', // post formats
      array(
        'aside', // title less blurb
        'gallery', // gallery of images
        'link', // quick link to other site
        'image', // an image
        'quote', // a quick quote
        'video', // video
        'audio', // audio
      )
    ); 

    //Custom Menu
    add_theme_support( 'menus' ); // wp menus
    register_nav_menus(
      array(
        'main_nav' => 'The Main Menu', // main nav in header
        'footer_links' => 'Footer Links' //secondary nav in footer
      ));
    
    //Posts & Comments Rss
    add_theme_support( 'automatic-feed-links' ); // rss

  }

  // Max Content Width
  if ( ! isset( $content_width ) )
    $content_width = 640;

}
add_action('after_setup_theme', 'gs_theme_support');


/* ------------------------------------------------------------------------------------
 * Configure excerpt string
 * ------------------------------------------------------------------------------------*/
function gs_excerpt_more($excerpt) {
	return str_replace('[...]', '...', $excerpt);
}
add_filter('wp_trim_excerpt', 'gs_excerpt_more');


/* ------------------------------------------------------------------------------------
 * Register and load common js 
 * ------------------------------------------------------------------------------------*/
function gs_theme_enqueue_script() {
  if ( !is_admin() ) { 
    $theme  = get_theme( get_current_theme() );
    wp_deregister_script( 'jquery' );
    wp_register_script( 'modernizr', get_template_directory_uri() . '/js/libs/modernizr-2.0.6.min.js', false );
    wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js', false, '1.6', TRUE);
    wp_register_script( 'theme-plugin-js', get_template_directory_uri() . '/js/plugin.js', 'jquery', THEME_VERSION, TRUE);
    wp_register_script( 'theme-script-js', get_template_directory_uri() . '/js/script.js', 'jquery', THEME_VERSION, TRUE);

    wp_enqueue_script( 'modernizr' );
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'theme-plugin-js');
    wp_enqueue_script( 'theme-script-js');

    // declare the URL to the file that handles the AJAX request (wp-admin/admin-ajax.php)
    wp_localize_script( 'theme-script-js', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
  }
}    
add_action('wp_enqueue_scripts', 'gs_theme_enqueue_script');


/* ------------------------------------------------------------------------------------
 * Register and load styles
 * ------------------------------------------------------------------------------------*/
function gs_theme_enqueue_stylesheet() {
  if ( !is_admin() ) { 
      $theme  = get_theme( get_current_theme() );
      wp_register_style( 'normalize', get_bloginfo( 'stylesheet_directory' ) . '/css/normalize.css', false );
      wp_register_style( 'less-framework', get_bloginfo( 'stylesheet_directory' ) . '/css/lessframework.css', false, 4 );
      wp_register_style( 'theme-styles', get_bloginfo( 'stylesheet_directory' ) . '/css/theme.css', false, THEME_VERSION );

      wp_enqueue_style( 'normalize' );
      wp_enqueue_style( 'less-framework' );
      wp_enqueue_style( 'theme-styles' );
  }
}
add_action('wp_print_styles', 'gs_theme_enqueue_stylesheet');


/* ------------------------------------------------------------------------------------
 * Register and load scripts for single pages
 * ------------------------------------------------------------------------------------*/
function gs_theme_single_scripts() {
  if(is_singular()) {
		wp_enqueue_script( 'comment-reply' );
  } 
}
add_action( 'wp_print_styles', 'gs_theme_single_scripts' );
	

/* ------------------------------------------------------------------------------------
 * Register Widgets 
 * ------------------------------------------------------------------------------------*/
function gs_theme_register_sidebars() {
  if ( function_exists('register_sidebar') ) {

    register_sidebar(array(
      'name' => 'Main Sidebar',
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget' => '</div>',
      'before_title' => '<h3 class="widget-title">',
      'after_title' => '</h3>'
    ));
  
  }
}
add_action( 'widgets_init', 'gs_theme_register_sidebars' );


/*-----------------------------------------------------------------------------------*/
/*	Custom Login Logo 
/*-----------------------------------------------------------------------------------*/
function gs_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_template_directory_uri().'/images/custom-login-logo.png) !important; }
    </style>';
}
function gs_login_title() {
echo get_option('blogname');
}
//add_action('login_head', 'gs_login_logo');
add_filter('login_headertitle', 'gs_login_title');


/* ------------------------------------------------------------------------------------
 * Load libary files.
 * ------------------------------------------------------------------------------------*/
require_once GS_LIB . '/ajax.php';
require_once GS_LIB . '/template.php';

?>
