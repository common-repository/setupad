<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

function setupad_ad_sc($atts, $content = null) {
    extract(shortcode_atts(array(
        'num' => '',
    ), $atts));
    global $wpdb;
    $tablename= $wpdb->prefix . 'setupad';

    $setupad_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM %5s WHERE id = %d", $tablename, $num) );

    if(!$setupad_row) return;

    $adContents = setupad_get_ad_contents($setupad_row);

    return $adContents;
}
add_shortcode('setup_ad','setupad_ad_sc');

function setupad_sc($atts, $content = null) {
    extract(shortcode_atts(array(
        'num' => '',
    ), $atts));
    global $wpdb;
    $tablename= $wpdb->prefix . 'setupad';

    $setupad_row = $wpdb->get_row( $wpdb->prepare("SELECT * FROM %5s WHERE id = %d", $tablename, $num) );

    if(!$setupad_row) return;

    $adContents = setupad_get_ad_contents($setupad_row);

    return $adContents;
}
add_shortcode('setupad','setupad_sc');
