<?php

if ( ! function_exists( 'ngsand_setup' ) ) :

    function ngsand_setup() {
        /**
         * Enable theme support features
         *
         * @link https://developer.wordpress.org/reference/functions/add_theme_support/
         */
        add_theme_support( 'title-tag' );

        add_theme_support( 'custom-header' );

        add_theme_support( 'post-thumbnails' );

        add_theme_support( 'custom-background' );

        // add_theme_support( 'post-formats', array(
        //  'aside', 'image', 'video', 'quote', 'link', 'gallery',
        // ) );

        /**
         * Register navigation menus
         *
         * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
         */
        register_nav_menus( array( 'main-menu' => 'Main Nav', 'footer-menu' => 'Footer Nav' ) );

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support( 'html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ) );

    } // end setup function
endif;
add_action( 'after_setup_theme', 'ngsand_setup' );

/**
 * Enqueue scripts and styles.
 */
function ngsand_scripts() {
    wp_enqueue_script( 'ngacustom', get_bloginfo('template_url') . '/js/custom.js', 'jquery', '1.0', true );
    wp_enqueue_script( 'ngavideo', 'http://code.jquery.com/jquery-1.11.3.min.js');
    wp_enqueue_style( 'ngsand_main', get_bloginfo('template_url') . '/main.css', array('bootstrap'), false );
    wp_enqueue_style( 'fontawesome', get_bloginfo('template_url') . '/css/font-awesome.min.css' );
    wp_enqueue_style( 'Lara', 'https://fonts.googleapis.com/css?family=Lora' );
    wp_enqueue_style( 'Roboto', 'https://fonts.googleapis.com/css?family=Roboto:300,400,400i,700,900' );
    wp_enqueue_style( 'RobotoCondensed', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,400,400i,700,900' );
    wp_enqueue_style( 'OpenSans', 'https://fonts.googleapis.com/css?family=Open+Sans' );
}
add_action( 'wp_enqueue_scripts', 'ngsand_scripts' );

/*
 * Widgets
 */
function ngwidgets_init() {

  register_sidebar( array(
    'name'          => 'Blog Sidebar',
    'id'            => 'blog_sidebar',
    'before_widget' => '<div>',
    'after_widget'  => '</div>',
  ) );

}
add_action( 'widgets_init', 'ngwidgets_init' );


function create_cpt_carousel() {

    register_post_type( 'carousel',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Carousel' ),
                'singular_name' => __( 'Carousel' )
            ),
            'supports' => array( 'title', 'editor', 'page-attributes' ),
            'public' => true,
            'publicly_queryable' => true,
            'show_ui' => true,
            'exclude_from_search' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'carousel', 'with_front' => false ),
            'capability_type' => 'post',
            'has_archive' => true,
            'hierarchical' => false,
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_cpt_carousel' );





// Changing excerpt length
function new_excerpt_length($length) {
return 90;
}
add_filter('excerpt_length', 'new_excerpt_length');

// Changing excerpt more
function new_excerpt_more($more) {
return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');



/*
* Utility Function
*
* Mainly used to get the post id of a page outside of the loop in a page template
 */
function get_the_post_id() {
  if (in_the_loop()) {
       $post_id = get_the_ID();
  } else {
       global $wp_query;
       $post_id = $wp_query->get_queried_object_id();
         }
  return $post_id;
}

include(STYLESHEETPATH.'/admin/custom_shortcodes.php');
include(TEMPLATEPATH.'/admin/post_types/testimonials/index.php');
include(TEMPLATEPATH.'/admin/post_types/our_team/index.php');
include(TEMPLATEPATH.'/admin/post_types/our_promotions/index.php');
include(TEMPLATEPATH.'/admin/post_types/slider/index.php');
