<?php

function setupad_create_ad_unit_tab(){
    global $wpdb;
    $table_name = $wpdb->prefix . 'setupad';

    $message = '';
    $notice = '';

    // This is default $item which will be used for new records
    $item = array(
        'id' => 0,
        'setupad_title' => '',
        'setupad_type' => '',
        'setupad_content' => null,
        'setupad_image_url' => null,
        'setupad_img_width' => '',
        'setupad_img_height' => '',
        'setupad_img_alt' => '',
        'setupad_img_url' => '',
        'setupad_img_target' => '',
        'setupad_img_referrerpolicy' => '',
        'setupad_insertion_pages' => 'post_page',
        'setupad_position' => '',
        'setupad_block_position' => '',
        'setupad_starting_position' => '',
        'setupad_multiple_block_position' => '',
        'setupad_device_selection' => '',
        'setupad_contents_alignment' => 0,
        'setupad_alignment_css' => '',
        'setupad_lazy_loading' => 'false',
        'setupad_url_exclusions' => '',
        'setupad_url_inclusions' => '',
        'setupad_inside_html_type' => '',
    );
    if (isset($_REQUEST['id'])) {
        $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE id = %d", $table_name, sanitize_text_field($_REQUEST['id'])), ARRAY_A);

        if (isset($item['setupad_image_attributes'])){
            $setupad_image_attributes = json_decode(stripcslashes($item['setupad_image_attributes']));

            $item['setupad_img_width'] = property_exists($setupad_image_attributes, 'setupad_img_width') ? $setupad_image_attributes->setupad_img_width : '';
            $item['setupad_img_height'] = property_exists($setupad_image_attributes, 'setupad_img_height') ? $setupad_image_attributes->setupad_img_height : '';
            $item['setupad_img_alt'] = property_exists($setupad_image_attributes, 'setupad_img_alt') ? $setupad_image_attributes->setupad_img_alt : '';
            $item['setupad_img_url'] = property_exists($setupad_image_attributes, 'setupad_img_url') ? $setupad_image_attributes->setupad_img_url : '';
            $item['setupad_img_target'] = property_exists($setupad_image_attributes, 'setupad_img_target') ? $setupad_image_attributes->setupad_img_target : '';
            $item['setupad_img_referrerpolicy'] = property_exists($setupad_image_attributes, 'setupad_img_referrerpolicy') ? $setupad_image_attributes->setupad_img_referrerpolicy : '';
        }

        if (!$item) {
            $notice = __('Item not found', 'setupad');
        }
    }

    ?>
    <div class="wrap">
        <?php
        if (isset($_REQUEST['id'])) {
            setupad_navigation_menu();
        } else {
            setupad_navigation_menu('add-new');
        }
        ?>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo esc_html($notice) ?></p></div>
        <?php endif;?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo esc_html($message) ?></p></div>
        <?php endif;?>

        <div class="stpd-tab-contents create-ad-unit-contents">
            <form id="form" action="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=setupad'));?>" AutoComplete=off method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('create-new-ad')) ?>"/>

                <input type="hidden" name="id" value="<?php echo esc_attr($item['id']) ?>"/>

                <div id="post-body">
                    <div>
                        <?php include_once(SETUPAD_BASE_PATH . 'admin/includes/forms/setupad-create-ad-unit-form.php'); ?>
                        <a href="<?php echo esc_url('https://setupad.com/setupad-prebid-self-serve/?utm_source=' . $_SERVER['HTTP_HOST'] . '&utm_medium=banner&utm_campaign=setupad-prebid-self-serve') ?>" target="_blank" referrerpolicy="noopener nofollow">
                            <img src="<?php echo esc_url((SETUPAD_BASE_URL .'admin/assets/images/setupad-self-serve.png')) ?>" width="300" height="600" alt="Try Setupad Prebid Self-Serve!">
                        </a>
                    </div>
                    <div class="stpd-btn-row">
                        <input type="submit" value="<?php _e('Save ad placement', 'setupad')?>" id="submit" class="stpd-save-btn">
                        <?php if (isset($item['id']) && $item['id']): ?>
                            <a href="<?php echo esc_url('?page=setupad&action=delete&id=' . $item["id"]) ?>"class="stpd-delete-btn"><?php _e('Delete ad placement', 'setupad') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
}
