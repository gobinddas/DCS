<?php

/**
 * Code Plumbing functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package codecrewz_DCS
 */
if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function codecrewz_DCS_setup()
{
    /*
  * Make theme available for translation.
  * Translations can be filed in the /languages/ directory.
  * If you're building a theme based on Code Plumbing, use a find and replace
  * to change 'codecrewz_DCS' to the name of your theme in all the template files.
  */
    load_theme_textdomain('codecrewz_DCS', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
  * Let WordPress manage the document title.
  * By adding theme support, we declare that this theme does not use a
  * hard-coded <title> tag in the document head, and expect WordPress to
  * provide it for us.
  */
    add_theme_support('title-tag');

    /*
  * Enable support for Post Thumbnails on posts and pages.
  *
  * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
  */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Primary', 'codecrewz_DCS'),
        )
    );

    /*
  * Switch default core markup for search form, comment form, and comments
  * to output valid HTML5.
  */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'codecrewz_DCS_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}

add_action('after_setup_theme', 'codecrewz_DCS_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function codecrewz_DCS_content_width()
{
    $GLOBALS['content_width'] = apply_filters('codecrewz_DCS_content_width', 640);
}

add_action('after_setup_theme', 'codecrewz_DCS_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function codecrewz_DCS_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'codecrewz_DCS'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'codecrewz_DCS'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'codecrewz_DCS_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function codecrewz_DCS_scripts()
{
    wp_register_style('bootstrap', 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css');
    wp_register_style('font-awesome', 'https://use.fontawesome.com/releases/v6.3.0/css/all.css');
    wp_register_style('animate', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');
    wp_register_style('slick', '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css');
    wp_register_style('magnific', 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css');
    wp_register_style('simple-line-icons', 'https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.5.5/css/simple-line-icons.min.css');
    // wp_register_style( '', '' );
    wp_enqueue_style('codecrewz_DCS-style', get_stylesheet_uri(), ['font-awesome', 'bootstrap',  'magnific', 'slick', 'simple-line-icons'], _S_VERSION);
    wp_style_add_data('codecrewz_DCS-style', 'rtl', 'replace');

    wp_enqueue_script('codecrewz_DCS-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_register_script("bootstrap", 'https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js', ['jquery'], _S_VERSION, true);
    wp_register_script("slick", '//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js', ['jquery'], _S_VERSION, true);
    wp_register_script("magnific", 'https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js', ['jquery'], _S_VERSION, true);
    wp_enqueue_script('codecrewz_DCS-main', get_template_directory_uri() . '/js/main.js', array('jquery', 'bootstrap', 'slick', 'magnific'), _S_VERSION, true);
    if (is_front_page()) {
    }

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'codecrewz_DCS_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 *  Codecrewz Plugins.
 */
require get_template_directory() . '/inc/codecrewz.php';

/**
 *  Recommended Plugins.
 */
require get_template_directory() . '/tgm/example.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

require_once get_template_directory() . '/inc/custom_functions.php';


// for($i=2;$i<10;$i++){
//   // Prepare post data
//   $post_data = array(
//     'post_title' => "Gallery $i",
//     'post_content' => '',
//     'post_status' => 'publish',
//     'post_type' => 'post'
//   );

//   // Insert the post into the database
//   $post_id = wp_insert_post($post_data);
//   if (!is_wp_error($post_id)) {
//     // Set the featured image for the post
//     $image_url = "https://hawpainting.com.au/wp-content/uploads/2023/02/gallery$i.jpg";
//     $image_id = attachment_url_to_postid($image_url);
//     set_post_thumbnail($post_id, $image_id);
//   }
  
// }