(function($){
  $(function(){
    var $labels = $('.event-listing-meta .label');
    if (!$labels.length) return;

    // Remove the base min-width to measure natural widths
    $labels.css('min-width', 0);

    var maxWidth = 0;
    $labels.each(function(){
      var width = Math.ceil($(this).outerWidth());
      if (width > maxWidth) {
        maxWidth = width;
      }
    });

    // Apply the widest width to all labels
    $labels.css({
      width: maxWidth + 'px',
      'min-width': maxWidth + 'px'
    });
  });
})(jQuery);
