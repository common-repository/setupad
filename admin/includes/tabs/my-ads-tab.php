<?php

function setupad_my_ads_tab() {

    include(SETUPAD_BASE_PATH . 'admin/includes/database/create-update-ad-unit.php');

    $table = new Setupad_List_Table();
    $table->prepare_items();

    $message = '';

    if ('delete' === $table->current_action() && isset($_REQUEST['id'])) {
        $countIds= is_array($_REQUEST['id'])? count($_REQUEST['id']):1;
        $message = sprintf(__('Items deleted: %d', 'setupad'), $countIds);
    }
    else if ('duplicate' === $table->current_action() && isset($_REQUEST['id'])) {
        $countIds= is_array($_REQUEST['id'])? count($_REQUEST['id']):1;
        $message = sprintf(__('Items duplicated: %d', 'setupad'), $countIds);
    }
    ?>
    <div class="wrap">
        <?php setupad_navigation_menu('ad-list'); ?>
        <?php if ($message) {
          echo  '<div class="updated below-h2" id="message"><p>' . esc_html($message) . '</p></div>';
        } ?>
        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo esc_html($notice) ?></p></div>
        <?php endif;?>
        <?php if (!empty($message_create_ad_units)): ?>
            <div id="message" class="updated"><p><?php echo esc_html($message_create_ad_units) ?></p></div>
        <?php endif;?>

        <div class="stpd-tab-contents">
            <form id="setupads-table" method="GET">
                <input type="hidden" name="page" value="<?php echo esc_attr($_REQUEST['page']) ?>"/>
                <?php $table->display() ?>
            </form>
        </div>
    </div>

<?php
}

add_action( 'wp_ajax_update_ad_status', 'update_ad_status' );
function update_ad_status() {
    check_ajax_referer('setupad-my-ads-tab-ajax', 'security');

    global $wpdb;
    $table_name = $wpdb->prefix . 'setupad';
    $adID = absint($_POST['adID']);
    $query = $wpdb->prepare("SELECT setupad_status FROM $table_name WHERE id = %s", $adID);
    $ad_status = $wpdb->get_var($query);
    if ($ad_status === '1'){
        $return_data = '<button data-id="'.$adID.'" class="stpd-ad-status stpd-ad-status-disabled">Disabled</button>';
        $wpdb->update($table_name, array('setupad_status' => false), array('id' => $adID));
    } else if ($ad_status === '0'){
        $return_data = '<button data-id="'.$adID.'" class="stpd-ad-status stpd-ad-status-active">Active</button>';
        $wpdb->update($table_name, array('setupad_status' => true), array('id' => $adID));
    } else {
        return;
    }

    echo $return_data;

    wp_reset_postdata();
    wp_die();
}

