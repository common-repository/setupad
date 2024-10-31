<?php

include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');
function setupad_insert_html() {

    global $setupad_rows;

    $setupad_html_insertion_data = array();

    foreach ( $setupad_rows as $row ) {

        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($row->setupad_position == "before_html" || $row->setupad_position == "after_html" || $row->setupad_position == "inside_html" ) {

            $adContents = setupad_get_ad_contents($row);

            if (!empty($row->setupad_block_position)){
                $selector = $row->setupad_block_position;
                $insertion_type = 'single';
            }
            else{
                $selector = $row->setupad_multiple_block_position;
                $starting_position = $row->setupad_starting_position;
                $insertion_type = 'multiple';
            }

            $position = $row->setupad_position;
            $timeout = $row->setupad_timeout_delay;
            $wait_for_element = $row->setupad_wait_for_element;

            if ($row->setupad_position == "inside_html")
                $action = isset($row->setupad_inside_html_type) ? $row->setupad_inside_html_type : null;

            if ($adContents && $selector) {
                $setupad_html_insertion_data[] = array(
                    'ad_codes' => $adContents,
                    'selector' => $selector,
                    'position' => $position,
                    'action' => isset($action) ? $action : null,
                    'starting_position' => isset($starting_position) ? $starting_position : null,
                    'insertion_type' => $insertion_type,
                    'timeout' => $timeout,
                    'wait_for_element' => $wait_for_element
                );
            }
        }
    }

    if($setupad_html_insertion_data)
        wp_add_inline_script('setupad-html-insertion', 'const setupad_html_insertion_data = ' . json_encode($setupad_html_insertion_data), 'before');

}

add_action ('wp_footer', 'setupad_insert_html', 5);
