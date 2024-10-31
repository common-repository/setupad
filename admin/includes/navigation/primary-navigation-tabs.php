<?php

function setupad_navigation_menu($page = "none"){ ?>
    <?php
    $adListCss = 'background-color: transparent;';
    $relatedPostCss = 'background-color: transparent;';
    $adsTxtCss = 'background-color: transparent;';
    $headerFooterCss = 'background-color: transparent;';
    $settingsCss = 'background-color: transparent;';

    if ($page === 'ad-list') {
        $adListCss = 'background-color: rgba(41, 176, 189, 0.1);';
    } else if($page === 'related-posts') {
        $relatedPostCss = 'background-color: rgba(41, 176, 189, 0.1);';
    } else if ($page === 'ads-txt'){
        $adsTxtCss = 'background-color: rgba(41, 176, 189, 0.1);';
    } else if ($page === 'header-footer') {
        $headerFooterCss = 'background-color: rgba(41, 176, 189, 0.1);';
    } else if ($page === 'settings') {
        $settingsCss = 'background-color: rgba(41, 176, 189, 0.1);';
    }
    ?>
    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
    <div class="header-logo">
        <div>
            <img src="<?php echo esc_url((SETUPAD_BASE_URL .'admin/assets/images/setupad-full-logo.svg')) ?>" height="30px" />
            <div>
                <?php _e('Earn more money from ads on your website.', 'setupad'); ?>
                <a href="<?php echo esc_url('https://setupad.com/?utm_source=' . $_SERVER['HTTP_HOST'] . '&utm_medium=WP_Plugin&utm_campaign=promo') ?>" rel="noopener nofollow" target="_blank"> <?php _e('Learn more.', 'setupad'); ?></a>
            </div>
        </div>
    </div>
    <div class="tabs">
        <a class="all-ads" style="<?php echo esc_attr($adListCss) ?>" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=setupad')) ?>"><?php _e('My Ads', 'setupad')?></a>
        <a class="related-posts" style="<?php echo esc_attr($relatedPostCss) ?>" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=stpd-related-posts')) ?>"><?php _e('Related Posts', 'setupad')?></a>
        <a class="stpd-ads-txt" style="<?php echo esc_attr($adsTxtCss) ?>" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=stpd-ads_txt')) ?>"><?php _e('Ads.txt', 'setupad')?></a>
        <a class="header-footer-scripts" style="<?php echo esc_attr($headerFooterCss) ?>" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=stpd-header-footer')) ?>"><?php _e('Header/Footer', 'setupad')?></a>
        <a class="stpd-settings" style="<?php echo esc_attr($settingsCss) ?>" href="<?php echo esc_url(get_admin_url(get_current_blog_id(), 'admin.php?page=stpd-settings')) ?>"><?php _e('Settings', 'setupad')?></a>
    </div>
    <?php
}
