<?php

function setupad_header_footer_tab () {
    global $wpdb;
    $message = '';
    $errors = [];
    $settings_table_name = $wpdb->prefix . 'setupad_settings';
    $last_tab = isset($_COOKIE['last_tab']) ? $_COOKIE['last_tab'] : 'header';
    if ($last_tab == 'footer'): ?>
        <style>
            #header-scripts{
                display:none;
            }
            #header-script-btn{
                border-bottom: none;
            }
            #footer-script-btn{
                border-bottom: solid 2px #0497A5;
            }
            #footer-scripts{
                display:block;
            }
        </style>
    <?php endif;

    if (isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        $setupad_content = [
            'setupad_header_elements' => (isset($_POST['setupad_header_elements'])) ? sanitize_text_field($_POST['setupad_header_elements']) : '',
            'setupad_footer_elements' => (isset($_POST['setupad_footer_elements'])) ? sanitize_text_field($_POST['setupad_footer_elements']) : ''
        ];

        if ($setupad_content['setupad_header_elements'] && isset($_POST['setupad_header_elements'])) {
            $setupad_content['setupad_header_content'] = wp_kses(str_replace(['<', '>'], ['&lt;', '&gt;'],json_decode(stripcslashes($_POST['setupad_header_content']))), json_decode(stripcslashes($setupad_content['setupad_header_elements']), true));
            $setupad_content['setupad_header_content'] = html_entity_decode($setupad_content['setupad_header_content']);
        } else {
            $setupad_content['setupad_header_content'] = '';
        }

        if ($setupad_content['setupad_footer_elements'] && isset($_POST['setupad_footer_elements'])) {
            $setupad_content['setupad_footer_content'] = wp_kses(str_replace(['<', '>'], ['&lt;', '&gt;'],json_decode(stripcslashes($_POST['setupad_footer_content']))), json_decode(stripcslashes($setupad_content['setupad_footer_elements']), true));
            $setupad_content['setupad_footer_content'] = html_entity_decode($setupad_content['setupad_footer_content']);
        } else {
            $setupad_content['setupad_footer_content'] = '';
        }

        $header_content_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'setupad_header_content'", $settings_table_name), ARRAY_A);
        $footer_content_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'setupad_footer_content'", $settings_table_name), ARRAY_A);
        $header_elements_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'setupad_header_elements'", $settings_table_name), ARRAY_A);
        $footer_elements_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'setupad_footer_elements'", $settings_table_name), ARRAY_A);

        if (isset($header_content_db) && $setupad_content['setupad_header_content'] == $header_content_db['setting_value']) {
            array_push($errors, 1);
        } else {
            if ($header_content_db){
                array_push($errors, $wpdb->update($settings_table_name, array('setting_name' => 'setupad_header_content',
                    'setting_value' => $setupad_content['setupad_header_content']),
                    array('ID' => $header_content_db['id'])));
            } else {
                array_push($errors, $wpdb->insert($settings_table_name, array('setting_name' => 'setupad_header_content',
                    'setting_value' => $setupad_content['setupad_header_content'])));
            }
        }
        if (isset($header_elements_db) && $setupad_content['setupad_header_elements'] == $header_elements_db['setting_value']) {
            array_push($errors, 1);
        } else {
            if ($header_elements_db){
                array_push($errors, $wpdb->update($settings_table_name, array('setting_name' => 'setupad_header_elements',
                    'setting_value' => $setupad_content['setupad_header_elements']),
                    array('ID' => $header_elements_db['id'])));
            } else {
                array_push($errors, $wpdb->insert($settings_table_name, array('setting_name' => 'setupad_header_elements',
                    'setting_value' => $setupad_content['setupad_header_elements'])));
            }
        }

        if (isset($footer_content_db) && $setupad_content['setupad_footer_content'] == $footer_content_db['setting_value']) {
            array_push($errors, 1);
        } else {
            if ($footer_content_db){
                array_push($errors, $wpdb->update($settings_table_name, array('setting_name' => 'setupad_footer_content',
                    'setting_value' => $setupad_content['setupad_footer_content']),
                    array('ID' => $footer_content_db['id'])));
            } else {
                array_push($errors, $wpdb->insert($settings_table_name, array('setting_name' => 'setupad_footer_content',
                    'setting_value' => $setupad_content['setupad_footer_content'])));
            }
        }
        if (isset($footer_elements_db) && $setupad_content['setupad_footer_elements'] == $footer_elements_db['setting_value']) {
            array_push($errors, 1);
        } else {
            if ($footer_elements_db) {
                array_push($errors, $wpdb->update($settings_table_name, array('setting_name' => 'setupad_footer_elements',
                    'setting_value' => $setupad_content['setupad_footer_elements']),
                    array('ID' => $footer_elements_db['id'])));
            } else {
                array_push($errors, $wpdb->insert($settings_table_name, array('setting_name' => 'setupad_footer_elements',
                    'setting_value' => $setupad_content['setupad_footer_elements'])));
            }
        }

        if (in_array(0,$errors)) {
            $notice = __('There was an error while updating settings', 'setupad');
        } else {
            $message = __('Settings have been updated succesfully', 'setupad');
        }

        $header_content_db['setting_value'] = $setupad_content['setupad_header_content'];
        $footer_content_db['setting_value'] = $setupad_content['setupad_footer_content'];
    } else {
        // If settings already exist we populate fields with them if not we update database with default settings and use those
        $header_content_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'setupad_header_content'", $settings_table_name), ARRAY_A);
        $footer_content_db = $wpdb->get_row($wpdb->prepare("SELECT * FROM %5s WHERE setting_name = 'setupad_footer_content'", $settings_table_name), ARRAY_A);
    }

    ?>
    <div class="wrap">
        <?php setupad_navigation_menu('header-footer'); ?>

        <?php if (!empty($notice)): ?>
            <div id="notice" class="error"><p><?php echo esc_html($notice) ?></p></div>
        <?php endif; ?>
        <?php if (!empty($message)): ?>
            <div id="message" class="updated"><p><?php echo esc_html($message) ?></p></div>
        <?php endif; ?>

        <div class="stpd-tab-contents">
            <form id="form" class="header-footer-form" method="post" enctype="multipart/form-data">
                <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce(basename(__FILE__))) ?>"/>

                <div class="info-section">
                    <button id="header-script-btn" type="button">Header</button>
                    <button id="footer-script-btn" type="button">Footer</button>
                </div>

                <div id="header-scripts">
                    <div class="header-footer-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                        </svg>
                        <p><?php _e('Code will be inserted in the', 'setupad'); ?> <b>&#60;head&#62;&#60;/head&#62;</b> <?php _e('section of all HTML pages', 'setupad'); ?></p>
                    </div>

                    <div style="max-width: 600px;position: relative; height: 300px;">
                        <div id="header-editor" class="editor"></div>
                        <textarea id="editor-text-header" style="display: none;"><?php
                            if (isset($header_content_db['setting_value']) && $header_content_db['setting_value']) {
                                print $header_content_db['setting_value'];
                            }
                            ?>
                        </textarea>
                        <input name="setupad_header_content" type="hidden" id="header-editortext">
                        <input name="setupad_header_elements" type="hidden" id="content_elements_header">
                    </div>
                    <script>
                        var HeaderEditor = ace.edit("header-editor");
                        HeaderEditor.renderer.setShowGutter(false);
                        HeaderEditor.setTheme("ace/theme/monokai");
                        HeaderEditor.session.setMode("ace/mode/html");
                        HeaderEditor.session.setUseWrapMode(true);
                        document.getElementById('header-editor').style.fontSize='14px';

                        <?php if (isset($header_content_db['setting_value']) && $header_content_db['setting_value']): ?>
                            HeaderEditor.setValue(document.getElementById('editor-text-header').value, -1);
                        <?php endif; ?>
                    </script>
                </div>

                <div id="footer-scripts">
                    <div class="header-footer-info">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                        </svg>
                        <p><?php _e('Code will be inserted after the', 'setupad'); ?> <b>&#60;footer&#62;&#60;/footer&#62;</b> <?php _e('section of all HTML pages', 'setupad'); ?></p>
                    </div>

                    <div style="max-width: 600px;position: relative; height: 300px;">
                        <div id="footer-editor" class="editor"></div>
                        <textarea id="editor-text-footer" style="display: none;"><?php
                            if (isset($footer_content_db['setting_value']) && $footer_content_db['setting_value']) {
                                print $footer_content_db['setting_value'];
                            }
                            ?>
                        </textarea>
                        <input name="setupad_footer_content" type="hidden" id="footer-editortext">
                        <input name="setupad_footer_elements" type="hidden" id="content_elements_footer">
                    </div>
                    <script>
                        var FooterEditor = ace.edit("footer-editor");
                        FooterEditor.renderer.setShowGutter(false);
                        FooterEditor.setTheme("ace/theme/monokai");
                        FooterEditor.session.setMode("ace/mode/html");
                        FooterEditor.session.setUseWrapMode(true);
                        document.getElementById('footer-editor').style.fontSize='14px';

                        <?php if (isset($footer_content_db['setting_value']) && $footer_content_db['setting_value']): ?>
                            FooterEditor.setValue(document.getElementById('editor-text-footer').value, -1);
                        <?php endif; ?>

                        document.getElementById("form").onsubmit = function(evt) {
                            if (HeaderEditor.getValue()) {
                                let editorDom = new DOMParser().parseFromString(HeaderEditor.getValue(), 'text/html');
                                let editorContentChildren = editorDom.getElementsByTagName("*");
                                let editorChildNodes = {};

                                for (let i = 0; i < editorContentChildren.length; i++) {
                                    let attrs = editorContentChildren[i].getAttributeNames();

                                    if (!editorChildNodes[editorContentChildren[i].nodeName.toLowerCase()])
                                        editorChildNodes[editorContentChildren[i].nodeName.toLowerCase()] = {};

                                    if (attrs) {
                                        let attrArray = {};
                                        attrs.forEach(attr => {
                                            attrArray[attr] = [];

                                            if (!editorChildNodes[editorContentChildren[i].nodeName.toLowerCase()][attr])
                                                editorChildNodes[editorContentChildren[i].nodeName.toLowerCase()][attr] = [];
                                        })
                                    } else {
                                        editorChildNodes[editorContentChildren[i].nodeName.toLowerCase()] = null;
                                    }
                                }
                                document.getElementById("content_elements_header").value = JSON.stringify(editorChildNodes);
                            }
                            document.getElementById("header-editortext").value = JSON.stringify(HeaderEditor.getValue());

                            if (FooterEditor.getValue()) {
                                let editorDom1 = new DOMParser().parseFromString(FooterEditor.getValue(), 'text/html');
                                let editorContentChildren1 = editorDom1.getElementsByTagName("*");
                                let editorChildNodes1 = {};

                                for (let i = 0; i < editorContentChildren1.length; i++) {
                                    let attrs = editorContentChildren1[i].getAttributeNames();

                                    if (!editorChildNodes1[editorContentChildren1[i].nodeName.toLowerCase()])
                                        editorChildNodes1[editorContentChildren1[i].nodeName.toLowerCase()] = {};

                                    if (attrs) {
                                        let attrArray = {};
                                        attrs.forEach(attr => {
                                            attrArray[attr] = [];

                                            if (!editorChildNodes1[editorContentChildren1[i].nodeName.toLowerCase()][attr])
                                                editorChildNodes1[editorContentChildren1[i].nodeName.toLowerCase()][attr] = [];
                                        })
                                    } else {
                                        editorChildNodes1[editorContentChildren1[i].nodeName.toLowerCase()] = null;
                                    }
                                }
                                document.getElementById("content_elements_footer").value = JSON.stringify(editorChildNodes1);
                            }
                            document.getElementById("footer-editortext").value = JSON.stringify(FooterEditor.getValue());
                        }
                    </script>
                </div>

                <input type="submit" value="<?php _e('Save settings', 'setupad') ?>" id="submit" class="stpd-save-btn">
            </form>
        </div>
    </div>

<?php
}