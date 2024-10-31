<?php
include_once(SETUPAD_BASE_PATH . "public/includes/mobile-detect/StpdMobileDetect.php");

use \Detection\StpdMobileDetect;

function setupad_page_check() {
    $loop = 0;

    if ( is_front_page ()) {
        $loop = 'homepage';
    } elseif ( is_single() ) {
        $loop = 'post_page';
    } elseif ( is_category() ) {
        $loop = 'category_page';
    } elseif (is_page()) {
        $loop = 'static_page';
    } elseif ( is_archive() || (is_home () && !is_front_page ())) {
        $loop = 'archive_page';
    } elseif ( is_search() ) {
        $loop = 'search_page';
    } elseif ( is_404() ) {
        $loop = '404';
    }

    return $loop;
}

//Accepts object parameter
function setupad_get_ad_contents($ad_row) {
    if(!$ad_row->setupad_status)
        return false;

    $adContents = '';
    $device_selection_array = [];

    // Placement settings
    $wrapper_classname = !empty($GLOBALS['setupad_ad_placement_class_name']) ? $GLOBALS['setupad_ad_placement_class_name'] : 'stpd-wp-block';
    $ad_placement_label_enabled = !empty($GLOBALS['setupad_ad_placement_label_enable']) && $GLOBALS['setupad_ad_placement_label_enable'];
    if($ad_placement_label_enabled){
        $ad_placement_label = !empty($GLOBALS['setupad_ad_placement_label']) ? $GLOBALS['setupad_ad_placement_label'] : 'Advertisement';
    }
    if ($ad_row->setupad_device_selection) $device_selection_array = explode(',', $ad_row->setupad_device_selection);

    // Label for ad placements
    if ( isset($ad_placement_label) ){
        $adContents .= "<span class='stpd-ad-placement-label'>". $ad_placement_label ."</span>";
    }

    //shortcode insertion
    if ($ad_row->setupad_type === 'shortcode') {
        if (in_array(setupad_server_side_mobile_detection(), $device_selection_array) || !$ad_row->setupad_device_selection) {

            if ($ad_row->setupad_contents_alignment && $ad_row->setupad_alignment_css) {
                $adContents .= "<div class='". $wrapper_classname ." ". $wrapper_classname ."-". $ad_row->id ."' style='". stripslashes($ad_row->setupad_alignment_css) ."'>" . do_shortcode(stripslashes($ad_row->setupad_shortcode_content)) . "</div>";
            } else {
                $adContents .= "<div class='". $wrapper_classname ." ". $wrapper_classname ."-". $ad_row->id ."'>". do_shortcode(stripcslashes($ad_row->setupad_shortcode_content)) . "</div>";
            }

            return $adContents;
        } else {
            return false;
        }
    }
    // Double banner insertion
    if ($ad_row->setupad_type === 'double_banner'){
        json_decode(stripcslashes($ad_row->setupad_double_banner_1));
        if (json_last_error() === JSON_ERROR_NONE) {
            $ad_row->setupad_double_banner_1 = json_decode(stripcslashes($ad_row->setupad_double_banner_1));
        }
        json_decode(stripcslashes($ad_row->setupad_double_banner_2));
        if (json_last_error() === JSON_ERROR_NONE) {
            $ad_row->setupad_double_banner_2 = json_decode(stripcslashes($ad_row->setupad_double_banner_2));
        }
        $double_banner =
            '<div class="stpd_double_banner_container">
                <div class="stpd_double_banner_1">'
                . $ad_row->setupad_double_banner_1 .
                '</div>
                <div class="stpd_double_banner_2">'
                . $ad_row->setupad_double_banner_2 .
                '</div>
            </div>';
        if(!defined('double_banner_css')){
            define('double_banner_css', true);
            $double_banner .= '<style>
                                .stpd_double_banner_container {
                                    display: flex;
                                    flex-wrap: wrap;';

            switch($ad_row->setupad_contents_alignment){

                case '0':
                    break;
                case '1':
                    $double_banner .= 'justify-content:start;';
                    break;
                case '2':
                case '4':
                    $double_banner .= 'justify-content:center;';
                    break;
                case '3':
                    $double_banner .= 'justify-content:end;';
                    break;

            }

            $double_banner .=      'margin: auto;
                                    padding: 15px 0px;
                                    min-height: 250px;
                                    gap:10px;
                                }
                                .stpd_double_banner_1{
                                    display: flex;
                                    text-align: center;
                                    align-items: center;
                                }
                                .stpd_double_banner_2{
                                    display: flex;
                                    align-items: center;
                                    text-align: center;
                                }
                                </style>';
        }
    }

    json_decode(stripcslashes($ad_row->setupad_content));
    if (json_last_error() === JSON_ERROR_NONE) {
        $ad_row->setupad_content = json_decode(stripcslashes($ad_row->setupad_content));
    }

    // Ad placement is an image
    if ($ad_row->setupad_type == "images") {
        $img_attributes = json_decode(stripcslashes($ad_row->setupad_image_attributes));
        $img_width = '';
        $img_height = '';
        $img_alt = '';
        $img_url = '';
        $img_target = '';
        $img_referrerpolicy = '';
        $img_wrapper_element_tag = 'div';

        if (!empty($img_attributes->setupad_img_width)) $img_width = 'width="' . $img_attributes->setupad_img_width . '"';
        if (!empty($img_attributes->setupad_img_height)) $img_height = 'height="' . $img_attributes->setupad_img_height . '"';
        if (!empty($img_attributes->setupad_img_alt)) $img_alt = 'alt="' . $img_attributes->setupad_img_alt . '"';
        if (!empty($img_attributes->setupad_img_url)) {
            $img_url = 'href="' . $img_attributes->setupad_img_url . '"';
            if (!empty($img_attributes->setupad_img_target)) $img_target = 'target="'. $img_attributes->setupad_img_target .'"';
            if (!empty($img_attributes->setupad_img_referrerpolicy)) $img_referrerpolicy = 'referrerpolicy="'. $img_attributes->setupad_img_referrerpolicy .'"';
            $img_wrapper_element_tag = 'a';
        }

        $image = "<". $img_wrapper_element_tag ." ". $img_target ." ". $img_url ." ". $img_referrerpolicy ."><img src='".$ad_row->setupad_image_url."' " . $img_width . " " . $img_height . " " . $img_alt . "/></". $img_wrapper_element_tag .">";
    }

    // lazy load content if needed
    $lazy_placement_position = true;
    // Add positions to exclude lazy load here
    switch($ad_row->setupad_position){
        case 'header':
            $lazy_placement_position = false;
            break;
    }

    if ($ad_row->setupad_lazy_loading === 'true' && $lazy_placement_position ){
        $lazy_identifier = rand(0, 100000);
        if (isset($image)) $image = setupad_lazy_load($image, $lazy_identifier, $wrapper_classname);
        if (isset($double_banner)) $double_banner = setupad_lazy_load($double_banner, $lazy_identifier, $wrapper_classname);

        $ad_content = setupad_lazy_load($ad_row->setupad_content, $lazy_identifier, $wrapper_classname);
    } else {
        $ad_content = $ad_row->setupad_content;
    };
    if ($ad_row->setupad_type == "images" && isset($image)) {
        $adContents .= $image;
    } else if ($ad_row->setupad_type == "double_banner" && isset($double_banner)) {
        $adContents .= $double_banner;
    } else
        $adContents .= $ad_content;

    if ($ad_row->setupad_contents_alignment && $ad_row->setupad_alignment_css) {
        $adContents = "<div style='". stripslashes($ad_row->setupad_alignment_css) ."'>" . $adContents . "</div>";
    }

    if (in_array(setupad_server_side_mobile_detection(), $device_selection_array) || !$ad_row->setupad_device_selection){
        if ($lazy_placement_position && isset($lazy_identifier)) {
            return "<div id='lazy-". $wrapper_classname ."-". $lazy_identifier ."' class='". $wrapper_classname ." ". $wrapper_classname ."-". $ad_row->id ."'>". $adContents . "</div>";
        } else {
            return "<div class='". $wrapper_classname ." ". $wrapper_classname ."-". $ad_row->id ."'>". $adContents . "</div>";
        }
    }
    else
        return false;
}

