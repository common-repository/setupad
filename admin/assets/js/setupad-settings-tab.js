jQuery(document).ready(function () {

    // Ad label display functionality start

    if (document.getElementById('setupad_ad_placement_label_enable').checked){
        const ad_placement_label = document.getElementById('ad-placement-label');
        const ad_placement_label_enable = document.getElementById('ad-placement-label-enable');

        ad_placement_label.style.display = 'table-row';
        ad_placement_label_enable.style.backgroundColor = 'rgb(245 251 252)';
        ad_placement_label_enable.removeAttribute('disabled');
    }
    else{
        const ad_placement_label = document.getElementById('ad-placement-label');
        const ad_placement_label_enable = document.getElementById('ad-placement-label-enable');

        ad_placement_label.style.display = 'none';
        ad_placement_label_enable.style.backgroundColor = 'transparent';
        ad_placement_label_enable.setAttribute('disabled', 'disabled');
    }

    document.getElementById('setupad_ad_placement_label_enable').addEventListener('click', event => {
        const ad_placement_label = document.getElementById('ad-placement-label');
        const ad_placement_label_enable = document.getElementById('ad-placement-label-enable');

        if (event.target.checked) {
            ad_placement_label.style.display = 'table-row';
            ad_placement_label_enable.style.backgroundColor = 'rgb(245 251 252)';
            ad_placement_label_enable.removeAttribute('disabled');
        } else {
            ad_placement_label.style.display = 'none';
            ad_placement_label_enable.style.backgroundColor = 'transparent';
            ad_placement_label_enable.setAttribute('disabled', 'disabled');
        }
    })

    // Ad label display functionality end

});