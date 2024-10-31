<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

function setupad_inside_content($content){
    global $setupad_rows;

    $in_paragraph_exists = array_filter($setupad_rows, function($row){
        return ($row->setupad_position === "before_paragraph" || $row->setupad_position === "after_paragraph");
    });
    $before_image_exists = array_filter($setupad_rows, function($row){
        return ($row->setupad_position === "before_image");
    });
    $after_image_exists = array_filter($setupad_rows, function($row){
        return ($row->setupad_position === "after_image");
    });
    $before_after_content_exists = array_filter($setupad_rows, function($row){
        return ($row->setupad_position === "before_content" || $row->setupad_position === "after_content");
    });
    $before_after_list_exists = array_filter($setupad_rows, function($row){
        return ($row->setupad_position === "before_list" || $row->setupad_position === "after_list");
    });
    $between_list_items_exists = array_filter($setupad_rows, function($row){
        return ($row->setupad_position === "between_list_items");
    });

    if ($in_paragraph_exists) $content = setupad_before_after_paragraph($content, $setupad_rows);

    $reserved_ad_positions = [];
    if ($before_image_exists) $content = setupad_before_image($content, $setupad_rows, $reserved_ad_positions);
    if ($after_image_exists) $content = setupad_after_image($content, $setupad_rows, $reserved_ad_positions);

    if ($before_after_content_exists) $content = setupad_before_after_content($content, $setupad_rows);
    if ($between_list_items_exists) $content = setupad_between_list_items($content, $setupad_rows);
    if ($before_after_list_exists) $content = setupad_before_after_list($content, $setupad_rows);

    return $content;
}
add_filter('the_content', 'setupad_inside_content');

function setupad_before_after_content ($content, $setupad_rows) {
    $adContents_before = '';
    $adContents_after = '';
    foreach ( $setupad_rows as $row ) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($row->setupad_position == "before_content") {

            $adContents = setupad_get_ad_contents($row);

            if ($adContents) $adContents_before .= $adContents;

        } else if ($row->setupad_position == "after_content") {

            $adContents = setupad_get_ad_contents($row);

            if ($adContents) $adContents_after .= $adContents;
        }
    }

    return $adContents_before . $content . $adContents_after;
}

function setupad_before_after_paragraph($content, $setupad_rows) {
    $exclusion_elements = !empty($GLOBALS['setupad_paragraph_exclusion']) ? array_map('trim', explode(',', $GLOBALS['setupad_paragraph_exclusion'])) : [];

    $content_blocks = preg_split('/(< *\/?[^>]+>)/si', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

    $exclusion_stack = [];
    foreach ($setupad_rows as $row) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(), explode(',', $row->setupad_insertion_pages))) continue;
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue;
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue;

        if ($row->setupad_position == "after_paragraph" || $row->setupad_position == "before_paragraph") {
            $position = $row->setupad_block_position;
            $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
            $positions = setupad_get_positions($position, true, true);
            $starting_position = $row->setupad_starting_position;
            $non_excluded_paragraph_count = 0;

            for ($i = 0; $i < count($content_blocks); $i++) {
                $block = $content_blocks[$i];

                // Check for opening exclusion tags
                if (preg_match('/< *(' . implode('|', $exclusion_elements) . ')(\s|>)/i', $block, $matches)) {
                    array_push($exclusion_stack, $matches[1]);
                }

                // Check for closing exclusion tags
                if (preg_match('/<\/ *(' . implode('|', $exclusion_elements) . ')>/i', $block, $matches)) {
                    if (end($exclusion_stack) == $matches[1]) {
                        array_pop($exclusion_stack);
                    }
                }

                // Check for paragraph tags, including those with attributes
                if (preg_match('/< *p[^>]*>/i', $block)) {
                    if (empty($exclusion_stack)) {
                        $non_excluded_paragraph_count++;
                    }
                }

                // Insert ads after closing paragraph tags or before opening paragraph tags
                if (empty($exclusion_stack) && (preg_match('/<\/p *>/i', $block) || preg_match('/< *p[^>]*>/i', $block))) {
                    $insert_ad = false;
                    if ($repeated_position) {
                        if (($non_excluded_paragraph_count - 1) >= $starting_position &&
                            (($non_excluded_paragraph_count - 1) - $starting_position) % $repeated_position == 0) {
                            $insert_ad = true;
                        }
                    } elseif (in_array(($non_excluded_paragraph_count - 1), $positions)) {
                        $insert_ad = true;
                    }

                    if ($insert_ad) {
                        $adContents = setupad_get_ad_contents($row);
                        if ($adContents) {
                            if ($row->setupad_position == "after_paragraph" && preg_match('/<\/p *>/i', $block)) {
                                $content_blocks[$i] .= $adContents;
                            } elseif ($row->setupad_position == "before_paragraph" && preg_match('/< *p[^>]*>/i', $block)) {
                                $content_blocks[$i] = $adContents . $content_blocks[$i];
                            }
                        }
                    }
                }
            }
        }
    }
    return implode('', $content_blocks);
}

