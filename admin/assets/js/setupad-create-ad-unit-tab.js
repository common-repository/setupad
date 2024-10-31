jQuery(document).ready(function () {

    // Alignment selection START

    let customCssValue = "";
    document.querySelectorAll('.alignment-selection-list-item input').forEach(element => {
        if (element.checked && element.value) {
            if (element.value == 0) {
                document.querySelector("#stpd-custom-css").style.display = "none";
            } else if (element.value == 1) {
                document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: left; display: block; clear: both;";
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = true
            } else if (element.value == 2) {
                document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: center; display: block; clear: both;";
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = true
            } else if (element.value == 3) {
                document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: right; display: block; clear: both;";
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = true
            } else {
                customCssValue = document.querySelector("#stpd-custom-css").value;
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = false
            }
        }
    })

    document.querySelectorAll('.alignment_selection_label').forEach(element => element.addEventListener('click', event => {
        if (!event.target.previousElementSibling.checked) {
            document.querySelectorAll('.alignment-selection-list-item').forEach(element => {
                element.removeAttribute('style');
            })

            if (event.target.previousElementSibling.value == 0) {
                document.querySelector("#stpd-custom-css").style.display = "none";
            } else if (event.target.previousElementSibling.value == 1) {
                document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: left; display: block; clear: both;";
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = true
            } else if (event.target.previousElementSibling.value == 2) {
                document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: center; display: block; clear: both;";
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = true
            } else if (event.target.previousElementSibling.value == 3) {
                document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: right; display: block; clear: both;";
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = true
            } else {
                document.querySelector("#stpd-custom-css").value = customCssValue;
                document.querySelector("#stpd-custom-css").style.display = "block";
                document.querySelector("#stpd-custom-css").readOnly = false
            }

            event.target.previousElementSibling.checked = true;
            event.target.parentElement.style.background = "rgba(146,146,146,.3)";
        }
    }));

    document.querySelectorAll('.alignment-selection-list-item input').forEach(element => element.addEventListener('click', event => {
        document.querySelectorAll('.alignment-selection-list-item').forEach(element => {
            element.removeAttribute('style');
        })

        if (event.target.value == 0) {
            document.querySelector("#stpd-custom-css").style.display = "none";
        } else if (event.target.value == 1) {
            document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: left; display: block; clear: both;";
            document.querySelector("#stpd-custom-css").style.display = "block";
            document.querySelector("#stpd-custom-css").readOnly = true
        } else if (event.target.value == 2) {
            document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: center; display: block; clear: both;";
            document.querySelector("#stpd-custom-css").style.display = "block";
            document.querySelector("#stpd-custom-css").readOnly = true
        } else if (event.target.value == 3) {
            document.querySelector("#stpd-custom-css").value = "margin: 10px 0; text-align: right; display: block; clear: both;";
            document.querySelector("#stpd-custom-css").style.display = "block";
            document.querySelector("#stpd-custom-css").readOnly = true
        } else {
            document.querySelector("#stpd-custom-css").value = customCssValue;
            document.querySelector("#stpd-custom-css").style.display = "block";
            document.querySelector("#stpd-custom-css").readOnly = false
        }

        element.parentElement.style.background = "rgba(146,146,146,.3)";
    }));

    // Alignment selection END

    // Device selection START

    let devices = [];

    //Appending sidebar disabling option values to the hidden input
    document.querySelectorAll('.device_selection_inputs').forEach(function (element) {
        if (element.checked) {
            devices.push(element.value);
        }
    });
    document.querySelector('#device_selections').value = devices;

    document.querySelectorAll('.device_selection_inputs').forEach(element => element.addEventListener('click', event => {
        if (event.target.checked) {
            event.target.parentElement.style.background = "background: rgba(146,146,146,.3);";

            let allDevicesInput = document.querySelector('#all_device_selection');
            if (event.target != allDevicesInput && allDevicesInput.checked) {
                allDevicesInput.checked = false;
                allDevicesInput.parentElement.removeAttribute('style');
                let index = devices.indexOf(allDevicesInput.value);
                devices.splice(index, 1);
                devices.push(event.target.value);
            } else if (event.target === allDevicesInput){
                document.querySelectorAll('.device_selection_inputs').forEach(inputs => {
                    inputs.checked = false;
                    inputs.parentElement.removeAttribute('style');
                    let index = devices.indexOf(inputs.value);
                    devices.splice(index, 1);
                })
                allDevicesInput.checked = true;
                allDevicesInput.parentElement.style.background = "rgba(146,146,146,.3)";
                devices.push(allDevicesInput.value);
            } else {
                devices.push(event.target.value);
            }
        } else {
            const index = devices.indexOf(event.target.value);
            if (index > -1) {
                devices.splice(index, 1);
            }
            event.target.parentElement.removeAttribute('style');
        }
        document.querySelector('#device_selections').value = devices;
    }));

    document.querySelectorAll('.device_selection_label').forEach(element => element.addEventListener('click', event => {
        if (event.target.previousElementSibling.checked){
            event.target.previousElementSibling.checked = false;
            const index = devices.indexOf(event.target.previousElementSibling.value);
            if (index > -1) {
                devices.splice(index, 1);
            }
            event.target.parentElement.removeAttribute('style');
        } else {
            event.target.parentElement.style.background = "rgba(146,146,146,.3)";

            let allDevicesInput = document.querySelector('#all_device_selection');
            if (event.target.previousElementSibling != allDevicesInput && allDevicesInput.checked) {
                allDevicesInput.checked = false;
                allDevicesInput.parentElement.removeAttribute('style');
                let index = devices.indexOf(allDevicesInput.value);
                devices.splice(index, 1);
                event.target.previousElementSibling.checked = true;
                devices.push(event.target.previousElementSibling.value);
            } else if (event.target.previousElementSibling === allDevicesInput){
                document.querySelectorAll('.device_selection_inputs').forEach(inputs => {
                    inputs.checked = false;
                    inputs.parentElement.removeAttribute('style');
                    let index = devices.indexOf(inputs.value);
                    devices.splice(index, 1);
                })
                allDevicesInput.checked = true;
                allDevicesInput.parentElement.style.background = "rgba(146,146,146,.3)";
                devices.push(allDevicesInput.value);
            } else {
                event.target.previousElementSibling.checked = true;
                devices.push(event.target.previousElementSibling.value);
            }
        }
        document.querySelector('#device_selections').value = devices;
    }));

    // Device selection END

    // Page selection START

    let insertionPages = [];

    //Appending sidebar disabling option values to the hidden input
    document.querySelectorAll('.page_selection_inputs').forEach(function (element) {
        if (element.checked) {
            insertionPages.push(element.value);
        }
    });
    document.querySelector('#insertion_pages').value = insertionPages;

    document.querySelectorAll('.page_selection_inputs').forEach(element => element.addEventListener('click', event => {
        if (event.target.checked) {
            insertionPages.push(event.target.value);
            event.target.parentElement.style.background = "rgba(146,146,146,.3)";
        } else {
            const index = insertionPages.indexOf(event.target.value);
            if (index > -1) {
                insertionPages.splice(index, 1);
            }
            event.target.parentElement.removeAttribute('style');
        }
        document.querySelector('#insertion_pages').value = insertionPages;
    }));

    document.querySelectorAll('.page_selection_label').forEach(element => element.addEventListener('click', event => {
        if (event.target.previousElementSibling.checked){
            event.target.previousElementSibling.checked = false;
            const index = insertionPages.indexOf(event.target.previousElementSibling.value);
            if (index > -1) {
                insertionPages.splice(index, 1);
            }
            event.target.parentElement.removeAttribute('style');
        } else {
            event.target.previousElementSibling.checked = true;
            insertionPages.push(event.target.previousElementSibling.value);
            event.target.parentElement.style.background = "rgba(146,146,146,.3)";
        }
        document.querySelector('#insertion_pages').value = insertionPages;
    }));

    // Page selection END

    // Inside HTML insertion type selection START

    document.querySelectorAll('input[name="setupad_inside_html_type"]').forEach(element => element.addEventListener('click', event => {
        event.target.parentElement.style.background = "rgba(146,146,146,.3)";
        Array.from(event.target.parentElement.parentElement.children).forEach(sibling => {
            if (sibling !== event.target.parentElement) {
                sibling.removeAttribute('style');
            }
        });
    }));

    document.querySelectorAll('.setupad_inside_html_type_label').forEach(element => element.addEventListener('click', event => {
        if (!event.target.previousElementSibling.checked) {
            event.target.previousElementSibling.checked = true;
            event.target.parentElement.style.background = "rgba(146,146,146,.3)";
            Array.from(event.target.parentElement.parentElement.children).forEach(sibling => {
                if (sibling !== event.target.parentElement) {
                    sibling.removeAttribute('style');
                }
            });
        }
    }));

    // Inside HTML insertion type selection END

    // Ad output position selection functionality START

    document.querySelectorAll('.stpd-position-select .single-d-input').forEach(element => {
        if (element.checked){
            let position = element.value;

            if(position === "before_paragraph") {
                toggleElements(true, '.setupad-before-paragraph', '#setupad-before-paragraph', '#setupad-before-every-paragraph','#setupad-before-every-paragraph-starting-from');
            } else if (position === "after_paragraph") {
                toggleElements(true, '.setupad-after-paragraph', '#setupad-after-paragraph', '#setupad-after-every-paragraph', '#setupad-after-every-paragraph-starting-from');
            } else if (position === "before_image") {
                toggleElements(true, '.setupad-before-image', '#setupad-before-image', '#setupad-before-every-image', '#setupad-before-every-image-starting-from');
            } else if (position === "after_image") {
                toggleElements(true, '.setupad-after-image', '#setupad-after-image', '#setupad-after-every-image', '#setupad-after-every-image-starting-from');
            } else if (position === "before_excerpt") {
                toggleElements(true, '.setupad-before-excerpt', '#setupad-before-excerpt', '#setupad-before-every-excerpt', '#setupad-before-every-excerpt-starting-from');
            } else if (position === "after_excerpt") {
                toggleElements(true, '.setupad-after-excerpt', '#setupad-after-excerpt', '#setupad-after-every-excerpt', '#setupad-after-every-excerpt-starting-from');
            } else if (position === "between_comments") {
                toggleElements(true, '.setupad-between-comments', '#setupad-between-comments', '#setupad-between-every-comment', '#setupad-between-every-comment-starting-from');
            } else if (position === "between_posts") {
                toggleElements(true, '.setupad-between-posts', '#setupad-between-posts', '#setupad-between-every-post', '#setupad-between-every-post-starting-from');
            } else if (position === "before_list"){
                toggleElements(true, '.setupad-before-list', '#setupad-before-list','#setupad-before-every-list','#setupad-before-every-list-starting-from');
            } else if (position === "after_list"){
                toggleElements(true, '.setupad-after-list', '#setupad-after-list','#setupad-after-every-list','#setupad-after-every-list-starting-from');
            } else if (position === "between_list_items"){
                toggleElements(true, '.setupad-between-list-items', '#setupad-between-list-items','#setupad-between-every-list-item','#setupad-between-every-list-item-starting-from');
            } else if (position === "before_html"){
                toggleElements(true, '.setupad-before-html', '#setupad-before-html', '#setupad-before-every-html', '#setupad-before-every-html-starting-from');
            } else if (position === "after_html"){
                toggleElements(true, '.setupad-after-html', '#setupad-after-html', '#setupad-after-every-html', '#setupad-after-every-html-starting-from');
            } else if (position === "inside_html"){
                toggleElements(true, '.setupad-inside-html', '#setupad-inside-html', '#setupad-inside-every-html', '#setupad-inside-every-html-starting-from');
                jQuery('.setupad-inside-html-type-selection').show();
            }
        }
    })
    document.querySelectorAll('.stpd-position-select div.single-d-div').forEach(element => element.addEventListener('click', event => {
        let position = event.currentTarget.querySelector('.single-d-input').value;

        if(position === "before_paragraph")
            toggleElements(true, '.setupad-before-paragraph', '#setupad-before-paragraph', '#setupad-before-every-paragraph', '#setupad-before-every-paragraph-starting-from');
        else
            toggleElements(false, '.setupad-before-paragraph', '#setupad-before-paragraph', '#setupad-before-every-paragraph', '#setupad-before-every-paragraph-starting-from');

        if(position === "after_paragraph")
            toggleElements(true, '.setupad-after-paragraph', '#setupad-after-paragraph', '#setupad-after-every-paragraph', '#setupad-after-every-paragraph-starting-from');
        else
            toggleElements(false, '.setupad-after-paragraph', '#setupad-after-paragraph', '#setupad-after-every-paragraph', '#setupad-after-every-paragraph-starting-from');

        if(position === "before_image")
            toggleElements(true, '.setupad-before-image', '#setupad-before-image', '#setupad-before-every-image', '#setupad-before-every-image-starting-from');
        else
            toggleElements(false, '.setupad-before-image', '#setupad-before-image', '#setupad-before-every-image', '#setupad-before-every-image-starting-from');

        if(position === "after_image")
            toggleElements(true, '.setupad-after-image', '#setupad-after-image', '#setupad-after-every-image', '#setupad-after-every-image-starting-from');
        else
            toggleElements(false, '.setupad-after-image', '#setupad-after-image', '#setupad-after-every-image', '#setupad-after-every-image-starting-from');

        if(position === "before_excerpt")
            toggleElements(true, '.setupad-before-excerpt', '#setupad-before-excerpt', '#setupad-before-every-excerpt', '#setupad-before-every-excerpt-starting-from');
        else
            toggleElements(false, '.setupad-before-excerpt', '#setupad-before-excerpt', '#setupad-before-every-excerpt', '#setupad-before-every-excerpt-starting-from');

        if(position === "after_excerpt")
            toggleElements(true, '.setupad-after-excerpt', '#setupad-after-excerpt', '#setupad-after-every-excerpt', '#setupad-after-every-excerpt-starting-from');
        else
            toggleElements(false, '.setupad-after-excerpt', '#setupad-after-excerpt', '#setupad-after-every-excerpt', '#setupad-after-every-excerpt-starting-from');

        if(position === "between_comments")
            toggleElements(true, '.setupad-between-comments', '#setupad-between-comments', '#setupad-between-every-comment', '#setupad-between-every-comment-starting-from');
        else
            toggleElements(false, '.setupad-between-comments', '#setupad-between-comments', '#setupad-between-every-comment', '#setupad-between-every-comment-starting-from');

        if(position === "between_posts")
            toggleElements(true, '.setupad-between-posts', '#setupad-between-posts', '#setupad-between-every-post', '#setupad-between-every-post-starting-from');
        else
            toggleElements(false, '.setupad-between-posts', '#setupad-between-posts', '#setupad-between-every-post', '#setupad-between-every-post-starting-from');

        if (position === "before_list")
            toggleElements(true, '.setupad-before-list', '#setupad-before-list','#setupad-before-every-list','#setupad-before-every-list-starting-from');
        else
            toggleElements(false, '.setupad-before-list', '#setupad-before-list','#setupad-before-every-list','#setupad-before-every-list-starting-from');

        if (position === "after_list")
            toggleElements(true, '.setupad-after-list', '#setupad-after-list','#setupad-after-every-list','#setupad-after-every-list-starting-from');
        else
            toggleElements(false, '.setupad-after-list', '#setupad-after-list','#setupad-after-every-list','#setupad-after-every-list-starting-from');

        if (position === "between_list_items")
            toggleElements(true, '.setupad-between-list-items', '#setupad-between-list-items','#setupad-between-every-list-item','#setupad-between-every-list-item-starting-from');
        else
            toggleElements(false, '.setupad-between-list-items', '#setupad-between-list-items','#setupad-between-every-list-item','#setupad-between-every-list-item-starting-from');

        if (position === "before_html")
            toggleElements(true, '.setupad-before-html', '#setupad-before-html', '#setupad-before-every-html', '#setupad-before-every-html-starting-from');
        else
            toggleElements(false, '.setupad-before-html', '#setupad-before-html', '#setupad-before-every-html', '#setupad-before-every-html-starting-from');

        if (position === "after_html")
            toggleElements(true, '.setupad-after-html', '#setupad-after-html', '#setupad-after-every-html', '#setupad-after-every-html-starting-from');
        else
            toggleElements(false, '.setupad-after-html', '#setupad-after-html', '#setupad-after-every-html', '#setupad-after-every-html-starting-from');

        if (position === "inside_html"){
            toggleElements(true, '.setupad-inside-html', '#setupad-inside-html', '#setupad-inside-every-html', '#setupad-inside-every-html-starting-from');
            jQuery('.setupad-inside-html-type-selection').show();
        }
        else {
            toggleElements(false, '.setupad-inside-html', '#setupad-inside-html', '#setupad-inside-every-html', '#setupad-inside-every-html-starting-from');
            jQuery('.setupad-inside-html-type-selection').hide();
        }
    }))

    // Ad output position selection functionality END

    // Image ad type handling and functionality START

    let dropArea = document.getElementById('drop-area')
    ;['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, preventDefaults, false)
    })

    ;['dragenter', 'dragover'].forEach(eventName => {
        dropArea.addEventListener(eventName, highlight, false)
    })

    ;['dragleave', 'drop'].forEach(eventName => {
        dropArea.addEventListener(eventName, unhighlight, false)
    })

    dropArea.addEventListener('drop', handleDrop, false)

    document.getElementById('stpd-file-elem').addEventListener('change', e => {
        handleInput(e.target);
    })

    document.querySelectorAll('.delete-uploaded-file-btn').forEach(element => element.addEventListener('click', e => {
        document.getElementById('stpd-file-uploaded').style.display = 'none';
        document.getElementById('stpd-file-size-format-error').style.display = 'none';
        document.getElementById('stpd-upload-file').style.display = 'block';
    }));

    // Image ad type handling and functionality START

    // Ad type selector initial visibility settings START

    document.querySelectorAll('.stpd-type-selection .single-d-input').forEach(element => {
        if (element.checked){
            let adcode_editor = jQuery('#editortext');
            let adcode_editor_elements = jQuery('#content_elements');
            let double_banner_1_editor = jQuery('#db_1_editortext');
            let double_banner_1_editor_elements = jQuery('#db_1_elements');
            let double_banner_2_editor = jQuery('#db_2_editortext');
            let double_banner_2_editor_elements = jQuery('#db_2_elements');

            if(element.value ==="codes") {
                jQuery(".setupad-adcodes").show();
                jQuery(".setupad-double-1").hide();
                jQuery(".setupad-double-2").hide();
                jQuery(".setupad-image").hide();
                jQuery(".img-width").hide();
                jQuery(".img-height").hide();
                jQuery(".img-alt").hide();
                jQuery(".img-url").hide();
                jQuery(".setupad-shortcode").hide();
                jQuery(adcode_editor).attr('name', 'setupad_content');
                jQuery(adcode_editor_elements).attr('name', 'setupad_content_elements');
                jQuery(double_banner_1_editor).removeAttr('name');
                jQuery(double_banner_1_editor_elements).removeAttr('name');
                jQuery(double_banner_2_editor).removeAttr('name');
                jQuery(double_banner_2_editor_elements).removeAttr('name');
                advancedOptions(element.value);
            } else if(element.value ==="images") {
                jQuery(".setupad-adcodes").hide();
                jQuery(".setupad-double-1").hide();
                jQuery(".setupad-double-2").hide();
                jQuery(".setupad-image").show();
                jQuery(".img-width").show();
                jQuery(".img-height").show();
                jQuery(".img-alt").show();
                jQuery(".img-url").show();
                jQuery(".setupad-shortcode").hide();
                jQuery(adcode_editor).removeAttr('name');
                jQuery(adcode_editor_elements).removeAttr('name');
                jQuery(double_banner_1_editor).removeAttr('name');
                jQuery(double_banner_1_editor_elements).removeAttr('name');
                jQuery(double_banner_2_editor).removeAttr('name');
                jQuery(double_banner_2_editor_elements).removeAttr('name');
                advancedOptions(element.value);
            } else if(element.value ==="shortcode") {
                jQuery(".setupad-adcodes").hide();
                jQuery(".setupad-double-1").hide();
                jQuery(".setupad-double-2").hide();
                jQuery(".setupad-image").hide();
                jQuery(".img-width").hide();
                jQuery(".img-height").hide();
                jQuery(".img-alt").hide();
                jQuery(".img-url").hide();
                jQuery(".setupad-shortcode").show();
                jQuery('#setupad_lazy_loading').prop('checked', false);
                jQuery('#setupad_lazy_loading').val(false);
                jQuery(adcode_editor).removeAttr('name');
                jQuery(adcode_editor_elements).removeAttr('name');
                jQuery(double_banner_1_editor).removeAttr('name');
                jQuery(double_banner_1_editor_elements).removeAttr('name');
                jQuery(double_banner_2_editor).removeAttr('name');
                jQuery(double_banner_2_editor_elements).removeAttr('name');
                advancedOptions(element.value);
            } else if(element.value === "double_banner"){
                jQuery(".setupad-adcodes").hide();
                jQuery(".setupad-double-1").show();
                jQuery(".setupad-double-2").show();
                jQuery(".setupad-image").hide();
                jQuery(".img-width").hide();
                jQuery(".img-height").hide();
                jQuery(".img-alt").hide();
                jQuery(".img-url").hide();
                jQuery(".setupad-shortcode").hide();
                jQuery(adcode_editor).removeAttr('name');
                jQuery(adcode_editor_elements).removeAttr('name');
                jQuery(double_banner_1_editor).attr('name', 'setupad_double_banner_1');
                jQuery(double_banner_1_editor_elements).attr('name', 'setupad_double_banner_1_elements');
                jQuery(double_banner_2_editor).attr('name', 'setupad_double_banner_2');
                jQuery(double_banner_2_editor_elements).attr('name', 'setupad_double_banner_2_elements');
                advancedOptions(element.value);
            }
        }
    })

    // Ad type selector initial visibility settings END

    // Ad type selector click visibility functionality START

    document.querySelectorAll('.stpd-type-selection div.single-d-div').forEach(element => element.addEventListener('click', event => {
        let position = event.currentTarget.querySelector('.single-d-input').value;
        let adcode_editor = jQuery('#editortext');
        let adcode_editor_elements = jQuery('#content_elements');
        let double_banner_1_editor = jQuery('#db_1_editortext');
        let double_banner_1_editor_elements = jQuery('#db_1_elements');
        let double_banner_2_editor = jQuery('#db_2_editortext');
        let double_banner_2_editor_elements = jQuery('#db_2_elements');

        if(position === "codes") {
            jQuery(".setupad-adcodes").show();
            jQuery(".setupad-double-1").hide();
            jQuery(".setupad-double-2").hide();
            jQuery(".setupad-image").hide();
            jQuery(".img-width").hide();
            jQuery(".img-height").hide();
            jQuery(".img-alt").hide();
            jQuery(".img-url").hide();
            jQuery(".setupad-shortcode").hide();
            jQuery(adcode_editor).attr('name', 'setupad_content');
            jQuery(adcode_editor_elements).attr('name', 'setupad_content_elements');
            jQuery(double_banner_1_editor).removeAttr('name');
            jQuery(double_banner_1_editor_elements).removeAttr('name');
            jQuery(double_banner_2_editor).removeAttr('name');
            jQuery(double_banner_2_editor_elements).removeAttr('name');
            advancedOptions(position);
        } else if(position === "images") {
            jQuery(".setupad-adcodes").hide();
            jQuery(".setupad-double-1").hide();
            jQuery(".setupad-double-2").hide();
            jQuery(".setupad-image").show();
            jQuery(".img-width").show();
            jQuery(".img-height").show();
            jQuery(".img-alt").show();
            jQuery(".img-url").show();
            jQuery(".setupad-shortcode").hide();
            jQuery(adcode_editor).removeAttr('name');
            jQuery(adcode_editor_elements).removeAttr('name');
            jQuery(double_banner_1_editor).removeAttr('name');
            jQuery(double_banner_1_editor_elements).removeAttr('name');
            jQuery(double_banner_2_editor).removeAttr('name');
            jQuery(double_banner_2_editor_elements).removeAttr('name');
            advancedOptions(position);
        } else if(position === "shortcode") {
            jQuery(".setupad-adcodes").hide();
            jQuery(".setupad-double-1").hide();
            jQuery(".setupad-double-2").hide();
            jQuery(".setupad-image").hide();
            jQuery(".img-width").hide();
            jQuery(".img-height").hide();
            jQuery(".img-alt").hide();
            jQuery(".img-url").hide();
            jQuery(".setupad-shortcode").show();
            jQuery('#setupad_lazy_loading').prop('checked', false);
            jQuery('#setupad_lazy_loading').val(false);
            jQuery(adcode_editor).removeAttr('name');
            jQuery(adcode_editor_elements).removeAttr('name');
            jQuery(double_banner_1_editor).removeAttr('name');
            jQuery(double_banner_1_editor_elements).removeAttr('name');
            jQuery(double_banner_2_editor).removeAttr('name');
            jQuery(double_banner_2_editor_elements).removeAttr('name');
            advancedOptions(position);
        } else if(position === "double_banner"){
            jQuery(".setupad-adcodes").hide();
            jQuery(".setupad-double-1").show();
            jQuery(".setupad-double-2").show();
            jQuery(".setupad-image").hide();
            jQuery(".img-width").hide();
            jQuery(".img-height").hide();
            jQuery(".img-alt").hide();
            jQuery(".img-url").hide();
            jQuery(".setupad-shortcode").hide();
            jQuery(adcode_editor).removeAttr('name');
            jQuery(adcode_editor_elements).removeAttr('name');
            jQuery(double_banner_1_editor).attr('name', 'setupad_double_banner_1');
            jQuery(double_banner_1_editor_elements).attr('name', 'setupad_double_banner_1_elements');
            jQuery(double_banner_2_editor).attr('name', 'setupad_double_banner_2');
            jQuery(double_banner_2_editor_elements).attr('name', 'setupad_double_banner_2_elements');
            advancedOptions(position);
        }
    }))

    // Ad type selector click visibility functionality END
    document.querySelectorAll('.stpd-position-select div.single-d-div').forEach(element => element.addEventListener('click', event => {
        let ad_type = document.querySelector('.stpd-type-selection div.single-d-div.checked .single-d-input').value;
        advancedOptions(ad_type);
    }))
    // Ad position selector click visibility functionality START

    // Ad position selector click visibility functionality END

    // Advanced options functionality START

    jQuery(document.querySelector('#advanced-options-btn')).data('enabled', false);

    // Advanced options button click
    document.querySelector('#advanced-options-btn').addEventListener('click', event => {
        event.preventDefault();
        jQuery(event.currentTarget).data('enabled') === true ? jQuery(event.currentTarget).data('enabled', false) : jQuery(event.currentTarget).data('enabled', true);
        let position =	document.querySelector('.stpd-type-selection div.single-d-div.checked .single-d-input').value;
        advancedOptions(position);
    });

    let blacklistBtn = document.querySelector('#blacklist-select-btn');
    let whitelistBtn = document.querySelector('#whitelist-select-btn');

    // Blacklist button click
    blacklistBtn.addEventListener('click', event => {
        event.preventDefault();
        jQuery('#stpd-excluded-url-list-box').show();
        jQuery('#stpd-included-url-list-box').hide();
        blacklistBtn.style.backgroundColor = "#f0f7f8"
        whitelistBtn.style.backgroundColor = "transparent";
    });
    // Whitelist button click
    whitelistBtn.addEventListener('click', event => {
        event.preventDefault();
        jQuery('#stpd-excluded-url-list-box').hide();
        jQuery('#stpd-included-url-list-box').show();
        whitelistBtn.style.backgroundColor = "#f0f7f8";
        blacklistBtn.style.backgroundColor = "transparent";
    });

    // Advanced options functionality END

    // URL Whitelist/Blacklist functionality START
    // Delete URL from list button click
    jQuery('.stpd-delete-url-btn').each(function() {
        jQuery(this).on('click', function(event) {
            deleteURLBtnLogic(event,jQuery(this));
        });
    });

    // Keyboard enter press for exclusions
    jQuery('#setupad_url_exclusions').on('keypress', function(event) {
        if (event.which === 13) {  // 13 is the Enter key
            event.preventDefault();
            jQuery('#add-exclusion').click();  // Trigger click on #add-exclusion
        }
    });

    //Keyboard enter press for inclusions
    jQuery('#setupad_url_inclusions').on('keypress', function(event) {
        if (event.which === 13) {  // 13 is the Enter key
            event.preventDefault();
            jQuery('#add-inclusion').click();  // Trigger click on #add-inclusion
        }
    });

    // Add URL to Blacklist click
    jQuery('#add-exclusion').on('click', function(event) {
        event.preventDefault();
        let element = jQuery('#setupad_url_exclusions');
        let exclusion = element.val().trim();
        if (validateURL(exclusion, element)){
            let appendString =
                `<div class="stpd-btn-row">
                    <li class="stpd-excluded-url">${exclusion}</li>
                    <button class="stpd-delete-url-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>\n</button>
                </div>`;
            let newElement = jQuery(appendString).appendTo('#stpd-excluded-url-list-box ul');
            newElement.find('.stpd-delete-url-btn').click(function(event) {
                deleteURLBtnLogic(event,jQuery(this));
            });
            updateURLExclusionInput();
            element.val('');
        }
    });

    // Add URL to Whitelist click
    jQuery('#add-inclusion').on('click', function(event) {
        event.preventDefault();
        let element = jQuery('#setupad_url_inclusions');
        let inclusion = element.val().trim();
        if (validateURL(inclusion, element)){
            let appendString =
                `<div class="stpd-btn-row">
                    <li class="stpd-included-url">${inclusion}</li>
                    <button class="stpd-delete-url-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>\n</button>
                </div>`;
            let newElement = jQuery(appendString).appendTo('#stpd-included-url-list-box ul');
            newElement.find('.stpd-delete-url-btn').click(function(event) {
                deleteURLBtnLogic(event,jQuery(this));
            });
            updateURLInclusionInput();
            element.val('');
        }
    });

    // URL Whitelist/Blacklist functionality END

    // Helper functions

    //Toggle elements visibility and selected attributes for position selection
    function toggleElements (show, classSelector, block_position, multiple_block_position, starting_position) {
        if (show) {
            jQuery(classSelector).show();
            jQuery(block_position).attr('name', 'setupad_block_position');
            jQuery(multiple_block_position).attr('name', 'setupad_multiple_block_position');
            jQuery(starting_position).attr('name', 'setupad_starting_position');

            document.querySelectorAll(classSelector + ' th').forEach(element => element.addEventListener('click', event => {
                element.querySelector('input').checked = true;
                if (element.querySelector('input').className == 'multiple-positions') {
                    document.querySelector(block_position).disabled = true;
                    document.querySelector(multiple_block_position).disabled = false;
                    document.querySelector(starting_position).disabled = false;
                } else {
                    document.querySelector(block_position).disabled = false;
                    document.querySelector(multiple_block_position).disabled = true;
                    document.querySelector(starting_position).disabled = true;
                }

            }))
        } else {
            jQuery(classSelector).hide();
            jQuery(block_position).removeAttr('name');
            jQuery(multiple_block_position).removeAttr('name');
            jQuery(starting_position).removeAttr('name');
        }
    }
    function preventDefaults (e) {
        e.preventDefault()
        e.stopPropagation()
    }
    function highlight(e) {
        dropArea.classList.add('highlight')
    }
    function unhighlight(e) {
        dropArea.classList.remove('highlight')
    }
    function handleDrop(e) {
        let dt = e.dataTransfer
        let file = dt.files
        let input = document.getElementById('stpd-file-elem');
        input.files = file;
        handleInput(input);
        e.preventDefault();
    }
    function handleInput (input){
        let fileName = input.files[0].name;
        let acceptedFileTypes = [
            'image/gif',
            'image/jpeg',
            'image/png',
            'image/webp',
        ];
        let fileType = input.files[0].type;

        if (fileName.length > 35) {
            fileName = fileName.substr(0, 20) + '...' + fileName.substr(fileName.length-10, fileName.length);
        }

        if (input.files[0].size < 8388608 && acceptedFileTypes.includes(fileType)) {
            document.querySelector('p.uploaded-file-name').innerHTML = fileName;
            document.querySelector('p.uploaded-file-size').innerHTML = formatBytes(input.files[0].size, 1);

            document.getElementById('stpd-upload-file').style.display = 'none';
            document.getElementById('stpd-file-uploaded').style.display = 'flex';

            function formatBytes(bytes, decimals = 2) {
                if (!+bytes) return '0 Bytes'

                const k = 1024
                const dm = decimals < 0 ? 0 : decimals
                const sizes = ['bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB']

                const i = Math.floor(Math.log(bytes) / Math.log(k))

                return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))}${sizes[i]}`
            }
        } else if (input.files[0].size > 8388608){
            input.value = '';

            document.querySelector('p.uploaded-file-name-sm').innerHTML = fileName;
            document.querySelector('.uploaded-file-data-err p').innerHTML = 'File too large (max. 8MB)';
            document.getElementById('stpd-upload-file').style.display = 'none';
            document.getElementById('stpd-file-size-format-error').style.display = 'flex';
        } else if (!acceptedFileTypes.includes(fileType)) {
            input.value = '';

            document.querySelector('p.uploaded-file-name-sm').innerHTML = fileName;
            document.querySelector('.uploaded-file-data-err p').innerHTML = 'Wrong format, please upload JPG, PNG, WEBP, GIF. (max. 8MB)';
            document.getElementById('stpd-upload-file').style.display = 'none';
            document.getElementById('stpd-file-size-format-error').style.display = 'flex';
        }
    }
    // Advanced Options button functionality
    function advancedOptions(ad_type){

        let advancedOptionsBtn = document.querySelector('#advanced-options-btn');
        let position = document.querySelector('.stpd-position-select div.single-d-div.checked .single-d-input').value;
        jQuery(advancedOptionsBtn).data('enabled') === false ? jQuery(advancedOptionsBtn).css('text-decoration','none') : jQuery(advancedOptionsBtn).data('enabled') === true ? jQuery(advancedOptionsBtn).css('text-decoration','#0497A5 underline 2px') : null;

        // Hide/Show advanced options
        document.querySelectorAll('.advanced-option').forEach( element => {
            if(jQuery(advancedOptionsBtn).data('enabled') === true){
                //Handle when to not show specific options, skip error elements
                if(!jQuery(element).hasClass('error')){
                    let hideElement = false;

                    // Disable lazy loading for shortcode
                    if ( jQuery(element).hasClass('setupad-lazy-loading') && ( ad_type === 'shortcode' || position === 'header' ) ){
                        jQuery(element).hide();
                        hideElement = true;
                        jQuery(element).find('input').prop('disabled', true);
                    }
                    // Disable target and referrerpolicy for non image placement
                    if ( (jQuery(element).hasClass('setupad-img-target') || jQuery(element).hasClass('setupad-img-referrerpolicy') ) && ad_type !== 'images'){
                        jQuery(element).hide();
                        hideElement = true;
                        jQuery(element).find('input').prop('disabled', true);
                    }
                    // Disable insertion delay and wait for element for non HTML insertions
                    if ( (jQuery(element).hasClass('setupad-insertion-delay') || jQuery(element).hasClass('setupad-wait-for-element') ) && (position !== 'before_html' && position !== 'after_html' && position !== 'inside_html') ) {
                        jQuery(element).hide();
                        hideElement = true;
                        jQuery(element).find('input').prop('disabled', true);
                    }
                    if (!hideElement) {
                        jQuery(element).show(200);
                        jQuery(element).find('input').prop('disabled', false);
                    }

                }
            }
            else if (jQuery(advancedOptionsBtn).data('enabled') === false)
                jQuery(element).hide(200);
        });

    }
    // Delete URL from URL list button logic
    function deleteURLBtnLogic(event, button){
        event.preventDefault();
        button.parent().remove();
        if (button.siblings('.stpd-excluded-url').length > 0)
            updateURLExclusionInput();
        else if (button.siblings('.stpd-included-url').length > 0)
            updateURLInclusionInput();
    }
    // Frontend URL input validation
    function validateURL(url, element){
        function logError(element, error, text){
            element.css('box-shadow', '0 0 5px red');
            error.find('strong').text(text);
            error.css('display', 'table-row');
        }

        element = element  || null;
        let error = element.closest('tr').nextAll('tr.error').first();
        error.hide();
        element.on('blur', function() {
            element.css('box-shadow', 'none');
        });
        if (url.split(/[\s,;]+(?![^()]*\))/).length === 1){
            if (url !== ""){
                let relativeURL = url.replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&').replace(/\/$/, '');
                let flag = false;

                jQuery('.stpd-excluded-url').each(function(){
                    if (relativeURL === jQuery(this).text().trim().replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&').replace(/\/$/, '')) {
                        let text = 'This URL is already added to Blacklist!';
                        logError(element, error, text);
                        flag = true;
                        return false;
                    }
                });
                jQuery('.stpd-included-url').each(function(){
                    if (relativeURL === jQuery(this).text().trim().replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&').replace(/\/$/, '')) {
                        let text = 'This URL is already added to Whitelist!';
                        logError(element, error, text);
                        flag = true;
                        return false;
                    }
                });
                if (flag === true)
                    return false;
                if(url.length >= 2048){
                    let text = 'The input URL is too long!';
                    logError(element, error, text);
                    return false;
                }
                return true;
            }
            else{
                let text = 'Please provide a valid URL!';
                logError(element, error, text);
                return false;
            }
        }
        else{
            let text = 'Please enter a single URL and do not use separators like comma, space, semicolon, etc.!';
            logError(element, error, text);
            return false;
        }
    }
    // Update URL exclusion list and values
    function updateURLExclusionInput(){
        let urls = [];
        jQuery('.stpd-excluded-url').each( function() {
            urls.push(jQuery(this).text());
        });
        document.querySelector('input[name="setupad_url_exclusions"]').value = urls;
    }
    // Update URL inclusion list and values
    function updateURLInclusionInput(){
        let urls = [];
        jQuery('.stpd-included-url').each( function() {
            urls.push(jQuery(this).text());
        });
        document.querySelector('input[name="setupad_url_inclusions"]').value = urls;
    }
});