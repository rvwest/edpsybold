jQuery(function($){
    $('.menu-toggle').on('click', function(){
        var nav = $('.top-nav-menu');
        nav.toggleClass('open');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });

    // Insert submenu toggle buttons
    $('.top-nav-menu li.menu-item-has-children').each(function(){
        var $li = $(this);
        if(!$li.children('button.submenu-toggle').length){
            var $btn = $('<button class="submenu-toggle" aria-expanded="false"><i class="far fa-angle-down"></i></button>');
            $li.prepend($btn);
        }
    });

    // Toggle submenu visibility
    $('.top-nav-menu').on('click', 'button.submenu-toggle', function(e){
        e.preventDefault();
        var $btn = $(this);
        var $li = $btn.parent('li');
        $li.toggleClass('submenu-open');
        $li.children('ul.sub-menu').slideToggle(200);
        $btn.find('i').toggleClass('fa-angle-down fa-angle-up');
    });
});
