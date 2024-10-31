<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

$setupad_excerpt_count = 1;
function setupad_before_after_excerpt( $excerpt ) {
    global $setupad_rows, $setupad_excerpt_count;
    foreach ( $setupad_rows as $row ) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions
        if ($row->setupad_starting_position > $setupad_excerpt_count) continue; //Skip until starting position

        if ($row->setupad_position == "after_excerpt" || $row->setupad_position == "before_excerpt") {

            $position = $row->setupad_block_position;
            $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
            $positions = setupad_get_positions($position, false, true);

            if ($repeated_position) {
                if (($setupad_excerpt_count - $row->setupad_starting_position) % $repeated_position == 0){
                    $adContents = setupad_get_ad_contents($row);

                    if ($adContents) {
                        if ($row->setupad_position == "after_excerpt"){
                            $excerpt .= $adContents;
                        } else {
                            $excerpt = $adContents . $excerpt;
                        }
                    }
                }
            } else {
                $adContents = setupad_get_ad_contents($row);

                if (in_array($setupad_excerpt_count, $positions) && $adContents) {
                    if ($row->setupad_position == "after_excerpt") {
                        $excerpt .= $adContents;
                    } else {
                        $excerpt = $adContents . $excerpt;
                    }
                }
            }
        }
    }

    $setupad_excerpt_count++;
    return $excerpt;
}
add_filter( 'the_excerpt', 'setupad_before_after_excerpt' );