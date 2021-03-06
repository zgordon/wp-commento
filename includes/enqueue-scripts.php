<?php

add_action( 'wp_enqueue_scripts', 'wpcommento_frontend_scripts', 100 );
function wpcommento_frontend_scripts() {
  wp_enqueue_script(
    'wpcommento-js',
    'https://cdn.commento.io/js/commento.js',
    [],
    '',
    true    
  );
}

add_filter( 'script_loader_tag', 'wpcommento_defer_scripts', 10, 3 );
function wpcommento_defer_scripts( $tag, $handle, $src ) {
    
    $styles_url = get_stylesheet_directory_uri() . '/style.css';
    $defer = array( 
      'wpcommento-js'      
    );

    if ( in_array( $handle, $defer ) ) {
       return '<script src="' . $src . '" defer="defer"  data-css-override="' . $styles_url . '" type="text/javascript"></script>' . "\n";
    }
      
    return $tag;
  } 
  

?>
