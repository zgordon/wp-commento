<?php
/*
Plugin Name: Commento Comments
Plugin URI: https://github.com/zgordon/wp-commento
Description: Replace native WordPress comments with Commento
Version: 1.0.0
Contributors: zgordon
Author: Zac Gordon
Author URI: https://zacgordon.com
License: GPLv2 or later
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: wpcommento
Domain Path:  /languages
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
  die;
}

include( plugin_dir_path( __FILE__ ) . 'includes/enqueue-scripts.php');

add_filter( 'comments_template', 'wpcommento_comment_template' );
function wpcommento_comment_template( $comment_template ) {
  return dirname(__FILE__)  . '/templates/frontend/commento.php';      
}

?>