function setupad_before_image ($content, $setupad_rows, &$reserved_ad_positions) {
    $paragraph_positions = array ();
    $active_paragraph_positions = array ();

    $dummy = array ();

    $paragraph_tags = 'figure,img,amp-img';


    $paragraph_start_strings = explode (",", $paragraph_tags);

    setupad_get_paragraph_start_position($content , $dummy, $paragraph_start_strings, $paragraph_positions, $active_paragraph_positions);

    sort ($paragraph_positions);
    ksort ($active_paragraph_positions);
    $new_active_paragraph_positions = array ();
    foreach ($active_paragraph_positions as $active_paragraph_position) {
        $new_active_paragraph_positions [] = $active_paragraph_position;
    }
    $active_paragraph_positions = $new_active_paragraph_positions;

    $special_element_offsets = array ();
    $special_element_tags_array = array ('figure', 'amp-img', 'li');
    foreach ($special_element_tags_array as $special_element_tag) {
        preg_match_all ("/<\/?$special_element_tag/i", $content, $special_elements, PREG_OFFSET_CAPTURE);

        $nesting = array ();
        $special_elements = $special_elements [0];
        foreach ($special_elements as $index => $special_element) {
            if (isset ($special_elements [$index + 1][0])) {
                $tag1 = strtolower ($special_element [0]);
                $tag2 = strtolower ($special_elements [$index + 1][0]);

                $start_offset = $special_element [1];
                $nesting_ended = false;

                $tag1_start = $tag1 == "<$special_element_tag";
                $tag2_start = $tag2 == "<$special_element_tag";
                $tag1_end   = $tag1 == "</$special_element_tag";
                $tag2_end   = $tag2 == "</$special_element_tag";

                if ($tag1_start && $tag2_start) {
                    array_push ($nesting, $start_offset);
                    continue;
                }
                elseif ($tag1_end && $tag2_end) {
                    $start_offset = array_pop ($nesting);
                    if (count ($nesting) == 0) $nesting_ended = true;
                }

                if (count ($nesting) != 0) continue;

                if (($nesting_ended || $tag1_start) && $tag2_end) {

                    $special_element_offsets []= array ($start_offset + 1, $special_elements [$index + 1][1]);
                }
            }
        }
    }

    if (count ($special_element_offsets) != 0) {

        $inside_special_element = array ();

        foreach ($special_element_offsets as $special_element_offset) {
            foreach ($paragraph_positions as $paragraph_position) {
                if ($paragraph_position >= $special_element_offset [0] && $paragraph_position <= $special_element_offset [1]) $inside_special_element [] = $paragraph_position;
            }
        }

        foreach ($paragraph_positions as $index => $paragraph_position) {
            if (in_array ($paragraph_position, $inside_special_element)) $active_paragraph_positions [$index] = 0;
        }
    }

    // Prepare $paragraph_end_positions
    if (!isset ($paragraph_end_positions)) {
        $paragraph_end_positions = array ();
        setupad_get_paragraph_end_position ($content, $paragraph_positions, $paragraph_start_strings, $paragraph_end_positions, $dummy);
    }

    $filtered_paragraph_end_positions = array ();
    // Use $paragraph_positions for counting as it is checked for consistency
    foreach ($paragraph_positions as $index => $paragraph_position) {
        if ($active_paragraph_positions [$index]) $filtered_paragraph_end_positions [] = $paragraph_end_positions [$index];
    }
    $paragraph_end_positions = $filtered_paragraph_end_positions;

    $filtered_paragraph_positions = array ();
    foreach ($paragraph_positions as $index => $paragraph_position) {
        $existing_ad = false;
        foreach ($reserved_ad_positions as $reserved_ad_position) {
            $interval = explode(",", $reserved_ad_position);
            if ($paragraph_position > $interval[0] && $paragraph_position < $interval[1]) {
                $existing_ad = true;
            }
        }
        if ($active_paragraph_positions [$index] && !$existing_ad && !in_array($paragraph_position, $filtered_paragraph_positions)) $filtered_paragraph_positions [] = $paragraph_position;
    }
    $paragraph_positions = $filtered_paragraph_positions;

    if (count($paragraph_positions) === 0) return $content;

    //$positions contains indexes in $paragraph_positions
    $existing_positions = [];
    foreach ( $setupad_rows as $row ) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($row->setupad_position == "before_image") {
            $position = $row->setupad_block_position;
            $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
            $positions = setupad_get_positions($position, true, true);

            if (!empty ($positions) || !empty ($repeated_position)) {
                $existing_positions = [];

                if ($repeated_position) {
                    for ($i = 0; $i <= count($paragraph_positions); $i++) {
                        if ($row->setupad_starting_position > $i) continue; //Skip until starting position
                        if (($i - $row->setupad_starting_position) % $repeated_position == 0 && $i) {
                            $position = $i-1;
                            setupad_handle_ad_insertion_before_images($row, $position, $existing_positions, $paragraph_positions, $reserved_ad_positions, $content);
                        }
                    }
                } else {
                    foreach ($positions as $position) {
                        setupad_handle_ad_insertion_before_images($row, $position, $existing_positions, $paragraph_positions, $reserved_ad_positions, $content);
                    }
                }
            }
        }
    }

    return $content;
}

