<?php


global $wpdb;
$message = '';
$errors = [];
$settings_table_name = $wpdb->prefix . 'setupad_settings';

if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'settings-tab-form')) {
    $setupad_settings = [
        'setupad_lazy_load_offset' => isset($_POST['setupad_lazy_load_offset']) ? sanitize_text_field($_POST['setupad_lazy_load_offset']) : false,
        'setupad_ad_placement_class_name' => (isset($_POST['setupad_ad_placement_class_name'])) ? sanitize_text_field($_POST['setupad_ad_placement_class_name']) : null,
        'setupad_ad_placement_label_enable' => (isset($_POST['setupad_ad_placement_label_enable'])) ? rest_sanitize_boolean($_POST['setupad_ad_placement_label_enable']) : false,
        'setupad_ad_placement_label' => (isset($_POST['setupad_ad_placement_label'])) ? sanitize_text_field($_POST['setupad_ad_placement_label']) : false,
        'setupad_paragraph_exclusion' => (isset($_POST['setupad_paragraph_exclusion'])) ? sanitize_text_field($_POST['setupad_paragraph_exclusion']) : null,
    ];

    $field_errors = validateSettingsFields($setupad_settings);

    if (empty($field_errors)) {
        // No validation errors, proceed with saving
        $db_errors = [];

        // Loop through each setting and save it to the database
        foreach ($setupad_settings as $setting_name => $setting_value) {
            $setting_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$settings_table_name} WHERE setting_name = %s", $setting_name), ARRAY_A);

            if ($setting_db) {
                $result = $wpdb->update(
                    $settings_table_name,
                    array('setting_value' => $setting_value),
                    array('setting_name' => $setting_name)
                );
            } else {
                $result = $wpdb->insert(
                    $settings_table_name,
                    array('setting_name' => $setting_name, 'setting_value' => $setting_value)
                );
            }

            // Check if the database operation was successful
            if ($result === false) {
                $db_errors[] = $setting_name;
            }
        }

        if (empty($db_errors)) {
            $message = __('Settings have been updated successfully', 'setupad');
        } else {
            $notice = __('There was an error while updating settings', 'setupad');
        }
    } else {
        $notice = implode(PHP_EOL, $field_errors);
    }

} else {
    // Retrieve all settings from the database
    $settings_db = $wpdb->get_results("SELECT setting_name, setting_value FROM {$settings_table_name}", ARRAY_A);

    // Initialize the settings array
    $setupad_settings = [];

    // Process each setting
    foreach ($settings_db as $setting) {
        $setting_name = $setting['setting_name'];
        $setting_value = maybe_unserialize($setting['setting_value']);

        // Assign each setting to the setupad_settings array
        $setupad_settings[$setting_name] = $setting_value;
    }
}

function validateSettingsFields($setupad_settings) {
    $field_errors = [];

    // Validate setupad_lazy_load_offset
    if ($setupad_settings['setupad_lazy_load_offset'] !== false && $setupad_settings['setupad_lazy_load_offset'] !== '') {
        if (!is_numeric($setupad_settings['setupad_lazy_load_offset'])) {
            $field_errors[] = __('Lazy load offset must be a numeric value!');
        } elseif ( (!filter_var($setupad_settings['setupad_lazy_load_offset'], FILTER_VALIDATE_INT)) && intval($setupad_settings['setupad_lazy_load_offset']) !== 0 ) {
            $field_errors[] = __('Lazy load offset must be an integer!');
        } elseif (abs(intval($setupad_settings['setupad_lazy_load_offset'])) > 10000) {
            $field_errors[] = __('Lazy load offset must be between -10000 and 10000!');
        }
    }

    // Validate setupad_ad_placement_class_name
    if ($setupad_settings['setupad_ad_placement_class_name'] !== null && $setupad_settings['setupad_ad_placement_class_name'] !== '') {
        if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_-]*$/', $setupad_settings['setupad_ad_placement_class_name'])) {
            $field_errors[] = __('Ad placement class name must be a valid single HTML class name!');
        }
    }

    // Validate setupad_ad_placement_label_enable
    if (!is_bool($setupad_settings['setupad_ad_placement_label_enable'])) {
        $field_errors[] = __('Ad placement label enable must be true or false!');
    }

    // Validate setupad_ad_placement_label
    if ($setupad_settings['setupad_ad_placement_label'] !== false && $setupad_settings['setupad_ad_placement_label'] !== '') {
        $label_length = strlen($setupad_settings['setupad_ad_placement_label']);
        if ($label_length > 100) {
            $field_errors[] = __('Ad placement label must be 100 characters or less!');
        }
    }

    // Validate setupad_paragraph_exclusion
    if ($setupad_settings['setupad_paragraph_exclusion'] !== null && $setupad_settings['setupad_paragraph_exclusion'] !== '') {
        $tags = explode(',', $setupad_settings['setupad_paragraph_exclusion']);
        foreach ($tags as $tag) {
            $tag = trim($tag);
            if ($tag !== '' && !preg_match('/^[a-zA-Z][a-zA-Z0-9]*$/', $tag)) {
                $field_errors[] = sprintf(__('Invalid HTML tag in paragraph exclusion: %s'), $tag);
            }
        }
    }

    return $field_errors;
}
