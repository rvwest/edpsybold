jQuery(function ($) {
    var body = $('body');

    $('.menu-toggle').on('click', function () {
        var nav = $('.top-nav-menu');
        var icon = $(this).find('i');

        nav.toggleClass('open');

        var isOpen = nav.hasClass('open');

        icon.toggleClass('fa-bars', !isOpen).toggleClass('fa-times', isOpen);

        body.toggleClass('menu-on', isOpen);
        body.toggleClass('menu-closed', !isOpen);
    });
});
