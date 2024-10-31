// Related Posts tab ajax
jQuery(document).ready(function($) {

    if(jQuery('#related-preview-btn')){
        jQuery('#related-preview-btn').on('click', function(event){
            event.preventDefault();

            const loaderHTML = "<div class='stpd-loader-rp'><div>";
            const button = jQuery(this);
            const originalButton = button.clone(true);

            const related_posts_title = jQuery('#setupad_related_posts_title').val();
            let related_posts_categories = [];
            jQuery('.related-categories-arr:selected').each(function(){
                related_posts_categories.push(jQuery(this).val());
            });
            related_posts_categories = related_posts_categories.join(',');
            const related_posts_articles_per_category = jQuery('.single-d-input[name="articles_per_category"]:checked').val();
            const related_posts_cat_title_enabled = jQuery('#setupad_related_posts_cat_title').is(':checked');
            const related_posts_ads_enabled = jQuery('#setupad_related_articles_ads').is(':checked');
            const related_posts_thumbnail_width = jQuery('input[name="setupad_related_posts_thumbnail_width"]').val();
            const related_posts_thumbnail_height = jQuery('input[name="setupad_related_posts_thumbnail_height"]').val();
            const setupad_related_posts_post_title_limit = jQuery('input[name="setupad_related_posts_post_title_limit"]').val();
            const setupad_related_posts_post_title_alignment = jQuery('input[name="setupad_related_posts_post_title_alignment"]:checked').val();
            const setupad_related_posts_columns = jQuery('input[name="setupad_related_posts_columns"]:checked').val();

            const data = {
                'action': 'return_related_preview',
                'security': setupad_ajax_object.security,
                'mobile_settings_enabled': false,
                'related_posts_title': related_posts_title,
                'related_posts_categories': related_posts_categories,
                'related_posts_articles_per_category': related_posts_articles_per_category,
                'related_posts_cat_title_enabled': related_posts_cat_title_enabled,
                'related_articles_ads_enabled': related_posts_ads_enabled,
                'related_posts_thumbnail_width': related_posts_thumbnail_width,
                'related_posts_thumbnail_height': related_posts_thumbnail_height,
                'setupad_related_posts_post_title_limit': setupad_related_posts_post_title_limit,
                'setupad_related_posts_post_title_alignment': setupad_related_posts_post_title_alignment,
                'setupad_related_posts_columns': setupad_related_posts_columns,
            };

            button.addClass('loading');
            button.html(loaderHTML);

            jQuery.post(setupad_ajax_object.ajax_url, data, function(response) {

                button.promise().done(function () {
                    button.replaceWith(originalButton);
                });

                if(!jQuery('#related-preview-area').length){
                    jQuery('#wpcontent').append(jQuery('<div id="related-preview-area-modal">\n' +
                        '       <div id="related-preview-area"></div>\n' +
                        '   </div>'));
                }
                jQuery('#related-preview-area').html(response);
                if(jQuery('#related-preview-close-btn')){
                    jQuery('#related-preview-close-btn').on('click', function(event) {
                        event.preventDefault();
                        jQuery('#related-preview-area-modal').remove();
                    });
                }
                jQuery(document.body).trigger('post-load');
            }).fail(function() {
                alert( "Something went wrong!" );
            });

        });
    }
    if(jQuery('#related-mobile-preview-btn')){
        jQuery('#related-mobile-preview-btn').on('click', function(event){
            event.preventDefault();

            const loaderHTML = "<div class='stpd-loader-rp'><div>";
            const button = jQuery(this);
            const originalButton = button.clone(true);

            const mobile_settings_enabled = document.getElementById('setupad_mobile_rp_settings_enable').checked;

            const related_posts_title = mobile_settings_enabled ? jQuery('#setupad_mobile_related_posts_title').val() : jQuery('#setupad_related_posts_title').val();
            let related_posts_categories = [];
            if(mobile_settings_enabled){
                jQuery('.related-categories-mobile-arr:selected').each(function(){
                    related_posts_categories.push(jQuery(this).val());
                });
            } else {
                jQuery('.related-categories-arr:selected').each(function(){
                    related_posts_categories.push(jQuery(this).val());
                });
            }
            related_posts_categories = related_posts_categories.join(',');
            const related_posts_articles_per_category = mobile_settings_enabled ? jQuery('.single-d-input[name="articles_mobile_per_category"]:checked').val() : jQuery('.single-d-input[name="articles_per_category"]:checked').val();
            const related_posts_cat_title_enabled = mobile_settings_enabled ? jQuery('#setupad_mobile_related_posts_cat_title').is(':checked') : jQuery('#setupad_related_posts_cat_title').is(':checked');
            const related_posts_ads_enabled = mobile_settings_enabled ? jQuery('#setupad_mobile_related_articles_ads').is(':checked') : jQuery('#setupad_related_articles_ads').is(':checked');
            const related_posts_thumbnail_width = mobile_settings_enabled ? jQuery('input[name="setupad_mobile_related_posts_thumbnail_width"]').val() : jQuery('input[name="setupad_related_posts_thumbnail_width"]').val();
            const related_posts_thumbnail_height = mobile_settings_enabled ? jQuery('input[name="setupad_mobile_related_posts_thumbnail_height"]').val() : jQuery('input[name="setupad_related_posts_thumbnail_height"]').val();
            const setupad_related_posts_post_title_limit = mobile_settings_enabled ? jQuery('input[name="setupad_mobile_related_posts_post_title_limit"]').val() : jQuery('input[name="setupad_related_posts_post_title_limit"]').val();
            const setupad_related_posts_post_title_alignment = mobile_settings_enabled ? jQuery('input[name="setupad_mobile_related_posts_post_title_alignment"]:checked').val() : jQuery('input[name="setupad_related_posts_post_title_alignment"]:checked').val();
            const setupad_related_posts_columns = mobile_settings_enabled ? jQuery('input[name="setupad_mobile_related_posts_columns"]:checked').val() : jQuery('input[name="setupad_related_posts_columns"]:checked').val();

            const data = {
                'action': 'return_related_preview',
                'security': setupad_ajax_object.security,
                'mobile_settings_enabled': mobile_settings_enabled,
                'related_posts_title': related_posts_title,
                'related_posts_categories': related_posts_categories,
                'related_posts_articles_per_category': related_posts_articles_per_category,
                'related_posts_cat_title_enabled': related_posts_cat_title_enabled,
                'related_articles_ads_enabled': related_posts_ads_enabled,
                'related_posts_thumbnail_width': related_posts_thumbnail_width,
                'related_posts_thumbnail_height': related_posts_thumbnail_height,
                'setupad_related_posts_post_title_limit': setupad_related_posts_post_title_limit,
                'setupad_related_posts_post_title_alignment': setupad_related_posts_post_title_alignment,
                'setupad_related_posts_columns': setupad_related_posts_columns,
            };

            button.addClass('loading');
            button.html(loaderHTML);

            jQuery.post(setupad_ajax_object.ajax_url, data, function(response) {

                button.promise().done(function () {
                    button.replaceWith(originalButton);
                });

                if(!jQuery('#related-preview-area').length){
                    jQuery('#wpcontent').append(jQuery('<div id="related-preview-area-modal">\n' +
                        '       <div id="related-preview-area"></div>\n' +
                        '   </div>'));
                }
                jQuery('#related-preview-area').html(response);
                if(jQuery('#related-preview-close-btn')){
                    jQuery('#related-preview-close-btn').on('click', function(event) {
                        event.preventDefault();
                        jQuery('#related-preview-area-modal').remove();
                    });
                }
                jQuery(document.body).trigger('post-load');
            }).fail(function() {
                alert( "Something went wrong!" );
            });
        });
    }
});