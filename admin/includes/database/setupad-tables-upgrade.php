<?php
global $wpdb;
$table_name = $wpdb->prefix . "setupad";
$setupad_db_version = '1.2.19';
$charset_collate = $wpdb->get_charset_collate();
$setupad_installed_ver = get_option( "setupad_db_version" );

if ( $setupad_installed_ver != $setupad_db_version ) {
    $sql = "CREATE TABLE " . $wpdb->prefix . "setupad (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `setupad_title` VARCHAR(400) NOT NULL,
        `setupad_type` VARCHAR(100) NOT NULL,
        `setupad_content` text NULL DEFAULT NULL,
        `setupad_content_elements` text NULL DEFAULT NULL,
        `setupad_double_banner_1` text NULL DEFAULT NULL,
        `setupad_double_banner_1_elements` text NULL DEFAULT NULL,
        `setupad_double_banner_2` text NULL DEFAULT NULL,
        `setupad_double_banner_2_elements` text NULL DEFAULT NULL,
        `setupad_image_url` text NULL DEFAULT NULL,
        `setupad_image_file_path` text NULL DEFAULT NULL,
        `setupad_image_attributes` VARCHAR(300) NULL DEFAULT NULL,
        `setupad_shortcode_content` text NULL DEFAULT NULL,
        `setupad_insertion_pages` VARCHAR(100) NULL DEFAULT NULL,
        `setupad_position` VARCHAR(100) NOT NULL,
        `setupad_block_position` VARCHAR(1000) NOT NULL,
        `setupad_starting_position` SMALLINT UNSIGNED NULL DEFAULT '0',
        `setupad_multiple_block_position` VARCHAR(1000) NOT NULL,
        `setupad_device_selection` VARCHAR(10) NULL DEFAULT '0',   
        `setupad_contents_alignment` TINYINT  NOT NULL DEFAULT '0',
        `setupad_alignment_css` VARCHAR(500) NOT NULL DEFAULT '0',    
        `setupad_shortcode` VARCHAR(100) NOT NULL,
        UNIQUE KEY shortcode_constraint (setupad_shortcode),
        `setupad_creation_date` datetime NOT NULL,
        `setupad_status` TINYINT(1) NOT NULL DEFAULT 0,
        `setupad_lazy_loading` ENUM('true', 'false') NOT NULL DEFAULT 'false',
        `setupad_url_exclusions` MEDIUMTEXT NOT NULL,
        `setupad_url_inclusions` MEDIUMTEXT NOT NULL,
        `setupad_inside_html_type` VARCHAR(10) NULL DEFAULT '0',
        `setupad_timeout_delay` INT UNSIGNED NULL DEFAULT NULL,
        `setupad_wait_for_element` VARCHAR(1000) NOT NULL,
        PRIMARY KEY  (id)
    ) $charset_collate;";

    $sql .= "CREATE TABLE ".$wpdb->prefix . "setupad_settings (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `setting_name` VARCHAR(100) NOT NULL,
            `setting_value` MEDIUMTEXT NOT NULL,
            PRIMARY KEY  (id)
    ) $charset_collate;";

    $sql .= "CREATE TABLE ".$wpdb->prefix . "setupad_ads_txt (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `adstxt_value` MEDIUMTEXT NOT NULL,
            PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
    update_option('setupad_db_version', $setupad_db_version);
    if(!get_option('setupad_notice_date')){
        add_option('setupad_notice_date', date('Y-m-d H:i:s', strtotime('+3 days', current_time('timestamp'))));
    }
}
