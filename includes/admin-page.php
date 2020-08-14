<?php

function commento_setup_menu()
{
    add_menu_page('Commento', 'Commento', 'manage_options', 'commento_comments', 'commento_comments_dashboard_page');

    add_submenu_page('commento_comments', 'Commento', 'Commento', 'manage_options', 'commento_comments', 'commento_comments_dashboard_page');
    add_submenu_page('commento_comments', 'Settings', 'Settings', 'manage_options', 'commento_comments_settings', 'commento_comments_settings_page');
}

function commento_comments_dashboard_page()
{
?>
    <h1>Commento</h1>
    <?php settings_errors();
    // The data to send to the API

    echo "<h2>Posts:</h2>";

    $site_url = get_site_url();

    $parsed_url = parse_url($site_url);

    $is_selfhosted = get_option('commento_use_selfhosted');
    
    if (@$is_selfhosted == 1) {

        $posts = get_posts();

        foreach ($posts as $post) {

            $permalink = get_permalink($post);
            $post_url = parse_url($permalink);

            $commento_host = get_option('commento_host');

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

            // Check for errors
            if ($response === FALSE) {
                curl_error($ch);
            }

            // Decode the response
            $responseData = json_decode($response, TRUE);

            $comment_count = count($responseData["comments"]);

            echo '<h3><a href="' . $permalink . '">' . $post->post_title . '</a> - ' . $comment_count . ' Comments</h3>';
        }
    }
    ?>

<?php
}


function commento_comments_settings_page()
{
?>
    <h1>Commento Settings</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php" class="commento-general-form">
        <?php settings_fields('commento-settings-group'); ?>
        <?php do_settings_sections('commento_comments'); ?>
        <?php submit_button(); ?>
    </form>
<?php
}
add_action('admin_menu', 'commento_setup_menu');


function commento_settings()
{
    register_setting('commento-settings-group', 'commento_use_selfhosted');
    register_setting('commento-settings-group', 'commento_host');

    add_settings_section('commento-general-settings', 'General Settings', 'commento_general_settings', 'commento_comments');

    add_settings_field('commento-use-selfhosted', 'Use Selfhosted Commento', 'commento_selfhosted_checkbox', 'commento_comments', 'commento-general-settings');
    add_settings_field('commento-commento-host', 'Commento Host', 'commento_host_field', 'commento_comments', 'commento-general-settings');
}

add_action('admin_init', 'commento_settings');


function commento_general_settings()
{
    echo '';
}

function commento_host_field()
{
    $commento_host = esc_attr(get_option('commento_host'));
    echo '<input type="text" name="commento_host" value="' . $commento_host . '" placeholder="https://commento.example.com" style="width: 40%;" />';
}

function commento_selfhosted_checkbox()
{
    $checked = (@get_option('commento_use_selfhosted') == 1 ? 'checked="checked"' : '');
    echo '<label><input type="checkbox" id="commento_use_selfhosted" name="commento_use_selfhosted" value="1" ' . $checked .  ' /> Use Selfhosted Commento</label><br>';
}
