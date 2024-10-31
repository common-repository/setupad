jQuery(document).ready(function() {

    // Handle the "Leave review" button click
    jQuery('#stpd-review').on('click', function() {

        const data = {
            'action': 'setupad_review_notice_dismiss',
            '_ajax_nonce': setupad_notice_ajax_object._ajax_nonce
        };

        jQuery.post(setupad_notice_ajax_object.ajax_url, data, function(response) {
            jQuery('#stpd-review-notice').slideUp(300, function(){ this.remove(); }); // Hide the notice
        }).fail(function(xhr, textStatus, error) {
            console.error('Error details:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                textStatus: textStatus,
                error: error
            });
        });

    });

    // Handle the "Later" button click
    jQuery('#stpd-review-later').on('click', function() {

        const data = {
            'action': 'setupad_review_notice_later',
            '_ajax_nonce': setupad_notice_ajax_object._ajax_nonce,
            'days': 3 // Default to 3 days for "Later"
        };

        jQuery.post(setupad_notice_ajax_object.ajax_url, data, function(response) {
            jQuery('#stpd-review-notice').slideUp(300, function(){ this.remove(); }); // Hide the notice
        }).fail(function(xhr, textStatus, error) {
            console.error(xhr.statusText);
            console.error(textStatus);
            console.error(error);
            alert("Something went wrong! Check console for error log!");
        });

    });

    // Handle the "Never show this again" button click
    jQuery('#stpd-dismiss').on('click', function() {

        let buttonWidth = jQuery(this).outerWidth();

        // Slide the original button out to the left by its own width
        jQuery(this).animate({left: -buttonWidth}, 200).promise().then(function() {
            // Hide the original button
            jQuery(this).hide();

            // Show the new buttons and animate them from right to original position
            jQuery('.stpd-button-group').css({
                display: 'flex',
                right: -buttonWidth,
                opacity: 0,
            }).animate({right: '0', opacity: '1'}, 200);
        });

    });

    // Handle the "Remind Me in 30 days" button click
    jQuery('#stpd-review-month').on('click', function() {

        const data = {
            'action': 'setupad_review_notice_later',
            '_ajax_nonce': setupad_notice_ajax_object._ajax_nonce,
            'days': 30 // Default to "30 days" for month reminder
        };

        jQuery.post(setupad_notice_ajax_object.ajax_url, data, function(response) {
            jQuery('#stpd-review-notice').slideUp(300, function(){ this.remove(); }); // Hide the notice
        }).fail(function(xhr, textStatus, error) {
            console.error(xhr.statusText);
            console.error(textStatus);
            console.error(error);
            alert("Something went wrong! Check console for error log!");
        });

    });

    // Handle the "Yes, Never Show Again" button click
    jQuery('#stpd-confirm-dismiss').on('click', function() {

        jQuery.post(setupad_notice_ajax_object.ajax_url, {
            action: 'setupad_review_notice_dismiss',
            _ajax_nonce: setupad_notice_ajax_object._ajax_nonce,
        }, function(response) {
            jQuery('#stpd-review-notice').slideUp(300, function(){ this.remove(); }); // Hide the notice
        }).fail(function(xhr, textStatus, error) {
            console.error('Error details:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                textStatus: textStatus,
                error: error
            });
            alert("Something went wrong! Check console for error log!");
        });

    });

});