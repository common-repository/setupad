<?php

require_once(SETUPAD_BASE_PATH . 'admin/includes/database/setupad-helper-functions.php');

$related_articles_settings_key = array_search('related_articles', array_column($setupad_settings, 'setting_name'));
if ($related_articles_settings_key || $related_articles_settings_key === 0) {
    $related_articles_settings_arr = $setupad_settings[$related_articles_settings_key];
    $related_articles_settings = json_decode($related_articles_settings_arr['setting_value']);
    $related_articles_settings = (array) $related_articles_settings;
}
?>

<table id="related-posts-desktop-settings" style="width: 100%; margin: 0" class="form-table related-posts-tbl">
    <tbody>
    <tr class="enable-related-posts">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Related Posts block', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enable related posts block. It will be displayed after your post\'s content (After content).','setupad'); ?></span>
            </div>
        </td>

        <td>
            <label class="stpd-tgl-switch">
                <input id="setupad_related_articles" name="setupad_related_articles" type="checkbox" value="true"
                    <?php if(isset($related_articles_settings['setupad_related_articles']) && $related_articles_settings['setupad_related_articles']){
                        echo 'checked';
                    }; ?>
                >
                <span class="stpd-slider"></span>
            </label>
        </td>
    </tr>

    <tr class="related-posts-title">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Related Posts title', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Write a custom related posts block title. Title will be displayed right before related posts block (This field is optional, if you leave it empty then no title will be displayed).', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <input id="setupad_related_posts_title" name="setupad_related_posts_title" type="text" placeholder="<?php _e('Related posts title', 'setupad')?>" value="<?php if (isset($related_articles_settings['setupad_related_posts_title'])) echo $related_articles_settings['setupad_related_posts_title'] ?>">
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Show category titles', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enable to show category titles before their related posts.', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <label class="stpd-tgl-switch">
                <input id="setupad_related_posts_cat_title" name="setupad_related_posts_cat_title" type="checkbox" value="true"
                    <?php if (!isset($related_articles_settings['setupad_related_posts_cat_title']) || (isset($related_articles_settings['setupad_related_posts_cat_title']) && $related_articles_settings['setupad_related_posts_cat_title'])) {
                        echo 'checked';
                    }; ?>
                >
                <span class="stpd-slider"></span>
            </label>
        </td>
    </tr>

    <tr class="post-category-selection">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Select categories', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Select categories that you want to display in your related posts block (displays all categories you have created in WordPress).', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <select style="display: none" multiple multiselect-search="true" multiselect-hide-x="true" multiselect-max-items="3">
                <?php
                    $categories = get_categories( array(
                        'orderby' => 'name',
                        'order' => 'ASC'
                    ) );
                    usort($categories, function($a, $b) {return strcmp($b->count, $a->count);});

                    if (count($categories) != 0) {
                        foreach ($categories as $category){ ?>
                            <option
                            value="<?php echo esc_attr($category->term_id); ?>"
                            class="related-categories-arr"
                            <?php if(isset($related_articles_settings['related_articles_categories']) && in_array($category->term_id,explode(",",$related_articles_settings['related_articles_categories']))){
                                echo 'selected';
                            }; ?>
                            >
                                <?php echo (esc_textarea($category->name). ' (' . esc_textarea($category->count) . ')') ?>
                            </option>
                            <?php
                        }
                    };
                ?>
            </select>
            <input id="related_articles_categories" name="related_articles_categories" type="hidden"
                <?php if (isset($related_articles_settings['related_articles_categories']) && $related_articles_settings['related_articles_categories']) {
                    echo 'value="'. esc_attr($related_articles_settings['related_articles_categories']) . '"';
                }; ?>
            >
            <div class="multiselect-dropdown">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="" fill="none">
                    <path d="M9.16667 15.8333C12.8486 15.8333 15.8333 12.8486 15.8333 9.16667C15.8333 5.48477 12.8486 2.5 9.16667 2.5C5.48477 2.5 2.5 5.48477 2.5 9.16667C2.5 12.8486 5.48477 15.8333 9.16667 15.8333Z" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M17.5 17.5L13.875 13.875" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_title"><?php _e('Select post row count per category', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Select how many rows of posts you want to display per each of your previously chosen category.', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <div class="single-dropdown" single>
                <div class="single-dropdown-list-wrapper" style="display: none;">
                    <div class="single-dropdown-list" style="height: 15rem;">
                        <?php $category_post_count = 0 ?>
                        <?php for($x = 1; $x <= 8; $x += 1){ ?>
                            <div <?php echo (isset($related_articles_settings['articles_per_category']) && $related_articles_settings['articles_per_category'] == $x) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php echo esc_textarea($x) ?></label>
                                <input class="single-d-input" type="radio" name="articles_per_category" value="<?php echo esc_textarea($x) ?>"

                                    <?php   if (isset($related_articles_settings['articles_per_category']) && $related_articles_settings['articles_per_category'] == $x) {echo 'checked';}
                                            elseif ( !isset($related_articles_settings['articles_per_category']) && 2 == $x) {echo 'checked';}
                                            // Backwards compatibility below
                                            elseif ( isset($related_articles_settings['articles_per_category']) && $related_articles_settings['articles_per_category'] > 8 && 8 == $x) {echo 'checked';} $category_post_count = $x;?>
                                >
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <span class="optext"></span>
            </div>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_title"><?php _e('Select columns', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Select how many columns of posts you want displayed in your related posts block.', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <div class="single-dropdown" single>
                <div class="single-dropdown-list-wrapper" style="display: none;">
                    <div class="single-dropdown-list" style="height: 9rem;">
                        <?php $related_posts_columns = 2 ?>
                        <?php for($x = 1; $x <= 4; $x += 1){ ?>
                            <div <?php echo ( (isset($related_articles_settings['setupad_related_posts_columns']) && $related_articles_settings['setupad_related_posts_columns'] == $x) || (!isset($related_articles_settings['setupad_related_posts_columns']) && 2 == $x) ) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php echo esc_textarea($x) ?></label>
                                <input class="single-d-input" type="radio" name="setupad_related_posts_columns" value="<?php echo esc_textarea($x) ?>"

                                    <?php   if (isset($related_articles_settings['setupad_related_posts_columns']) && $related_articles_settings['setupad_related_posts_columns'] == $x) {echo 'checked';}
                                            elseif (!isset($related_articles_settings['setupad_related_posts_columns']) && 2 == $x) {echo 'checked';} $related_posts_columns = $x; ?>
                                >
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <span class="optext"></span>
            </div>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Post title character limit', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Set a character limit for the titles of posts in your related posts section, this will output all the title words that do not exceed set character limit.', 'setupad'); ?></span>
            </div>
        </td>

        <td style="display:flex;">
            <input id="setupad_related_posts_post_title_limit" class="code" name="setupad_related_posts_post_title_limit" type="text"
                   value="<?php if ((isset($related_articles_settings['setupad_related_posts_post_title_limit']) )) echo $related_articles_settings['setupad_related_posts_post_title_limit'];
                                else echo '35'; ?>">
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Post title alignment', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Select an alignment option for the titles of posts in your related posts section.', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <ul class="checkbox-grid">
                <div class="checkbox-grid-row">
                    <li <?php if( isset($related_articles_settings['setupad_related_posts_post_title_alignment']) && $related_articles_settings['setupad_related_posts_post_title_alignment'] === 'left' ) echo 'style="background:rgba(146,146,146,.3)"'?> >
                        <input type="radio" value="left" name="setupad_related_posts_post_title_alignment" <?php if(isset($related_articles_settings['setupad_related_posts_post_title_alignment']) && $related_articles_settings['setupad_related_posts_post_title_alignment'] === 'left') echo 'checked' ?>>
                        <label class="setupad_related_posts_post_title_alignment_label">Left</label>
                    </li>
                    <li <?php if( !isset($related_articles_settings['setupad_related_posts_post_title_alignment']) || $related_articles_settings['setupad_related_posts_post_title_alignment'] === 'center' ) echo 'style="background:rgba(146,146,146,.3)"'?> >
                        <input type="radio" value="center" name="setupad_related_posts_post_title_alignment" <?php if( !isset($related_articles_settings['setupad_related_posts_post_title_alignment']) || $related_articles_settings['setupad_related_posts_post_title_alignment'] === 'center' ) echo 'checked'?>>
                        <label class="setupad_related_posts_post_title_alignment_label">Centered</label>
                    </li>
                    <li <?php if( isset($related_articles_settings['setupad_related_posts_post_title_alignment']) && $related_articles_settings['setupad_related_posts_post_title_alignment'] === 'right' ) echo 'style="background:rgba(146,146,146,.3)"'?> >
                        <input type="radio" value="right" name="setupad_related_posts_post_title_alignment" <?php if(isset($related_articles_settings['setupad_related_posts_post_title_alignment']) && $related_articles_settings['setupad_related_posts_post_title_alignment'] === 'right') echo 'checked' ?>>
                        <label class="setupad_related_posts_post_title_alignment_label">Right</label>
                    </li>
                </div>
            </ul>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Insert ads between categories', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enable to insert custom ad placement after each category block.', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <label class="stpd-tgl-switch">
                <input id="setupad_related_articles_ads" name="setupad_related_articles_ads" type="checkbox" value="true"
                    <?php if (isset($related_articles_settings['setupad_related_articles_ads']) && $related_articles_settings['setupad_related_articles_ads']) {
                        echo 'checked';
                    }; ?>
                >
                <span class="stpd-slider"></span>
            </label>
        </td>
    </tr>

    <tr id="rp-ad-code-block"
        <?php if (!isset($related_articles_settings['setupad_related_articles_ads']) || !$related_articles_settings['setupad_related_articles_ads']) {
            echo 'style="display: none;"';
        }; ?>
    >
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Ad placement', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Select one of your created related posts ad placements to be placed between related posts categories.', 'setupad'); ?></span>
            </div>
        </td>

        <td>
            <div class="single-dropdown stpd-type-selection" single>
                <div class="single-dropdown-list-wrapper" style="display: none;">
                    <div class="single-dropdown-list">
                        <?php
                            $rows = get_column_entries('setupad_title', 'setupad_position', 'related_posts');

                            $backwards_compatibility_required = true; // Backwards compatibility

                            if (count($rows) != 0) {
                                foreach ($rows as $row){ ?>

                                    <div <?php echo (isset($related_articles_settings['setupad_related_articles_ad']) && in_array($row->id,explode(",",$related_articles_settings['setupad_related_articles_ad']))) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                        <label class="single-d-label"><?php echo (esc_textarea($row->setupad_title)) ?></label>
                                        <input class="single-d-input" type="radio" name="setupad_related_articles_ad" value="<?php echo esc_attr($row->id); ?>" <?php if (isset($related_articles_settings['setupad_related_articles_ad'])) checked( $related_articles_settings['setupad_related_articles_ad'], $row->id ); ?>>
                                    </div>
                            <?php
                                    if (isset($related_articles_settings['setupad_related_articles_ad']) && in_array($row->id, explode(",", $related_articles_settings['setupad_related_articles_ad']))) {
                                        $backwards_compatibility_required = false;
                                    }
                                }
                            }

                            // Backwards compatibility, remove after some time
                            if ( (isset($related_articles_settings['setupad_related_articles_ad']) && $backwards_compatibility_required) ){
                                $old_settings = get_column_entries('setupad_title', 'ID', $related_articles_settings['setupad_related_articles_ad']);
                                if(!empty($old_settings)){
                                    foreach ($old_settings as $old_setting) {?>
                                    <div class="single-d-div checked">
                                        <label class="single-d-label"><?php echo (esc_textarea($old_setting->setupad_title)) ?></label>
                                        <input class="single-d-input" type="radio" name="setupad_related_articles_ad" value="<?php echo esc_attr($old_setting->id); ?>" <?php checked( $related_articles_settings['setupad_related_articles_ad'], $old_setting->id ); ?>>
                                    </div>
                            <?php   }
                                }
                            }
                        ?>
                    </div>
                </div>
                <span class="optext"></span>
            </div>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Thumbnail width (%)', 'setupad')?></label>
        </th>
        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Use the slider to specify the width (%) of the thumbnails that will be shown in related posts. For 16:9 aspect ratio default value used is 100. Thumbnail preview represented below may not be exact since related posts block width will depend on your post content width.', 'setupad'); ?></span>
            </div>
        </td>
        <td>
            <div class="slider-container">
                <input id="stpd-thumb-width" class="stpd-range-slider-value" type="number" min="1" max="100" value="<?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_width']) && ($related_articles_settings['setupad_related_posts_thumbnail_width'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_width'] : 100; ?>" readonly aria-readonly="true">
                <input type="range" min="1" max="100" value="<?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_width']) && ($related_articles_settings['setupad_related_posts_thumbnail_width'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_width'] : 100; ?>" class="stpd-range-slider" id="stpd-thumb-width-slider" name="setupad_related_posts_thumbnail_width">
            </div>
        </td>
    </tr>
    <tr>
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Thumbnail height (%)', 'setupad')?></label>
        </th>
        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Use the slider to specify the height (%) of the thumbnails that will be shown in related posts. For 16:9 aspect ratio default value used is 56. Thumbnail preview represented below may not be exact since related posts block width will depend on your post content width.', 'setupad'); ?></span>
            </div>
        </td>
        <td>
            <div class="slider-container">
                <input id="stpd-thumb-height" class="stpd-range-slider-value" type="number" min="1" max="100" value="<?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_height']) && ($related_articles_settings['setupad_related_posts_thumbnail_height'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_height'] : 56; ?>" readonly aria-readonly="true">
                <input type="range" min="1" max="100" value="<?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_height']) && ($related_articles_settings['setupad_related_posts_thumbnail_height'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_height'] : 56; ?>" class="stpd-range-slider" id="stpd-thumb-height-slider" name="setupad_related_posts_thumbnail_height">
            </div>
        </td>
    </tr>
    <tr>
        <th></th>
        <td></td>
        <td>
            <div id="thumbnail-preview">
                <div style="display: none;" class="thumbnail">
                    <div style="background: url( <?php echo SETUPAD_BASE_URL . 'admin/assets/images/setupad-related-posts-thumbnail.svg' ?> ); padding-top: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_height']) && ($related_articles_settings['setupad_related_posts_thumbnail_height'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_height'] : 56; ?>%; width: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_width']) && ($related_articles_settings['setupad_related_posts_thumbnail_width'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_width'] : 100; ?>%;"></div>
                </div>
                <div style="display: none;" class="thumbnail">
                    <div style="background: url( <?php echo SETUPAD_BASE_URL . 'admin/assets/images/setupad-related-posts-thumbnail.svg' ?> ); padding-top: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_height']) && ($related_articles_settings['setupad_related_posts_thumbnail_height'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_height'] : 56; ?>%; width: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_width']) && ($related_articles_settings['setupad_related_posts_thumbnail_width'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_width'] : 100; ?>%;"></div>
                </div>
                <div style="display: none;" class="thumbnail">
                    <div style="background: url( <?php echo SETUPAD_BASE_URL . 'admin/assets/images/setupad-related-posts-thumbnail.svg' ?> ); padding-top: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_height']) && ($related_articles_settings['setupad_related_posts_thumbnail_height'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_height'] : 56; ?>%; width: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_width']) && ($related_articles_settings['setupad_related_posts_thumbnail_width'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_width'] : 100; ?>%;"></div>
                </div>
                <div style="display: none;" class="thumbnail">
                    <div style="background: url( <?php echo SETUPAD_BASE_URL . 'admin/assets/images/setupad-related-posts-thumbnail.svg' ?> ); padding-top: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_height']) && ($related_articles_settings['setupad_related_posts_thumbnail_height'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_height'] : 56; ?>%; width: <?php echo isset($related_articles_settings['setupad_related_posts_thumbnail_width']) && ($related_articles_settings['setupad_related_posts_thumbnail_width'] <= 100) ? $related_articles_settings['setupad_related_posts_thumbnail_width'] : 100; ?>%;"></div>
                </div>
            </div>
        </td>
    </tr>
    <tr class="form-field" id="advanced-options">
        <th scope="row">
            <button id="advanced-options-btn"><?php _e('Show advanced options', 'setupad')?></button>
        </th>
    </tr>
    <tr class="form-field advanced-option mobile-rp-checkbox">
        <th scope="row">
            <label for="setupad_subtitle"><?php _e('Separate settings for mobile', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Enable separate related posts settings for mobile. After checking this checkbox a navbar will appear at the top of the page where you can select and customize mobile settings. While this is enabled, desktop settings will be used only for desktop instead of all devices. ','setupad'); ?></span>
            </div>
        </td>

        <td>
            <label class="stpd-tgl-switch">
                <input id="setupad_mobile_rp_settings_enable" name="setupad_mobile_rp_settings_enable" type="checkbox" value="true"
                    <?php if(isset($related_articles_settings['setupad_mobile_rp_settings_enable']) && $related_articles_settings['setupad_mobile_rp_settings_enable']){
                        echo 'checked';
                    }; ?>
                >
                <span class="stpd-slider"></span>
            </label>
        </td>
    </tr>
    <tr class="form-field advanced-option setupad-exclusions">
        <th scope="row">
            <label for="setupad_title"><?php _e('URL blacklist', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Exclude a URL where you don\'t want related posts shown. It is also possible to use a wildcard ( e.g. /blog/* ).','setupad'); ?></span>
            </div>
        </td>

        <td>
            <div class="stpd-btn-row">
                <input id="setupad_url_exclusions" size="3000" class="code" placeholder="<?php _e('/blog/my-post, /categories/*', 'setupad')?>" AutoComplete=off data-lpignore="true" type="text">
                <button id="add-exclusion" class="stpd-add-btn">Add</button>
            </div>
        </td>
    </tr>
    <tr class="form-field advanced-option error" style="display:none">
        <th scope="row"></th>
        <td></td>
        <td>
            <strong></strong>
        </td>
    </tr>
    <tr class="form-field advanced-option setupad-inclusions">
        <th scope="row">
            <label for="setupad_title"><?php _e('URL whitelist', 'setupad')?></label>
        </th>

        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('Include a URL where you explicitly want related posts shown. It is also possible to use a wildcard ( e.g. /blog/* ).','setupad'); ?></span>
            </div>
        </td>

        <td>
            <div class="stpd-btn-row">
                <input id="setupad_url_inclusions" size="3000" class="code" placeholder="<?php _e('/blog/my-post, /categories/*', 'setupad')?>" AutoComplete=off data-lpignore="true" type="text">
                <button id="add-inclusion" class="stpd-add-btn">Add</button>
            </div>
        </td>
    </tr>
    <tr class="form-field advanced-option error" style="display:none">
        <th scope="row"></th>
        <td></td>
        <td>
            <strong></strong>
        </td>
    </tr>
    <tr id="stpd-url-list" class="advanced-option">
        <th scope="row">
            <label for="setupad_title"><?php _e('URL list', 'setupad')?></label>
        </th>
        <td>
            <div class="stpd-tooltip">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                    <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                </svg>
                <span class="stpd-tooltiptext"><?php _e('List of URLs currently added to your related posts blacklist/whitelist.','setupad'); ?></span>
            </div>
        </td>
        <td>
            <button id="blacklist-select-btn">Blacklist</button>
            <button id="whitelist-select-btn">Whitelist</button>
            <div id="stpd-excluded-url-list-box">
                <ul>
                    <?php
                    if (isset($related_articles_settings['setupad_url_exclusions']) && $related_articles_settings['setupad_url_exclusions']) {
                        $urls = explode(',',stripslashes($related_articles_settings['setupad_url_exclusions']));
                        foreach($urls as $url){
                            echo '<div class="stpd-btn-row">';
                            echo    '<li class="stpd-excluded-url">' . esc_attr($url) . '</li>
                                         <button class="stpd-delete-url-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                         </button>';
                            echo '</div>';
                        }
                    } ?>
                </ul>
                <input name="setupad_url_exclusions" type="hidden" value="<?php if(isset($related_articles_settings['setupad_url_exclusions']) && $related_articles_settings['setupad_url_exclusions']) echo $related_articles_settings['setupad_url_exclusions']; else echo ''; ?>">
            </div>
            <div id="stpd-included-url-list-box">
                <ul>
                    <?php
                    if (isset($related_articles_settings['setupad_url_inclusions']) && $related_articles_settings['setupad_url_inclusions']) {
                        $urls = explode(',',stripslashes($related_articles_settings['setupad_url_inclusions']));
                        foreach($urls as $url){
                            echo '<div class="stpd-btn-row">';
                            echo    '<li class="stpd-included-url">' . esc_attr($url) . '</li>
                                        <button class="stpd-delete-url-btn">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                         </button>';
                            echo '</div>';
                        }
                    } ?>
                </ul>
                <input name="setupad_url_inclusions" type="hidden" value="<?php if(isset($related_articles_settings['setupad_url_inclusions']) && $related_articles_settings['setupad_url_inclusions']) echo $related_articles_settings['setupad_url_inclusions']; else echo ''; ?>">
            </div>
        </td>
    </tr>
    </tbody>
</table>


