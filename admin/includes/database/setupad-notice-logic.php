<?php

// Calculate if it's time to show the reminder
$activation_date = get_option('setupad_notice_date');

if ($activation_date) {
    $activation_time = strtotime($activation_date);
    $current_time = current_time('timestamp');
    $days_elapsed = floor(($current_time - $activation_time) / (60 * 60 * 24));

    if ($days_elapsed >= 0) { // 0 days means it's time to show the notice

        include_once(SETUPAD_BASE_PATH . 'admin/includes/forms/setupad-review-notice-form.php');

    }
}
