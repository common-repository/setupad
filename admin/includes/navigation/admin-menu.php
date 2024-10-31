<?php

function setupad_admin_menu()
{
    global $submenu;

    add_menu_page(__('Setupad', 'setupad'), __('Setupad', 'setupad'), 'activate_plugins', 'setupad', 'setupad_my_ads_tab', 'data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNiIgaGVpZ2h0PSIxNiIgZmlsbD0iIzljYTFhOCI+CiAgICA8cGF0aCBzdHlsZT0ic3Ryb2tlOm5vbmU7ZmlsbC1ydWxlOmV2ZW5vZGQ7ZmlsbC1vcGFjaXR5OjEiIGQ9Ik04LjY3NiA2LjkwNmMuMDA0IDAgMi4yMzggNi4wNjcgMy4zODYgOS4wOWgyLjc0M2MuNzg1IDAgMS4zNTEtLjc0MiAxLjE0NC0xLjQ5Ni0xLjczLTQuMzc1LTUuMjI2LTEzLjExMy01LjIyNi0xMy4xMTcgMCAuMDA0LTIuMDQzIDUuNTIzLTIuMDQ3IDUuNTIzWk01LjgwNS4wMDhDMy44OTUgNC44NCAxLjk2NSA5LjY2OC4wNSAxNC41Yy0uMjExLjc1NC4zNiAxLjQ5NiAxLjE0NCAxLjQ5NkgzLjkzQzUuMjY2IDEyLjUyMyA5LjM4NyAxLjg2NyAxMC4wOTguMDA4Wm0wIDAiLz4KPC9zdmc+Cg==', 26);
    add_submenu_page('setupad', __('Add New', 'setupad'), __('Add New', 'setupad'), 'activate_plugins', 'stpd-new_ad', 'setupad_create_ad_unit_tab');
    add_submenu_page('setupad', __('Related Posts', 'setupad'), __('Related Posts', 'setupad'), 'activate_plugins', 'stpd-related-posts', 'setupad_related_posts_tab');
    add_submenu_page('setupad', __('Ads.txt', 'setupad'), __('Ads.txt', 'setupad'), 'activate_plugins', 'stpd-ads_txt', 'setupad_ads_txt_tab');
    add_submenu_page('setupad', __('Header/Footer', 'setupad'), __('Header/Footer', 'setupad'), 'activate_plugins', 'stpd-header-footer', 'setupad_header_footer_tab');
    add_submenu_page('setupad', __('Settings', 'setupad'), __('Settings', 'setupad'), 'activate_plugins', 'stpd-settings', 'setupad_settings_tab');
    add_submenu_page('setupad', __('Documentation', 'setupad'), __('Documentation', 'setupad'), 'activate_plugins', 'https://setupad.github.io/Setupad-WP-Plugin-Documentation');

    $submenu['setupad'][0][0] = __('My Ads', 'setupad');

    wp_register_script( 'setupad-documentation', '', [], '', true );
    wp_enqueue_script( 'setupad-documentation');
    wp_add_inline_script( 'setupad-documentation', 'jQuery(\'a[href="https://setupad.github.io/Setupad-WP-Plugin-Documentation"]\').attr(\'target\', \'_blank\').attr(\'rel\', \'noopener noreferrer\');' );

}

add_action('admin_menu', 'setupad_admin_menu');
