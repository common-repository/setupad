<?php

global $wpdb;
$message = '';
$db_errors = [];
$mobile_db_errors = [];
$settings_table_name = $wpdb->prefix . 'setupad_settings';

if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'related-posts-form')) {

    $setupad_mobile_settings = $wpdb->get_results($wpdb->prepare("SELECT * FROM %5s", $settings_table_name), ARRAY_A);

    $setupad_settings = [
        'setupad_related_articles' => (isset($_POST['setupad_related_articles'])) ? rest_sanitize_boolean($_POST['setupad_related_articles']) : false,
        'setupad_related_posts_title' => (isset($_POST['setupad_related_posts_title'])) ? sanitize_text_field($_POST['setupad_related_posts_title']) : '',
        'related_articles_categories' => sanitize_text_field($_POST['related_articles_categories']),
        'articles_per_category' => sanitize_text_field($_POST['articles_per_category']),
        'setupad_related_posts_columns' => sanitize_text_field($_POST['setupad_related_posts_columns']),
        'setupad_related_posts_cat_title' => (isset($_POST['setupad_related_posts_cat_title'])) ? rest_sanitize_boolean($_POST['setupad_related_posts_cat_title']) : false,
        'setupad_related_articles_ads' => (isset($_POST['setupad_related_articles_ads'])) ? rest_sanitize_boolean($_POST['setupad_related_articles_ads']) : false,
        'setupad_related_articles_ad' => (isset($_POST['setupad_related_articles_ad'])) ? absint($_POST['setupad_related_articles_ad']) : '',
        'setupad_related_posts_thumbnail_width' => sanitize_text_field($_POST['setupad_related_posts_thumbnail_width']),
        'setupad_related_posts_thumbnail_height' => sanitize_text_field($_POST['setupad_related_posts_thumbnail_height']),
        'setupad_related_posts_post_title_limit' => sanitize_text_field($_POST['setupad_related_posts_post_title_limit']),
        'setupad_related_posts_post_title_alignment' => sanitize_text_field($_POST['setupad_related_posts_post_title_alignment']),
        'setupad_url_exclusions' => (isset($_POST['setupad_url_exclusions'])) ? sanitize_text_field($_POST['setupad_url_exclusions']) : '',
        'setupad_url_inclusions' => (isset($_POST['setupad_url_inclusions'])) ? sanitize_text_field($_POST['setupad_url_inclusions']) : '',
        'setupad_mobile_rp_settings_enable' => (isset($_POST['setupad_mobile_rp_settings_enable'])) ? rest_sanitize_boolean($_POST['setupad_mobile_rp_settings_enable']) : false,
    ];

    $mobile_settings_enabled = $setupad_settings['setupad_mobile_rp_settings_enable'];

    if (!empty($setupad_settings['setupad_url_exclusions'])){
        $setupad_settings['setupad_url_exclusions'] = implode(', ', array_filter(array_map('trim', explode(',', $setupad_settings['setupad_url_exclusions']))));
    }

    if (!empty($setupad_settings['setupad_url_inclusions'])){
        $setupad_settings['setupad_url_inclusions'] = implode(', ', array_filter(array_map('trim', explode(',', $setupad_settings['setupad_url_inclusions']))));
    }

    $related_articles = array(
        'setupad_related_articles' => $setupad_settings['setupad_related_articles'],
        'setupad_related_posts_title' => $setupad_settings['setupad_related_posts_title'],
        'related_articles_categories' => $setupad_settings['related_articles_categories'],
        'articles_per_category' => $setupad_settings['articles_per_category'],
        'setupad_related_posts_columns' => $setupad_settings['setupad_related_posts_columns'],
        'setupad_related_posts_cat_title' => $setupad_settings['setupad_related_posts_cat_title'],
        'setupad_related_articles_ads' => $setupad_settings['setupad_related_articles_ads'],
        'setupad_related_articles_ad' => $setupad_settings['setupad_related_articles_ad'],
        'setupad_related_posts_thumbnail_width' => $setupad_settings['setupad_related_posts_thumbnail_width'],
        'setupad_related_posts_thumbnail_height' => $setupad_settings['setupad_related_posts_thumbnail_height'],
        'setupad_related_posts_post_title_limit' => $setupad_settings['setupad_related_posts_post_title_limit'],
        'setupad_related_posts_post_title_alignment' => $setupad_settings['setupad_related_posts_post_title_alignment'],
        'setupad_url_exclusions' => $setupad_settings['setupad_url_exclusions'],
        'setupad_url_inclusions' => $setupad_settings['setupad_url_inclusions'],
        'setupad_mobile_rp_settings_enable' => $setupad_settings['setupad_mobile_rp_settings_enable']
    );

    $related_articles_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'related_articles'", $settings_table_name), ARRAY_A);

    $field_errors = validateFields($setupad_settings);

    $related_articles = json_encode($related_articles);

    if(isset($related_articles_db) && $related_articles_db['setting_value'] == $related_articles){
        $db_errors[] = 1;
    }
    else if (empty($field_errors)) {
        if ($related_articles_db){
            array_push($db_errors, $wpdb->update($settings_table_name, array('setting_name' => 'related_articles',
                'setting_value' => $related_articles),
                array('ID' => $related_articles_db['id'])));
        } else {
            array_push($db_errors, $result_1 = $wpdb->insert($settings_table_name, array('setting_name' => 'related_articles',
                'setting_value' => $related_articles)));
        }
    }

    if (in_array(0,$db_errors)) {
        $notice = __('There was an error while updating settings', 'setupad');
    } else if ($field_errors) {
        $notice = implode(PHP_EOL, $field_errors);
    } else {
        $message = __('Settings have been updated succesfully', 'setupad');
    }

    $setupad_settings = array(
        array('setting_name' => 'related_articles',
            'setting_value' => $related_articles)
    );

    // Mobile settings
    if ($mobile_settings_enabled == true){

        $setupad_mobile_settings = [
            'setupad_mobile_related_articles' => (isset($_POST['setupad_mobile_related_articles'])) ? rest_sanitize_boolean($_POST['setupad_mobile_related_articles']) : false,
            'setupad_mobile_related_posts_title' => (isset($_POST['setupad_mobile_related_posts_title'])) ? sanitize_text_field($_POST['setupad_mobile_related_posts_title']) : '',
            'related_mobile_articles_categories' => sanitize_text_field($_POST['related_mobile_articles_categories']),
            'articles_mobile_per_category' => sanitize_text_field($_POST['articles_mobile_per_category']),
            'setupad_mobile_related_posts_columns' => sanitize_text_field($_POST['setupad_mobile_related_posts_columns']),
            'setupad_mobile_related_posts_cat_title' => (isset($_POST['setupad_mobile_related_posts_cat_title'])) ? rest_sanitize_boolean($_POST['setupad_mobile_related_posts_cat_title']) : false,
            'setupad_mobile_related_articles_ads' => (isset($_POST['setupad_mobile_related_articles_ads'])) ? rest_sanitize_boolean($_POST['setupad_mobile_related_articles_ads']) : false,
            'setupad_related_articles_ad' => (isset($_POST['setupad_related_articles_ad'])) ? absint($_POST['setupad_related_articles_ad']) : '',
            'setupad_mobile_related_posts_thumbnail_width' => sanitize_text_field($_POST['setupad_mobile_related_posts_thumbnail_width']),
            'setupad_mobile_related_posts_thumbnail_height' => sanitize_text_field($_POST['setupad_mobile_related_posts_thumbnail_height']),
            'setupad_mobile_related_posts_post_title_limit' => sanitize_text_field($_POST['setupad_mobile_related_posts_post_title_limit']),
            'setupad_mobile_related_posts_post_title_alignment' => sanitize_text_field($_POST['setupad_mobile_related_posts_post_title_alignment']),
            'setupad_mobile_url_exclusions' => (isset($_POST['setupad_mobile_url_exclusions'])) ? sanitize_text_field($_POST['setupad_mobile_url_exclusions']) : '',
            'setupad_mobile_url_inclusions' => (isset($_POST['setupad_mobile_url_inclusions'])) ? sanitize_text_field($_POST['setupad_mobile_url_inclusions']) : '',

        ];

        if (!empty($setupad_mobile_settings['setupad_mobile_url_exclusions'])){
            $setupad_mobile_settings['setupad_mobile_url_exclusions'] = implode(', ', array_filter(array_map('trim', explode(',', $setupad_mobile_settings['setupad_mobile_url_exclusions']))));
        }

        if (!empty($setupad_mobile_settings['setupad_mobile_url_inclusions'])){
            $setupad_mobile_settings['setupad_mobile_url_inclusions'] = implode(', ', array_filter(array_map('trim', explode(',', $setupad_mobile_settings['setupad_mobile_url_inclusions']))));
        }

        $related_mobile_articles = array(
            'setupad_related_articles' => $setupad_mobile_settings['setupad_mobile_related_articles'],
            'setupad_related_posts_title' => $setupad_mobile_settings['setupad_mobile_related_posts_title'],
            'related_articles_categories' => $setupad_mobile_settings['related_mobile_articles_categories'],
            'articles_per_category' => $setupad_mobile_settings['articles_mobile_per_category'],
            'setupad_related_posts_columns' => $setupad_mobile_settings['setupad_mobile_related_posts_columns'],
            'setupad_related_posts_cat_title' => $setupad_mobile_settings['setupad_mobile_related_posts_cat_title'],
            'setupad_related_articles_ads' => $setupad_mobile_settings['setupad_mobile_related_articles_ads'],
            'setupad_related_articles_ad' => $setupad_mobile_settings['setupad_related_articles_ad'],
            'setupad_related_posts_thumbnail_width' => $setupad_mobile_settings['setupad_mobile_related_posts_thumbnail_width'],
            'setupad_related_posts_thumbnail_height' => $setupad_mobile_settings['setupad_mobile_related_posts_thumbnail_height'],
            'setupad_related_posts_post_title_limit' => $setupad_mobile_settings['setupad_mobile_related_posts_post_title_limit'],
            'setupad_related_posts_post_title_alignment'=> $setupad_mobile_settings['setupad_mobile_related_posts_post_title_alignment'],
            'setupad_url_exclusions' => $setupad_mobile_settings['setupad_mobile_url_exclusions'],
            'setupad_url_inclusions' => $setupad_mobile_settings['setupad_mobile_url_inclusions']
        );

        $related_mobile_articles_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'related_mobile_articles'", $settings_table_name), ARRAY_A);

        $mobile_field_errors = validateMobileFields($setupad_mobile_settings);

        $related_mobile_articles = json_encode($related_mobile_articles);

        if(isset($related_mobile_articles_db) && $related_mobile_articles_db['setting_value'] == $related_mobile_articles){
            $mobile_db_errors[] = 1;
        }
        else if (empty($mobile_field_errors)) {
            if ($related_mobile_articles_db){
                array_push($mobile_db_errors, $wpdb->update($settings_table_name, array('setting_name' => 'related_mobile_articles',
                    'setting_value' => $related_mobile_articles),
                    array('ID' => $related_mobile_articles_db['id'])));
            } else {
                array_push($mobile_db_errors, $result_2 = $wpdb->insert($settings_table_name, array('setting_name' => 'related_mobile_articles',
                    'setting_value' => $related_mobile_articles)));
            }
        }

        if (in_array(0, $mobile_db_errors)){
            $notice = __('There was an error while updating mobile settings', 'setupad');
        } else if ($mobile_field_errors) {
            $notice = implode(PHP_EOL, $mobile_field_errors);
        } else {
            $message = __('Mobile settings have been updated succesfully', 'setupad');
        }

        $setupad_mobile_settings = array(
            array('setting_name' => 'related_mobile_articles',
                'setting_value' => $related_mobile_articles)
        );
    }

} else {
    // If settings already exist we populate fields with them
    $setupad_settings = $wpdb->get_results($wpdb->prepare("SELECT * FROM %5s", $settings_table_name), ARRAY_A);

    $setupad_mobile_settings = $wpdb->get_results($wpdb->prepare("SELECT * FROM %5s", $settings_table_name), ARRAY_A);
}

