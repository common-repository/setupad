<?php
include_once(SETUPAD_BASE_PATH . 'public/includes/helper-functions.php');

function setupad_enable_related_articles($content){
    if(is_single() && is_main_query()) {
        global $wpdb;
        $settings_table_name = $wpdb->prefix . 'setupad_settings';
            $setupad_settings = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name='related_articles'", $settings_table_name), ARRAY_A);
        //if (setupad_server_side_mobile_detection() == 2 || setupad_server_side_mobile_detection() == 3)
            //$setupad_settings = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name='related_mobile_articles'", $settings_table_name), ARRAY_A);

        if (!$setupad_settings) return $content;
        $setupad_settings = json_decode($setupad_settings['setting_value']);
        $setupad_settings = (array) $setupad_settings;

        if (isset($setupad_settings['setupad_mobile_rp_settings_enable'])){
            if (setupad_server_side_mobile_detection() == 2 || setupad_server_side_mobile_detection() == 3){
                $setupad_mobile_settings = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name='related_mobile_articles'", $settings_table_name), ARRAY_A);
                if ($setupad_mobile_settings){
                    $setupad_mobile_settings = json_decode($setupad_mobile_settings['setting_value']);
                    $setupad_settings = (array) $setupad_mobile_settings;
                }
            }
        }

        if (!$setupad_settings['setupad_related_articles']) return $content;
        if (!$setupad_settings['related_articles_categories']) return $content;
        if (!isset($setupad_settings['setupad_related_posts_columns']))
            $setupad_settings['setupad_related_posts_columns'] = 2;             // Backwards compatible
        if (!isset($setupad_settings['setupad_related_posts_post_title_limit']))
            $setupad_settings['setupad_related_posts_post_title_limit'] = 35;   // Backwards compatible

        $related_posts_thumb_width = (isset($setupad_settings['setupad_related_posts_thumbnail_width']) && $setupad_settings['setupad_related_posts_thumbnail_width'] !== 0) ? $setupad_settings['setupad_related_posts_thumbnail_width'] : 100;
        $related_posts_thumb_height = (isset($setupad_settings['setupad_related_posts_thumbnail_height']) && $setupad_settings['setupad_related_posts_thumbnail_height'] !== 0) ? $setupad_settings['setupad_related_posts_thumbnail_height'] : 56;

        // Backwards compatibility for previous px values instead of % values
        if($related_posts_thumb_height > 100)
            $related_posts_thumb_height = 56;
        if($related_posts_thumb_width > 100)
            $related_posts_thumb_width = 100;

        $related_posts_thumb_title_alignment = isset($setupad_settings['setupad_related_posts_post_title_alignment']) ? $setupad_settings['setupad_related_posts_post_title_alignment'] : 'center';

        // URL Inclusions & Exclusions
        $setupad_settings['setupad_url_inclusions'] = isset($setupad_settings['setupad_url_inclusions']) ? $setupad_settings['setupad_url_inclusions'] : '';
        $setupad_settings['setupad_url_exclusions'] = isset($setupad_settings['setupad_url_exclusions']) ? $setupad_settings['setupad_url_exclusions'] : '';
        if (setupad_url_inclusions($setupad_settings['setupad_url_inclusions'])) return $content; // URL Inclusions - Prioritize whitelisting before blacklisting
        else if (setupad_url_exclusions($setupad_settings['setupad_url_exclusions']) && !$setupad_settings['setupad_url_inclusions']) return $content; // URL Exclusions

        $after = '<div class="stpd-related-posts">';
        $after .= '<style>
                    #related_posts h3 {
                        margin-bottom: 20px;
                    }

                    .relatedposts {
                        clear: both;
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(calc((100% - 20px * ('. $setupad_settings['setupad_related_posts_columns'] .' - 1)) / '. $setupad_settings['setupad_related_posts_columns'] .'), 1fr));
                        gap: 20px;
                    }  
                    .relatedbackground {
                        width: '. $related_posts_thumb_width .'%;
                        padding-top: '. $related_posts_thumb_height .'%;
                        background-size: cover !important;
                        align-self: center;
                        background-repeat: no-repeat !important;
                        background-position: center !important; 
                    }

            
                    .relatedthumb {
                        position: relative; 
                    }
            
                    .relatedtitle {
                        font-weight: bold;
                        font-size: 17px;
                        padding: 5px;
                        line-height: 22px;
                        text-align: ' . $related_posts_thumb_title_alignment . ';
                    }
            
                    .relatedposts a, .relatedthumb a {
                        color: #000000;
                        text-decoration: none !important;
                        display: flex;
                        flex-direction: column;
                    }
                    .relatedposts h4 {
                        margin-bottom: 0;
                        grid-column: 1 / -1;
                    }
                    @media only screen and (max-width: 767px) {           
                        .relatedtitle {
                            overflow: hidden;
                            font-weight: bold;
                            font-size: 13px !important;
                            padding: 5px;
                            line-height: 15px !important;
                        }
                    }
                </style>';

        if ($setupad_settings['setupad_related_posts_title'])
            $after .= "<div id=\"related_posts\"><h3>" . $setupad_settings['setupad_related_posts_title'] . "</h3></div>";

        $article_categories = explode( ',', $setupad_settings['related_articles_categories'] );
        foreach ($article_categories as &$value) {
            $after .= setupad_get_articles_from_category($value, $setupad_settings);
        }

        $after .= '</div>';
        $content .= $after;

        wp_reset_postdata();
    }

    return $content;
}
add_filter( 'the_content', 'setupad_enable_related_articles', 99 );

