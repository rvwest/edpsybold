(function ($, api) {
    'use strict';

    if (typeof edpCustomizePostControl === 'undefined') {
        return;
    }

    function decodeAttribute(value) {
        var textarea;

        if (typeof value !== 'string') {
            return value;
        }

        textarea = document.createElement('textarea');
        textarea.innerHTML = value;
        return textarea.value;
    }

    function parseJSONAttribute(value) {
        if (!value) {
            return null;
        }

        try {
            return JSON.parse(decodeAttribute(value));
        } catch (e) {
            return null;
        }
    }

    function toIntArray(values) {
        if (!Array.isArray(values)) {
            return [];
        }

        return values.map(function (value) {
            return parseInt(value, 10);
        }).filter(function (value) {
            return !isNaN(value);
        });
    }

    function AutocompleteControl(element) {
        this.$container = $(element);
        this.settingId = this.$container.data('settingId');
        this.$input = this.$container.find('.edp-post-autocomplete-input');
        this.$valueInput = this.$container.find('.edp-post-autocomplete-value');
        this.$results = this.$container.find('.edp-post-autocomplete-results');
        this.$clear = this.$container.find('.edp-post-autocomplete-clear');
        this.filters = parseJSONAttribute(this.$input.attr('data-filters')) || {};
        this.selectedMeta = parseJSONAttribute(this.$input.attr('data-selected')) || null;
        this.currentRequest = null;
        this.debounceTimer = null;

        this.bindEvents();
    }

    AutocompleteControl.prototype.bindEvents = function () {
        var self = this;

        this.$input.on('input', function () {
            var value = $(this).val();
            self.handleInput(value);
        });

        this.$input.on('focus', function () {
            if ($(this).val().length > 0) {
                self.handleInput($(this).val());
            }
        });

        this.$clear.on('click', function (event) {
            event.preventDefault();
            self.clearSelection();
        });

        $(document).on('click', function (event) {
            if (!self.$container.is(event.target) && self.$container.has(event.target).length === 0) {
                self.hideResults();
            }
        });

        this.$results.on('click', 'button', function (event) {
            event.preventDefault();
            var itemData = $(this).data('item');
            if (itemData) {
                self.setSelection(itemData);
            }
        });

        if (this.filters.tag_setting && api.has(this.filters.tag_setting)) {
            var setting = api(this.filters.tag_setting);
            var selfControl = this;
            setting.bind(function (newValue) {
                selfControl.onTagFilterChange(newValue);
            });
        }
    };

    AutocompleteControl.prototype.onTagFilterChange = function (tagId) {
        var parsedTag = parseInt(tagId, 10);
        if (isNaN(parsedTag) || parsedTag <= 0) {
            return;
        }

        if (!this.selectedMeta) {
            return;
        }

        var tagMatches = toIntArray(this.selectedMeta.tags);
        if (tagMatches.indexOf(parsedTag) === -1) {
            this.clearSelection();
        }
    };

    AutocompleteControl.prototype.handleInput = function (query) {
        var self = this;
        var trimmed = query.trim();

        if (this.debounceTimer) {
            window.clearTimeout(this.debounceTimer);
        }

        if (trimmed.length === 0) {
            this.hideResults();
            return;
        }

        this.debounceTimer = window.setTimeout(function () {
            self.fetchResults(trimmed);
        }, 200);
    };

    AutocompleteControl.prototype.fetchResults = function (query) {
        var self = this;
        var data = {
            action: 'edp_search_posts',
            nonce: edpCustomizePostControl.nonce,
            q: query
        };

        if (this.filters.tag_setting && api.has(this.filters.tag_setting)) {
            var tagValue = api(this.filters.tag_setting).get();
            if (tagValue) {
                data.tag = tagValue;
            }
        }

        if (this.filters.tag) {
            data.tag = this.filters.tag;
        }

        if (this.filters.category) {
            data.category = this.filters.category;
        }

        if (this.currentRequest && typeof this.currentRequest.abort === 'function') {
            this.currentRequest.abort();
        }

        this.currentRequest = $.ajax({
            url: edpCustomizePostControl.ajaxUrl,
            method: 'GET',
            dataType: 'json',
            data: data
        }).done(function (response) {
            if (!response || !response.success) {
                self.renderResults([]);
                return;
            }

            var items = response.data && response.data.items ? response.data.items : [];
            self.renderResults(items);
        }).fail(function () {
            self.renderResults([]);
        });
    };

    AutocompleteControl.prototype.renderResults = function (items) {
        var self = this;
        this.$results.empty();

        if (!items.length) {
            var $empty = $('<li class="edp-post-autocomplete-empty" />');
            $empty.text(edpCustomizePostControl.strings.noResults);
            this.$results.append($empty);
            this.$results.attr('hidden', false);
            return;
        }

        items.forEach(function (item) {
            var $button = $('<button type="button" class="button-link" />');
            $button.text(item.title);
            $button.data('item', item);

            var $li = $('<li class="edp-post-autocomplete-result" />');
            $li.append($button);
            self.$results.append($li);
        });

        this.$results.attr('hidden', false);
    };

    AutocompleteControl.prototype.hideResults = function () {
        this.$results.attr('hidden', true);
    };

    AutocompleteControl.prototype.setSelection = function (item) {
        this.$input.val(item.title);
        this.$valueInput.val(item.id).trigger('change');
        if (this.settingId && api.has(this.settingId)) {
            api(this.settingId).set(item.id);
        }
        this.selectedMeta = {
            tags: toIntArray(item.tags),
            categories: toIntArray(item.categories)
        };
        this.$input.attr('data-selected', JSON.stringify({
            id: item.id,
            tags: this.selectedMeta.tags,
            categories: this.selectedMeta.categories
        }));
        this.$clear.prop('disabled', false);
        this.hideResults();
    };

    AutocompleteControl.prototype.clearSelection = function () {
        this.$input.val('');
        this.$valueInput.val('').trigger('change');
        if (this.settingId && api.has(this.settingId)) {
            api(this.settingId).set('');
        }
        this.selectedMeta = null;
        this.$input.removeAttr('data-selected');
        this.$clear.prop('disabled', true);
        this.hideResults();
    };

    $(function () {
        $('.edp-post-autocomplete-control').each(function () {
            new AutocompleteControl(this);
        });
    });
})(jQuery, wp.customize);
