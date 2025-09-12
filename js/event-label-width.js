(function($){
  $(function(){
    var $labels = $('.event-listing-meta .label');
    if(!$labels.length) return;
    var maxWidth = 0;
    $labels.each(function(){
      var width = Math.ceil($(this).outerWidth());
      if(width > maxWidth){
        maxWidth = width;
      }
    });
    $labels.css('min-width', maxWidth + 'px');
  });
})(jQuery);