function setupad_get_articles_from_category($id, $setupad_settings) {

    // Backwards compatibility
    $columns = max(1, min(4, $setupad_settings['setupad_related_posts_columns'])); // Ensure columns are between 1 and 4
    $rows = max(1, min(8, $setupad_settings['articles_per_category']) ); // Ensure rows are between 1 and 8

    $posts_per_page = $columns * $rows; // Number of related posts rows that will be displayed.

    $args     = array(
        'cat'              => $id,
        'posts_per_page'   => $posts_per_page,
        'ignore_sticky_posts' => 1,
        'orderby'          => 'DESC' // Sort posts by date
    );
    global $post;
    $related_category_content = null;
    $my_query = new wp_query($args);

    if ($my_query->have_posts()) {
        $related_category_content .= "<div class=\"relatedposts\">";

        if ($setupad_settings['setupad_related_posts_cat_title'])
            $related_category_content .= "<h4><a href='" . get_category_link($id) . "'>" . get_cat_name($id) . "</a></h4>";

        while ( $my_query->have_posts() ) {
            $my_query->the_post();

            if (strlen($post->post_title) > $setupad_settings['setupad_related_posts_post_title_limit'] )  {
                if ( $setupad_settings['setupad_related_posts_post_title_limit'] == 0 ) {
                    $trimmed_title = '';
                }
                else{
                    $s = substr($post->post_title, 0, $setupad_settings['setupad_related_posts_post_title_limit']);
                    $trimmed_title = substr($s, 0, strrpos($s, ' ')) . "...";
                }
            } else {
                $trimmed_title = $post->post_title;
            }

            ?>
            <?php if (has_post_thumbnail()) { ?>
                <?php $image_url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'medium');

                $related_category_content .= "<div class=\"relatedthumb\">
                                    <a href=\"" . get_permalink() . "\" rel=\"bookmark\" title=\"" . $post->post_title . "\">
                                        <div class=\"relatedbackground\" style=\"background: url('" . $image_url[0] . "');\"></div>
                                        <div class=\"relatedtitle\">" . $trimmed_title . "</div>
                                    </a>
                                </div>";
            } else {
                $related_category_content .= "<div class=\"relatedthumb\">
                                        <a href=\"" . get_permalink() . "\" rel=\"bookmark\" title=\"" . $post->post_title . "\">
                                            " . $trimmed_title . "</a>
                                    </div>";
            }
        }
        $related_category_content .= "</div>";

        // Remove after some time (backwards compatibility)
        if (isset($setupad_settings['setupad_related_articles_ads']) && $setupad_settings['setupad_related_articles_ads'] && isset($setupad_settings['related_articles_ad_content']) && $setupad_settings['related_articles_ad_content'] && !isset($setupad_settings['setupad_related_articles_ad'])){
            $related_category_content .= "<div style='text-align: center; margin: 20px 0px; clear: both;'> "
                . stripslashes($setupad_settings['related_articles_ad_content']) .
                "</div>";
        }
        // Leave/adjust after removing backwards compatibility code
        else if (isset($setupad_settings['setupad_related_articles_ads']) && $setupad_settings['setupad_related_articles_ads'] && $setupad_settings['setupad_related_articles_ad']){
            $ad_id = $setupad_settings['setupad_related_articles_ad'];
            $ad_row = setupad_get_ad_row($ad_id);
            // Check URL Blacklist/Whitelist
            if($ad_row !== null){
                if(!setupad_url_inclusions($ad_row->setupad_url_inclusions) && !(setupad_url_exclusions($ad_row->setupad_url_exclusions) && !$ad_row->setupad_url_inclusions)){
                    $related_category_content .= setupad_get_ad_contents($ad_row);
                }
            }

        }
    }
    return $related_category_content;
    wp_reset_query();
}