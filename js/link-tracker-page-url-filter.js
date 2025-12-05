(function ($) {
    'use strict';

    function addPageUrlFilter() {
        var $forms = $('form[data-report="link-tracker"], form[id*="link-tracker"], form[class*="link-tracker"]');
        if (!$forms.length) {
            return;
        }

        $forms.each(function () {
            var $form = $(this);

            if ($form.data('edpsyboldPageUrlFilterInit')) {
                return;
            }

            $form.data('edpsyboldPageUrlFilterInit', true);

            if ($form.find('[name="page_url"]').length) {
                return;
            }

            var $filtersContainer = $form.find('.wps-ar-filter-items, .wps-ar-filter-row, .wps-ar-filters, .filters, .filter-row').first();
            if (!$filtersContainer.length) {
                $filtersContainer = $form;
            }

            var wrapperClass = '';
            if ($filtersContainer.children().length) {
                wrapperClass = $filtersContainer.children().first().attr('class') || '';
            }

            var $wrapper = $('<div>', {
                'class': $.trim((wrapperClass ? wrapperClass + ' ' : '') + 'edpsybold-page-url-filter')
            });

            var fieldId = 'edpsybold-page-url-filter-field';
            if ($filtersContainer.find('#' + fieldId).length) {
                fieldId += '-' + Math.floor(Math.random() * 10000);
            }

            if ($filtersContainer.find('label').length) {
                $('<label>', {
                    'for': fieldId,
                    text: (window.edpsyboldLinkTrackerUrlFilter && window.edpsyboldLinkTrackerUrlFilter.label) || 'Page URL'
                }).appendTo($wrapper);
            }

            var $input = $('<input>', {
                type: 'search',
                id: fieldId,
                name: 'page_url',
                'class': 'regular-text',
                placeholder: (window.edpsyboldLinkTrackerUrlFilter && window.edpsyboldLinkTrackerUrlFilter.placeholder) || 'Filter by URL…'
            });

            $input.on('keydown', function (event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    triggerSubmit($form);
                }
            });

            $input.on('change', function () {
                triggerSubmit($form);
            });

            $wrapper.append($input);

            if ($filtersContainer.is($form)) {
                $filtersContainer.prepend($wrapper);
            } else {
                $filtersContainer.append($wrapper);
            }
        });
    }

    function triggerSubmit($form) {
        var $submit = $form.find('[type="submit"], button.submit, .wps-ar-apply');

        if ($submit.length) {
            $submit.first().trigger('click');
            return;
        }

        $form.trigger('submit');
    }

    $(document).ready(addPageUrlFilter);
    $(document).on('wps_ar_report_loaded', addPageUrlFilter);
})(jQuery);
