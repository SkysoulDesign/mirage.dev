$(document).ready(function () {

    $('.ui.accordion').accordion();

    $('.dropdown').dropdown();

    $('.message .close').on('click', function () {
        $(this).closest('.message').transition('fade');
    });

    $('.ui.checkbox').checkbox();

});