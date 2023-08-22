<?php

function insert_pages($page_title, $page_template, $order = 99)
{
 $page_check = get_page_by_title($page_title, $page_template);
 $new_page = array(
  'post_type' => 'page',
  'post_title' => $page_title,
  'post_content' => '',
  'post_status' => 'publish',
  'post_author' => 1,
  'menu_order' => $order,
 );
 if (!isset($page_check->ID)) {
  $new_page_id = wp_insert_post($new_page);
  if (!empty($page_template)) {
   update_post_meta($new_page_id, '_wp_page_template', $page_template);
  }
  return true;
 }
 return false;
}
// Add a new top-level menu item in the admin menu
add_action('admin_menu', 'add_sync_button');
function add_sync_button()
{
 add_menu_page('Sync Data', 'Sync Data', 'manage_options', 'sync-data', 'sync_data_callback', 'dashicons-update', 6);
}

// Callback function for the sync button
function sync_data_callback()
{
 fetch_data_and_save_to_db();
 echo '<div class="notice notice-success is-dismissible"><p>Data synced successfully!</p></div>';
}
// Register the function that will be called after the theme is activated
add_action('init', 'codecrewz_create_table');
function codecrewz_create_table()
{
 insert_pages('Code Crewz Projects', 'pages/codecrewz.php', 1);
 global $wpdb;
 $table_name = $wpdb->prefix . 'codecrewz_project';
 $table = $wpdb->get_var("SHOW TABLES LIKE '$table_name'");
 if ($table != $table_name) {
  insert_pages('Home', 'front-page.php', 1);
  insert_pages('About Us', 'pages/about.php', 2);
  insert_pages('Services', 'pages/services.php', 3);
  insert_pages('Gallery', 'pages/gallery.php', 4);
  insert_pages('Contact Us', 'pages/contact.php', 5);
  insert_pages('Get Free Quote', 'pages/quote.php', 6);
  insert_pages('FAQ', 'pages/faq.php', 7);

  $sql = "CREATE TABLE $table_name (
       link VARCHAR(500) NOT NULL PRIMARY KEY,
       name VARCHAR(500) NOT NULL,
       description TEXT ,
       phone VARCHAR(500) ,
       email VARCHAR(500) ,
       abn VARCHAR(500) ,
       address VARCHAR(500) ,
       logo VARCHAR(500) ,
       screenshot VARCHAR(500)
     );";
  require_once ABSPATH . 'wp-admin/includes/upgrade.php';
  dbDelta($sql);
  $success = empty($wpdb->last_error);
  fetch_data_and_save_to_db();
 }
}
// Function that fetches data and saves it to the database
function fetch_data_and_save_to_db()
{
  for($i=1;$i<15;$i++){
    // Prepare post data
    $post_data = array(
      'post_title' => "Gallery $i",
      'post_content' => '',
      'post_status' => 'publish',
      'post_type' => 'post'
    );

    // Insert the post into the database
    $post_id = wp_insert_post($post_data);
    if (!is_wp_error($post_id)) {
      // Set the featured image for the post
      $image_url = "http://localhost/mrm/wp-content/uploads/2023/03/gallery$i-jpg.webp";
      $image_id = attachment_url_to_postid($image_url);
      if(!empty($image_id))
      set_post_thumbnail($post_id, $image_id);
    }
  }

 // Fetch data from an external source
 $data = wp_remote_get('https://script.google.com/macros/s/AKfycbwmcf-Ep98XMQuuv-s_3Cl1INMCUo9Azl8OLXb4aYMSm8W66BXFG6YYiJ6Ab302eCXQ2Q/exec',['timeout' => 60]);
 $data = json_decode($data['body'], true)['user'];
 // Create the custom table if it doesn't exist
 global $wpdb;
 $table_name = $wpdb->prefix . 'codecrewz_project';

 // Loop through the data and save it to the custom table
 foreach ($data as $item) {
  // Prepare the data for the custom table
  $link = $item['link'];
  if (empty($link) || filter_var($link, FILTER_VALIDATE_URL) === false) {
   continue;
  }
  $name = $item['name'];
  $description = $item['description'];
  $phone = $item['phone'];
  $email = $item['email'];
  $abn = $item['abn'];
  $address = $item['address'];
  $logo = $item['logo'];
  $screenshot = $item['screenshot'];
  // Insert or update the data into the custom table
  $wpdb->replace(
   $table_name,
   array(
    'link' => $link,
    'name' => $name,
    'description' => $description,
    'phone' => $phone,
    'email' => $email,
    'abn' => $abn,
    'address' => $address,
    'logo' => $logo,
    'screenshot' => $screenshot,
   ),
   array(
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',
    '%s',
   )
  );
 }
}

// Schedule the cron job to run every month
if (!wp_next_scheduled('update_data_codecrew_project')) {

 wp_schedule_event(time(), 'monthly', 'update_data_codecrew_project');
}

// Register the function that will be called when the cron job runs
add_action('update_data_codecrew_project', 'fetch_data_and_save_to_db');