function setupad_after_image ($content, $setupad_rows, $reserved_ad_positions ) {
    $paragraph_positions = array ();
    $active_paragraph_positions = array ();

    $dummy = array ();

    $paragraph_tags = 'figure,img,amp-img';

    $paragraph_end_strings = explode (",", $paragraph_tags);

    setupad_get_paragraph_end_position ($content, $dummy, $paragraph_end_strings, $paragraph_positions, $active_paragraph_positions);

    sort ($paragraph_positions);
    ksort ($active_paragraph_positions);
    $new_active_paragraph_positions = array ();
    foreach ($active_paragraph_positions as $active_paragraph_position) {
        $new_active_paragraph_positions [] = $active_paragraph_position;
    }
    $active_paragraph_positions = $new_active_paragraph_positions;

    $special_element_offsets = array ();
    $special_element_tags_array = array ('figure', 'amp-img', 'li');

    foreach ($special_element_tags_array as $special_element_tag) {
        preg_match_all ("/<\/?$special_element_tag/i", $content, $special_elements, PREG_OFFSET_CAPTURE);

        $nesting = array ();
        $special_elements = $special_elements [0];
        foreach ($special_elements as $index => $special_element) {
            if (isset ($special_elements [$index + 1][0])) {
                $tag1 = strtolower ($special_element [0]);
                $tag2 = strtolower ($special_elements [$index + 1][0]);

                $start_offset = $special_element [1];
                $nesting_ended = false;

                $tag1_start = $tag1 == "<$special_element_tag";
                $tag2_start = $tag2 == "<$special_element_tag";
                $tag1_end   = $tag1 == "</$special_element_tag";
                $tag2_end   = $tag2 == "</$special_element_tag";

                if ($tag1_start && $tag2_start) {
                    array_push ($nesting, $start_offset);
                    continue;
                }
                elseif ($tag1_end && $tag2_end) {
                    $start_offset = array_pop ($nesting);
                    if (count ($nesting) == 0) $nesting_ended = true;
                }

                if (count ($nesting) != 0) continue;

                if (($nesting_ended || $tag1_start) && $tag2_end) {

                    $special_element_offsets []= array ($start_offset, $special_elements [$index + 1][1]);
                }
            }
        }
    }

    if (count ($special_element_offsets) != 0) {

        $inside_special_element = array ();

        foreach ($special_element_offsets as $special_element_offset) {
            foreach ($paragraph_positions as $paragraph_position) {
                if ($paragraph_position >= $special_element_offset [0] && $paragraph_position <= $special_element_offset [1]) $inside_special_element [] = $paragraph_position;
            }
        }

        foreach ($paragraph_positions as $index => $paragraph_position) {
            if (in_array ($paragraph_position, $inside_special_element)) $active_paragraph_positions [$index] = 0;
        }
    }

    // Prepare $paragraph_start_positions
    if (!isset ($paragraph_start_positions)) {
        $paragraph_start_positions = array ();
        setupad_get_paragraph_start_position ($content, $paragraph_positions, $paragraph_end_strings, $paragraph_start_positions, $dummy);
    }

    $filtered_paragraph_positions = array ();
    // Use $paragraph_positions for counting as it is checked for consistency
    foreach ($paragraph_positions as $index => $paragraph_position) {
        if ($active_paragraph_positions [$index]) $filtered_paragraph_positions [] = $paragraph_start_positions [$index];
    }
    $paragraph_start_positions = $filtered_paragraph_positions;

    $filtered_paragraph_positions = array ();
    foreach ($paragraph_positions as $index => $paragraph_position) {
        $existing_ad = false;
        foreach ($reserved_ad_positions as $reserved_ad_position) {
            $interval = explode(",", $reserved_ad_position);
            if ($paragraph_position > $interval[0] && $paragraph_position < $interval[1]) {
                $existing_ad = true;
            }
        }
        if ($active_paragraph_positions [$index] && !$existing_ad && !in_array($paragraph_position, $filtered_paragraph_positions)){ $filtered_paragraph_positions [] = $paragraph_position; }
    }
    $paragraph_positions = $filtered_paragraph_positions;

    if (count($paragraph_positions) === 0) return $content;

    $existing_positions = [];
    foreach ( $setupad_rows as $row ) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($row->setupad_position == "after_image") {
            $position = $row->setupad_block_position;
            $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
            $positions = setupad_get_positions($position, true, true);

            if (!empty ($positions) || !empty ($repeated_position)) {
                $existing_positions = [];

                if ($repeated_position) {
                    for ($i = 0; $i <= count($paragraph_positions); $i++) {
                        if ($row->setupad_starting_position > $i) continue; //Skip until starting position
                        if (($i - $row->setupad_starting_position)% $repeated_position == 0 && $i) {
                            $position = $i-1;
                            setupad_handle_ad_insertion_after_images($row, $position, $existing_positions, $paragraph_positions, $content);
                        }
                    }
                } else {
                    foreach ($positions as $position) {
                        setupad_handle_ad_insertion_after_images($row, $position, $existing_positions, $paragraph_positions, $content);
                    }
                }
            }
        }
    }
    return $content;
}

