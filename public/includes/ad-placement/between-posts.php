<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

function setupad_between_posts(){

    if (setupad_page_check() && setupad_page_check() != "page" && setupad_page_check() != "single"){

        if (!defined ('first_post_check')) {
            define ('first_post_check', true);
        } else {
            global $setupad_rows, $setupad_post_count;
            if(!isset($setupad_post_count))
                $setupad_post_count = 1;

            foreach ( $setupad_rows as $row ) {
                if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
                if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
                else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions
                if ($row->setupad_starting_position > $setupad_post_count) continue; //Skip until starting position

                if (setupad_page_check() == 'post_page') continue;

                if ($row->setupad_position == "between_posts") {
                    $position = $row->setupad_block_position;
                    $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
                    $positions = setupad_get_positions($position, false, true);

                    $adContents = setupad_get_ad_contents($row);

                    if ($repeated_position) {
                        if (($setupad_post_count - $row->setupad_starting_position) % $repeated_position == 0 && $adContents){
                            print "<div class='stpd_between_posts'>";
                            print $adContents;
                            print "</div>";
                        }
                    } else {
                        if ($position == 0 || in_array($setupad_post_count, $positions) && $adContents) {
                            print "<div class='stpd_between_posts'>";
                            print $adContents;
                            print "</div>";
                        }
                    }
                }
            }
            $setupad_post_count++;
        }
    }
}
add_action( 'the_post', 'setupad_between_posts');