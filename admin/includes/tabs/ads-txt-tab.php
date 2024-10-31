<?php

function setupad_ads_txt_tab()
{
    global $wpdb;
    $message = '';
    $adstxt_table_name = $wpdb->prefix . 'setupad_ads_txt';
    $errors    = [];
    $save_adstxt_anyway = false;

    if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        $setupad_ads_txt = stripslashes_deep(sanitize_textarea_field($_POST['adstxt']));

        if (isset($_POST['save_adstxt'])) {
            $save_adstxt_anyway = true;
        }

        $lines     = preg_split( '/\r\n|\r|\n/', $setupad_ads_txt );
        $sanitized = [];

        foreach ( $lines as $i => $line ) {
            $line_number = $i + 1;
            $result      = validate_line( $line, $line_number );

            $sanitized[] = $result['sanitized'];
            if ( ! empty( $result['errors'] ) ) {
                $errors = array_merge( $errors, $result['errors'] );
            }
        }
        $sanitized = implode( PHP_EOL, $sanitized );

        $existing_adstxt = $setupad_ads_txt;

        if (count($errors) === 0 || $save_adstxt_anyway) {
            $ads_txt = $wpdb->get_row($wpdb->prepare( "SELECT * FROM %5s WHERE id = %d", $adstxt_table_name, 1 ));
            if ($ads_txt){
                $result = $wpdb->update($adstxt_table_name, array(
                    'adstxt_value' => $sanitized),
                    array('ID' => 1));
            } else {
                $result = $wpdb->insert($adstxt_table_name, array('id' => 1,
                    'adstxt_value' => $sanitized));
            }

            if ($result) {
                $message = __('Settings have been updated succesfully', 'setupad');
            } else {
                $notice = __('There was an error while updating settings', 'setupad');
            }
        }
    } else {
        $existing_adstxt = $wpdb->get_row($wpdb->prepare( "SELECT * FROM %5s WHERE id = %d", $adstxt_table_name, 1 ));
        if ($existing_adstxt) {
            $existing_adstxt = $existing_adstxt->adstxt_value;
        }
    }
    ?>
    <div class="wrap">
        <?php setupad_navigation_menu('ads-txt'); ?>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo esc_html($notice) ?></p></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo esc_html($message) ?></p></div>
        <?php endif; ?>

        <div class="stpd-tab-contents">
            <form id="form" class="ads-txt-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce(basename(__FILE__))) ?>"/>

                <div class="info-section">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                    </svg>
                    <p><?php _e('Ads.txt is a public file that declares who is authorized to sell the publishers\' inventory. The purpose of the ads.txt file is to ensure that publishers\' ad inventory is only sold through authorized channels, and that they are paid the correct amount for their inventory. Ads.txt also helps to prevent fraud, such as domain spoofing.','setupad'); ?></p>
                </div>

                <?php if(isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__)) && count($errors) !== 0 && !$save_adstxt_anyway) { ?>
                    <div id="adstxt-notices">
                        <span><?php _e('Your ads.txt has following problems:', 'setupad'); ?></span>
                        <?php foreach ($errors as $error){ ?>
                            <p><?php echo ("Line " . esc_html($error['line']) . ': ' . esc_html($error['type'])); ?></p>
                        <?php } ?>
                    </div>
                <?php } ?>

                <div id="cEditor">
                    <textarea id='lineCounter' wrap='off' readonly oninput='this.style.width = "";this.style.width = this.scrollWidth + "px"'>1.</textarea>
                    <textarea id='codeEditor' wrap='off' name="adstxt" spellcheck='false'><?php if ($existing_adstxt) echo esc_textarea($existing_adstxt)?></textarea>
                </div>

                <?php if(isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__)) && count($errors) !== 0 && !$save_adstxt_anyway) { ?>
                    <div class="update-adstxt-anyway">
                        <label><?php _e('Update ads.txt anyway?', 'setupad'); ?></label>
                        <input type="checkbox" value="1" name="save_adstxt">
                    </div>
                <?php } ?>

                <?php if (is_subdirectory()): ?>
                    <p style="color: red;"><?php _e('Ads.txt cannot be created because you have a subdirectory wordpress installation.', 'setupad'); ?></p>
                    <input type="submit" value="<?php _e('Save ads.txt', 'setupad') ?>" id="submit" class="stpd-save-btn" name="submit" disabled>
                <?php else: ?>
                    <input type="submit" value="<?php _e('Save ads.txt', 'setupad ') ?>" id="submit" class="stpd-save-btn" name="submit">
                <?php endif; ?>
            </form>
        </div>
    </div>

    <script>
        var codeEditor = document.getElementById('codeEditor');
        var lineCounter = document.getElementById('lineCounter');

        codeEditor.addEventListener('scroll', () => {
            lineCounter.scrollTop = codeEditor.scrollTop;
            lineCounter.scrollLeft = codeEditor.scrollLeft;
        });

        codeEditor.addEventListener('keydown', (e) => {
            let { keyCode } = e;
            let { value, selectionStart, selectionEnd } = codeEditor;
            if (keyCode === 9) {  // TAB = 9
                e.preventDefault();
                codeEditor.value = value.slice(0, selectionStart) + '\t' + value.slice(selectionEnd);
                codeEditor.setSelectionRange(selectionStart+2, selectionStart+2)
            }
        });

        var lineCountCache = 0;
        function line_counter() {
            var lineCount = codeEditor.value.split('\n').length;
            var outarr = new Array();
            if (lineCountCache != lineCount) {
                for (var x = 0; x < lineCount; x++) {
                    outarr[x] = (x + 1) + '.';
                }
                lineCounter.value = outarr.join('\n');
            }
            lineCountCache = lineCount;

            lineCounter.style.width = "1px";
            lineCounter.style.width = 10 + lineCounter.scrollWidth + "px";
        }
        codeEditor.addEventListener('input', () => {
            line_counter();
        });

        line_counter();
    </script>

    <?php
}

