<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

$setupad_comments_saved_callback = 0;
$setupad_comments_saved_end_callback = 0;
$setupad_number_of_comments = 0;
$setupad_comments_counter = 0;

//Adding custom callback function to comments
function setupad_list_comments_args ($args) {
    global $setupad_comments_saved_callback, $setupad_comments_saved_end_callback;

    $setupad_comments_saved_callback = $args ['callback'];
    $args ['callback'] = 'setupad_comment_callback';

    $setupad_comments_saved_end_callback = $args ['end-callback'];
    $args ['end-callback'] = 'setupad_comment_end_callback';

    return $args;
}
add_filter('wp_list_comments_args', 'setupad_list_comments_args');

//counting comments
function setupad_comments_array ($comments , $post_id ){
    global $setupad_number_of_comments;

    $thread_comments = get_option ('thread_comments');
    $comment_counter = 0;
    foreach ($comments as $comment) {
        if (!$thread_comments || empty ($comment->comment_parent))
            $comment_counter ++;
    }
    $setupad_number_of_comments = $comment_counter;

    return $comments;
}
add_filter('comments_array', 'setupad_comments_array', 10, 2);


// comments counter and before comments position
function setupad_comment_callback ($comment, $args, $depth) {
    global $setupad_rows, $setupad_comments_saved_callback, $setupad_comments_counter;

    if ($depth == 1) {
        if (!$setupad_comments_counter) {
            $setupad_comments_counter = 1;
        } else {
            $setupad_comments_counter++;
        }
    }

    // Get ad contents
    foreach ( $setupad_rows as $row ) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($args ['style'] == 'div') $tag = 'div'; else $tag = 'li';

        if ($depth == 1 && $setupad_comments_counter == 1 && $row->setupad_position == "before_comments") {

            $adContents = setupad_get_ad_contents($row);

            if ($adContents) {
                print "<$tag class='stpd_before_after_comments'>\n";
                print $adContents;
                print "</$tag>\n";
            }
        }
    }

    if (!empty($setupad_comments_saved_callback)) {
        print call_user_func ($setupad_comments_saved_callback, $comment, $args, $depth );
    }
}

//after comments and between comments position
function setupad_comment_end_callback ($comment, $args, $depth) {
    global $setupad_rows, $setupad_comments_saved_end_callback, $setupad_number_of_comments ,$setupad_comments_counter;

    if (!empty ($setupad_comments_saved_end_callback)){
        print call_user_func ($setupad_comments_saved_end_callback, $comment, $args, $depth);
    };

    if ($depth == 0) {
        $last_comment_number = false;

        if ($args ['style'] == 'div') $tag = 'div'; else $tag = 'li';

        foreach ( $setupad_rows as $row ) {
            if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
            if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
            else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

            if ($row->setupad_position == "after_comments" &&
                !empty ($args ['per_page']) && !empty ($args ['page']) && $last_comment_number !== false) {
                $number_of_comments_mod_per_page = $setupad_number_of_comments % $args ['per_page'];
                if ($number_of_comments_mod_per_page != 0) {
                    $last_page = (int) ($setupad_number_of_comments / $args ['per_page']) + 1;
                    $last_comment_number = $args ['page'] == $last_page ? $number_of_comments_mod_per_page : $args ['per_page'];
                } else $last_comment_number = $args ['per_page'];
            } else $last_comment_number = $setupad_number_of_comments;

            if ($setupad_comments_counter != $last_comment_number) {
                if ($row->setupad_position == "between_comments") {

                    $position = $row->setupad_block_position;
                    $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
                    $positions = setupad_get_positions($position, false, true);
                    if ($row->setupad_starting_position > $setupad_comments_counter) continue; //Skip until starting position

                    $adContents = setupad_get_ad_contents($row);

                    if ($repeated_position) {
                        if (($setupad_comments_counter - $row->setupad_starting_position) % $repeated_position == 0 && $adContents){
                            print "<$tag class='stpd_between_comments' >\n";
                            print $adContents;
                            print "</$tag>\n";
                        }
                    } else {
                        if ($adContents && ($position == 0 || in_array($setupad_comments_counter, $positions))) {
                            print "<$tag class='stpd_between_comments' >\n";
                            print $adContents;
                            print "</$tag>\n";
                        }
                    }

                }
            } else {
                if ($row->setupad_position == "after_comments") {
                    $adContents = setupad_get_ad_contents($row);

                    if ($adContents) {
                        print "<$tag class='stpd_before_after_comments'>\n";
                        print $adContents;
                        print "</$tag>\n";
                    }
                }
            }
        }
    }
}