<?php

global $content_width;

if (!$_POST['related_posts_categories']) {
    $return_data = '<button id="related-preview-close-btn">Close</button><div class="stpd-related-posts">
                    <style>
                        .stpd-related-posts {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            overflow-x: hidden!important;
                            overflow-y: scroll!important;
                            height: 100%;
                            padding: 0 5vw 0 5vw;
                        }
                        .related-warning{
                            font-size: 40px;
                            white-space: nowrap;
                        }
                        #related-preview-area{
                            height:40% !important;
                        }
                        @media screen and (max-width: 1200px) {
                          .related-warning {
                            font-size: 30px;
                          }
                        }
                        @media screen and (max-width: 800px) {
                          .related-warning {
                            font-size: 17px;
                          }
                        }
                    </style>
                    <div class="related-warning">Please select categories to preview related posts!</div>
                    </div>';
    return $return_data;
}
else if (!$_POST['related_posts_articles_per_category']) {
    $return_data = '<button id="related-preview-close-btn">Close</button><div class="stpd-related-posts">
                    <style>
                        .stpd-related-posts {
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            overflow-x: hidden!important;
                            overflow-y: scroll!important;
                            height: 100%;
                            padding: 0 5vw 0 5vw;
                        }
                        .related-warning{
                            font-size: 40px;
                            white-space: nowrap;
                        }
                        #related-preview-area{
                            height:40% !important;
                        }
                        @media screen and (max-width: 1200px) {
                          .related-warning {
                            font-size: 30px;
                          }
                        }
                        @media screen and (max-width: 800px) {
                          .related-warning {
                            font-size: 17px;
                          }
                        }
                    </style>
                    <div class="related-warning">Please specify post count per category!</div>
                    </div>';
    return $return_data;
}

$return_data = '<button id="related-preview-close-btn">Close</button><div class="stpd-related-posts">';
$return_data .= '<style>
                    #related-preview-close-btn {
                        transform: '. ($_POST["mobile_settings_enabled"] === "true" ? 'scale(1.2)' : "scale(1.6)") .';
                    }
                    #related-preview-area{
                        max-width: '. (!$content_width ? '1200px' : $content_width * 0.8 ) .'px;
                        width: '. ($_POST["mobile_settings_enabled"] === "true" ? '20' : "55") .'%;
                    }
                    .custom-ad{
                        margin: auto;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        border: 1px solid #104E66;
                        height: '. ($_POST["mobile_settings_enabled"] === "true" ? '250' : "90") .'px;
                        max-width: '. ($_POST["mobile_settings_enabled"] === "true" ? '300' : "728") .'px;
                    }
                    .stpd-related-posts {
                        overflow-x: hidden!important;
                        overflow-y: scroll!important;
                        height: 100%;
                        margin-top: 70px;
                        flex-grow: 1;
                        padding: '. ($_POST["mobile_settings_enabled"] === "true" ? '0 1.5vw 0 1.5vw;' : "0 5vw 0 5vw;") .'
                    }
                    #related_posts h3 {
                        margin-bottom: 20px;
                    }
    
                    .relatedposts {
                        clear: both;
                        display: grid;
                        grid-template-columns: repeat(auto-fill, minmax(calc((100% - 20px * ('. esc_attr($_POST['setupad_related_posts_columns']) .' - 1)) / '. esc_attr($_POST['setupad_related_posts_columns']) .'), 1fr));
                        gap: 20px;
                    }  
                    
                    .relatedbackground {
                        padding-top: '. esc_attr($_POST['related_posts_thumbnail_height']) .'% !important;
                        width: '. esc_attr($_POST['related_posts_thumbnail_width']) .'% !important;
                        align-self: center;
                        background-size: cover !important;
                        background-repeat: no-repeat !important;
                        background-position: center !important;
                    }
                    
                    .relatedthumb {
                        position: relative; 
                    }
            
                    .relatedtitle {
                        '. ($_POST["mobile_settings_enabled"] === "true" ? 'overflow: hidden;' : " ") .'
                        font-weight: bold;
                        font-size: '. ($_POST["mobile_settings_enabled"] === "true" ? '13' : '17') .'px;
                        padding: 5px;
                        line-height: '. ($_POST["mobile_settings_enabled"] === "true" ? '15' : '22') .'px;
                        text-align: ' . esc_attr($_POST['setupad_related_posts_post_title_alignment']) . ';
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
                        .custom-ad{
                        height: 250px !important;
                        width: 300px !important;
                        } 
            
                        .relatedtitle {
                            overflow: hidden;
                            font-weight: bold;
                            font-size: 13px !important;
                            padding: 5px;
                            line-height: 15px !important;
                        }
                        .stpd-related-posts {
                            max-width:100%;
                        }
                    }
                </style>';

if ($_POST['related_posts_title'])
    $return_data .= "<div id=\"related_posts\"><h3>" . sanitize_text_field($_POST['related_posts_title']) . "</h3></div>";

$article_categories = explode( ',', $_POST['related_posts_categories'] );
foreach ($article_categories as &$value) {
    $return_data .= setupad_get_articles_from_category($value);
}
$return_data .= '</div>';

echo $return_data;

wp_reset_postdata();
wp_die();

function setupad_get_articles_from_category($id) {

    $columns = max(1, min(4, $_POST['setupad_related_posts_columns'])); // Ensure columns are between 1 and 4
    $rows = max(1, min(8, $_POST['related_posts_articles_per_category']) ); // Ensure rows are between 1 and 8

    $posts_per_page = $columns * $rows; // Number of related posts rows that will be displayed.

    $args     = array(
        'cat'              => $id,
        'posts_per_page'   => $posts_per_page, // Number of related posts that will be displayed.
        'ignore_sticky_posts' => 1,
        'orderby'          => 'DESC' // Sort posts by date
    );
    global $post;
    $related_category_content = null;
    $my_query = new wp_query($args);

    if ($my_query->have_posts()) {
        $related_category_content .= "<div class=\"relatedposts\">";

        if ($_POST['related_posts_cat_title_enabled'] === 'true')
            $related_category_content .= "<h4><a href='" . get_category_link($id) . "'>" . get_cat_name($id) . "</a></h4>";

        while ( $my_query->have_posts() ) {
            $my_query->the_post();

            if (strlen( $post->post_title) > sanitize_text_field($_POST['setupad_related_posts_post_title_limit']) ) {
                $s = substr( $post->post_title, 0, sanitize_text_field($_POST['setupad_related_posts_post_title_limit']) );
                $trimmed_title = substr($s, 0, strrpos($s, ' ')) . "...";
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

        if ($_POST['related_articles_ads_enabled'] === 'true'){
            $related_category_content .= "<div style='text-align: center; margin: 20px 0px; clear: both;'><div class='custom-ad'> "
                ."HERE GOES YOUR AD PLACEMENT".
                "</div></div>";
        }

    }
    return $related_category_content;
    wp_reset_query();
}