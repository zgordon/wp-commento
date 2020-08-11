<?php

function commento_setup_menu() {
    add_menu_page( 'Commento', 'Commento', 'manage_options', 'commento_comments', 'commento_comments_settings_page' );

    add_submenu_page( 'commento_comments', 'Commento', 'Settings', 'manage_options', 'commento_comments', 'commento_comments_settings_page' );
}
 

function commento_comments_settings_page() {
    ?>
    <h1>Commento Settings</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php" class="commento-general-form">
        <?php settings_fields( 'commento-settings-group' ); ?>
        <?php do_settings_sections( 'commento_comments' ); ?>
        <?php submit_button(); ?>
    </form>
    <?php
}
add_action( 'admin_menu', 'commento_setup_menu' );


function commento_settings() {
	register_setting( 'commento-settings-group', 'commento_use_selfhosted' );
	register_setting( 'commento-settings-group', 'commento_host' );
	
	add_settings_section( 'commento-general-settings', 'General Settings', 'commento_general_settings', 'commento_comments');
	
	add_settings_field( 'commento-use-selfhosted', 'Use Selfhosted Commento', 'commento_selfhosted_checkbox', 'commento_comments', 'commento-general-settings');
	add_settings_field( 'commento-commento-host', 'Commento Host', 'commento_host_field', 'commento_comments', 'commento-general-settings');
}

add_action( 'admin_init', 'commento_settings' );


function commento_general_settings() {
	echo '';
}

function commento_host_field() {
    $commento_host = esc_attr( get_option( 'commento_host' ) );
	echo '<input type="text" name="commento_host" value="' . $commento_host . '" placeholder="https://commento.example.com" style="width: 40%;" />';
}

function commento_selfhosted_checkbox() { 
    $checked = ( @get_option( 'commento_use_selfhosted' ) == 1 ? 'checked="checked"' : '' );
	echo '<label><input type="checkbox" id="commento_use_selfhosted" name="commento_use_selfhosted" value="1" ' . $checked .  ' /> Use Selfhosted Commento</label><br>';
}
