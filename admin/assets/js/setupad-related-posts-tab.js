jQuery(document).ready(function () {

    // If no ads available, display message
    if (document.querySelector('#rp-ad-code-block .single-dropdown-list').children.length < 1 ) {
        document.querySelector('#rp-ad-code-block span.optext').textContent = 'No ads available';
    }
    if (document.querySelector('#rp-mobile-ad-code-block .single-dropdown-list').children.length < 1 ) {
        document.querySelector('#rp-mobile-ad-code-block span.optext').textContent = 'No ads available';
    }

    // Form submit code, map selected related article categories
    document.getElementById("form").onsubmit = function() {
        let relatedPostCategories = [];
        let relatedPostMobileCategories = [];

        document.querySelectorAll('.related-categories-arr').forEach(element => {
            if (element.selected) {
                relatedPostCategories.push(element.value);
            }
        })

        document.querySelectorAll('.related-categories-mobile-arr').forEach(element => {
            if (element.selected) {
                relatedPostMobileCategories.push(element.value);
            }
        })

        document.getElementById("related_articles_categories").value = relatedPostCategories.join(',');
        document.getElementById("related_mobile_articles_categories").value = relatedPostMobileCategories.join(',');
    }

    // Ad code block functionality START

    document.getElementById('setupad_related_articles_ads').addEventListener('click', event => {
        if (event.target.checked) {
            document.getElementById('rp-ad-code-block').style.display = 'table-row';
        } else {
            document.getElementById('rp-ad-code-block').style.display = 'none';
        }
    })

    document.getElementById('setupad_mobile_related_articles_ads').addEventListener('click', event => {
        if (event.target.checked) {
            document.getElementById('rp-mobile-ad-code-block').style.display = 'table-row';
        } else {
            document.getElementById('rp-mobile-ad-code-block').style.display = 'none';
        }
    })

    // Ad code block functionality END

    // Post title alignment functionality START

    document.querySelectorAll('input[name="setupad_related_posts_post_title_alignment"], input[name="setupad_mobile_related_posts_post_title_alignment"]').forEach(element => element.addEventListener('click', event => {
        event.target.parentElement.style.background = "rgba(146,146,146,.3)";
        Array.from(event.target.parentElement.parentElement.children).forEach(sibling => {
            if (sibling !== event.target.parentElement) {
                sibling.removeAttribute('style');
            }
        });
    }));

    document.querySelectorAll('.setupad_related_posts_post_title_alignment_label, .setupad_mobile_related_posts_post_title_alignment_label').forEach(element => element.addEventListener('click', event => {
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

    // Post title alignment functionality END

    // Thumbnail settings/slider functionality START

    // Desktop
    if (document.getElementById('stpd-thumb-width') && document.getElementById('stpd-thumb-height')){
        let widthSlider = document.getElementById('stpd-thumb-width-slider');
        let heightSlider = document.getElementById('stpd-thumb-height-slider');
        let widthInputBox = document.getElementById('stpd-thumb-width');
        let heightInputBox = document.getElementById('stpd-thumb-height');
        let thumbnailPreview = document.getElementById('thumbnail-preview');

        // Update the current slider value (each time you drag the slider handle)
        widthSlider.oninput = function() {
            widthInputBox.value = this.value;
            thumbnailPreview.querySelectorAll('.thumbnail > div').forEach(img => img.style.width = widthSlider.value + "%");
        }
        heightSlider.oninput = function() {
            heightInputBox.value = this.value;
            thumbnailPreview.querySelectorAll('.thumbnail > div').forEach(img => img.style.paddingTop = heightSlider.value + "%");
        }
    }

    // Mobile
    if (document.getElementById('stpd-mobile-thumb-width') && document.getElementById('stpd-mobile-thumb-height')){
        let widthSlider = document.getElementById('stpd-mobile-thumb-width-slider');
        let heightSlider = document.getElementById('stpd-mobile-thumb-height-slider');
        let widthInputBox = document.getElementById('stpd-mobile-thumb-width');
        let heightInputBox = document.getElementById('stpd-mobile-thumb-height');
        let thumbnailPreview = document.getElementById('thumbnail-mobile-preview');

        // Update the current slider value (each time you drag the slider handle)
        widthSlider.oninput = function() {
            widthInputBox.value = this.value;
            thumbnailPreview.querySelectorAll('.thumbnail > div').forEach(img => img.style.width = widthSlider.value + "%");
        }
        heightSlider.oninput = function() {
            heightInputBox.value = this.value;
            thumbnailPreview.querySelectorAll('.thumbnail > div').forEach(img => img.style.paddingTop = heightSlider.value + "%");
        }
    }

    // Thumbnail settings/slider functionality END


    // Column selection functionality START

    // On page open Desktop
    document.querySelectorAll('.single-d-div').forEach(function(div) {
        // Check if the div contains a child input with name related_posts_columns
        const input = div.querySelector('input[name="setupad_related_posts_columns"]');
        const mobile_input = div.querySelector('input[name="setupad_mobile_related_posts_columns"]');
        if (input) {
            // Add change event listener to the parent div
            if (div.classList.contains('checked')) {
                // Get the value and call switchColumns
                const columns = input.value;
                switchColumns(columns, 'thumbnail-preview');
            }
            div.addEventListener('change', function(event) {
                // Check if the div has the class checked
                if (div.classList.contains('checked')) {
                    // Get the value and call switchColumns
                    const columns = input.value;
                    switchColumns(columns, 'thumbnail-preview');
                }
            });
        }
        else if (mobile_input){
            // Add change event listener to the parent div
            if (div.classList.contains('checked')) {
                // Get the value and call switchColumns
                const columns = mobile_input.value;
                switchColumns(columns, 'thumbnail-mobile-preview');
            }
            div.addEventListener('change', function(event) {
                // Check if the div has the class checked
                if (div.classList.contains('checked')) {
                    // Get the value and call switchColumns
                    const columns = mobile_input.value;
                    switchColumns(columns, 'thumbnail-mobile-preview');
                }
            });
        }
    });
    function switchColumns(columns, thumbnail_preview_id){

        const thumbnailWrapper = document.getElementById(thumbnail_preview_id);
        const thumbnails = thumbnailWrapper.children;

        // Calculate the number of items to show based on the column amount, if 1 column then show 2 thumbs
        let visibleThumbnails = columns == 1 ? 2 : Math.min(columns, thumbnails.length);

        // Change grid columns for thumbnail preview
        thumbnailWrapper.style.gridTemplateColumns = `repeat(${columns}, 1fr)`;

        // Hide all child elements
        for (let i = 0; i < thumbnails.length; i++) {
            thumbnails[i].style.display = 'none';
        }

        // Show the required number of child elements
        for (let j = 0; j < visibleThumbnails; j++) {
            thumbnails[j].style.display = 'flex';
        }

    }
    // Column selection functionality END


    // Advanced options functionality START

    jQuery(document.querySelector('#advanced-options-btn')).data('enabled', false);
    jQuery(document.querySelector('#advanced-mobile-options-btn')).data('enabled', false);


    // Advanced options button click
    document.querySelector('#advanced-options-btn').addEventListener('click', event => {
        event.preventDefault();
        jQuery(event.currentTarget).data('enabled') === true ? jQuery(event.currentTarget).data('enabled', false) : jQuery(event.currentTarget).data('enabled', true);
        advancedOptions('desktop');
    });

    document.querySelector('#advanced-mobile-options-btn').addEventListener('click', event => {
        event.preventDefault();
        jQuery(event.currentTarget).data('enabled') === true ? jQuery(event.currentTarget).data('enabled', false) : jQuery(event.currentTarget).data('enabled', true);
        advancedOptions('mobile');
    });

    const blacklistBtn = document.querySelector('#blacklist-select-btn');
    const whitelistBtn = document.querySelector('#whitelist-select-btn');
    const blacklistMobileBtn =  document.querySelector('#blacklist-mobile-select-btn');
    const whitelistMobileBtn =  document.querySelector('#whitelist-mobile-select-btn');


    // Blacklist button click
    blacklistBtn.addEventListener('click', event => {
        event.preventDefault();
        jQuery('#stpd-excluded-url-list-box').show();
        jQuery('#stpd-included-url-list-box').hide();
        blacklistBtn.style.backgroundColor = "#f0f7f8"
        whitelistBtn.style.backgroundColor = "transparent";
    });
    blacklistMobileBtn.addEventListener('click', event => {
        event.preventDefault();
        jQuery('#stpd-mobile-excluded-url-list-box').show();
        jQuery('#stpd-mobile-included-url-list-box').hide();
        blacklistMobileBtn.style.backgroundColor = "#f0f7f8"
        whitelistMobileBtn.style.backgroundColor = "transparent";
    });
    // Whitelist button click
    whitelistBtn.addEventListener('click', event => {
        event.preventDefault();
        jQuery('#stpd-excluded-url-list-box').hide();
        jQuery('#stpd-included-url-list-box').show();
        whitelistBtn.style.backgroundColor = "#f0f7f8";
        blacklistBtn.style.backgroundColor = "transparent";
    });
    whitelistMobileBtn.addEventListener('click', event => {
        event.preventDefault();
        jQuery('#stpd-mobile-excluded-url-list-box').hide();
        jQuery('#stpd-mobile-included-url-list-box').show();
        whitelistMobileBtn.style.backgroundColor = "#f0f7f8";
        blacklistMobileBtn.style.backgroundColor = "transparent";
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
            updateURLExclusionInput('desktop');
            element.val('');
        }
    });

    jQuery('#add-mobile-exclusion').on('click', function(event) {
        event.preventDefault();
        let element = jQuery('#setupad_mobile_url_exclusions');
        let exclusion = element.val().trim();
        if (validateURL(exclusion, element)){
            let appendString =
                `<div class="stpd-btn-row">
                    <li class="stpd-mobile-excluded-url">${exclusion}</li>
                    <button class="stpd-mobile-delete-url-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>\n</button>
                </div>`;
            let newElement = jQuery(appendString).appendTo('#stpd-mobile-excluded-url-list-box ul');
            newElement.find('.stpd-mobile-delete-url-btn').click(function(event) {
                deleteURLBtnLogic(event,jQuery(this));
            });
            updateURLExclusionInput('mobile');
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
            updateURLInclusionInput('desktop');
            element.val('');
        }
    });

    jQuery('#add-mobile-inclusion').on('click', function(event) {
        event.preventDefault();
        let element = jQuery('#setupad_mobile_url_inclusions');
        let inclusion = element.val().trim();
        if (validateURL(inclusion, element)){
            let appendString =
                `<div class="stpd-btn-row">
                    <li class="stpd-mobile-included-url">${inclusion}</li>
                    <button class="stpd-delete-url-btn"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#0497A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>\n</button>
                </div>`;
            let newElement = jQuery(appendString).appendTo('#stpd-mobile-included-url-list-box ul');
            newElement.find('.stpd-mobile-delete-url-btn').click(function(event) {
                deleteURLBtnLogic(event,jQuery(this));
            });
            updateURLInclusionInput('mobile');
            element.val('');
        }
    });
    // URL Whitelist/Blacklist functionality END


    // Separate desktop/mobile settings functionality START

    // Navbar visibility on page open
    if (document.getElementById('setupad_mobile_rp_settings_enable').checked){
        document.getElementById('desktop-mobile-selectors').style.display = 'flex';
        jQuery("#related-posts-mobile-settings :input").attr("disabled", false);
    }
    else{
        document.getElementById('desktop-mobile-selectors').style.display = 'none';
        jQuery("#related-posts-mobile-settings :input").attr("disabled", true);
    }

    // Navbar visibility on checkbox change
    document.getElementById('setupad_mobile_rp_settings_enable').addEventListener('click', event => {
        if (event.target.checked) {
            document.getElementById('desktop-mobile-selectors').style.display = 'flex';
            jQuery("#related-posts-mobile-settings :input").attr("disabled", false);
        } else {
            document.getElementById('desktop-mobile-selectors').style.display = 'none';
            jQuery("#related-posts-mobile-settings :input").attr("disabled", true);
        }
    })

    // Navbar click functionality
    document.getElementById('desktop-rp-btn').addEventListener('click', event => {
        event.target.style.borderBottom = 'solid 2px #0497A5';
        document.getElementById('mobile-rp-btn').style.borderBottom = 'none';
        document.getElementById('related-posts-desktop-settings').style.display = 'table';
        document.getElementById('related-posts-mobile-settings').style.display = 'none';
    })
    document.getElementById('mobile-rp-btn').addEventListener('click', event => {
        event.target.style.borderBottom = 'solid 2px #0497A5';
        document.getElementById('desktop-rp-btn').style.borderBottom = 'none';
        document.getElementById('related-posts-desktop-settings').style.display = 'none';
        document.getElementById('related-posts-mobile-settings').style.display = 'table';
    })


    // Separate desktop/mobile settings functionality END


    // Delete URL from URL list button logic
    function deleteURLBtnLogic(event, button){
        event.preventDefault();
        button.parent().remove();
        if (button.siblings('.stpd-excluded-url').length > 0)
            updateURLExclusionInput('desktop');
        else if (button.siblings('.stpd-included-url').length > 0)
            updateURLInclusionInput('desktop');
        else if (button.siblings('.stpd-mobile-excluded-url').length > 0)
            updateURLInclusionInput('mobile');
        else if (button.siblings('.stpd-mobile-included-url').length > 0)
            updateURLInclusionInput('mobile');
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

                if(element[0].id == "setupad_url_exclusions" || element[0].id == "setupad_url_inclusions"){
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
                } else if (element[0].id == "setupad_mobile_url_exclusions" || element[0].id == "setupad_mobile_url_inclusions"){
                    jQuery('.stpd-mobile-excluded-url').each(function(){
                        if (relativeURL === jQuery(this).text().trim().replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&').replace(/\/$/, '')) {
                            let text = 'This URL is already added to Blacklist!';
                            logError(element, error, text);
                            flag = true;
                            return false;
                        }
                    });
                    jQuery('.stpd-mobile-included-url').each(function(){
                        if (relativeURL === jQuery(this).text().trim().replace(/[.*+\-?^${}()|[\]\\]/g, '\\$&').replace(/\/$/, '')) {
                            let text = 'This URL is already added to Whitelist!';
                            logError(element, error, text);
                            flag = true;
                            return false;
                        }
                    });
                }

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
    function updateURLExclusionInput(device){
        let urls = [];
        if (device === 'desktop'){
            jQuery('.stpd-excluded-url').each( function() {
                urls.push(jQuery(this).text());
            });
            document.querySelector('input[name="setupad_url_exclusions"]').value = urls;
        } else if (device === 'mobile'){
            jQuery('.stpd-mobile-excluded-url').each( function() {
                urls.push(jQuery(this).text());
            });
            document.querySelector('input[name="setupad_mobile_url_exclusions"]').value = urls;
        }
    }
    // Update URL inclusion list and values
    function updateURLInclusionInput(device){
        let urls = [];
        if (device === 'desktop') {
            jQuery('.stpd-included-url').each(function () {
                urls.push(jQuery(this).text());
            });
            document.querySelector('input[name="setupad_url_inclusions"]').value = urls;
        } else if (device === 'mobile') {
            jQuery('.stpd-mobile-included-url').each(function () {
                urls.push(jQuery(this).text());
            });
            document.querySelector('input[name="setupad_mobile_url_inclusions"]').value = urls;
        }
    }

    function advancedOptions(device){

        if (device == 'desktop'){
            let advancedOptionsBtn = document.querySelector('#advanced-options-btn');
            jQuery(advancedOptionsBtn).data('enabled') === false ? jQuery(advancedOptionsBtn).css('text-decoration','none') : jQuery(advancedOptionsBtn).data('enabled') === true ? jQuery(advancedOptionsBtn).css('text-decoration','#0497A5 underline 2px') : null;

            // Hide/Show advanced options
            document.querySelectorAll('.advanced-option').forEach( element => {
                if(jQuery(advancedOptionsBtn).data('enabled') === true){
                    //Handle when to not show specific options, skip error elements
                    if(!jQuery(element).hasClass('error')){
                        jQuery(element).show(200);
                    }
                }
                else if (jQuery(advancedOptionsBtn).data('enabled') === false)
                    jQuery(element).hide(200);
            });
        } else if (device == 'mobile'){
            let advancedOptionsBtn = document.querySelector('#advanced-mobile-options-btn');
            jQuery(advancedOptionsBtn).data('enabled') === false ? jQuery(advancedOptionsBtn).css('text-decoration','none') : jQuery(advancedOptionsBtn).data('enabled') === true ? jQuery(advancedOptionsBtn).css('text-decoration','#0497A5 underline 2px') : null;

            // Hide/Show advanced options
            document.querySelectorAll('.advanced-mobile-option').forEach( element => {
                if(jQuery(advancedOptionsBtn).data('enabled') === true){
                    //Handle when to not show specific options, skip error elements
                    if(!jQuery(element).hasClass('error')){
                        jQuery(element).show(200);
                    }
                }
                else if (jQuery(advancedOptionsBtn).data('enabled') === false)
                    jQuery(element).hide(200);
            });
        }
    }
});