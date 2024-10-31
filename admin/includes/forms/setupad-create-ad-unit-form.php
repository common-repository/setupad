<table style="width: 100%; margin: 0; margin-left: -20px;" class="form-table create-ad-unit-tbl">
        <tbody>
        <tr class="form-field">
            <th scope="row">
                <label for="setupad_title"><?php _e('Ad placement title', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Write an ad placement title, it is displayed only in', 'setupad'); ?> <b> <?php _e('My ads', 'setupad'); ?> </b> <?php _e('section.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <input id="setupad_title" name="setupad_title" value="<?php echo esc_attr(stripslashes($item['setupad_title']))?>"
                       size="50" class="code" placeholder="<?php _e('Ad title', 'setupad')?>" AutoComplete=off data-lpignore="true" type="text" required style="max-width: 600px;">
            </td>
        </tr>

        <tr class="form-field">
            <th scope="row">
                <label for="setupad_type"><?php _e('Select ad type', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select the type of your ad placement: image or script.', 'setupad'); ?> </span>
                </div>
            </td>

            <td>
                <div class="single-dropdown stpd-type-selection" single>
                    <div class="single-dropdown-list-wrapper" style="display: none;">
                        <div class="single-dropdown-list">
                            <div <?php echo ($item['setupad_type'] == 'codes' || !$item['setupad_position']) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Ad codes (HTML, JS)', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_type" value="codes" checked>
                            </div>
                            <div <?php echo ($item['setupad_type'] == 'double_banner') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Double banner', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_type" value="double_banner" <?php checked( $item['setupad_type'], 'double_banner' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_type'] == 'images') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Image', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_type" value="images" <?php checked( $item['setupad_type'], 'images' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_type'] == 'shortcode') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Shortcode', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_type" value="shortcode" <?php checked( $item['setupad_type'], 'shortcode' ); ?>>
                            </div>
                        </div>
                    </div>
                    <span class="optext"></span>
                </div>
            </td>
        </tr>

        <tr class="form-field setupad-content setupad-adcodes">
            <th scope="row">
                <label for="setupad_content"><?php _e('Ad code', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your third-party ad placement HTML or JS tags.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <div style="max-width: 600px;position: relative; height: 300px;">
                    <div id="editor" class="editor"></div>
                    <textarea id="editor-text" style="display: none;"><?php
                        if (isset($item['setupad_content']) && $item['setupad_content']) {
                            print $item['setupad_content'];
                        }
                    ?>
                    </textarea>
                    <input name="setupad_content" type="hidden" id="editortext">
                    <input name="setupad_content_elements" type="hidden" id="content_elements">
                </div>
                <script>
                    let editor = ace.edit("editor");
                    editor.renderer.setShowGutter(false);
                    editor.setTheme("ace/theme/monokai");
                    editor.session.setMode("ace/mode/html");
                    editor.session.setUseWrapMode(true);
                    document.getElementById('editor').style.fontSize='14px';

                    <?php if (isset($item['setupad_content']) && $item['setupad_content']): ?>
                        editor.setValue(document.getElementById('editor-text').value, -1);
                    <?php endif; ?>
                </script>
            </td>
        </tr>
        <tr class="form-field setupad-content setupad-double-1" style="display:none;">
            <th scope="row">
                <label for="setupad_content"><?php _e('1st banner ad code', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your first third-party ad placement HTML or JS tag. This ad unit will be on the left side of the double banner placement, if placement exceeds maximum width where the placement is inserted, this banner will be above the second one.', 'setupad'); ?></span>
                </div>
            </td>
            <td>
                <div style="max-width: 600px;position: relative; height: 300px;">
                    <div id="editor-db-1" class="editor"></div>
                    <textarea id="editor-db-1-text" style="display: none;"><?php
                        if (isset($item['setupad_double_banner_1']) && $item['setupad_double_banner_1']) {
                            print $item['setupad_double_banner_1'];
                        }
                        ?>
                    </textarea>
                    <input name="setupad_double_banner_1" type="hidden" id="db_1_editortext">
                    <input name="setupad_double_banner_1_elements" type="hidden" id="db_1_elements">
                </div>
                <script>
                    let db_editor_1 = ace.edit("editor-db-1");
                    db_editor_1.renderer.setShowGutter(false);
                    db_editor_1.setTheme("ace/theme/monokai");
                    db_editor_1.session.setMode("ace/mode/html");
                    db_editor_1.session.setUseWrapMode(true);
                    document.getElementById('editor-db-1').style.fontSize='14px';

                    <?php if (isset($item['setupad_double_banner_1']) && $item['setupad_double_banner_1']): ?>
                    db_editor_1.setValue(document.getElementById('editor-db-1-text').value, -1);
                    <?php endif; ?>
                </script>
            </td>
        </tr>
        <tr class="form-field setupad-content setupad-double-2" style="display:none;">
            <th scope="row">
                <label for="setupad_content"><?php _e('2nd banner ad code', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your second third-party ad placement HTML or JS tag. This ad unit will be on the right side of the double banner placement, if placement exceeds maximum width where the placement is inserted, this banner will be below the first one.', 'setupad'); ?></span>
                </div>
            </td>
            <td>
                <div style="max-width: 600px;position: relative; height: 300px;">
                    <div id="editor-db-2" class="editor"></div>
                    <textarea id="editor-db-2-text" style="display: none;"><?php
                        if (isset($item['setupad_double_banner_2']) && $item['setupad_double_banner_2']) {
                            print $item['setupad_double_banner_2'];
                        }
                        ?>
                    </textarea>
                    <input name="setupad_double_banner_2" type="hidden" id="db_2_editortext">
                    <input name="setupad_double_banner_2_elements" type="hidden" id="db_2_elements">
                </div>
                <script>
                    let db_editor_2 = ace.edit("editor-db-2");
                    db_editor_2.renderer.setShowGutter(false);
                    db_editor_2.setTheme("ace/theme/monokai");
                    db_editor_2.session.setMode("ace/mode/html");
                    db_editor_2.session.setUseWrapMode(true);
                    document.getElementById('editor-db-2').style.fontSize='14px';

                    <?php if (isset($item['setupad_double_banner_2']) && $item['setupad_double_banner_2']): ?>
                    db_editor_2.setValue(document.getElementById('editor-db-2-text').value, -1);
                    <?php endif; ?>

                    document.getElementById("form").onsubmit = function() {
                        if (editor.getValue()) {
                            let editorDom = new DOMParser().parseFromString(editor.getValue(), 'text/html');
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
                            document.getElementById("content_elements").value = JSON.stringify(editorChildNodes);
                            document.getElementById("editortext").value = JSON.stringify(editor.getValue());
                        }
                        if (db_editor_1.getValue()) {
                            let editorDom1 = new DOMParser().parseFromString(db_editor_1.getValue(), 'text/html');
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
                            document.getElementById("db_1_elements").value = JSON.stringify(editorChildNodes1);
                            document.getElementById("db_1_editortext").value = JSON.stringify(db_editor_1.getValue());
                        }

                        if (db_editor_2.getValue()) {
                            let editorDom2 = new DOMParser().parseFromString(db_editor_2.getValue(), 'text/html');
                            let editorContentChildren2 = editorDom2.getElementsByTagName("*");
                            let editorChildNodes2 = {};

                            for (let i = 0; i < editorContentChildren2.length; i++) {
                                let attrs = editorContentChildren2[i].getAttributeNames();

                                if (!editorChildNodes2[editorContentChildren2[i].nodeName.toLowerCase()])
                                    editorChildNodes2[editorContentChildren2[i].nodeName.toLowerCase()] = {};

                                if (attrs) {
                                    let attrArray = {};
                                    attrs.forEach(attr => {
                                        attrArray[attr] = [];

                                        if (!editorChildNodes2[editorContentChildren2[i].nodeName.toLowerCase()][attr])
                                            editorChildNodes2[editorContentChildren2[i].nodeName.toLowerCase()][attr] = [];
                                    })
                                } else {
                                    editorChildNodes2[editorContentChildren2[i].nodeName.toLowerCase()] = null;
                                }
                            }
                            document.getElementById("db_2_elements").value = JSON.stringify(editorChildNodes2);
                            document.getElementById("db_2_editortext").value = JSON.stringify(db_editor_2.getValue());
                        }
                    }
                </script>
            </td>
        </tr>
        <tr class="form-field setupad-image" style="display:none;">
            <th scope="row">
                <label for="setupad_image_url"><?php _e('Upload image', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Upload any image you want to display as a custom ad placement.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <?php
                function convert_filesize($bytes, $decimals = 2){
                    $size = array('bytes','KB','MB','GB','TB','PB','EB','ZB','YB');
                    $factor = floor((strlen($bytes) - 1) / 3);
                    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
                }
                ?>
                <div id="drop-area">
                    <div id="stpd-upload-file" <?php if (isset($item['setupad_image_url']) && $item['setupad_image_url'] && file_exists($item['setupad_image_file_path'])) echo 'style="display: none;"' ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="57" viewBox="0 0 56 57" fill="none">
                            <rect x="4" y="4.5" width="48" height="48" rx="24" fill="#E4FDFF"/>
                            <g clip-path="url(#clip0_225_4)">
                                <path d="M32 32.0022L28 28.0022L24 32.0022" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M28 28.0022V37.0022" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M36.39 34.3922C37.3653 33.8605 38.1358 33.0191 38.5798 32.0008C39.0239 30.9825 39.1162 29.8454 38.8422 28.7689C38.5682 27.6923 37.9434 26.7377 37.0666 26.0556C36.1898 25.3736 35.1108 25.0029 34 25.0022H32.74C32.4373 23.8314 31.8731 22.7445 31.0899 21.8232C30.3067 20.9018 29.3248 20.17 28.2181 19.6828C27.1113 19.1955 25.9085 18.9655 24.7001 19.0101C23.4916 19.0546 22.309 19.3725 21.2411 19.9398C20.1732 20.5072 19.2479 21.3093 18.5346 22.2858C17.8213 23.2622 17.3387 24.3877 17.1229 25.5776C16.9072 26.7674 16.9641 27.9907 17.2892 29.1554C17.6143 30.3202 18.1992 31.396 19 32.3022" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M32 32.0022L28 28.0022L24 32.0022" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </g>
                            <rect x="4" y="4.5" width="48" height="48" rx="24" stroke="#F1FEFF" stroke-width="8" stroke-linecap="round"/>
                            <defs>
                                <clipPath id="clip0_225_4">
                                    <rect width="24" height="24" fill="white" transform="translate(16 16.0022)"/>
                                </clipPath>
                            </defs>
                        </svg>
                        <p><label class="drop-label" for="stpd-file-elem"> <?php _e('Click to upload', 'setupad'); ?> </label> <?php _e('or drag and drop JPG, PNG, WEBP, GIF. (max. 8MB)', 'setupad'); ?></p>
                    </div>
                    <input type="file" id="stpd-file-elem" name="setupad_image_url" accept=".jpg, .jpeg, .png, .webp, .gif">

                    <div id="stpd-file-uploaded" <?php if (!isset($item['setupad_image_url']) || !$item['setupad_image_url'] || !file_exists($item['setupad_image_file_path'])) echo 'style="display: none;"' ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                            <rect x="4" y="4" width="48" height="48" rx="24" fill="#E4FDFF"/>
                            <path d="M35 19.5H21C19.8954 19.5 19 20.3954 19 21.5V35.5C19 36.6046 19.8954 37.5 21 37.5H35C36.1046 37.5 37 36.6046 37 35.5V21.5C37 20.3954 36.1046 19.5 35 19.5Z" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.5 26.5C25.3284 26.5 26 25.8284 26 25C26 24.1716 25.3284 23.5 24.5 23.5C23.6716 23.5 23 24.1716 23 25C23 25.8284 23.6716 26.5 24.5 26.5Z" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M37 31.5L32 26.5L21 37.5" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="4" y="4" width="48" height="48" rx="24" stroke="#F1FEFF" stroke-width="8" stroke-linecap="round"/>
                        </svg>
                        <div class="file-contents">
                            <?php if (isset($item['setupad_image_url']) && $item['setupad_image_url']) {
                                $fileName = explode("/", $item['setupad_image_url']);
                                $fileName = array_pop($fileName);

                                if (strlen($fileName) > 35) {
                                    $fileName = substr($fileName, 0, 20) . '...' . substr($fileName, strlen($fileName)-10, strlen($fileName));
                                }
                            }?>

                            <div class="uploaded-file-data">
                                <p class="uploaded-file-name"><?php if (isset($fileName) && $fileName) echo esc_textarea($fileName) ?></p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                    <circle cx="10" cy="10" r="10" fill="#0497A5"/>
                                    <path d="M15 7L8.125 13.875L5 10.75" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>

                            <?php
                                if (isset($item['setupad_image_file_path']) && $item['setupad_image_file_path']) {
                                    $fileSize = convert_filesize(filesize($item['setupad_image_file_path']), 1);
                                }
                            ?>
                            <p class="uploaded-file-size"><?php if(isset($fileSize) && $fileSize) echo esc_textarea($fileSize) ?></p>
                        </div>
                        <div class="delete-uploaded-file">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" class="delete-uploaded-file-btn" fill="none">
                                <path d="M2.75 5.5H4.58333H19.25" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.4167 5.50004V18.3334C17.4167 18.8196 17.2236 19.2859 16.8797 19.6297C16.5359 19.9736 16.0696 20.1667 15.5834 20.1667H6.41671C5.93048 20.1667 5.46416 19.9736 5.12034 19.6297C4.77653 19.2859 4.58337 18.8196 4.58337 18.3334V5.50004M7.33337 5.50004V3.66671C7.33337 3.18048 7.52653 2.71416 7.87035 2.37034C8.21416 2.02653 8.68048 1.83337 9.16671 1.83337H12.8334C13.3196 1.83337 13.7859 2.02653 14.1297 2.37034C14.4736 2.71416 14.6667 3.18048 14.6667 3.66671V5.50004" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.16663 10.0834V15.5834" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.8334 10.0834V15.5834" stroke="#667085" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>

                    </div>

                    <div id="stpd-file-size-format-error" style="display: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none">
                            <rect x="4" y="4" width="48" height="48" rx="24" fill="#FAE5E3"/>
                            <path d="M35 19.5H21C19.8954 19.5 19 20.3954 19 21.5V35.5C19 36.6046 19.8954 37.5 21 37.5H35C36.1046 37.5 37 36.6046 37 35.5V21.5C37 20.3954 36.1046 19.5 35 19.5Z" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M24.5 26.5C25.3284 26.5 26 25.8284 26 25C26 24.1716 25.3284 23.5 24.5 23.5C23.6716 23.5 23 24.1716 23 25C23 25.8284 23.6716 26.5 24.5 26.5Z" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M37 31.5L32 26.5L21 37.5" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <rect x="4" y="4" width="48" height="48" rx="24" stroke="#FFF3F2" stroke-width="8" stroke-linecap="round"/>
                        </svg>
                        <div class="file-contents">
                            <div class="uploaded-file-data-err">
                                <p></p>
                            </div>
                            <p class="uploaded-file-name-sm"></p>
                        </div>
                        <div class="delete-uploaded-file">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none" class="delete-uploaded-file-btn">
                                <path d="M2.75 5.5H4.58333H19.25" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M17.4167 5.49992V18.3333C17.4167 18.8195 17.2236 19.2858 16.8797 19.6296C16.5359 19.9734 16.0696 20.1666 15.5834 20.1666H6.41671C5.93048 20.1666 5.46416 19.9734 5.12034 19.6296C4.77653 19.2858 4.58337 18.8195 4.58337 18.3333V5.49992M7.33337 5.49992V3.66659C7.33337 3.18035 7.52653 2.71404 7.87035 2.37022C8.21416 2.02641 8.68048 1.83325 9.16671 1.83325H12.8334C13.3196 1.83325 13.7859 2.02641 14.1297 2.37022C14.4736 2.71404 14.6667 3.18035 14.6667 3.66659V5.49992" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M9.16663 10.0833V15.5833" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12.8334 10.0833V15.5833" stroke="#C1483A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr class="form-field img-width" style="display:none;">
            <th scope="row">
                <label for="setupad_img_width"><?php _e('Image width', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Specify the width of your image, measurement is in pixels (px), e.g. 300.', 'setupad');?></span>
                </div>
            </td>

            <td>
                <input id="setupad_img_width" name="setupad_img_width" value="<?php if (isset($item['setupad_img_width'])) echo esc_attr(stripslashes($item['setupad_img_width'])) ?>"
                       size="50" placeholder="300" AutoComplete=off data-lpignore="true" type="text" style="max-width: 600px;">
            </td>
        </tr>
        <tr class="form-field img-width" style="display:none;">
            <th scope="row">
                <label for="setupad_img_height"><?php _e('Image height', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Specify the height of your image, measurement is in pixels (px), e.g. 250.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <input id="setupad_img_height" name="setupad_img_height" value="<?php if (isset($item['setupad_img_height'])) echo esc_attr(stripslashes($item['setupad_img_height'])) ?>"
                       size="50" placeholder="250" AutoComplete=off data-lpignore="true" type="text" style="max-width: 600px;">
            </td>
        </tr>
        <tr class="form-field img-alt" style="display:none;">
            <th scope="row">
                <label for="setupad_img_alt"><?php _e('Image alt text', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Write an alt text for the image (E.g. Apple juice advertisement).', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <input id="setupad_img_alt" name="setupad_img_alt" value="<?php if (isset($item['setupad_img_alt'])) echo esc_attr(stripslashes($item['setupad_img_alt'])) ?>"
                       size="200" placeholder="<?php _e('Insert your alt text', 'setupad')?>" AutoComplete=off data-lpignore="true" type="text" style="max-width: 600px;">
            </td>
        </tr>
        <tr class="form-field img-url" style="display:none;">
            <th scope="row">
                <label for="setupad_img_url"><?php _e('Image URL', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Write a URL to which the image placement will redirect when clicked.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <input id="setupad_img_url" name="setupad_img_url" value="<?php if (isset($item['setupad_img_url'])) echo esc_attr(stripslashes($item['setupad_img_url'])) ?>"
                       size="200" placeholder="https://example.com" AutoComplete=off data-lpignore="true" type="text" style="max-width: 600px;">
            </td>
        </tr>


        <tr class="form-field setupad-shortcode">
            <th scope="row">
                <label for="setupad_shortcode_content"><?php _e('Shortcode', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert any valid shortcode that you want to display on your website.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <input id="setupad_shortcode_content" name="setupad_shortcode_content" value="<?php if (isset($item['setupad_shortcode_content'])) echo esc_attr(stripslashes($item['setupad_shortcode_content']))?>"
                       size="100" class="code" placeholder="<?php _e('Shortcode, e.g., [my shortcode 5]', 'setupad')?>" AutoComplete=off data-lpignore="true" type="text" style="max-width: 600px;">
            </td>
        </tr>

        <tr class="form-field page-selection">
            <th scope="row">
                <label for="setupad_page_selection"><?php _e('Insert in pages', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select on which WordPress pages your ad will be displayed. Multiple selections are available.', 'setupad'); ?></span>
                </div>
            </td>

            <td>
                <?php
                    $page_selection_array = [];
                    if ($item['setupad_insertion_pages']) $page_selection_array = explode(',', $item['setupad_insertion_pages']);
                ?>
                <ul class="checkbox-grid">
                    <div class="checkbox-grid-row">
                        <li <?php if (in_array('post_page', $page_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="page_selection_inputs" type="checkbox" value="post_page" <?php if (in_array('post_page', $page_selection_array)) echo 'checked' ?> /><label class="page_selection_label">Post pages</label></li>
                        <div class="vline"></div>
                        <li <?php if (in_array('static_page', $page_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="page_selection_inputs" type="checkbox" value="static_page" <?php if (in_array('static_page', $page_selection_array)) echo 'checked' ?> /><label class="page_selection_label">Static pages</label></li>
                        <li <?php if (in_array('category_page', $page_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="page_selection_inputs" type="checkbox" value="category_page" <?php if (in_array('category_page', $page_selection_array)) echo 'checked' ?> /><label class="page_selection_label">Category pages</label></li>
                    </div>
                    <div class="checkbox-grid-row">
                        <li <?php if (in_array('homepage', $page_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="page_selection_inputs" type="checkbox" value="homepage" <?php if (in_array('homepage', $page_selection_array)) echo 'checked' ?> /><label class="page_selection_label">Homepage</label></li>
                        <div class="vline-width"></div>
                        <li <?php if (in_array('search_page', $page_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="page_selection_inputs" type="checkbox" value="search_page" <?php if (in_array('search_page', $page_selection_array)) echo 'checked' ?> /><label class="page_selection_label">Search pages</label></li>
                        <li <?php if (in_array('archive_page', $page_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="page_selection_inputs" type="checkbox" value="archive_page" <?php if (in_array('archive_page', $page_selection_array)) echo 'checked' ?> /><label class="page_selection_label">Archive pages</label></li>
                    </div>
                </ul>
                <input id="insertion_pages" name="setupad_insertion_pages" type="hidden" value="">
            </td>
        </tr>

        <tr class="form-field device-selection">
            <th scope="row">
                <label for="setupad_device_selection"><?php _e('Device selection', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select on what device your ad placement should be displayed. You can combine device types, e.g., desktop/mobile, mobile/tablet, etc.', 'setupad'); ?></span>
                </div>
            </td>

            <td>

                <?php
                $device_selection_array = [];
                if ($item['setupad_device_selection']) $device_selection_array = explode(',', $item['setupad_device_selection']);
                ?>

                <ul class="checkbox-grid">
                    <div class="checkbox-grid-row">
                        <li <?php if (in_array('0', $device_selection_array) || !$item['setupad_device_selection']) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="device_selection_inputs" id="all_device_selection" type="checkbox" value="0" <?php if (in_array('0', $device_selection_array) || !$item['setupad_device_selection']) echo 'checked' ?> /><label class="device_selection_label">All devices</label></li>
                        <li <?php if (in_array('1', $device_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="device_selection_inputs" type="checkbox" value="1" <?php if (in_array('1', $device_selection_array)) echo 'checked' ?> /><label class="device_selection_label">Desktop<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-monitor"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg></label></li>
                        <li <?php if (in_array('2', $device_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="device_selection_inputs" type="checkbox" value="2" <?php if (in_array('2', $device_selection_array)) echo 'checked' ?> /><label class="device_selection_label">Mobile<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-smartphone"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg></label></li>
                        <li <?php if (in_array('3', $device_selection_array)) echo 'style="background: rgba(146,146,146,.3)"' ?>><input class="device_selection_inputs" type="checkbox" value="3" <?php if (in_array('3', $device_selection_array)) echo 'checked' ?> /><label class="device_selection_label">Tablet<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-tablet"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12.01" y2="18"></line></svg></label></li>
                    </div>
                </ul>
                <input id="device_selections" name="setupad_device_selection" type="hidden" value="">
            </td>
        </tr>

        <tr class="form-field alignment-selection">
            <th scope="row">
                <label for="setupad_alignment_selection"><?php _e('Align ad placement', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select your ad placement alignment. You can add custom CSS under custom alignment. CSS is inserted inline.','setupad');?></span>
                </div>
            </td>

            <td>
                <ul class="checkbox-grid">
                    <div class="checkbox-grid-row">
                        <li <?php if($item['setupad_contents_alignment'] == 0) echo 'style="background: rgba(146,146,146,.3)"' ?> class="alignment-selection-list-item"><input type="radio" value="0" name="setupad_contents_alignment" <?php if($item['setupad_contents_alignment'] == 0) echo 'checked'; ?> /><label class="alignment_selection_label"><?php _e('None','setupad'); ?></label></li>
                        <li <?php if($item['setupad_contents_alignment'] == 1) echo 'style="background: rgba(146,146,146,.3)"' ?> class="alignment-selection-list-item"><input type="radio" value="1" name="setupad_contents_alignment" <?php if($item['setupad_contents_alignment'] == 1) echo 'checked'; ?>/><label class="alignment_selection_label"><?php _e('Left','setupad'); ?></label></li>
                        <li <?php if($item['setupad_contents_alignment'] == 2) echo 'style="background: rgba(146,146,146,.3)"' ?> class="alignment-selection-list-item"><input type="radio" value="2" name="setupad_contents_alignment" <?php if($item['setupad_contents_alignment'] == 2) echo 'checked'; ?>/><label class="alignment_selection_label"><?php _e('Centered','setupad'); ?></label></li>
                        <li <?php if($item['setupad_contents_alignment'] == 3) echo 'style="background: rgba(146,146,146,.3)"' ?> class="alignment-selection-list-item"><input type="radio" value="3" name="setupad_contents_alignment" <?php if($item['setupad_contents_alignment'] == 3) echo 'checked'; ?>/><label class="alignment_selection_label"><?php _e('Right','setupad'); ?></label></li>
                        <li <?php if($item['setupad_contents_alignment'] == 4) echo 'style="background: rgba(146,146,146,.3)"' ?> class="alignment-selection-list-item"><input type="radio" value="4" name="setupad_contents_alignment" <?php if($item['setupad_contents_alignment'] == 4) echo 'checked'; ?>/><label class="alignment_selection_label"><?php _e('Custom','setupad'); ?></label></li>
                    </div>
                    <div>
                        <input type="text" id="stpd-custom-css" name="setupad_alignment_css" style="width: 100%; display: none;" <?php if($item['setupad_contents_alignment'] == 4 && $item['setupad_alignment_css']) echo 'value="'. esc_textarea(stripslashes($item['setupad_alignment_css'])). '"'; ?>>
                    </div>
                </ul>
            </td>
        </tr>

        <tr class="form-field setupad-select-position">
            <th scope="row">
                <label for="setupad_position"><?php _e('Ad output position', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select ad placement insertion position. Depending on your WordPress theme, some positions may not be available.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <div class="single-dropdown stpd-position-select" single>
                    <div class="single-dropdown-list-wrapper" style="display: none;">
                        <div class="single-dropdown-list">
                            <div <?php echo ($item['setupad_position'] == 'before_post' || !$item['setupad_position']) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before Post', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_post" checked>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'between_posts') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Between posts', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="between_posts" <?php checked( $item['setupad_position'], 'between_posts' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_post') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After Post', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_post" <?php checked( $item['setupad_position'], 'after_post' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_content') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before content', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_content" <?php checked( $item['setupad_position'], 'before_content' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_content') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After content', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_content" <?php checked( $item['setupad_position'], 'after_content' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_paragraph') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before paragraph', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_paragraph" <?php checked( $item['setupad_position'], 'before_paragraph' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_paragraph') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After paragraph', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_paragraph" <?php checked( $item['setupad_position'], 'after_paragraph' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_image') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before image', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_image" <?php checked( $item['setupad_position'], 'before_image' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_image') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After image', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_image" <?php checked( $item['setupad_position'], 'after_image' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_comments') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before comments', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_comments" <?php checked( $item['setupad_position'], 'before_comments' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'between_comments') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Between comments', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="between_comments" <?php checked( $item['setupad_position'], 'between_comments' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_comments') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After comments', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_comments" <?php checked( $item['setupad_position'], 'after_comments' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_excerpt') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before excerpt', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_excerpt" <?php checked( $item['setupad_position'], 'before_excerpt' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_excerpt') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After excerpt', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_excerpt" <?php checked( $item['setupad_position'], 'after_excerpt' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_sidebar') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before sidebar', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_sidebar" <?php checked( $item['setupad_position'], 'before_sidebar' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_sidebar') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After sidebar', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_sidebar" <?php checked( $item['setupad_position'], 'after_sidebar' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_list') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before list', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_list" <?php checked( $item['setupad_position'], 'before_list' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'between_list_items') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Between list items', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="between_list_items" <?php checked( $item['setupad_position'], 'between_list_items' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_list') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After list', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_list" <?php checked( $item['setupad_position'], 'after_list' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'before_html') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Before HTML', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="before_html" <?php checked( $item['setupad_position'], 'before_html' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'after_html') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('After HTML', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="after_html" <?php checked( $item['setupad_position'], 'after_html' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'inside_html') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Inside HTML', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="inside_html" <?php checked( $item['setupad_position'], 'inside_html' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'header') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Header', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="header" <?php checked( $item['setupad_position'], 'header' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'footer') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Footer', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="footer" <?php checked( $item['setupad_position'], 'footer' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_position'] == 'related_posts') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('Related Posts', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_position" value="related_posts" <?php checked( $item['setupad_position'], 'related_posts' ); ?>>
                            </div>
                        </div>
                    </div>
                    <span class="optext"></span>
                </div>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-before-paragraph" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-paragraph-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert before every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement before every Nth paragraph (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-every-paragraph" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('paragraph number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('paragraph starting from', 'setupad')?></label>
                <input id="setupad-before-every-paragraph-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="0" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-before-paragraph" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-paragraph-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or before', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific paragraph (if more paragraphs - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-paragraph" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('paragraph number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('paragraph(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-after-paragraph" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-paragraph-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert after every', 'setupad')?></label>
                </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement after every Nth paragraph (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-every-paragraph" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('paragraph number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('paragraph starting from', 'setupad')?></label>
                <input id="setupad-after-every-paragraph-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-after-paragraph" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-paragraph-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or after', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific paragraph (if more paragraphs - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-paragraph" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('paragraph number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('paragraph(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-before-image" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-image-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert before every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement before every Nth image (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-every-image" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('image number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('image starting from', 'setupad')?></label>
                <input id="setupad-before-every-image-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>

            </td>
        </tr>
        <tr class="form-field two-inputs setupad-before-image" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-image-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or before', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific image (if more images - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-image" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('image number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('image(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-after-image" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-image-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert after every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement after every Nth image (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-every-image" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('image number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('image starting from', 'setupad')?></label>
                <input id="setupad-after-every-image-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-after-image" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-image-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or after', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific image (if more images - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-image" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('image number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('image(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-between-comments" style="display: none;">
            <th scope="row">
                <input type="radio" name="between-comments-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert between every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement between every Nth comment (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-between-every-comment" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('comment number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('comment starting from', 'setupad')?></label>
                <input id="setupad-between-every-comment-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-between-comments" style="display: none;">
            <th scope="row">
                <input type="radio" name="between-comments-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or between', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific comment (if more comments - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-between-comments" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('comment number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('comment(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-between-posts" style="display: none;">
            <th scope="row">
                <input type="radio" name="between-posts-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert between every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement between every Nth post (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-between-every-post" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('post number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('post starting from', 'setupad')?></label>
                <input id="setupad-between-every-post-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-between-posts" style="display: none;">
            <th scope="row">
                <input type="radio" name="between-posts-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or between', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific post (if more posts - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-between-posts" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('post number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('post(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-before-excerpt" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-excerpt-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert before every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement before every Nth excerpt (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-every-excerpt" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('excerpt number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('excerpt starting from', 'setupad')?></label>
                <input id="setupad-before-every-excerpt-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-before-excerpt" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-excerpt-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or before', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific excerpt (if more excerpts - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-excerpt" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('excerpt number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('excerpt(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-after-excerpt" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-excerpt-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert after every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement after every Nth excerpt (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-every-excerpt" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('excerpt number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('excerpt starting from', 'setupad')?></label>
                <input id="setupad-after-every-excerpt-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-after-excerpt" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-excerpt-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or after', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific excerpt (if more excerpts - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-excerpt" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('excerpt number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('excerpt(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-before-list" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-list-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert before every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement before every Nth list (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-every-list" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('list number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('list starting from', 'setupad')?></label>
                <input id="setupad-before-every-list-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-before-list" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-list-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or before', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific list number (if more lists - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-list" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('list number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('list(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-after-list" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-list-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert after every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement after every Nth list (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-every-list" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('list number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('list starting from', 'setupad')?></label>
                <input id="setupad-after-every-list-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-after-list" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-list-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or after', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific list number (if more lists - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-list" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('list number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('list(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-between-list-items" style="display: none;">
            <th scope="row">
                <input type="radio" name="between-list-items-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert between every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement between every Nth list item (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-between-every-list-item" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('list item number', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('list item starting from', 'setupad')?></label>
                <input id="setupad-between-every-list-item-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-between-list-items" style="display: none;">
            <th scope="row">
                <input type="radio" name="between-list-items-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Or between', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Enter a specific list item (if more list items - separate with commas, e.g., 2,3,5) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-between-list-items" type="text" value="<?php echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('list item number(s)', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?>>

                <label for="setupad_block_position"><?php _e('list item(s)', 'setupad')?></label>
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-before-html" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-html-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_multiple_block_position"><?php _e('Insert before every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement before every Nth HTML element (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-every-html" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('#content > #primary', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_multiple_block_position"><?php _e('starting from', 'setupad')?></label>
                <input id="setupad-before-every-html-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-before-html" style="display: none;">
            <th scope="row">
                <input type="radio" name="before-html-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert before', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement before specified HTML element (e.g div#primary > #content) where you want ads to appear. Uses jQuery selectors.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-before-html" type="text" value="<?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('#primary > #content', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?> >
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-after-html" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-html-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_multiple_block_position"><?php _e('Insert after every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement after every Nth HTML element (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-every-html" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('#content > #primary', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_block_position"><?php _e('starting from', 'setupad')?></label>
                <input id="setupad-after-every-html-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-after-html" style="display: none;">
            <th scope="row">
                <input type="radio" name="after-html-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert after', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement after specified HTML element (e.g div#primary > #content) where you want ads to appear. Uses jQuery selectors.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-after-html" type="text" value="<?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('#primary > #content', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?> >
            </td>
        </tr>

        <tr class="form-field two-inputs setupad-inside-html-type-selection" style="display:none">

            <th scope="row">
                <label for="setupad_inside_html_type">Insertion type</label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select what type of insertion action should be performed for "Inside HTML" insertion.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <ul class="checkbox-grid">
                    <div class="checkbox-grid-row">
                        <li <?php if( !isset($item['setupad_inside_html_type']) || (isset($item['setupad_inside_html_type']) && $item['setupad_inside_html_type'] === 'prepend') ) echo 'style="background:rgba(146,146,146,.3)"'?> >
                            <input type="radio" value="prepend" name="setupad_inside_html_type" checked>
                            <label class="setupad_inside_html_type_label">Prepend</label>
                        </li>
                        <li <?php if( isset($item['setupad_inside_html_type']) && $item['setupad_inside_html_type'] === 'append' ) echo 'style="background:rgba(146,146,146,.3)"'?> >
                            <input type="radio" value="append" name="setupad_inside_html_type" <?php if(isset($item['setupad_inside_html_type']) && $item['setupad_inside_html_type'] === 'append') echo 'checked' ?>>
                            <label class="setupad_inside_html_type_label">Append</label>
                        </li>
                        <li <?php if( isset($item['setupad_inside_html_type']) && $item['setupad_inside_html_type'] === 'replace' ) echo 'style="background:rgba(146,146,146,.3)"'?> >
                            <input type="radio" value="replace" name="setupad_inside_html_type" <?php if(isset($item['setupad_inside_html_type']) && $item['setupad_inside_html_type'] === 'replace') echo 'checked' ?>>
                            <label class="setupad_inside_html_type_label">Replace</label>
                        </li>
                    </div>
                </ul>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-inside-html" style="display: none;">
            <th scope="row">
                <input type="radio" name="inside-html-position" class="multiple-positions" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_multiple_block_position"><?php _e('Insert inside every', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement inside every Nth HTML element (e.g., 2) where you want ads to appear.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-inside-every-html" type="text" value="<?php if (isset($item['setupad_multiple_block_position']) && $item['setupad_multiple_block_position']) echo esc_attr($item['setupad_multiple_block_position'])?>"
                       class="code" placeholder="<?php _e('#content > #primary', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
                <label for="setupad_multiple_block_position"><?php _e('starting from', 'setupad')?></label>
                <input id="setupad-inside-every-html-starting-from" type="text" value="<?php if (isset($item['setupad_starting_position']) && $item['setupad_starting_position']) echo esc_attr($item['setupad_starting_position']) ?>"
                       class="code" placeholder="<?php _e('0', 'setupad')?>" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "disabled" ?>>
            </td>
        </tr>
        <tr class="form-field two-inputs setupad-inside-html" style="display: none;">
            <th scope="row">
                <input type="radio" name="inside-html-position" class="single-positions" <?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo "checked" ?>>
                <label for="setupad_block_position"><?php _e('Insert inside', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Insert your ad placement inside specified HTML element (e.g div#primary > #content) where you want ads to appear. Uses CSS selectors.','setupad'); ?></span>
                </div>
            </td>

            <td style="display: flex;">
                <input id="setupad-inside-html" type="text" value="<?php if (isset($item['setupad_block_position']) && $item['setupad_block_position']) echo esc_attr($item['setupad_block_position'])?>"
                       class="code" placeholder="<?php _e('#primary > #content', 'setupad')?>" <?php if (!isset($item['setupad_block_position']) || !$item['setupad_block_position']) echo "disabled" ?> >
            </td>
        </tr>

        <tr class="form-field" id="advanced-options">
            <th scope="row">
                <button id="advanced-options-btn"><?php _e('Show advanced options', 'setupad')?></button>
            </th>
        </tr>

        <tr class="form-field advanced-option setupad-lazy-loading">
            <th scope="row">
                <label for="setupad_title"><?php _e('Enable lazy loading', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Lazy load your ad placement. Depending on your third party ad provider and tag structure, some tags may not work.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <label class="stpd-tgl-switch">
                    <input id="setupad_lazy_loading" name="setupad_lazy_loading" type="checkbox" value="true"
                        <?php if ($item['setupad_lazy_loading'] === 'true') { echo 'checked'; } ?>
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
                    <span class="stpd-tooltiptext"><?php _e('Exclude a URL where you don\'t want this ad placement shown. It is also possible to use a wildcard ( e.g. /blog/* ).','setupad'); ?></span>
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
                    <span class="stpd-tooltiptext"><?php _e('Include a URL where you want this ad placement shown. It is also possible to use a wildcard ( e.g. /blog/* ).','setupad'); ?></span>
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
                    <span class="stpd-tooltiptext"><?php _e('List of URLs currently added to your blacklist/whitelist.','setupad'); ?></span>
                </div>
            </td>
            <td>
                <button id="blacklist-select-btn">Blacklist</button>
                <button id="whitelist-select-btn">Whitelist</button>
                <div id="stpd-excluded-url-list-box">
                    <ul>
                        <?php
                        if (isset($item['setupad_url_exclusions']) && $item['setupad_url_exclusions']) {
                            $urls = explode(',',stripslashes($item['setupad_url_exclusions']));
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
                    <input name="setupad_url_exclusions" type="hidden" value="<?php if(isset($item['setupad_url_exclusions']) && $item['setupad_url_exclusions']) echo $item['setupad_url_exclusions']; else echo ''; ?>">
                </div>
                <div id="stpd-included-url-list-box">
                    <ul>
                        <?php
                        if (isset($item['setupad_url_inclusions']) && $item['setupad_url_inclusions']) {
                            $urls = explode(',',stripslashes($item['setupad_url_inclusions']));
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
                    <input name="setupad_url_inclusions" type="hidden" value="<?php if(isset($item['setupad_url_inclusions']) && $item['setupad_url_inclusions']) echo $item['setupad_url_inclusions']; else echo ''; ?>">
                </div>
            </td>
        </tr>
        <tr class="form-field advanced-option setupad-img-target">
            <th scope="row">
                <label for="setupad_title"><?php _e('Image URL target', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Set the target attribute for your image URL that you provided in "image URL" field.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <div class="single-dropdown setupad-img-target-selection" single>
                    <div class="single-dropdown-list-wrapper" style="display: none;">
                        <div class="single-dropdown-list">
                            <div <?php echo ($item['setupad_img_target'] == '_blank' || !$item['setupad_img_target']) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('_blank', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_target" value="_blank" checked>
                            </div>
                            <div <?php echo ($item['setupad_img_target'] == '_top') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('_top', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_target" value="_top" <?php checked( $item['setupad_img_target'], '_top' ); ?>>
                            </div>
                        </div>
                    </div>
                    <span class="optext"></span>
                </div>
            </td>
        </tr>
        <tr class="form-field advanced-option setupad-img-referrerpolicy">
            <th scope="row">
                <label for="setupad_title"><?php _e('Image URL referrerpolicy', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Set the referrerpolicy attribute for your image URL that you provided in "image URL" field.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <div class="single-dropdown setupad-img-referrerpolicy-selection" single>
                    <div class="single-dropdown-list-wrapper" style="display: none;">
                        <div class="single-dropdown-list">
                            <div <?php echo ($item['setupad_img_referrerpolicy'] == 'origin-when-cross-origin' || !$item['setupad_img_referrerpolicy']) ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('origin-when-cross-origin', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_referrerpolicy" value="origin-when-cross-origin" checked>
                            </div>
                            <div <?php echo ($item['setupad_img_referrerpolicy'] == 'origin') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('origin', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_referrerpolicy" value="origin" <?php checked( $item['setupad_img_referrerpolicy'], 'origin' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_img_referrerpolicy'] == 'no-referrer') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('no-referrer', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_referrerpolicy" value="no-referrer" <?php checked( $item['setupad_img_referrerpolicy'], 'no-referrer' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_img_referrerpolicy'] == 'no-referrer-when-downgrade') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('no-referrer-when-downgrade', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_referrerpolicy" value="no-referrer-when-downgrade" <?php checked( $item['setupad_img_referrerpolicy'], 'no-referrer-when-downgrade' ); ?>>
                            </div>
                            <div <?php echo ($item['setupad_img_referrerpolicy'] == 'unsafe-url') ? 'class="single-d-div checked"' : 'class="single-d-div"'; ?>>
                                <label class="single-d-label"><?php _e('unsafe-url', 'setupad')?></label>
                                <input class="single-d-input" type="radio" name="setupad_img_referrerpolicy" value="unsafe-url" <?php checked( $item['setupad_img_referrerpolicy'], 'unsafe-url' ); ?>>
                            </div>
                        </div>
                    </div>
                    <span class="optext"></span>
                </div>
            </td>
        </tr>
        <tr class="form-field advanced-option setupad-insertion-delay">
            <th scope="row">
                <label for="setupad_title"><?php _e('Insertion delay (ms)', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Add a timeout after which the ad unit will be inserted in the page.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <div class="stpd-btn-row">
                    <input id="setupad_timeout_delay" name="setupad_timeout_delay" size="20" class="code" placeholder="<?php _e('0 ms', 'setupad')?>" AutoComplete=off data-lpignore="true" type="number" min="0" step="1" max="100000" value="<?php if (isset($item['setupad_timeout_delay']) && $item['setupad_timeout_delay']) echo $item['setupad_timeout_delay'] ?>">
                </div>
            </td>
        </tr>
        <tr class="form-field advanced-option setupad-wait-for-element">
            <th scope="row">
                <label for="setupad_title"><?php _e('Wait for element', 'setupad')?></label>
            </th>

            <td>
                <div class="stpd-tooltip">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-info-circle-fill" viewBox="0 0 16 16">
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                    </svg>
                    <span class="stpd-tooltiptext"><?php _e('Select an element to wait for it to render, before inserting the ad placement. Uses jQuery selectors.','setupad'); ?></span>
                </div>
            </td>

            <td>
                <div class="stpd-btn-row">
                    <input id="setupad_wait_for_element" name="setupad_wait_for_element" size="3000" class="code" placeholder="<?php _e('#primary > #content', 'setupad')?>" AutoComplete=off data-lpignore="true" type="text" value="<?php if (isset($item['setupad_wait_for_element']) && $item['setupad_wait_for_element']) echo $item['setupad_wait_for_element'] ?>">
                </div>
            </td>
        </tr>


        </tbody>
</table>