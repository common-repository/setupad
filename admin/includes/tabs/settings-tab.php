<?php

function setupad_settings_tab (){

    include_once(SETUPAD_BASE_PATH . 'admin/includes/database/create-update-settings.php'); // DB operations and data setup

    ?>
    <div class="wrap">
        <?php setupad_navigation_menu('settings'); ?>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo esc_html($notice) ?></p></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo esc_html($message) ?></p></div>
        <?php endif; ?>

        <div class="stpd-tab-contents settings-contents">
            <form id="form" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('settings-tab-form')) ?>"/>

                <div id="post-body">
                    <div id="post-body-content">
                        <?php include_once(SETUPAD_BASE_PATH . 'admin/includes/forms/setupad-settings-form.php'); ?>
                        <div class="stpd-btn-row">
                            <input type="submit" value="<?php _e('Save settings', 'setupad') ?>" id="submit"
                                   class="stpd-save-btn">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php
}