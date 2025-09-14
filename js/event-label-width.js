// Match all event meta labels to the width of the widest label
jQuery(function ($) {
    var $labels = $('.event-listing-meta .label');
    if (!$labels.length) {
        return;
    }

    var maxWidth = 0;
    $labels.each(function () {
        var $label = $(this);
        var originalMin = $label.css('min-width');
        $label.css('min-width', 0);
        var width = $label.outerWidth();
        $label.css('min-width', originalMin);
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
