jQuery(document).ready(function() {

    if (typeof setupad_html_insertion_data !== 'undefined'){

        jQuery.each(setupad_html_insertion_data, function( index ){

            let selector =  setupad_html_insertion_data[index]['selector'];

            if(jQuery(selector)){

                let adcodes = setupad_html_insertion_data[index]['ad_codes'];
                let position =  setupad_html_insertion_data[index]['position'];
                let insertion_type = setupad_html_insertion_data[index]['insertion_type'];
                let action = setupad_html_insertion_data[index]['action'];
                let timeout = setupad_html_insertion_data[index]['timeout'];
                let wait_for_element = setupad_html_insertion_data[index]['wait_for_element'];

                function setupad_insert_positions(target, adcodes, position, action) {

                    if (jQuery(target).closest('#wpadminbar').length > 0) {
                        return; // Skip if target is inside #wpadminbar
                    }

                    if (position === 'before_html') {
                        jQuery(target).first().before(adcodes);
                    } else if (position === 'after_html') {
                        jQuery(target).first().after(adcodes);
                    } else if (position === 'inside_html') {
                        if (action === 'prepend') {
                            jQuery(target).first().prepend(adcodes);
                        } else if (action === 'append') {
                            jQuery(target).first().append(adcodes);
                        } else if (action === 'replace') {
                            jQuery(target).first().html(adcodes);
                        }
                    }
                }

                function setupad_insert_placement(targetSelector) {
                    if (timeout !== null) {
                        setTimeout(function() {
                            setupad_insert_positions(targetSelector, adcodes, position, action);
                        }, timeout);
                    } else {
                        setupad_insert_positions(targetSelector, adcodes, position, action);
                    }
                }

                // Function to observe DOM changes
                function setupad_observe_DOM(selector, callback) {
                    let observer = new MutationObserver(function(mutationsList, observer) {
                        // Check if the element now exists
                        if (jQuery(selector).length) {
                            callback();
                            observer.disconnect(); // Stop observing once the element is found
                        }
                    });

                    // Start observing the document for added nodes
                    observer.observe(document.documentElement, {
                        childList: true,
                        subtree: true
                    });
                }
                if (wait_for_element) {
                    setupad_observe_DOM(wait_for_element, function() {
                        if (insertion_type === 'single') {
                            setupad_insert_placement(selector);
                        } else if (insertion_type === 'multiple') {
                            let starting_position = setupad_html_insertion_data[index]['starting_position'];
                            let current_position = -1; // Track valid elements only

                            jQuery(selector).each(function(index, element) {
                                // Skip elements inside #wpadminbar
                                if (jQuery(element).closest('#wpadminbar').length > 0) {
                                    return;
                                }

                                // Increment position only for elements outside #wpadminbar
                                current_position++;

                                if (starting_position !== null && current_position < starting_position) {
                                    return;
                                } else {
                                    setupad_insert_placement(this);
                                }
                            });
                        } else {
                            console.error('SETUPAD WP ADS - something went wrong (HTML insertion)');
                        }
                    });
                } else {
                    if (insertion_type === 'single') {
                        setupad_insert_placement(selector);
                    } else if (insertion_type === 'multiple') {
                        let starting_position = setupad_html_insertion_data[index]['starting_position'];
                        let current_position = -1; // Track valid elements only

                        jQuery(selector).each(function(index, element) {
                            // Skip elements inside #wpadminbar
                            if (jQuery(element).closest('#wpadminbar').length > 0) {
                                return;
                            }

                            // Increment position only for elements outside #wpadminbar
                            current_position++;

                            if (starting_position !== null && current_position < starting_position) {
                                return;
                            } else {
                                setupad_insert_placement(this);
                            }
                        });
                    } else {
                        console.error('SETUPAD WP ADS - something went wrong (HTML insertion)');
                    }
                }

            }

        });

    }

});