function setupad_before_after_list($content, $setupad_rows) {

    preg_match_all('/<(ul|ol|dl)[^>]*>.*?<\/\1>/s', $content, $matches);
    if (empty($matches[0]))
        return $content;
    $content_block = $matches[0];

    foreach ( $setupad_rows as $row ) {
        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($row->setupad_position == "before_list" || $row->setupad_position == "after_list") {

            $position = $row->setupad_block_position;
            $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
            $positions = setupad_get_positions($position, true, true);

            if ($repeated_position) {
                for ($i = 0; $i <= count($content_block); $i++) {
                    if ($row->setupad_starting_position > $i-1) continue; //Skip until starting position
                    if (($i - $row->setupad_starting_position) % $repeated_position == 0 && $i){
                        $adContents = setupad_get_ad_contents($row);

                        if (!empty($content_block[$i-1]) && $adContents) {
                            if ($row->setupad_position == "after_list"){
                                $content_block[$i-1] .= '</ul></ol></dl>'. $adContents;
                            } else {
                                $content_block[$i-1] = $adContents . $content_block[$i-1] . '</ul></ol></dl>';
                            }
                        }
                    }
                }
            } else {
                foreach ($positions as $position) {
                    $adContents = setupad_get_ad_contents($row);

                    if (!empty($content_block[$position]) && $adContents) {
                        if ($row->setupad_position == "after_list"){
                            $content_block[$position] .= $adContents;
                        } else {
                            $content_block[$position] = $adContents . $content_block[$position];
                        }
                    }
                }
            }
        }
    }

    $merged_content = '';

    $original_content_parts = preg_split('/<(ul|ol|dl)[^>]*>.*?<\/\1>/s', $content);

    foreach ($original_content_parts as $i => $original_part) {
        $merged_content .= $original_part;

        if (isset($content_block[$i])) {
            $merged_content .= $content_block[$i];
        }
    }

    return $merged_content;
}

