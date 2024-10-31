<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

function setupad_after_post( $query ){
    if( $query->is_main_query() ){
        global $setupad_rows;

        foreach ( $setupad_rows as $row ) {
            if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
            if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
            else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

            if ($row->setupad_position == "after_post") {
                $adContents = setupad_get_ad_contents($row);
                if ($adContents) print $adContents;
            }
        }
    }
}
add_action( 'loop_end', 'setupad_after_post' );