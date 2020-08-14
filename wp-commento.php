<?php
/*
Plugin Name: Commento Comments
Plugin URI: https://github.com/zgordon/wp-commento
Description: Replace native WordPress comments with Commento
Version: 1.0.0
Contributors: zgordon, Breuxi
Author: Zac Gordon
Author URI: https://zacgordon.com
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpcommento
Domain Path:  /languages
*/

// If this file is called directly, abort.
if (!defined('WPINC')) {
  die;
}

include(plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php');

include(plugin_dir_path(__FILE__)  . 'includes/admin-page.php');

add_filter('comments_template', 'wpcommento_comment_template');
function wpcommento_comment_template($comment_template)
{
  return dirname(__FILE__)  . '/templates/frontend/commento.php';
}

function get_commento_comments_number($post_id)
{
  $is_selfhosted = get_option('commento_use_selfhosted');

  if (@$is_selfhosted == 1) {
    $commento_host = get_option('commento_host');

    $site_url = get_site_url();

    $parsed_url = parse_url($site_url);

    $permalink = get_permalink($post_id);
    $post_url = parse_url($permalink);

    $postData = array(
      'commenterToken' => 'anonymous',
      'domain'         => $parsed_url['host'],
      'path'           => $post_url['path'],
    );

    // Setup cURL
    $ch = curl_init($commento_host . '/api/comment/list');
    curl_setopt_array($ch, array(
      CURLOPT_POST => TRUE,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
      CURLOPT_POSTFIELDS => json_encode($postData)
    ));

    // Send the request
    $response = curl_exec($ch);

    if ($response) {
      // Decode the response
      $responseData = json_decode($response, TRUE);

      if (array_key_exists('comments', $responseData)) {
        return count($responseData["comments"]);
      }
    }

    return 0;
  }
}
