(function ($, api) {
    'use strict';

    var debounce = function (fn, delay) {
        var timer = null;
        return function () {
            var context = this;
            var args = arguments;
            window.clearTimeout(timer);
            timer = window.setTimeout(function () {
                fn.apply(context, args);
            }, delay);
        };
    };

    api.controlConstructor.edp_post_search = api.Control.extend({
        ready: function () {
            var control = this;

            control.input = control.container.find('.edp-post-search__input');
            control.valueField = control.container.find('.edp-post-search__value');
            control.results = control.container.find('.edp-post-search__results');
            control.postType = control.params.post_type || 'post';
            control.filters = control.params.filters || {};
            control.placeholder = control.params.placeholder || '';
            control.requestToken = 0;

            control.bindEvents();
            control.maybeBindTagWatcher();
        },

        bindEvents: function () {
            var control = this;

            control.input.on('input', debounce(function () {
                control.search(control.input.val());
            }, 200));

            control.input.on('focus', function () {
                control.search(control.input.val());
            });

            control.results.on('click', '.edp-post-search__item', function (event) {
                event.preventDefault();
                var button = $(this);
                control.selectPost(button.data('postId'), button.data('postTitle'));
            });

            $(document).on('click', function (event) {
                if (!control.container.is(event.target) && !control.container.has(event.target).length) {
                    control.closeResults();
                }
            });
        },

        maybeBindTagWatcher: function () {
            var control = this;

            if (!control.filters.tagSetting) {
                return;
            }

            api(control.filters.tagSetting, function (setting) {
                setting.bind(function (value) {
                    if (!value) {
                        control.clearSelection();
                    }

                    control.search(control.input.val());
                });
            });
        },

        closeResults: function () {
            this.results.removeClass('is-open is-loading');
            this.results.empty();
        },

        clearSelection: function () {
            this.valueField.val('').trigger('change');
            this.input.val('');
            if (this.setting) {
                this.setting.set(0);
            }
        },

        selectPost: function (postId, postTitle) {
            var id = parseInt(postId, 10);

            if (isNaN(id)) {
                id = 0;
            }

            this.valueField.val(id).trigger('change');
            this.input.val(postTitle);
            if (this.setting) {
                this.setting.set(id);
            }
            this.closeResults();
        },

        getTagId: function () {
            if (!this.filters.tagSetting) {
                return 0;
            }

            var setting = api(this.filters.tagSetting);
            if (!setting) {
                return 0;
            }

            var value = parseInt(setting.get(), 10);
            if (isNaN(value)) {
                return 0;
            }

            return value;
        },

        search: function (query) {
            var control = this;
            var currentQuery = query;

            if (typeof currentQuery !== 'string') {
                currentQuery = currentQuery === undefined || currentQuery === null ? '' : String(currentQuery);
            }

            var requestArgs = {
                nonce: edpPostSearch.nonce,
                post_type: control.postType,
                query: currentQuery
            };

            if (control.filters.category) {
                requestArgs.category = control.filters.category;
            }

            if (control.filters.tagSetting) {
                var tagId = control.getTagId();
                if (!tagId) {
                    control.showMessage(edpPostSearch.selectPrompt);
                    return;
                }

                requestArgs.tag_id = tagId;
            }

            control.results.addClass('is-open is-loading');
            control.results.empty();

            var token = ++control.requestToken;

            wp.ajax.post('edp_search_posts', requestArgs).done(function (response) {
                if (token !== control.requestToken) {
                    return;
                }

                control.renderResults(response);
            }).fail(function () {
                if (token !== control.requestToken) {
                    return;
                }

                control.showMessage(edpPostSearch.noResults);
            });
        },

        renderResults: function (items) {
            this.results.removeClass('is-loading');
            this.results.empty();

            if (!items || !items.length) {
                this.showMessage(edpPostSearch.noResults);
                return;
            }

            var list = $('<ul />').addClass('edp-post-search__list');

            items.forEach(function (item) {
                var button = $('<button type="button" />')
                    .addClass('edp-post-search__item')
                    .data('postId', item.id)
                    .data('postTitle', item.title)
                    .text(item.title);

                var listItem = $('<li />').append(button);
                list.append(listItem);
            });

            this.results.append(list);
        },

        showMessage: function (message) {
            this.results.removeClass('is-loading');
            this.results.addClass('is-open');
            this.results.html($('<div />').addClass('edp-post-search__message').text(message));
        }
    });
})(jQuery, wp.customize);