function setupad_between_list_items($content, $setupad_rows) {

    preg_match_all('/<(ul|ol|dl)[^>]*>.*?(<(li|dt|dd)[^>]*>.*?<\/\2>.*?)*<\/\1>/s', $content, $matches);

    if (empty($matches[0]))
        return $content;

    $list_block = $matches[0];
    $list_type_block = $matches[1];

    foreach ( $setupad_rows as $row ) {

        if (!$row->setupad_insertion_pages || !in_array(setupad_page_check(),explode(',',$row->setupad_insertion_pages))) continue; //page check
        if (setupad_url_inclusions($row->setupad_url_inclusions)) continue; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($row->setupad_url_exclusions) && !$row->setupad_url_inclusions) continue; // URL Exclusions

        if ($row->setupad_position == "between_list_items") {

            $position = $row->setupad_block_position;
            $repeated_position = setupad_get_positions($row->setupad_multiple_block_position, false, false);
            $positions = setupad_get_positions($position, true, true);

            foreach($list_block as $index => $list){

                preg_match_all('/<(li|dt|dd)[^>]*>.*?<\/\1>/s', $list, $matches);
                $list = $matches[0];
                array_unshift($list, '<'. $list_type_block[$index] . '>');

                if ($repeated_position) {
                    for ($i = 0; $i <= count($list); $i++) {

                        if ($row->setupad_starting_position > $i+1) continue; //Skip until starting position
                        if (($i - $row->setupad_starting_position) % $repeated_position == 0 && $i) {
                            $adContents = setupad_get_ad_contents($row);

                            if (!empty($list[$i]) && $adContents) {
                                $list[$i] .= '</li></dt></dd>' . $adContents;
                            }
                        }
                    }
                } else {
                    foreach ($positions as $position) {
                        $adContents = setupad_get_ad_contents($row);

                        if (!empty($list[$position+1]) && $adContents) {
                            $list[$position+1] .= $adContents;
                        }
                    }
                }

                $list[] .= '</'. $list_type_block[$index] .'>';

                $list_block[$index] = implode("", $list);

            }
        }
    }
    $merged_content = '';

    $original_content_parts = preg_split('/<(ul|ol|dl)[^>]*>.*?(<(li|dt|dd)[^>]*>.*?<\/\2>.*?)*<\/\1>/s', $content);

    foreach ($original_content_parts as $i => $original_part) {
        $merged_content .= $original_part;

        if (isset($list_block[$i])) {
            $merged_content .= $list_block[$i];
        }
    }

    return $merged_content;
}

//additional helper functions
function setupad_handle_ad_insertion_before_images ($row, $position, &$existing_positions, $paragraph_positions, &$reserved_ad_positions, &$content) {
    $adContents = setupad_get_ad_contents($row);

    if (!array_key_exists($position, $paragraph_positions)) return;
    if (!$adContents) return;

    if (empty($existing_positions)) {
        $existing_positions [] = ['p_position' => $position,
            'offset' => strlen($adContents)];
    } else {
        $p_position_offsets = [];
        $external_p_keys = [];
        foreach ($existing_positions as $key=>$existing_position) {
            if ($existing_position['p_position'] === $position) {
                $p_position_offsets [] = $existing_position['offset'];
            } else if ($existing_position['p_position'] > $position){
                if (!in_array($key, $external_p_keys)) {
                    $external_p_keys [] = $key;
                }
            }
        }

        if (!empty($p_position_offsets)) {
            $last_offset = end($p_position_offsets);
            $existing_positions [] = ['p_position' => $position,
                'offset' => $last_offset + strlen($adContents)];
            if (!empty($external_p_keys)) {
                foreach ($external_p_keys as $external_p_key) {
                    $existing_positions[$external_p_key]['offset'] = $existing_positions[$external_p_key]['offset'] + strlen($adContents);
                }
            }
        } else {
            foreach ($existing_positions as $key => $existing_position) {
                if ($existing_position['p_position'] < $position) {
                    $p_position_offsets [] = $existing_position['offset'];
                } else {
                    if (!in_array($key, $external_p_keys)) {
                        $external_p_keys [] = $key;
                    }
                }
            }

            $last_offset = end($p_position_offsets);
            if (empty($last_offset)) {
                $existing_positions [] = ['p_position' => $position,
                    'offset' => strlen($adContents)];
            } else {
                $existing_positions [] = ['p_position' => $position,
                    'offset' => $last_offset + strlen($adContents)];
            }

            if (!empty($external_p_keys)) {
                foreach ($external_p_keys as $external_p_key) {
                    $existing_positions[$external_p_key]['offset'] = $existing_positions[$external_p_key]['offset'] + strlen($adContents);
                }
            }
        }
    }
    array_multisort($existing_positions, SORT_ASC);

    $arr_column = array_column(array_reverse($existing_positions, true), 'p_position');
    $position_index = array_search($position, $arr_column);
    $position_key = array_keys(array_reverse($existing_positions, true))[$position_index];
    if (!$position_key) {
        $content = substr_replace($content, $adContents, $paragraph_positions[$position], 0);

        $ad_start_position = $paragraph_positions[$position];
        $ad_end_position = $ad_start_position + strlen($adContents);
        array_push($reserved_ad_positions, $ad_start_position . "," . $ad_end_position);
        foreach ($reserved_ad_positions as $key => $reserved_ad_position) {
            $explode = explode(',', $reserved_ad_position);
            if ($ad_start_position < $explode[0]){
                $start = $explode[0] + strlen($adContents);
                $end = $explode[1] + strlen($adContents);
                $reserved_ad_positions[$key] = $start . "," . $end;
            }
        }

    } else {
        $content = substr_replace($content, $adContents, $paragraph_positions[$position] + $existing_positions[$position_key-1]['offset'], 0);

        $ad_start_position = $paragraph_positions[$position] + $existing_positions[$position_key-1]['offset'];
        $ad_end_position = $ad_start_position + strlen($adContents);
        array_push($reserved_ad_positions, $ad_start_position . "," . $ad_end_position);
        foreach ($reserved_ad_positions as $key => $reserved_ad_position) {
            $explode = explode(',', $reserved_ad_position);
            if ($ad_start_position < $explode[0]){
                $start = $explode[0] + strlen($adContents);
                $end = $explode[1] + strlen($adContents);
                $reserved_ad_positions[$key] = $start . "," . $end;
            }
        }
    }
}