function validate_line( $line, $line_number ) {
    $domain_regex = '/^((?=[a-z0-9-]{1,63}\.)(xn--)?[a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,63}$/i';
    $errors       = array();

    if ( empty( $line ) ) {
        $sanitized = '';
    } elseif ( 0 === strpos( $line, '#' ) ) { // This is a full-line comment.
        $sanitized = wp_strip_all_tags( $line );
    } elseif ( 1 < strpos( $line, '=' ) ) { // This is a variable declaration.
        // The spec currently supports CONTACT, INVENTORYPARTNERDOMAIN and SUBDOMAIN.
        if ( ! preg_match( '/^(CONTACT|SUBDOMAIN|INVENTORYPARTNERDOMAIN|MANAGERDOMAIN|OWNERDOMAIN)=/i', $line ) ) {
            $errors[] = array(
                'line' => $line_number,
                'type' => 'invalid_variable',
            );
        } elseif ( 0 === stripos( $line, 'subdomain=' ) ) { // Subdomains should be, well, subdomains.
            // Disregard any comments.
            $subdomain = explode( '#', $line );
            $subdomain = $subdomain[0];

            $subdomain = explode( '=', $subdomain );
            array_shift( $subdomain );

            // If there's anything other than one piece left something's not right.
            if ( 1 !== count( $subdomain ) || ! preg_match( $domain_regex, $subdomain[0] ) ) {
                $subdomain = implode( '', $subdomain );
                $errors[]  = array(
                    'line'  => $line_number,
                    'type'  => 'invalid_subdomain',
                    'value' => $subdomain,
                );
            }
        }

        $sanitized = wp_strip_all_tags( $line );

        unset( $subdomain );
    } else { // Data records: the most common.
        // Disregard any comments.
        $record = explode( '#', $line );
        $record = $record[0];

        // Record format: example.exchange.com,pub-id123456789,RESELLER|DIRECT,tagidhash123(optional).
        $fields = explode( ',', $record );

        if ( 3 <= count( $fields ) ) {
            $exchange     = trim( $fields[0] );
            $pub_id       = trim( $fields[1] );
            $account_type = trim( $fields[2] );

            if ( ! preg_match( $domain_regex, $exchange ) ) {
                $errors[] = array(
                    'line'  => $line_number,
                    'type'  => 'invalid_exchange',
                    'value' => $exchange,
                );
            }

            if ( ! preg_match( '/^(RESELLER|DIRECT)$/i', $account_type ) ) {
                $errors[] = array(
                    'line' => $line_number,
                    'type' => 'invalid_account_type',
                );
            }

            if ( isset( $fields[3] ) ) {
                $tag_id = trim( $fields[3] );

                // TAG-IDs appear to be 16 character hashes.
                // TAG-IDs are meant to be checked against their DB - perhaps good for a service or the future.
                if ( ! empty( $tag_id ) && ! preg_match( '/^[a-f0-9]{16}$/', $tag_id ) ) {
                    $errors[] = array(
                        'line'  => $line_number,
                        'type'  => 'invalid_tagid',
                        'value' => $fields[3],
                    );
                }
            }

            $sanitized = wp_strip_all_tags( $line );
        } else {
            // Not a comment, variable declaration, or data record; therefore, invalid.
            // Early on we commented the line out for safety but it's kind of a weird thing to do with a JS AYS.
            $sanitized = wp_strip_all_tags( $line );

            $errors[] = array(
                'line' => $line_number,
                'type' => 'invalid_record',
            );
        }

        unset( $record, $fields );
    }

    return array(
        'sanitized' => $sanitized,
        'errors'    => $errors,
    );
}

function is_subdirectory( $url = null ) {
    $url = $url ? $url : home_url( '/' );

    $parsed_url = wp_parse_url( $url );
    if ( ! empty( $parsed_url['path'] ) && '/' !== $parsed_url['path'] ) {
        return true;
    }
    return false;
}