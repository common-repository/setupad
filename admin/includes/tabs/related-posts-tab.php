<?php

function setupad_related_posts_tab()
{
    include_once(SETUPAD_BASE_PATH . 'admin/includes/database/create-update-related-posts.php'); // DB operations and data setup
    ?>

    <div class="wrap">
        <?php setupad_navigation_menu('related-posts'); ?>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo esc_html($notice) ?></p></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo esc_html($message) ?></p></div>
        <?php endif; ?>

        <div class="stpd-tab-contents related-posts-contents">
            <form id="form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('related-posts-form')) ?>"/>

                <div id="desktop-mobile-selectors" class="info-section" style="display:none;">
                    <button id="desktop-rp-btn" type="button">Desktop</button>
                    <button id="mobile-rp-btn" type="button">Mobile</button>
                </div>

                <div id="post-body">
                    <div id="post-body-content">
                        <?php include_once(SETUPAD_BASE_PATH . 'admin/includes/forms/setupad-related-posts-form.php'); ?>
                        <?php include_once(SETUPAD_BASE_PATH . 'admin/includes/forms/setupad-related-posts-mobile-form.php'); ?>
                        <div class="stpd-btn-row">
                            <input type="submit" value="<?php _e('Save settings', 'setupad') ?>" id="submit"
                                   class="stpd-save-btn">
                            <button id="related-preview-btn"><?php _e('Preview desktop', 'setupad'); ?></button>
                            <button id="related-mobile-preview-btn"><?php _e('Preview mobile', 'setupad'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
}

add_action( 'wp_ajax_return_related_preview', 'return_related_preview' );
function return_related_preview() {
    check_ajax_referer('setupad-related-posts-ajax', 'security');
    $return_data = null;

    include(SETUPAD_BASE_PATH . 'admin/includes/forms/setupad-related-posts-preview-form.php');

    echo $return_data;
    wp_die();
}