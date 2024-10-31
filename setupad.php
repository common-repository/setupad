<?php
/**
 * @package Setupad WP Ads
 * @version 1.6.1
 */
/*
Plugin Name: Setupad WP Ads
Description: Simple and powerful ad insertion and management tool for WordPress users with built-in integration with Setupad header bidding monetization platform.
Author: Setupad
Version: 1.6.1
Author URI: https://setupad.com/
*/

define( 'SETUPAD_BASE', plugin_basename( __FILE__ ) );
define( 'SETUPAD_BASE_PATH', plugin_dir_path( __FILE__ ) );
define( 'SETUPAD_BASE_URL', plugin_dir_url( __FILE__ ) );
define( 'SETUPAD_BASE_DIR', dirname( SETUPAD_BASE ) );

/*----------------------------- ADMIN PHP CODE -----------------------------*/
require_once SETUPAD_BASE_PATH . 'admin/includes/database/class-setupad-display.php';

function setupad_installer(){
    include(SETUPAD_BASE_PATH . 'admin/includes/database/setupad-tables.php');
}
register_activation_hook(__file__, 'setupad_installer');


function setupad_update_db_check() {

    global $setupad_db_version;

    if ( get_site_option( 'setupad_db_version' ) != $setupad_db_version ) {
        include(SETUPAD_BASE_PATH . 'admin/includes/database/setupad-tables-upgrade.php');
    }

    if (is_admin() && current_user_can( 'manage_options' )){
        function setupad_load_resource_files() {
            // Plugin review notice JS initialization
            if (!get_option('setupad_plugin_review_reminder_shown', false)){
                wp_enqueue_script( 'setupad-notice-ajax',  SETUPAD_BASE_URL . 'admin/assets/js/setupad-notice-ajax.js', array('jquery'), '1.0', true);
                wp_localize_script( 'setupad-notice-ajax', 'setupad_notice_ajax_object',
                    array(
                        'ajax_url' => admin_url( 'admin-ajax.php' ),
                        '_ajax_nonce' => wp_create_nonce('setupad-notice-ajax')
                    )
                );
            }
            if (!isset($_GET['page'])) return;
            if ($_GET['page'] ==='setupad' || $_GET['page'] ==='stpd-new_ad' || $_GET['page'] ==='stpd-ads_txt' || $_GET['page'] ==='stpd-related-posts' || $_GET['page'] ==='stpd-header-footer' || $_GET['page'] === 'stpd-settings') {
                wp_register_style('custom.css', SETUPAD_BASE_URL . 'admin/assets/css/custom.css', array(), '39.72');
                wp_enqueue_style('custom.css');

                wp_register_script('setupad.js', SETUPAD_BASE_URL . 'admin/assets/js/setupad.js', array('jquery'), '29.7');
                wp_enqueue_script('setupad.js');

                // Include ace editor script when needed
                if ($_GET['page'] !=='setupad' && $_GET['page'] !=='stpd-ads_txt' && $_GET['page'] !=='stpd-related-posts') {
                    wp_enqueue_script( 'setupad-frontend', SETUPAD_BASE_URL . 'admin/includes/ace/ace.js', array(), '1.0' );
                }
            }
            if ($_GET['page'] === 'setupad'){
                wp_enqueue_script( 'setupad-my-ads-tab-ajax',  SETUPAD_BASE_URL . 'admin/assets/js/setupad-my-ads-tab-ajax.js', array('jquery'), '0.913', true);
                wp_localize_script( 'setupad-my-ads-tab-ajax', 'setupad_ajax_object',
                    array(
                        'ajax_url' => admin_url( 'admin-ajax.php' ),
                        'security' => wp_create_nonce('setupad-my-ads-tab-ajax')
                    )
                );
            }
            if ($_GET['page'] === 'stpd-related-posts'){
                wp_enqueue_script( 'setupad-related-posts-ajax',  SETUPAD_BASE_URL . 'admin/assets/js/setupad-related-posts-ajax.js', array('jquery'), '2.23', true);
                wp_localize_script( 'setupad-related-posts-ajax', 'setupad_ajax_object',
                    array(
                        'ajax_url' => admin_url( 'admin-ajax.php' ),
                        'security' => wp_create_nonce('setupad-related-posts-ajax')
                    )
                );
                wp_register_script('setupad-related-posts-tab', SETUPAD_BASE_URL . 'admin/assets/js/setupad-related-posts-tab.js', array('jquery'), '2.40');
                wp_enqueue_script('setupad-related-posts-tab');
            }
            else if ($_GET['page'] === 'stpd-header-footer') {
                wp_register_script('setupad-header-footer-tab', SETUPAD_BASE_URL . 'admin/assets/js/setupad-header-footer-tab.js', array('jquery'), '1');
                wp_enqueue_script('setupad-header-footer-tab');
            }
            else if ($_GET['page'] === 'stpd-new_ad') {
                wp_register_script('setupad-create-ad-unit-tab', SETUPAD_BASE_URL . 'admin/assets/js/setupad-create-ad-unit-tab.js', array('jquery'), '1.12');
                wp_enqueue_script('setupad-create-ad-unit-tab');
            }
            else if ($_GET['page'] === 'stpd-settings') {
                wp_register_script('setupad-settings-tab', SETUPAD_BASE_URL . 'admin/assets/js/setupad-settings-tab.js', array('jquery'), '0.1');
                wp_enqueue_script('setupad-settings-tab');
            }
        }
        add_action('admin_enqueue_scripts', 'setupad_load_resource_files' );
        add_filter( 'safe_style_css', function( $styles ) {
            $styles = array("align-content", "align-items", "align-self", "all", "animation", "animation-delay", "animation-direction", "animation-duration", "animation-fill-mode", "animation-iter-count", "animation-name", "animation-play-state", "animation-timing-fn", "backface-visibility", "background", "background-attachment", "background-blend-mode", "background-clip", "background-color", "background-image", "background-origin", "background-position", "background-repeat", "background-size", "border", "border-bottom", "border-bottom-color", "border-bottom-left-rad", "border-bottom-right-ra", "border-bottom-style", "border-bottom-width", "border-collapse", "border-color", "border-image", "border-image-outset", "border-image-repeat", "border-image-slice", "border-image-source", "border-image-width", "border-left", "border-left-color", "border-left-style", "border-left-width", "border-radius", "border-right", "border-right-color", "border-right-style", "border-right-width", "border-spacing", "border-style", "border-top", "border-top-color", "border-top-left-radius", "border-top-right-radiu", "border-top-style", "border-top-width", "border-width", "bottom", "box-decoration-break", "box-shadow", "box-sizing", "caption-side", "caret-color", "clear", "clip", "clip-path", "color", "column-count", "column-fill", "column-gap", "column-rule", "column-rule-color", "column-rule-style", "column-rule-width", "column-span", "column-width", "columns", "content", "counter-increment", "counter-reset", "cursor", "direction", "display", "empty-cells", "filter", "flex", "flex-basis", "flex-direction", "flex-flow", "flex-grow", "flex-shrink", "flex-wrap", "float", "font", "font-family", "font-kerning", "font-size", "font-stretch", "font-style", "font-variant", "font-weight", "gap", "grid", "grid-area", "grid-auto-columns", "grid-auto-flow", "grid-auto-rows", "grid-column", "grid-column-end", "grid-column-gap", "grid-column-start", "grid-gap", "grid-row", "grid-row-end", "grid-row-gap", "grid-row-start", "grid-template", "grid-template-areas", "grid-template-columns", "grid-template-rows", "height", "hyphens", "justify-content", "left", "letter-spacing", "line-height", "list-style", "list-style-image", "list-style-position", "list-style-type", "margin", "margin-bottom", "margin-left", "margin-right", "margin-top", "max-height", "max-width", "min-height", "min-width", "object-fit", "object-position", "opacity", "order", "outline", "outline-color", "outline-offset", "outline-style", "outline-width", "overflow", "overflow-x", "overflow-y", "padding", "padding-bottom", "padding-left", "padding-right", "padding-top", "page-break-after", "page-break-before", "page-break-inside", "perspective", "perspective-origin", "pointer-events", "position", "quotes", "right", "row-gap", "scroll-behavior", "table-layout", "text-align", "text-align-last", "text-decoration", "text-decoration-color", "text-decoration-line", "text-decoration-style", "text-indent", "text-justify", "text-overflow", "text-shadow", "text-transform", "top", "transform", "transform-origin", "transform-style", "transition", "transition-delay", "transition-duration", "transition-property", "transition-timing-fn", "user-select", "vertical-align", "visibility", "white-space", "width", "word-break", "word-spacing", "word-wrap", "writing-mode", "z-index");
            return $styles;
        } );

        //Include admin navigation
        include(SETUPAD_BASE_PATH . 'admin/includes/navigation/admin-menu.php');
        include(SETUPAD_BASE_PATH . 'admin/includes/navigation/primary-navigation-tabs.php');

        //Include admin tabs
        include(SETUPAD_BASE_PATH . 'admin/includes/tabs/create-ad-unit-tab.php');
        include(SETUPAD_BASE_PATH . 'admin/includes/tabs/my-ads-tab.php');
        include(SETUPAD_BASE_PATH . 'admin/includes/tabs/ads-txt-tab.php');
        include(SETUPAD_BASE_PATH . 'admin/includes/tabs/related-posts-tab.php');
        include(SETUPAD_BASE_PATH . 'admin/includes/tabs/header-footer-tab.php');
        include(SETUPAD_BASE_PATH . 'admin/includes/tabs/settings-tab.php');

        // Plugin review notice
        if (!get_option('setupad_plugin_review_reminder_shown', false)) {

            add_action( 'wp_ajax_setupad_review_notice_later', 'setupad_review_notice_later' );
            add_action( 'wp_ajax_setupad_review_notice_dismiss', 'setupad_review_notice_dismiss' );

            include_once(SETUPAD_BASE_PATH . 'admin/includes/database/setupad-helper-functions.php');

            function setupad_review_notice() {
                include(SETUPAD_BASE_PATH . 'admin/includes/database/setupad-notice-logic.php');
            }

            add_action('admin_notices', 'setupad_review_notice');
        }

    } else if (!is_admin()){
        /*----------------------------- PUBLIC PHP CODE -----------------------------*/
        $tablename = $GLOBALS['wpdb']->prefix . 'setupad';
        $settings_tablename = $GLOBALS['wpdb']->prefix . 'setupad_settings';

        $GLOBALS['setupad_rows'] = $GLOBALS['wpdb']->get_results($GLOBALS['wpdb']->prepare("SELECT * FROM %5s", $tablename));

        //Prepare settings for usage
        $GLOBALS['setupad_ad_placement_class_name'] = sanitize_html_class( $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT setting_value FROM $settings_tablename WHERE setting_name = %s", 'setupad_ad_placement_class_name')) );
        $GLOBALS['setupad_ad_placement_label_enable'] = sanitize_text_field( $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT setting_value FROM $settings_tablename WHERE setting_name = %s", 'setupad_ad_placement_label_enable')) );
        $GLOBALS['setupad_ad_placement_label'] = sanitize_text_field( $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT setting_value FROM $settings_tablename WHERE setting_name = %s", 'setupad_ad_placement_label')) );
        $GLOBALS['setupad_paragraph_exclusion'] = sanitize_text_field( $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT setting_value FROM $settings_tablename WHERE setting_name = %s", 'setupad_paragraph_exclusion')) );

        function setupad_frontend_scripts_method() {
            $setupad_rows = $GLOBALS['setupad_rows'];
            wp_register_style('custom.css', SETUPAD_BASE_URL . 'public/assets/css/custom.css', array(), '1.9');
            wp_enqueue_style('custom.css');
            wp_enqueue_script( 'setupad-frontend', SETUPAD_BASE_URL . 'public/assets/js/setupad.js', array('jquery'), '1.0', true );

            // Enable lazy loading if needed
            $lazy_loading = false;
            $html_insertion = false;

            foreach ( $setupad_rows as $row ) {

                if ($row->setupad_lazy_loading === "true")
                    $lazy_loading = true;

                if ($row->setupad_position == "before_html" || $row->setupad_position == "after_html" || $row->setupad_position == "inside_html")
                    $html_insertion = true;

            }

            if ($lazy_loading){

                $setupad_lazy_settings = sanitize_text_field( $GLOBALS['wpdb']->get_var($GLOBALS['wpdb']->prepare("SELECT setting_value FROM %5s WHERE setting_name='setupad_lazy_load_offset'", $GLOBALS['wpdb']->prefix . 'setupad_settings')) );
                if ($setupad_lazy_settings !== null) {
                    $offset = is_numeric($setupad_lazy_settings) ? intval($setupad_lazy_settings) : -400;
                } else {
                    $offset = -400;
                }

                wp_enqueue_script( 'inView', SETUPAD_BASE_URL . 'public/assets/js/in-view.min.js', array(), '1.0' );
                wp_add_inline_script( 'inView', 'inView.offset('.$offset.');');

            }
            if ($html_insertion){
                wp_enqueue_script('setupad-html-insertion', SETUPAD_BASE_URL . 'public/assets/js/setupad-html-insertion.js', array('jquery'), '0.43', true);
            }
        }
        add_action('wp_enqueue_scripts', 'setupad_frontend_scripts_method');

        //Placements
        if (count($GLOBALS['setupad_rows']) != 0) {
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/before-post.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/between-posts.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/after-post.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/the-content.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/in-comments.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/before-after-excerpt.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/in-footer.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/in-header.php');
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/sidebar-top.php');           //needs to be thoroughly tested because not every sidebar is generated with dynamic_sidebar()!!!
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/sidebar-bottom.php');        //needs to be thoroughly tested because not every sidebar is generated with dynamic_sidebar()!!!
            include(SETUPAD_BASE_PATH . 'public/includes/ad-placement/before-after-html.php');

            include(SETUPAD_BASE_PATH . 'public/includes/lazy-load.php');
            include(SETUPAD_BASE_PATH . 'public/includes/add-setupad-shortcode.php');
        }

        //related posts
        include(SETUPAD_BASE_PATH . 'public/includes/related-posts.php');

        //Ads.txt
        include(SETUPAD_BASE_PATH . 'public/includes/ads-txt.php');

        //Header/Footer content
        include(SETUPAD_BASE_PATH . 'public/includes/header-footer-insertion/header-content.php');
        include(SETUPAD_BASE_PATH . 'public/includes/header-footer-insertion/footer-content.php');

    }
}
add_action( 'plugins_loaded', 'setupad_update_db_check' );

function delete_setupad_database_tables(){
    global $wpdb;
    $tableArray = [   
      $wpdb->prefix . "setupad",
      $wpdb->prefix . "setupad_settings",
      $wpdb->prefix . "setupad_ads_txt",
    ];

    foreach ($tableArray as $tablename) {
     $wpdb->query($wpdb->prepare("DROP TABLE IF EXISTS %5s", $tablename));
    }

    delete_option('setupad_notice_date');
    delete_option('setupad_db_version');
    delete_option('setupad_plugin_review_reminder_shown');
}

register_uninstall_hook(__FILE__, 'delete_setupad_database_tables');

