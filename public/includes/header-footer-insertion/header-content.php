<?php

function setupad_header_content()
{
    global $wpdb;
    $settings_table_name = $wpdb->prefix . 'setupad_settings';
    $setupad_header_content = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name='setupad_header_content'", $settings_table_name), ARRAY_A);
    if (!$setupad_header_content) return;
    $setupad_header_content = stripslashes($setupad_header_content['setting_value']);


    if ($setupad_header_content) print $setupad_header_content;
}

add_action('wp_head', 'setupad_header_content', 1);