function setupad_handle_ad_insertion_after_images ($row, $position, &$existing_positions, $paragraph_positions, &$content) {
    $adContents = setupad_get_ad_contents($row);

    if (!array_key_exists($position, $paragraph_positions)) return;
    if (!$adContents) return;

    if (empty($existing_positions)) {
        $existing_positions [] = ['p_position' => $position,
            'offset' => strlen($adContents)];
    } else {
        $p_position_offsets = [];
        $external_p_keys = [];
        foreach ($existing_positions as $key=>$existing_position) {
            if ($existing_position['p_position'] === $position) {
                $p_position_offsets [] = $existing_position['offset'];
            } else if ($existing_position['p_position'] > $position){
                if (!in_array($key, $external_p_keys)) {
                    $external_p_keys [] = $key;
                }
            }
        }

        if (!empty($p_position_offsets)) {
            $last_offset = end($p_position_offsets);
            $existing_positions [] = ['p_position' => $position,
                'offset' => $last_offset + strlen($adContents)];
            if (!empty($external_p_keys)) {
                foreach ($external_p_keys as $external_p_key) {
                    $existing_positions[$external_p_key]['offset'] = $existing_positions[$external_p_key]['offset'] + strlen($adContents);
                }
            }
        } else {
            foreach ($existing_positions as $key => $existing_position) {
                if ($existing_position['p_position'] < $position) {
                    $p_position_offsets [] = $existing_position['offset'];
                } else {
                    if (!in_array($key, $external_p_keys)) {
                        $external_p_keys [] = $key;
                    }
                }
            }

            $last_offset = end($p_position_offsets);
            if (empty($last_offset)) {
                $existing_positions [] = ['p_position' => $position,
                    'offset' => strlen($adContents)];
            } else {
                $existing_positions [] = ['p_position' => $position,
                    'offset' => $last_offset + strlen($adContents)];
            }

            if (!empty($external_p_keys)) {
                foreach ($external_p_keys as $external_p_key) {
                    $existing_positions[$external_p_key]['offset'] = $existing_positions[$external_p_key]['offset'] + strlen($adContents);
                }
            }
        }
    }

    array_multisort($existing_positions, SORT_ASC);

    $arr_column = array_column(array_reverse($existing_positions, true), 'p_position');
    $position_index = array_search($position, $arr_column);
    $position_key = array_keys(array_reverse($existing_positions, true))[$position_index];


    if (!$position_key) {
        $content = substr_replace($content, $adContents, $paragraph_positions[$position] + 1, 0);
    } else {
        $content = substr_replace($content, $adContents, $paragraph_positions[$position] + $existing_positions[$position_key-1]['offset'] + 1, 0);
    }
}

