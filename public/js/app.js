$(document).ready(function () {

    $('.ui.accordion').accordion();

    $('.dropdown').dropdown();

    $('.message .close').on('click', function () {
        $(this).closest('.message').transition('fade');
    });

    $('.ui.checkbox').checkbox();

    if($('.tabular.menu').length>0) {// to trigger tabbed content in page
        $('.tabular.menu .item').tab();
    }

});