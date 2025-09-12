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
    maxWidth = Math.ceil(maxWidth / 5) * 5;
    $labels.css({
        width: maxWidth + 'px',
        minWidth: maxWidth + 'px'
    });
});
