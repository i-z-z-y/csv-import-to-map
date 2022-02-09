<?php
/*
 * Plugin Name: Wonderful iZZY
 * Description: USE SHORCODE: [wonderful] Wonderful Technical Interview Code Project
 * Author: iZZY CHEN
  ██╗███████╗███████╗██╗   ██╗     ██████╗██╗  ██╗███████╗███╗   ██╗
  ██║╚══███╔╝╚══███╔╝╚██╗ ██╔╝    ██╔════╝██║  ██║██╔════╝████╗  ██║
  ██║  ███╔╝   ███╔╝  ╚████╔╝     ██║     ███████║█████╗  ██╔██╗ ██║
  ██║ ███╔╝   ███╔╝    ╚██╔╝      ██║     ██╔══██║██╔══╝  ██║╚██╗██║
  ██║███████╗███████╗   ██║       ╚██████╗██║  ██║███████╗██║ ╚████║
  ╚═╝╚══════╝╚══════╝   ╚═╝        ╚═════╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═══╝
 */

// instantiate custom post type MAP
function wonderful_custom_post_type() {
  register_post_type('map',
    array(
      'labels'      => array(
          'name'          => __('Maps', 'textdomain'),
          'singular_name' => __('Map', 'textdomain'),
          ),
      'public'      => true,
      'has_archive' => true,
    )
  );
}
add_action('init', 'wonderful_custom_post_type');
////////////////////////////////////////////////////////////

function wonderful_wordpress_plugin_demo($atts) {
  // If POST data exists
  if(! isset($_POST['importSubmit'])){
    die();
  }
  // If the file is uploaded
  if(! is_uploaded_file($_FILES['file']['tmp_name'])){
    die();
  }
  // func() CREATE NEW CONTENT AS CUSTOM POST TYPE MAP
  $post_slug = md5(time().rand().rand()); // Slug of the Post
  $new_map = array(
      'post_type'     => 'map',
      'post_title'    => 'Test Map Title',
      'post_content'  => 'Test Map Content',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_name'     => $post_slug
  );
  $new_post_id = wp_insert_post($new_map);
  echo "<a href='";
  echo get_permalink( $new_post_id ); // URL of new MAP POST
  echo "'>";
  echo get_permalink( $new_post_id ); // URL of new MAP POST
  echo "</a>";

  // Open uploaded CSV file with read-only mode
  $csvFile = fopen($_FILES['file']['tmp_name'], 'r');
  // Skip the first line
  fgetcsv($csvFile);
  // Parse data from CSV file line by line
  $arrayed = array();
  while(($line = fgetcsv($csvFile)) !== FALSE){
      array_push($arrayed, $line);
  }
  $serialized = serialize($arrayed);
  // func($new_post_id, $serialized) INPUT CSV DATA TO DATABASE
  global $wpdb;
  $wpdb->insert(
    $wpdb->prefix . 'postmeta',
    array(
      'post_id' => $new_post_id,
      'meta_key' => 'csv',
      'meta_value' => $serialized
    )
  );
}
add_shortcode('wonderful', 'wonderful_wordpress_plugin_demo');
