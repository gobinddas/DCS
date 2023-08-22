<?php //Custom Functions
require_once 'wp-bootstrap-navwalker.php';
require_once 'Multi_Image_Custom_Control.php';

// require_once('WP_Customize_Schedule_Fields_Control.php');
// Bootstrap navigation
function bootstrap_nav($location = 'Main', $class = 'navbar-nav')
{
  wp_nav_menu(array(
    'theme_location' => $location,
    'depth' => 2,
    'container' => 'false',
    'menu_class' => $class,
    'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
    'walker' => new WP_Bootstrap_Navwalker()
  ));
}

function register_header_menu()
{
  register_nav_menus(array(
    'Main' => __('Main Menu', 'codecrewz_DCS'),
    'quick menu' => __('Quick Menu', 'codecrewz_DCS'),
    'footer Menu' => __('Footer Menu', 'codecrewz_DCS'),
    'Login Menu' => __('Login Menu', 'codecrewz_DCS'),
  ));
}

add_action('init', 'register_header_menu');

function add_setting($wp_customize, $args)
{
  $wp_customize->add_setting(
    $args['id'],
    array(
      'default' => empty($args['default']) ? '' : $args['default'],
      'type' => 'theme_mod', // you can also use 'theme_mod'
      'capability' => 'edit_theme_options',
      'transport' => empty($args['transport']) ? 'postMessage' : $args['transport'],
    ),
  );
}

function add_field($wp_customize, $args)
{

  if (empty($args['id'])) {
    return;
  }

  $type = empty($args['input_type']) ? 'text' : $args['input_type'];
  add_setting($wp_customize, $args);
  $wp_customize->add_control(new WP_Customize_Control(
    $wp_customize,
    $args['id'],
    array(
      'label' => __(empty($args['label']) ? 'Unlabel' : $args['label'], 'codecrewz_DCS'),
      'priority' => empty($args['priority']) ? 9 : $args['priority'],
      'section' => empty($args['section']) ? 'title_tagline' : $args['section'],
      'type' => $type,
      'render_callback' => empty($args['render_callback']) ? null : $args['render_callback'],
    )
  ));
}

function edit_button($wp_customize, $args)
{
  $id = $args['id'];
  $wp_customize->selective_refresh->add_partial(
    $args['id'],
    array(
      'selector' => ".$id",
      'render_callback' => 'call_back',
      'render_callback_args' => $id,
    )
  );
}

function call_back($id)
{
  echo get_theme_mod($id);
}

function create_section($wp_customize, $args)
{
  if (empty($args['id'])) {
    return;
  }

  $wp_customize->add_section(
    $args['id'],
    array(
      'priority' => empty($args['priority']) ? 5 : $args['priority'],
      'capability' => 'edit_theme_options',
      'theme_supports' => '',
      'title' => __(empty($args['title']) ? 'Section ' : $args['title'], 'codecrewz_DCS'),
      'description' => empty($args['description']) ? '' : $args['description'],
      'panel' => empty($args['panel']) ? 'my_custom_home_page_customize' : $args['panel'],
    )
  );
}

function create_image_list($wp_customize, $args)
{
  if (empty($args['id'])) {
    return;
  }

  add_setting($wp_customize, $args);
  $wp_customize->add_control(new Multi_Image_Custom_Control(
    $wp_customize,
    $args['id'],
    array(
      'label' => __(empty($args['label']) ? 'Unlabel' : $args['label'], 'codecrewz_DCS'),
      'description' => __(empty($args['description']) ? '' : $args['description'], 'codecrewz_DCS'),
      'section' => empty($args['section']) ? 'title_tagline' : $args['section'],
      'settings' => $args['id'],
      'priority' => empty($args['priority']) ? 9 : $args['priority'],
      'height' => empty($args['height']) ? 900 : $args['height'],
      'width' => empty($args['width']) ? 1920 : $args['width'],
      'max' => empty($args['max']) ? 10 : $args['max'],
      'fit' => empty($args['fit']) ? 'contain' : $args['fit'],
    )
  ));
}

function create_image($wp_customize, $args)
{
  if (empty($args['id'])) {
    return;
  }

  $wp_customize->add_setting($args['id']);
  $wp_customize->add_control(new WP_Customize_Image_Control(
    $wp_customize,
    $args['id'],
    array(
      'label' => __(empty($args['label']) ? 'Unlabel' : $args['label'], 'codecrewz_DCS'),
      'section' => empty($args['section']) ? 'title_tagline' : $args['section'],
      'settings' => $args['id'],
      'priority' => empty($args['priority']) ? 9 : $args['priority'],
    )
  ));
}

