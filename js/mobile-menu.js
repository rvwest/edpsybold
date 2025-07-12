jQuery(function($){
    $('.menu-toggle').on('click', function(){
        var nav = $('.top-nav-menu');
        nav.toggleClass('open');
        $(this).find('i').toggleClass('fa-bars fa-times');
    });
});
