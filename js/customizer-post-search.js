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
            control.tagValidationToken = 0;

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
                var handleTagChange = function (value) {
                    var tagId = parseInt(value, 10);

                    if (isNaN(tagId) || tagId < 0) {
                        tagId = 0;
                    }

                    control.onTagChange(tagId);
                };

                handleTagChange(setting.get());
                setting.bind(handleTagChange);
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
            this.closeResults();
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

        getCurrentValue: function () {
            var value = parseInt(this.valueField.val(), 10);

            if (isNaN(value) || value <= 0) {
                return 0;
            }

            return value;
        },

        onTagChange: function (tagId) {
            if (!tagId) {
                if (!this.getCurrentValue()) {
                    this.clearSelection();
                } else {
                    this.closeResults();
                }

                return;
            }

            this.closeResults();
            this.validateSelectionForTag(tagId);
        },

        validateSelectionForTag: function (tagId) {
            var control = this;
            var currentId = control.getCurrentValue();

            if (!currentId) {
                control.clearSelection();
                return;
            }

            var args = control.buildRequestArgs('', {
                tagId: tagId,
                include: [currentId]
            });

            if (!args) {
                control.clearSelection();
                return;
            }

            var token = ++control.tagValidationToken;

            control.requestPosts(args).done(function (items) {
                if (token !== control.tagValidationToken) {
                    return;
                }

                if (control.getCurrentValue() !== currentId) {
                    return;
                }

                var match = Array.isArray(items) && items.some(function (item) {
                    return parseInt(item.id, 10) === currentId;
                });

                if (!match) {
                    control.clearSelection();
                }
            }).fail(function () {
                if (token !== control.tagValidationToken) {
                    return;
                }

                if (control.getCurrentValue() === currentId) {
                    control.clearSelection();
                }
            });
        },

        buildRequestArgs: function (query, options) {
            var args = {
                nonce: edpPostSearch.nonce,
                post_type: this.postType,
                query: typeof query === 'string' ? query : (query === undefined || query === null ? '' : String(query))
            };

            var settings = options || {};

            if (this.filters.category) {
                args.category = this.filters.category;
            }

            if (this.filters.tagSetting) {
                var tagId = typeof settings.tagId !== 'undefined' ? settings.tagId : this.getTagId();

                if (!tagId) {
                    return null;
                }

                args.tag_id = tagId;
            }

            if (settings.include && settings.include.length) {
                args.include = settings.include;
            }

            return args;
        },

        requestPosts: function (args) {
            return wp.ajax.post('edp_search_posts', args);
        },

        search: function (query) {
            var control = this;
            var currentQuery = query;

            if (typeof currentQuery !== 'string') {
                currentQuery = currentQuery === undefined || currentQuery === null ? '' : String(currentQuery);
            }

            var requestArgs = control.buildRequestArgs(currentQuery);

            if (!requestArgs) {
                control.showMessage(edpPostSearch.selectPrompt);
                return;
            }

            control.results.addClass('is-open is-loading');
            control.results.empty();

            var token = ++control.requestToken;

            control.requestPosts(requestArgs).done(function (response) {
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