function my_action_callback($arg1)
{
  if (empty($arg1)) {
    return;
  }

  printf("<script defer>
(function($) {
        const ids=[$arg1];

        ids.forEach(id=> {
            wp.customize(id, function(value) {
                value.bind(function(to) {
                    $('#'+id).text(to);
                  }

                );
              }

            );
          }

        )
      }

      (jQuery));
    </script>");
}

add_action('wp_head', 'my_action_callback', 10, 1);

function switch_case($wp_customize, $array)
{
  $ids = '';

  foreach ($array as $item) {
    switch ($item['type']) {
      case 'image':
        create_image($wp_customize, $item);
        break;
      case 'image_list':
        create_image_list($wp_customize, $item);
        break;
      case 'field':
        add_field($wp_customize, $item);
        break;
      case 'section':
        create_section($wp_customize, $item);
        break;
      default:
        break;
    }

    edit_button($wp_customize, $item);
    $ids .= '"' . $item['id'] . '",';
  }

  //  do_action( 'wp_head', "$ids" ) ;
}

function my_render_callback($id)
{
  wp_editor(get_theme_mod($id), $id, array(
    'textarea_name' => $id,
    'textarea_rows' => 5,
    'media_buttons' => true,
    'tinymce' => array(
      'plugins' => 'wordpress, wplink',
      'toolbar1' => 'bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv',
    ),
  ));
}

function my_register_additional_customizer_settings($wp_customize)
{

  // Page Setting Panel
  $wp_customize->add_panel('my_custom_home_page_customize', array(
    'priority' => 0,
    'capability' => 'edit_theme_options',
    'theme_supports' => '',
    'title' => __('Pages Setting', 'codecrewz_DCS'),
    'description' => __('Customize Pages', 'codecrewz_DCS'),
  ));

  $fields = [ // Site Idenity new fields

    ['type' => 'field', 'id' => 'phone', 'label' => 'Phone Number'],
    ['type' => 'field', 'id' => 'email', 'label' => 'Email Address', 'input_type' => 'email'],
    ['type' => 'field', 'id' => 'facebook', 'label' => 'Facebook URL', 'input_type' => 'url'],
    ['type' => 'field', 'id' => 'instagram', 'label' => 'Instagram URL', 'input_type' => 'url'],
    ['type' => 'field', 'id' => 'twitter', 'label' => 'Twitter URL', 'input_type' => 'url'],


    // Home Page Sesction and fields

    ['type' => 'section', 'id' => 'home_page', 'title' => 'Home Page', 'description' => 'Home Page Customize'],
    // banner
    ['type' => 'field', 'id' => 'banner_title', 'label' => 'Banner short Title', 'input_type' => 'textarea', 'section' => 'home_page'],
    ['type' => 'field', 'id' => 'banner_des', 'label' => 'Banner short Description', 'input_type' => 'textarea', 'section' => 'home_page'],
    ['type' => 'image', 'id' => 'banner_image', 'label' => ' banner image1', 'section' => 'home_page'],

    // about 
    ['type' => 'field', 'id' => 'about_heading', 'label' => 'About Heading ', 'input_type' => 'textarea', 'section' => 'home_page'],
    ['type' => 'field', 'id' => 'about_des', 'label' => 'About description  ', 'input_type' => 'textarea', 'section' => 'home_page'],

    // why 
    ['type' => 'image', 'id' => 'why_us', 'label' => ' Why section image', 'section' => 'home_page'],

    // step
    ['type' => 'image', 'id' => 'first_step', 'label' => ' first step bg img', 'section' => 'home_page'],

    // quote















    // //Get a About Us Page Setting Panel
    // ['type' => 'section', 'id' => 'about_page', 'title' => 'About Us Page', 'description' => 'About Us Customize'],

    // // singlepage about us 
    // ['type' => 'image', 'id' => 'innerpage_img1', 'label' => 'about us page image1', 'section' => 'about_page'],
    // ['type' => 'image', 'id' => 'innerpage_img2', 'label' => 'about us page image2', 'section' => 'about_page'],

    // ['type' => 'field', 'id' => 'inner_page_content1', 'label' => 'inner page content1 ', 'input_type' => 'textarea', 'section' => 'about_page'],
    // ['type' => 'field', 'id' => 'inner_page_content2', 'label' => 'inner page content2 ', 'input_type' => 'textarea', 'section' => 'about_page'],







  ];
  switch_case($wp_customize, $fields);
}

add_action('customize_register', 'my_register_additional_customizer_settings');

add_action(
  'customize_preview_init',
  function () {
    wp_enqueue_script(
      'custom-preview-button',
      get_template_directory_uri() . '/js/custom-preview.js',
      array('jquery', 'customize-preview'),
      time(),
      true
    );
  }

);

//  to include in functions.php
function the_breadcrumb()
{

  $on_homepage = 0;

  /* Check for homepage first! */
  if (is_home() || is_front_page() || is_search()) {
    $on_homepage = 1;
  }

  /* Change according to your needs */
  $show_on_homepage = 0;
  $show_current = 1;
  $delimiter = '»';
  $before_wrap = '<span clas="current">';
  $after_wrap = '</span>';

  /* Don't change values below */
  $get_home_url = get_bloginfo('url');

  if (0 === $show_on_homepage && 1 === $on_homepage) {
    return;
  }

  /* Proceed with showing the breadcrumbs */
  $breadcrumbs = '<ol class="bread-row" itemscope itemtype="http://schema.org/BreadcrumbList">';

  $breadcrumbs .= '<li class="bread-list" itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="bread-link" href="' . $get_home_url . '">Home</a></li>';

  global $post;
  global $title1;

  /* Build breadcrumbs here */
  if (!is_category()) {
    $breadcrumbs .= '<li class="bread-list" itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="bread-link" href="' . get_permalink($post->ID) . '">' . get_the_title(($post->ID)) . '</a></li>';
    $title1 = get_the_title(($post->ID));
  } else {
    $cat_id = get_query_var('cat');
    $breadcrumbs .= categoryLink($cat_id);
  }

  $breadcrumbs .= '</ol>';
?> <div class="breadcrumb section header_image"> <?php $image_url = get_header_image();

                                                      if (!empty($image_url)) {
                                                      ?> <img class='attachment-post-thumbnail-background'
        src='<?= $image_url ?>' alt='Breadcrumn' /> <?php
                                                                                                      }

                                                                                                        ?> <div
        class="container">
        <div class="breadcrumb-wrapper">
            <h1><?= $title1 ?></h1> <?= $breadcrumbs ?>
        </div>
    </div>
</div> <?php
        }

        function categoryLink($id)
        {
          global $title1;
          $breadcrumbs = '';
          $category = get_category($id);

          if ($category->parent) {
            $breadcrumbs .= categoryLink($category->parent);
          }

          $title1 = $category->name;
          return $breadcrumbs . '<li class="bread-list" itemprop="itemListElement" itemtype="http://schema.org/ListItem"><a class="bread-link" href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
        }

        /*
 * Credit: http://www.thatweblook.co.uk/blog/tutorials/tutorial-wordpress-breadcrumb-function/
 */

        function social_links()
        {
          $social = [
            'facebook' => get_theme_mod('facebook'),
            'instagram' => get_theme_mod('instagram'),
            'twitter' => get_theme_mod('twitter'),
            'youtube' => get_theme_mod('youtube'),
          ];
          echo '<ul class="social-info">';

          foreach ($social as $key => $link) {
            if ($link) {
              echo "<li>";
              echo "<a class='$key' href='$link' target='_blank'><i class='fab fa-$key'></i></a>";
              echo "</li>";
            } else if (is_customize_preview()) {
              echo "<li>";
              echo "<div class='$key'>$key</div>";
              echo "</li>";
            }
          }

          echo '</ul>';
        }

        add_filter(
          'login_head',
          function () {
            // Update the line below with the URL to your own logo.
            // Adjust the Width & Height accordingly.
            $custom_logo = get_theme_mod('custom_logo');
            $logoImage = wp_get_attachment_image_src($custom_logo, 'full');
            $logo_width = '160px';
            $logo_height = '160px';

            printf(
              '<style>#login{padding:0;display: grid;place-content: center;height: 100vh;}.login h1 a {background-image:url(%1$s) !important; margin:0 auto; width: %2$s; height: %3$s; background-size: 100%%;}</style>',
              $logoImage['0'],
              $logo_width,
              $logo_height
            );
            printf("<script>document.querySelector('h1 a').href = 'https://codecrewz.com.au';</script>");
          },
          990
        );

        /**
         * Allow SVG uploads for administrator users.
         *
         * @param array $upload_mimes Allowed mime types.
         *
         * @return mixed
         */
        add_filter(
          'upload_mimes',
          function ($upload_mimes) {

            // By default, only administrator users are allowed to add SVGs.
            // To enable more user types edit or comment the lines below but beware of
            // the security risks if you allow any user to upload SVG files.
            if (!current_user_can('administrator')) {
              return $upload_mimes;
            }

            $upload_mimes['svg'] = 'image/svg+xml';
            $upload_mimes['svgz'] = 'image/svg+xml';

            return $upload_mimes;
          }

        );

        /**
         * Add SVG files mime check.
         *
         * @param array        $wp_check_filetype_and_ext Values for the extension, mime type, and corrected filename.
         * @param string       $file Full path to the file.
         * @param string       $filename The name of the file (may differ from $file due to $file being in a tmp directory).
         * @param string[]     $mimes Array of mime types keyed by their file extension regex.
         * @param string|false $real_mime The actual mime type or false if the type cannot be determined.
         */
        add_filter(
          'wp_check_filetype_and_ext',
          function ($wp_check_filetype_and_ext, $file, $filename, $mimes, $real_mime) {

            if (!$wp_check_filetype_and_ext['type']) {

              $check_filetype = wp_check_filetype($filename, $mimes);
              $ext = $check_filetype['ext'];
              $type = $check_filetype['type'];
              $proper_filename = $filename;

              if ($type && 0 === strpos($type, 'image/') && 'svg' !== $ext) {
                $ext = false;
                $type = false;
              }

              $wp_check_filetype_and_ext = compact('ext', 'type', 'proper_filename');
            }

            return $wp_check_filetype_and_ext;
          },
          10,
          5
        );

        // WordPress pagination for boostrap 4
        if (!function_exists('wpse64458_pagination')) {

          function wpse64458_pagination()
          {
            global $wp_query;
            ob_start();
            $translated = esc_html__('Page', 'wpse64458'); // Supply translatable string
            $check = is_category();
            $pagination = paginate_links(array(
              'base' => $check ? add_query_arg('page', '%#%') : str_replace(PHP_INT_MAX, '%#%', esc_url(get_pagenum_link(PHP_INT_MAX))),
              'format' => $check ? '' : '?paged=%#%',
              'current' => max(1, get_query_var('paged')),
              'total' => $wp_query->max_num_pages,
              'type' => 'array',
              'prev_text' => __('<span></span> Prev', 'wpse64458'),
              'next_text' => __('Next <span></span>', 'wpse64458'),
              'before_page_number' => '<span class = "screen-reader-text">' . $translated . ' </span>',
            ));

            if (!empty($pagination)) : ?><ul
    class="pagination pagination-sm justify-content-center wpse64458_pagination">
    <?php foreach ($pagination as $key => $page_link) : ?><li class="page-item<?php
                                                                                  if (strpos($page_link, 'current') !== false) {
                                                                                    echo ' active';
                                                                                  }

                                                                                  ?>">
        <?php echo str_replace('page-numbers', 'page-link', $page_link); ?></li>
    <?php endforeach ?></ul><?php endif;
                              echo ob_get_clean();
                            }
                          }

                          //Disable emojis in WordPress
                          add_action('init', 'smartwp_disable_emojis');

                          function smartwp_disable_emojis()
                          {
                            remove_action('wp_head', 'print_emoji_detection_script', 7);
                            remove_action('admin_print_scripts', 'print_emoji_detection_script');
                            remove_action('wp_print_styles', 'print_emoji_styles');
                            remove_filter('the_content_feed', 'wp_staticize_emoji');
                            remove_action('admin_print_styles', 'print_emoji_styles');
                            remove_filter('comment_text_rss', 'wp_staticize_emoji');
                            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
                            add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
                          }

                          function disable_emojis_tinymce($plugins)
                          {
                            if (is_array($plugins)) {
                              return array_diff($plugins, array('wpemoji'));
                            } else {
                              return array();
                            }
                          }

                          add_filter('show_admin_bar', '__return_false');




                          // Custom Post Type for banner section
                          function testimonials_post_types()
                          {
                            register_post_type('testimonials', array(
                              'labels' => array(
                                'name' => 'testimonials',
                                'all_items' => 'testimonialss',
                                'singular_name' => 'testimonials',
                                'add_new_item' => 'Add New testimonials',
                                'edit_item' => 'Edit testimonials'
                              ),
                              'supports' => array('title', 'thumbnail', 'revision', 'editor'),
                              'public' => true,
                              'menu_icon' => 'dashicons-portfolio'

                            ));
                          }

                          add_action('init', 'testimonials_post_types');