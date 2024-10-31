<?php
global $wpdb;
$table_name = $wpdb->prefix . 'setupad';

$message_create_ad_units = '';
$notice = '';
// shorthand if for isset can be shortened and replaced with $_POST['field'] ?? '';

if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], 'create-new-ad')) {

    if(sanitize_text_field($_POST['setupad_type']) === 'images') {
        $setupad_image_attributes = [
            'setupad_img_width' => (isset($_POST['setupad_img_width'])) ? sanitize_text_field($_POST['setupad_img_width']) : '',
            'setupad_img_height' => (isset($_POST['setupad_img_height'])) ? sanitize_text_field($_POST['setupad_img_height']) : '',
            'setupad_img_alt' => (isset($_POST['setupad_img_alt'])) ? sanitize_text_field($_POST['setupad_img_alt']) : '',
            'setupad_img_url' => (isset($_POST['setupad_img_url'])) ? sanitize_text_field($_POST['setupad_img_url']) : '',
            'setupad_img_target' => (isset($_POST['setupad_img_target'])) ? sanitize_text_field($_POST['setupad_img_target']) : '',
            'setupad_img_referrerpolicy' => (isset($_POST['setupad_img_referrerpolicy'])) ? sanitize_text_field($_POST['setupad_img_referrerpolicy']) : '',
        ];
        $setupad_image_attributes = json_encode($setupad_image_attributes);
    } else {
        $setupad_image_attributes = null;
    }

    $item = [
        'id' => sanitize_text_field($_POST['id']),
        'setupad_title' => sanitize_text_field($_POST['setupad_title']),
        'setupad_type' => sanitize_text_field($_POST['setupad_type']),
        'setupad_content' => (isset($_POST['setupad_content'])) ? sanitize_text_field($_POST['setupad_content']) : '',
        'setupad_content_elements' => (isset($_POST['setupad_content_elements'])) ? sanitize_text_field($_POST['setupad_content_elements']) : '',
        'setupad_double_banner_1' => (isset($_POST['setupad_double_banner_1'])) ? sanitize_text_field($_POST['setupad_double_banner_1']) : '',
        'setupad_double_banner_1_elements' => (isset($_POST['setupad_double_banner_1_elements'])) ? sanitize_text_field($_POST['setupad_double_banner_1_elements']) : '',
        'setupad_double_banner_2' => (isset($_POST['setupad_double_banner_2'])) ? sanitize_text_field($_POST['setupad_double_banner_2']) : '',
        'setupad_double_banner_2_elements' => (isset($_POST['setupad_double_banner_2_elements'])) ? sanitize_text_field($_POST['setupad_double_banner_2_elements']) : '',
        'setupad_image_url' => (isset($_POST['setupad_image_url'])) ? sanitize_url($_POST['setupad_image_url']) : null,
        'setupad_image_attributes' => $setupad_image_attributes,
        'setupad_shortcode_content' => (isset($_POST['setupad_shortcode_content'])) ? sanitize_text_field($_POST['setupad_shortcode_content']) : '',
        'setupad_insertion_pages' => (isset($_POST['setupad_insertion_pages'])) ? sanitize_text_field($_POST['setupad_insertion_pages']) : '',
        'setupad_position' => sanitize_text_field($_POST['setupad_position']),
        'setupad_block_position' => (isset($_POST['setupad_block_position'])) ? sanitize_text_field($_POST['setupad_block_position']) : '',
        'setupad_starting_position' => (isset($_POST['setupad_starting_position']) ? sanitize_text_field($_POST['setupad_starting_position']) : 0),
        'setupad_multiple_block_position' => (isset($_POST['setupad_multiple_block_position'])) ? sanitize_text_field($_POST['setupad_multiple_block_position']) : false,
        'setupad_device_selection' => sanitize_text_field($_POST['setupad_device_selection']),
        'setupad_contents_alignment' => (isset($_POST['setupad_contents_alignment'])) ? sanitize_text_field($_POST['setupad_contents_alignment']) : '',
        'setupad_alignment_css' => (isset($_POST['setupad_alignment_css'])) ? sanitize_text_field($_POST['setupad_alignment_css']) : '',
        'setupad_lazy_loading' => (isset($_POST['setupad_lazy_loading'])) ? rest_sanitize_boolean($_POST['setupad_title']) : false,
        'setupad_url_exclusions' => (isset($_POST['setupad_url_exclusions'])) ? sanitize_text_field($_POST['setupad_url_exclusions']) : '',
        'setupad_url_inclusions' => (isset($_POST['setupad_url_inclusions'])) ? sanitize_text_field($_POST['setupad_url_inclusions']) : '',
        'setupad_inside_html_type'=> (isset($_POST['setupad_inside_html_type']) ? sanitize_text_field($_POST['setupad_inside_html_type']) : ''),
        'setupad_timeout_delay' => (isset($_POST['setupad_timeout_delay']) ? sanitize_text_field($_POST['setupad_timeout_delay']) : null),
        'setupad_wait_for_element' => (isset($_POST['setupad_wait_for_element']) ? sanitize_text_field($_POST['setupad_wait_for_element']) : '')
    ];

    // Handle sanitization
    if ($item['setupad_content_elements'] && isset($_POST['setupad_content'])) {
        $item['setupad_content'] = wp_kses(str_replace(['<', '>'], ['&lt;', '&gt;'],json_decode(stripcslashes($_POST['setupad_content']))), json_decode(stripcslashes($item['setupad_content_elements']), true));
        $item['setupad_content'] = html_entity_decode($item['setupad_content']);
    }
    if ($item['setupad_double_banner_1_elements'] && isset($_POST['setupad_double_banner_1'])) {
        $item['setupad_double_banner_1'] = wp_kses(str_replace(['<', '>'], ['&lt;', '&gt;'],json_decode(stripcslashes($_POST['setupad_double_banner_1']))), json_decode(stripcslashes($item['setupad_double_banner_1_elements']), true));
        $item['setupad_double_banner_1'] = html_entity_decode($item['setupad_double_banner_1']);
    }
    if ($item['setupad_double_banner_2_elements'] && isset($_POST['setupad_double_banner_2'])) {
        $item['setupad_double_banner_2'] = wp_kses(str_replace(['<', '>'], ['&lt;', '&gt;'],json_decode(stripcslashes($_POST['setupad_double_banner_2']))), json_decode(stripcslashes($item['setupad_double_banner_2_elements']), true));
        $item['setupad_double_banner_2'] = html_entity_decode($item['setupad_double_banner_2']);
    }

    // URL filter out empty spaces
    if (!empty($item['setupad_url_exclusions'])){
        $item['setupad_url_exclusions'] = implode(', ', array_filter(array_map('trim', explode(',', $item['setupad_url_exclusions']))));

    }
    if (!empty($item['setupad_url_inclusions']))
        $item['setupad_url_inclusions'] = implode(', ', array_filter(array_map('trim', explode(',', $item['setupad_url_inclusions']))));

    $item_valid = setupad_validate_ad_entries($item);

    if ($item_valid === true) {
        if (isset($_REQUEST['id']) && $_REQUEST['id'] == 0) {
            if (isset($_FILES["setupad_image_url"]) && $_FILES["setupad_image_url"]['size'] > 0) {
                $file_name = $_FILES['setupad_image_url']['name'];
                $filetype = wp_check_filetype($file_name);
                $filename = time() . '.' . $filetype['ext'];
                $upload = wp_upload_bits($filename, null, file_get_contents($_FILES["setupad_image_url"]["tmp_name"]));
                $item['setupad_image_url'] = $upload['url'];
                $item['setupad_image_file_path'] = $upload['file'];
            }
            $item['setupad_creation_date'] = date('Y-m-d H:i:s', current_time('timestamp', 0));

            // Set status active when creating new ad unit
            $item['setupad_status'] = true;

            $result = $wpdb->insert($table_name, $item);
            $Id = $wpdb->insert_id;
            $shortCodeData = ['setupad_shortcode' => "[setupad num=" . $Id . "]"];
            $wpdb->update($table_name, $shortCodeData, array('id' => $Id));
            if ($result) {
                $message_create_ad_units = __('Ad unit was successfully created', 'setupad');
            } else {
                $notice = __('There was an error while creating ad unit', 'setupad');
            }
        } else {

            $existing_ad_item = $wpdb->get_row($wpdb->prepare("SELECT id, 
                                                                    setupad_title, 
                                                                    setupad_type, 
                                                                    setupad_content,
                                                                    setupad_content_elements,
                                                                    setupad_double_banner_1,
                                                                    setupad_double_banner_1_elements,
                                                                    setupad_double_banner_2,
                                                                    setupad_double_banner_2_elements,
                                                                    setupad_image_url,
                                                                    setupad_image_attributes,
                                                                    setupad_shortcode_content,
                                                                    setupad_insertion_pages,
                                                                    setupad_position,
                                                                    setupad_block_position,
                                                                    setupad_starting_position,
                                                                    setupad_multiple_block_position,
                                                                    setupad_device_selection, 
                                                                    setupad_contents_alignment,
                                                                    setupad_alignment_css,
                                                                    setupad_lazy_loading,
                                                                    setupad_url_exclusions,
                                                                    setupad_url_inclusions,
                                                                    setupad_inside_html_type,
                                                                    setupad_timeout_delay,
                                                                    setupad_wait_for_element
                                                                    FROM %5s WHERE id = %d", $table_name, $item['id']), ARRAY_A);


            if($item['setupad_type'] === 'images'){
                if ($_FILES["setupad_image_url"]['size'] > 0) {
                    if (!empty($item['setupad_image_file_path']))
                        wp_delete_file($item['setupad_image_file_path']);

                    $file_name = $_FILES['setupad_image_url']['name'];
                    $filetype = wp_check_filetype($file_name);
                    $filename = $file_name;
                    $upload = wp_upload_bits($filename, null, file_get_contents($_FILES["setupad_image_url"]["tmp_name"]));

                    $item['setupad_image_url'] = $upload['url'];
                    $item['setupad_image_file_path'] = $upload['file'];

                    $existing_file_path = $wpdb->get_var($wpdb->prepare("SELECT setupad_image_file_path FROM %5s WHERE id = %d", $table_name, $item['id']));
                    if (!empty($existing_file_path) && $item['setupad_image_file_path'] !== $existing_file_path){
                        wp_delete_file($existing_file_path);
                    }
                } else {
                    $item['setupad_image_url'] = $existing_ad_item['setupad_image_url'];
                }
            } else {
                $existing_file_path = $wpdb->get_var($wpdb->prepare("SELECT setupad_image_file_path FROM %5s WHERE id = %d", $table_name, $item['id']));
                if (!empty($existing_file_path)) {
                    wp_delete_file($existing_file_path);
                    $item['setupad_image_file_path'] = null;
                }

            }

            if ($item == $existing_ad_item) {
                $result = true;
            } else {
                $item['setupad_creation_date'] = date('Y-m-d H:i:s', current_time('timestamp', 0));

                // Save previous status when updating ad unit
                $item['setupad_status'] = $wpdb->get_var($wpdb->prepare("SELECT setupad_status FROM %5s WHERE id = %d", $table_name, $item['id']));

                $result = $wpdb->update($table_name, $item, array('id' => $item['id']), null, array('%d'));
            }

            if ($result) {
                $message_create_ad_units = __('Ad unit was succesfully updated', 'setupad');
            } else {
                $notice = __('There was an error while updating ad unit', 'setupad');
            }
        }
    } else {
        // if $item_valid not true it contains error message(s)
        $notice = $item_valid;
    }
}

function setupad_validate_ad_entries($item)
{
    $messages = array();

    if (empty($item['setupad_title'])) $messages[] = __('Ad Title is required. Ad placement was not created.', 'setupad');
    if (empty($item['setupad_type'])) $messages[] = __('Ad Type is required. Ad placement was not created.', 'setupad');
    if (empty($item['setupad_position'])) $messages[] = __('Ad Position is required. Ad placement was not created.', 'setupad');
    if (!isset($item['setupad_device_selection'])) $messages[] = __('Device selection is required. Ad placement was not created.', 'setupad');

    if (isset($item['setupad_title']) && strlen($item['setupad_title']) >= 500) $messages[] = __('Ad placement title is too long!');
    if (isset($item['setupad_type']) && strlen($item['setupad_type']) >= 100) $messages[] = __('Ad placement type is too long!');
    if (isset($item['setupad_content']) && strlen($item['setupad_content']) >= 2147483647) $messages[] = __('Ad placement content is too long!');
    if (isset($item['setupad_content_elements']) && strlen($item['setupad_content_elements']) >= 2147483647) $messages[] = __('Content elements field is too long!');
    if (isset($item['setupad_double_banner_1']) && strlen($item['setupad_double_banner_1']) >= 2147483647) $messages[] = __('1st ad placement content is too long!');
    if (isset($item['setupad_double_banner_1_elements']) && strlen($item['setupad_double_banner_1_elements']) >= 2147483647) $messages[] = __('1st content elements field is too long!');
    if (isset($item['setupad_double_banner_2']) && strlen($item['setupad_double_banner_2']) >= 2147483647) $messages[] = __('2nd ad placement content is too long!');
    if (isset($item['setupad_double_banner_2_elements']) && strlen($item['setupad_double_banner_2_elements']) >= 2147483647) $messages[] = __('2nd content elements field is too long!');
    if (isset($item['setupad_image_file_path']) && strlen($item['setupad_image_file_path']) >= 2147483647) $messages[] = __('Image file path is too long!');
    if (isset($item['setupad_alignment_css']) && strlen($item['setupad_alignment_css']) >= 500) $messages[] = __('Ad placement type is too long!');
    if (!empty($item['setupad_url_exclusions']) && strlen($item['setupad_url_exclusions']) >= 16777215) $messages[] = __('URL exclusions field is too long!');
    if (!empty($item['setupad_url_inclusions']) && strlen($item['setupad_url_inclusions']) >= 16777215) $messages[] = __('URL inclusions field is too long!');

    if ($item['setupad_position'] !== 'before_html' && $item['setupad_position'] !== 'after_html' && $item['setupad_position'] !== 'inside_html'){
        if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position'] <= 0 && $item['setupad_multiple_block_position'] !== false) $messages[] = __('Nth position can not be empty or negative.', 'setupad');
        if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position'] != null && !is_numeric($item['setupad_multiple_block_position'])) $messages[] = __('Every nth position must be a whole number!', 'setupad');
        if (isset($item['setupad_multiple_block_position']) && intval($item['setupad_multiple_block_position']) > 255 ) $messages[] = __('Nth position number is too large!', 'setupad');
        if (isset($item['setupad_block_position']) && strlen($item['setupad_block_position']) > 50) $messages[] = __('Too many insertion position numbers selected!', 'setupad');
    }
    if (isset($item['setupad_starting_position']) && $item['setupad_starting_position'] != null &&!is_numeric($item['setupad_starting_position'])) $messages[] = __('Insertion starting position must be a whole number!', 'setupad');
    if (isset($item['setupad_starting_position']) && $item['setupad_starting_position'] < 0 && is_numeric($item['setupad_starting_position'])) $messages[] = __('Insertion starting position cannot be negative!', 'setupad');
    if (isset($item['setupad_starting_position']) && $item['setupad_starting_position'] > 65535 && is_numeric($item['setupad_starting_position'])) $messages[] = __('Insertion starting position is too long!', 'setupad');
    if (isset($item['setupad_timeout_delay']) && $item['setupad_timeout_delay'] != null && !is_numeric($item['setupad_timeout_delay'])) $messages[] = __('Ad placement insertion delay must be a whole number!', 'setupad');
    if (isset($item['setupad_timeout_delay']) && $item['setupad_timeout_delay'] < 0 && is_numeric($item['setupad_timeout_delay'])) $messages[] = __('Ad placement insertion delay cannot be a negative number!', 'setupad');
    if (isset($item['setupad_timeout_delay']) && $item['setupad_timeout_delay'] > 100000 && is_numeric($item['setupad_timeout_delay'])) $messages[] = __('Ad placement insertion delay cannot be above 100000 ms!', 'setupad');

    if (empty($messages)) return true;

    return implode(PHP_EOL, $messages);

}