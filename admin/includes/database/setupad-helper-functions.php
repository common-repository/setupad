<?php

// Get rows of ID and $column_name from database
function get_column_entries($column_name, $filter_column = null, $filter_value = null){
    global $wpdb;
    $table_name = $wpdb->prefix . 'setupad';

    $query = $wpdb->prepare("SELECT id, %5s FROM $table_name", $column_name);

    if ($filter_column !== null && $filter_value !== null){
        $query .= $wpdb->prepare(" WHERE %5s = %s", $filter_column, $filter_value);
    }
    return $wpdb->get_results($query);
}

function setupad_review_notice_later() {

    check_ajax_referer('setupad-notice-ajax', '_ajax_nonce');

    $days = isset($_POST['days']) ? intval($_POST['days']) : 3; // Default to 3 days if not provided

    $new_reminder_date = date('Y-m-d H:i:s', strtotime("+{$days} days", current_time('timestamp')));

    update_option('setupad_notice_date', $new_reminder_date);

    wp_send_json_success();
}

function setupad_review_notice_dismiss() {
    check_ajax_referer('setupad-notice-ajax', '_ajax_nonce');

    update_option('setupad_plugin_review_reminder_shown', true);

    wp_send_json_success();
}