function setupad_get_paragraph_start_position ($content, $paragraph_end_positions, $paragraph_start_strings, &$paragraph_positions, &$active_paragraph_positions) {
    foreach ($paragraph_start_strings as $paragraph_start_string) {
        if (trim ($paragraph_start_string) == '') continue;

        $last_position = - 1;

        $paragraph_start_string = trim ($paragraph_start_string);
        if ($paragraph_start_string == "#") {
            $paragraph_start = "\r\n\r\n";
            if (!in_array (0, $paragraph_positions)) {
                $paragraph_positions [] = 0;
                $active_paragraph_positions [0] = 1;
            }
        } else $paragraph_start = '<' . $paragraph_start_string;

        $paragraph_start_len = strlen ($paragraph_start);
        while (stripos ($content, $paragraph_start, $last_position + 1) !== false) {
            $last_position = stripos ($content, $paragraph_start, $last_position + 1);
            if ($paragraph_start_string == "#") {
                $paragraph_positions [] = $last_position + 4;
                $active_paragraph_positions [$last_position + 4] = 1;
            } elseif ($content [$last_position + $paragraph_start_len] == ">" || $content [$last_position + $paragraph_start_len] == " ") {
                $paragraph_positions [] = $last_position;
                $active_paragraph_positions [$last_position] = 1;
            }
        }
    }

    // Consistency check
    if (count ($paragraph_end_positions) != 0) {
        foreach ($paragraph_end_positions as $index => $paragraph_end_position) {
            if ($index == 0) {
                if (!isset ($paragraph_positions [$index]) || $paragraph_positions [$index] >= $paragraph_end_position) {
                    $paragraph_positions [$index] = 0;
                }
            } else {
                if (!isset ($paragraph_positions [$index]) || $paragraph_positions [$index] >= $paragraph_end_position || $paragraph_positions [$index] <= $paragraph_end_positions [$index - 1]) {
                    $paragraph_positions [$index] = $paragraph_end_positions [$index - 1] + 1;
                }
            }
        }
    }
}

function setupad_get_paragraph_end_position ($content, $paragraph_start_positions, $paragraph_end_strings, &$paragraph_positions, &$active_paragraph_positions) {
    $no_closing_tag = array ('img', 'hr', 'br');

    foreach ($paragraph_end_strings as $paragraph_end_string) {

        $last_position = - 1;

        $paragraph_end_string = trim ($paragraph_end_string);
        if ($paragraph_end_string == '') continue;

        if (in_array ($paragraph_end_string, $no_closing_tag)) {
            if (preg_match_all ("/<$paragraph_end_string([^>]*?)>/", $content, $images)) {
                foreach ($images [0] as $paragraph_end) {
                    $last_position = stripos ($content, $paragraph_end, $last_position + 1) + strlen ($paragraph_end) - 1;
                    $paragraph_positions [] = $last_position;
                    $active_paragraph_positions [$last_position] = 1;
                }
            }
            continue;
        } else $paragraph_end = '</' . $paragraph_end_string . '>';


        while (stripos ($content, $paragraph_end, $last_position + 1) !== false) {
            $last_position = stripos ($content, $paragraph_end, $last_position + 1) + strlen ($paragraph_end) - 1;
            if ($paragraph_end_string == "#") {
                $paragraph_positions [] = $last_position - 4;
                $active_paragraph_positions [$last_position - 4] = 1;
            } else {
                $paragraph_positions [] = $last_position;
                $active_paragraph_positions [$last_position] = 1;
            }
        }
    }

    // Consistency check
    if (count ($paragraph_start_positions) != 0) {
        foreach ($paragraph_start_positions as $index => $paragraph_start_position) {
            if ($index == count ($paragraph_start_positions) - 1) {
                if (!isset ($paragraph_positions [$index]) || $paragraph_positions [$index] <= $paragraph_start_position) {
                    $paragraph_positions [$index] = strlen ($content) - 1;
                }
            } else {
                if (!isset ($paragraph_positions [$index]) || $paragraph_positions [$index] <= $paragraph_start_position || $paragraph_positions [$index] >= $paragraph_start_positions [$index + 1]) {
                    $paragraph_positions [$index] = $paragraph_start_positions [$index + 1] - 1;
                }
            }
        }
    }
}


