jQuery(document).ready(function($) {

    function handleStatusButtonClick (event, button){
        event.preventDefault();

        const loaderHTML = "<div class='stpd-loader-sm'><div></div><div></div><div></div><div></div></div>";
        const adID = button.attr('data-id');
        const data = {
            'action': 'update_ad_status',
            'security': setupad_ajax_object.security,
            'adID': adID,
        };
        button.addClass('loading');
        button.fadeOut(100, function() {
            button.html(loaderHTML).fadeIn(100);
        });

        jQuery.post(setupad_ajax_object.ajax_url, data, function(response) {

            button.promise().done(function () {
                button.replaceWith(response);
                jQuery(document.body).trigger('post-load');
                const newButton = jQuery(`.stpd-ad-status[data-id='${adID}']`);
                newButton.on('click', function (event) {
                    handleStatusButtonClick(event, jQuery(this));
                });
            });

        }).fail(function(xhr, textStatus, error) {
            console.error(xhr.statusText);
            console.error(textStatus);
            console.error(error);
            alert( "Something went wrong! Check console for error log!" );
        });
    }
    if(jQuery('.stpd-ad-status').length) {
        jQuery('.stpd-ad-status').on('click', function (event) {
            handleStatusButtonClick(event, jQuery(this));
        });
    }

});