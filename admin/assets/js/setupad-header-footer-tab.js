jQuery(document).ready(function () {

    // Header and Footer button functionality START

    let headerBtn = document.querySelector('#header-script-btn');
    let footerBtn = document.querySelector('#footer-script-btn');

    headerBtn.addEventListener('click', () => {
        headerBtn.style.borderBottom = 'solid 2px #0497A5';
        footerBtn.style.borderBottom = 'none';
        document.querySelector('#header-scripts').style.display = 'block';
        document.querySelector('#footer-scripts').style.display = 'none';
        document.cookie = 'last_tab=header';
    });

    footerBtn.addEventListener('click', () => {
        footerBtn.style.borderBottom = 'solid 2px #0497A5';
        headerBtn.style.borderBottom = 'none';
        document.querySelector('#footer-scripts').style.display = 'block';
        document.querySelector('#header-scripts').style.display = 'none';
        document.cookie = 'last_tab=footer';
    });

    // Header and Footer button functionality END

});