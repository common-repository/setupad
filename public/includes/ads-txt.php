<?php

function setupad_display_ads_txt() {
    $request = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : false;
    if ( '/ads.txt' === $request ) {
        global $wpdb;
        $adstxt_table_name = $wpdb->prefix . 'setupad_ads_txt';
        $adstxt = $wpdb->get_row($wpdb->prepare( "SELECT * FROM %5s WHERE id = %d", $adstxt_table_name, 1 ));

        if (isset($adstxt->adstxt_value)) {
            header( 'Content-Type: text/plain' );
            $adstxt = $adstxt->adstxt_value;
            echo esc_html( apply_filters( 'ads_txt_content', $adstxt ) );
            die();
        }
    }
}
add_action( 'init', 'setupad_display_ads_txt' );