function validateFields($related_articles) {
    $field_errors = [];

    if ( !is_numeric($related_articles['setupad_related_posts_post_title_limit']) )
        $field_errors[] = __('Post title character limit is not a numeric value!');
    if ( $related_articles['setupad_related_posts_post_title_limit'] < 0 )
        $field_errors[] = __('Post title character limit must be a positive number!');
    if ( filter_var($related_articles['setupad_related_posts_post_title_limit'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>0, "max_range"=>250))) === false )
        $field_errors[] = __('Post title character limit must be a whole number and must range from 0 to 250!');
    if (!empty($related_articles['setupad_url_exclusions']) && strlen($related_articles['setupad_url_exclusions']) >= 16777215) $field_errors[] = __('URL exclusions field is too long!');
    if (!empty($related_articles['setupad_url_inclusions']) && strlen($related_articles['setupad_url_inclusions']) >= 16777215) $field_errors[] = __('URL inclusions field is too long!');

    return $field_errors;
}

function validateMobileFields($related_mobile_articles) {
    $mobile_field_errors = [];

    if ( !is_numeric($related_mobile_articles['setupad_mobile_related_posts_post_title_limit']) )
        $mobile_field_errors[] = __('Mobile post title character limit is not a numeric value!');
    if ( $related_mobile_articles['setupad_mobile_related_posts_post_title_limit'] < 0 )
        $mobile_field_errors[] = __('Mobile post title character limit must be a positive number!');
    if ( filter_var($related_mobile_articles['setupad_mobile_related_posts_post_title_limit'], FILTER_VALIDATE_INT, array("options" => array("min_range"=>0, "max_range"=>250))) === false )
        $mobile_field_errors[] = __('Mobile post title character limit must be a whole number and must range from 0 to 250!');
    if (!empty($related_mobile_articles['setupad_mobile_url_exclusions']) && strlen($related_mobile_articles['setupad_mobile_url_exclusions']) >= 16777215) $mobile_field_errors[] = __('Mobile URL exclusions field is too long!');
    if (!empty($related_mobile_articles['setupad_mobile_url_inclusions']) && strlen($related_mobile_articles['setupad_mobile_url_inclusions']) >= 16777215) $mobile_field_errors[] = __('Mobile URL inclusions field is too long!');



    return $mobile_field_errors;
}