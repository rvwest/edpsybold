jQuery(function ($) {
    $('.menu-toggle').on('click', function () {
        var nav = $('.top-nav-menu');
        nav.toggleClass('open');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });

    // Insert submenu toggle buttons and wrap <a> and <button> in a <div>
    $('.top-nav-menu li.menu-item-has-children').each(function () {
        var $li = $(this);
        var $link = $li.children('a');
        if (!$link.siblings('div.submenu-wrapper').length) {
            var $btn = $('<button class="submenu-toggle" aria-expanded="false"><i class="far fa-angle-down"></i></button>');
            var $wrapper = $('<div class="submenu-wrapper"></div>').append($link.clone(), $btn);
            $link.replaceWith($wrapper);
        }
    });

    // Toggle submenu visibility
    $('.top-nav-menu').on('click', 'button.submenu-toggle', function (e) {
        e.preventDefault();
        var $btn = $(this);
        var $li = $btn.closest('li');
        var $submenu = $li.children('ul.sub-menu');

        if ($li.hasClass('submenu-open')) {
            $submenu.slideUp(200, function () {
                $submenu.attr('style', '');
            });
            $li.removeClass('submenu-open');
            $btn.attr('aria-expanded', 'false');
            $btn.find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
        } else {
            $submenu.hide().css('display', 'flex').slideDown(200, function () {
                $submenu.attr('style', '');
            });
            $li.addClass('submenu-open');
            $btn.attr('aria-expanded', 'true');
            $btn.find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
        }
    });
});
