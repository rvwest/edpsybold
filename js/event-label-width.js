jQuery(function ($) {
    var $labels = $('.event-listing-meta .label');
    if (!$labels.length) {
        return;
    }
    var maxWidth = 0;
    $labels.each(function () {
        var width = $(this).outerWidth();
        if (width > maxWidth) {
            maxWidth = width;
        }
    });
    $labels.css('width', maxWidth + 'px');
});