function setupad_get_positions($position, $reformat_to_array_positions, $return_as_array) {
    $positions = array ();

    if (is_numeric ($position)) {
        if (!$position || $position < 0) {
            $position = 0;
        }

        if ($return_as_array) {
            if ($reformat_to_array_positions)
                $positions [] = $position - 1;
            else
                $positions [] = $position;
        } else {
            return $position;
        }
    } else if (strpos ($position, ',') !== false) {
        $exploded_positions = explode(',', str_replace(' ', '', $position));

        foreach ($exploded_positions as $exploded_position) {
            if (is_numeric($exploded_position)) {
                if (!$position || $position < 0) {
                    $position = 0;
                }

                if ($return_as_array) {
                    if ($reformat_to_array_positions)
                        $positions [] = $exploded_position - 1;
                    else
                        $positions [] = $exploded_position;
                } else {
                    return $exploded_position;
                }

            }
        }
    }

    return $positions;
}

function setupad_server_side_mobile_detection() {
    $detect = new StpdMobileDetect;

    //tablet
    if( $detect->isTablet() ) return 3;

    //mobile only
    if( $detect->isMobile() && !$detect->isTablet() ) return 2;

    //desktop
    return 1;
}

function setupad_url_exclusions($urls) {
    if (!isset($urls) || !$urls) return false;

    $urlsArr = explode(',', $urls);
    $currentUrl = $_SERVER['REQUEST_URI'];
    foreach ($urlsArr as $url) {
        $url = wp_make_link_relative(trim($url));
        if (strpos($url, '*') !== false) {
            $urlPrefix = str_replace('*', '', rtrim($url, '/'));
            $urlPattern = preg_quote($urlPrefix, '/') . '.*'; // match any string that starts with the prefix
            if (preg_match('/^\/?' . $urlPattern . '$/', $currentUrl)) { // make the leading slash optional
                return true;
            }
        } else {
            if ($url === $currentUrl) {
                return true;
            } elseif ($url === rtrim($currentUrl, '/')) {
                return true;
            } elseif ($url === ltrim($currentUrl, '/')) {
                return true;
            } elseif ($url === rtrim(ltrim($currentUrl, '/'), "/")) {
                return true;
            }
        }
    }
    return false;
}
function setupad_url_inclusions($urls){
    if (!isset($urls) || !$urls) return false;

    $urlsArr = explode(',', $urls);
    $currentUrl = $_SERVER['REQUEST_URI'];
    foreach ($urlsArr as $url) {
        $url = wp_make_link_relative(trim($url));
        if (strpos($url, '*') !== false) {
            $urlPrefix = str_replace('*', '', rtrim($url, '/'));
            $urlPattern = preg_quote($urlPrefix, '/') . '.*'; // match any string that starts with the prefix
            if (preg_match('/^\/?' . $urlPattern . '$/', $currentUrl)) { // make the leading slash optional
                return false;
            }
        } else {
            if ($url === $currentUrl) {
                return false;
            } elseif ($url === rtrim($currentUrl, '/')) {
                return false;
            } elseif ($url === ltrim($currentUrl, '/')) {
                return false;
            } elseif ($url === rtrim(ltrim($currentUrl, '/'), "/")) {
                return false;
            }
        }
    }
    return true;
}

function setupad_get_ad_row($id){
    global $wpdb;
    $table_name = $wpdb->prefix . 'setupad';

    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %s", $id);

    return $wpdb->get_row($query);
}