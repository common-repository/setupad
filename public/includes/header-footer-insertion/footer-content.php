<?php

function setupad_footer_content() {
    global $wpdb;
    $settings_table_name = $wpdb->prefix . 'setupad_settings';
    $setupad_footer_content = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name='setupad_footer_content'", $settings_table_name), ARRAY_A);
    if (!$setupad_footer_content) return;
    $setupad_footer_content = stripslashes($setupad_footer_content['setting_value']);

    if ($setupad_footer_content) print $setupad_footer_content;
}
add_action( 'wp_footer', 'setupad_footer_content' );
