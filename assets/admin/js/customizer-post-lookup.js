(function (api, win) {
    'use strict';

    if (!api) {
        return;
    }

    var config = win.edpsyPostLookup || {};
    var ACTIVE_CLASS = 'is-active';
    var HIGHLIGHT_CLASS = 'is-highlighted';
    var INVALID_CLASS = 'is-invalid';

    function getString(key, fallback) {
        if (config.strings && config.strings[key]) {
            return config.strings[key];
        }
        return fallback || '';
    }

    function decodeEntities(str) {
        var textarea = decodeEntities.textarea;
        if (!textarea) {
            textarea = document.createElement('textarea');
            decodeEntities.textarea = textarea;
        }
        textarea.innerHTML = str || '';
        return textarea.value;
    }

    function buildParams(params) {
        var query = new URLSearchParams();
        Object.keys(params).forEach(function (key) {
            var value = params[key];
            if (value === undefined || value === null || value === '') {
                return;
            }
            query.append(key, value);
        });
        return query;
    }

    function fetchViaAjax(type, params) {
        if (!config.ajaxUrl || !config.ajaxActions || !config.ajaxActions[type]) {
            return Promise.reject(new Error('No AJAX fallback configured.'));
        }

        var body = new URLSearchParams();
        body.append('action', config.ajaxActions[type]);
        body.append('nonce', config.nonce || '');
        Object.keys(params).forEach(function (key) {
            var value = params[key];
            if (value === undefined || value === null || value === '') {
                return;
            }
            body.append(key, value);
        });

        return fetch(config.ajaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
            },
            body: body.toString(),
        }).then(function (response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        }).then(function (payload) {
            if (!payload || !payload.success) {
                throw new Error('Request failed');
            }
            return payload.data;
        });
    }

    function fetchLookup(type, params) {
        var routes = config.routes || {};
        var route = routes[type];
        var query = buildParams(params);

        if (!route) {
            return fetchViaAjax(type, params);
        }

        var url = route + (query.toString() ? '?' + query.toString() : '');
        var headers = {};
        if (config.nonce) {
            headers['X-WP-Nonce'] = config.nonce;
        }

        return fetch(url, {
            method: 'GET',
            credentials: 'same-origin',
            headers: headers,
        }).then(function (response) {
            if (!response.ok) {
                if (config.ajaxUrl) {
                    return fetchViaAjax(type, params);
                }
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        }).catch(function (error) {
            if (config.ajaxUrl) {
                return fetchViaAjax(type, params);
            }
            throw error;
        });
    }

    function debounce(fn, wait) {
        var timeout;
        return function () {
            var context = this;
            var args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function () {
                fn.apply(context, args);
            }, wait);
        };
    }

    function LookupControl(control) {
        this.control = control;
        this.container = control.container[0];
        this.lookupType = control.params.lookupType || 'post';
        this.filters = control.params.filters || {};
        this.allowClear = control.params.allowClear !== false;
        this.placeholder = control.params.placeholder || (this.lookupType === 'tag' ? getString('searchTags') : getString('searchPosts'));
        this.controlSettings = control.params.controlSettings || {};

        this.state = {
            items: [],
            open: false,
            loading: false,
            hasMore: true,
            query: '',
            nextPage: 1,
            highlight: -1,
            requestId: 0,
        };

        this.selection = null;
        this.currentTag = '';
        this.categoryFilter = this.filters.category || '';
        this.tagSettingId = this.filters.tag_setting || '';

        this.buildUI();
        this.bindSetting();
        this.bindEvents();
        this.initLinkedTagSetting();
        this.renderSelection();
    }

    LookupControl.prototype.buildUI = function () {
        this.valueInput = this.container.querySelector('.edpsy-post-lookup__value');
        this.selectionList = this.container.querySelector('.edpsy-post-lookup__selection');
        this.input = this.container.querySelector('.edpsy-post-lookup__input');
        this.results = this.container.querySelector('.edpsy-post-lookup__results');
        this.status = this.container.querySelector('.edpsy-post-lookup__status');
        this.notice = this.container.querySelector('.edpsy-post-lookup__notice');
        this.clearButton = this.container.querySelector('.edpsy-post-lookup__clear');
        this.tagFeedback = this.container.querySelector('.edpsy-post-lookup__tag-feedback');
        this.combobox = this.container.querySelector('.edpsy-post-lookup__combobox');

        if (this.input) {
            this.input.setAttribute('placeholder', this.placeholder);
        }
    };

    LookupControl.prototype.bindSetting = function () {
        var self = this;
        this.control.setting.bind(function (value) {
            self.updateSelectionFromSetting(value);
        });

        this.updateSelectionFromSetting(this.control.setting.get());
    };

    LookupControl.prototype.initLinkedTagSetting = function () {
        var self = this;
        if (!this.tagSettingId) {
            return;
        }

        api(this.tagSettingId, function (setting) {
            self.currentTag = setting.get() || '';
            setting.bind(function (value) {
                self.currentTag = value || '';
                self.onTagChanged();
            });
        });
    };

    LookupControl.prototype.bindEvents = function () {
        var self = this;

        if (this.input) {
            this.input.addEventListener('input', debounce(function (event) {
                self.onQueryChange(event.target.value);
            }, config.debounce || 250));

            this.input.addEventListener('keydown', function (event) {
                self.onKeyDown(event);
            });

            this.input.addEventListener('focus', function () {
                self.openList();
                if (!self.state.items.length && !self.state.loading) {
                    self.loadResults(true);
                }
            });
        }

        if (this.results) {
            this.results.addEventListener('mousedown', function (event) {
                var option = event.target.closest('[data-item-index]');
                if (!option) {
                    return;
                }
                event.preventDefault();
                var index = parseInt(option.getAttribute('data-item-index'), 10);
                self.selectItem(self.state.items[index]);
            });

            this.results.addEventListener('scroll', function () {
                if (!self.state.hasMore || self.state.loading) {
                    return;
                }
                if (self.results.scrollTop + self.results.clientHeight >= self.results.scrollHeight - 10) {
                    self.loadResults(false);
                }
            });
        }

        if (this.clearButton) {
            this.clearButton.addEventListener('click', function () {
                self.clearSelection();
                if (self.input) {
                    self.input.focus();
                }
            });
        }

        document.addEventListener('click', function (event) {
            if (!self.container.contains(event.target)) {
                self.closeList();
            }
        });
    };

    LookupControl.prototype.onQueryChange = function (value) {
        this.state.query = value;
        this.state.nextPage = 1;
        this.state.items = [];
        this.state.hasMore = true;
        this.state.highlight = -1;

        if (value.trim() === '') {
            this.renderResults();
            this.updateStatus('');
            return;
        }

        this.openList();
        this.loadResults(true);
    };

    LookupControl.prototype.onKeyDown = function (event) {
        var key = event.key;
        if (!this.state.open && (key === 'ArrowDown' || key === 'ArrowUp')) {
            this.openList();
        }

        switch (key) {
            case 'ArrowDown':
                event.preventDefault();
                this.moveHighlight(1);
                break;
            case 'ArrowUp':
                event.preventDefault();
                this.moveHighlight(-1);
                break;
            case 'Enter':
                if (this.state.highlight > -1 && this.state.items[this.state.highlight]) {
                    event.preventDefault();
                    this.selectItem(this.state.items[this.state.highlight]);
                }
                break;
            case 'Escape':
                this.closeList();
                break;
            default:
                break;
        }
    };

    LookupControl.prototype.moveHighlight = function (delta) {
        if (!this.state.items.length) {
            return;
        }

        var index = this.state.highlight + delta;
        if (index < 0) {
            index = this.state.items.length - 1;
        } else if (index >= this.state.items.length) {
            index = 0;
        }

        this.state.highlight = index;
        this.renderResults();

        var option = this.results.querySelector('[data-item-index="' + index + '"]');
        if (option) {
            option.scrollIntoView({ block: 'nearest' });
            if (this.input) {
                this.input.setAttribute('aria-activedescendant', option.id);
            }
        }
    };

    LookupControl.prototype.openList = function () {
        if (!this.results) {
            return;
        }

        this.state.open = true;
        this.container.classList.add(ACTIVE_CLASS);
        this.results.setAttribute('aria-hidden', 'false');
        if (this.combobox) {
            this.combobox.setAttribute('aria-expanded', 'true');
        }
    };

    LookupControl.prototype.closeList = function () {
        if (!this.results) {
            return;
        }
        this.state.open = false;
        this.state.highlight = -1;
        this.container.classList.remove(ACTIVE_CLASS);
        this.results.setAttribute('aria-hidden', 'true');
        if (this.combobox) {
            this.combobox.setAttribute('aria-expanded', 'false');
        }
        if (this.input) {
            this.input.removeAttribute('aria-activedescendant');
        }
    };

    LookupControl.prototype.loadResults = function (reset) {
        var _this = this;

        if (this.state.loading) {
            return;
        }

        this.state.loading = true;
        if (reset) {
            this.updateStatus(getString('loading'));
        }

        var requestId = ++this.state.requestId;
        var params = this.buildQueryParams(reset);

        fetchLookup(this.lookupType, params).then(function (data) {
            if (requestId !== _this.state.requestId) {
                return;
            }

            var items = data && data.items ? data.items : [];
            if (reset) {
                _this.state.items = items;
            } else {
                _this.state.items = _this.state.items.concat(items);
            }

            _this.state.hasMore = Boolean(data && data.has_more);
            _this.state.nextPage = reset ? 2 : _this.state.nextPage + 1;
            _this.renderResults();

            if (!_this.state.items.length) {
                _this.updateStatus(getString('noResults'));
            } else if (reset) {
                _this.updateStatus(getString('selectResult'));
            }
        }).catch(function () {
            _this.showError();
        }).finally(function () {
            _this.state.loading = false;
        });
    };

    LookupControl.prototype.buildQueryParams = function (reset) {
        var params = {
            per_page: 20,
            page: reset ? 1 : this.state.nextPage,
        };

        if (this.state.query) {
            params.search = this.state.query;
        }

        if (this.lookupType === 'post') {
            if (this.currentTag) {
                params.tag = this.currentTag;
            }
            if (this.categoryFilter) {
                params.category = this.categoryFilter;
            }
        }

        return params;
    };

    LookupControl.prototype.showError = function () {
        this.renderResults();
        this.updateStatus(getString('error'));
    };

    LookupControl.prototype.updateStatus = function (message) {
        if (!this.status) {
            return;
        }
        this.status.textContent = message || '';
    };

    LookupControl.prototype.renderResults = function () {
        var _this = this;
        if (!this.results) {
            return;
        }

        this.results.innerHTML = '';

        this.state.items.forEach(function (item, index) {
            var option = document.createElement('div');
            var title = decodeEntities(item.title || item.name || '');
            var date = item.date ? ' — ' + item.date : '';
            var description = '';

            option.className = 'edpsy-post-lookup__result-item';
            option.setAttribute('role', 'option');
            option.setAttribute('data-item-index', index);
            option.id = _this.control.id + '-option-' + index;

            if (index === _this.state.highlight) {
                option.classList.add(HIGHLIGHT_CLASS);
            }

            if (item.count !== undefined) {
                description = ' (' + item.count + ')';
            }

            option.innerHTML = '<span class="edpsy-post-lookup__result-title">' + title + '</span>' +
                (date ? '<span class="edpsy-post-lookup__result-meta">' + date + '</span>' : '') +
                (description ? '<span class="edpsy-post-lookup__result-meta">' + description + '</span>' : '');

            _this.results.appendChild(option);
        });
    };

    LookupControl.prototype.updateSelectionFromSetting = function (value) {
        if (this.lookupType === 'post') {
            value = parseInt(value, 10) || 0;
            if (!value) {
                this.selection = null;
                this.renderSelection();
                return;
            }
            this.fetchSelectedPost(value);
        } else {
            value = value || '';
            if (!value) {
                this.selection = null;
                this.renderSelection();
                return;
            }
            this.fetchSelectedTag(value);
        }
    };

    LookupControl.prototype.fetchSelectedPost = function (postId) {
        var _this = this;
        fetchLookup('post', {
            include: postId,
            tag: this.currentTag,
            category: this.categoryFilter,
        }).then(function (data) {
            var item = data && data.items ? data.items.find(function (candidate) {
                return parseInt(candidate.id, 10) === postId;
            }) : null;

            if (item) {
                _this.selection = item;
            } else {
                _this.selection = {
                    id: postId,
                    title: getString('unavailable') + ' (ID ' + postId + ')',
                    matches_tag: false,
                    matches_category: false,
                    valid: false,
                };
            }
            _this.renderSelection();
        }).catch(function () {
            _this.selection = {
                id: postId,
                title: getString('unavailable') + ' (ID ' + postId + ')',
                matches_tag: false,
                matches_category: false,
                valid: false,
            };
            _this.renderSelection();
        });
    };

    LookupControl.prototype.fetchSelectedTag = function (slug) {
        var _this = this;
        fetchLookup('tag', {
            search: slug,
            per_page: 1,
            slug: slug,
        }).then(function (data) {
            var item = data && data.items ? data.items.find(function (candidate) {
                return candidate.slug === slug;
            }) : null;
            if (item) {
                _this.selection = item;
            } else {
                _this.selection = {
                    slug: slug,
                    name: getString('unavailable') + ' (' + slug + ')',
                };
            }
            _this.renderSelection();
            _this.checkTagAvailability();
        }).catch(function () {
            _this.selection = {
                slug: slug,
                name: getString('unavailable') + ' (' + slug + ')',
            };
            _this.renderSelection();
        });
    };

    LookupControl.prototype.renderSelection = function () {
        if (!this.selectionList) {
            return;
        }

        this.selectionList.innerHTML = '';
        if (this.notice) {
            this.notice.textContent = '';
        }

        var hasSelection = Boolean(this.selection && (this.selection.id || this.selection.slug));

        if (!hasSelection) {
            if (this.valueInput) {
                this.valueInput.value = '';
            }
            if (this.allowClear && this.clearButton) {
                this.clearButton.style.display = 'none';
            }
            return;
        }

        if (this.lookupType === 'post') {
            this.renderPostSelection();
            if (this.valueInput) {
                this.valueInput.value = this.selection.id;
            }
        } else {
            this.renderTagSelection();
            if (this.valueInput) {
                this.valueInput.value = this.selection.slug;
            }
            this.checkTagAvailability();
        }

        if (this.allowClear && this.clearButton) {
            this.clearButton.style.display = '';
        }
    };

    LookupControl.prototype.renderPostSelection = function () {
        var token = document.createElement('div');
        token.className = 'edpsy-post-lookup__token';
        var matchesTag = this.selection.matches_tag;
        if (typeof matchesTag === 'undefined') {
            matchesTag = this.selection.matchesTag;
        }
        var matchesCategory = this.selection.matches_category;
        if (typeof matchesCategory === 'undefined') {
            matchesCategory = this.selection.matchesCategory;
        }
        var isValid = this.selection.valid;
        if (typeof isValid === 'undefined') {
            isValid = true;
        }

        if (matchesTag === false || matchesCategory === false || isValid === false) {
            token.classList.add(INVALID_CLASS);
            if (this.notice) {
                this.notice.textContent = getString('selectionInvalid');
            }
        }

        var title = decodeEntities(this.selection.title || '');
        var date = this.selection.date ? '<span class="edpsy-post-lookup__token-meta">' + this.selection.date + '</span>' : '';

        token.innerHTML = '<span class="edpsy-post-lookup__token-label">' + title + '</span>' + date;

        var remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'button-link edpsy-post-lookup__remove';
        remove.textContent = getString('clear');
        remove.addEventListener('click', this.onRemoveSelection.bind(this));
        token.appendChild(remove);

        this.selectionList.appendChild(token);
    };

    LookupControl.prototype.renderTagSelection = function () {
        var token = document.createElement('div');
        token.className = 'edpsy-post-lookup__token';

        var label = decodeEntities(this.selection.name || this.selection.label || '');
        var count = typeof this.selection.count === 'number' ? '<span class="edpsy-post-lookup__token-meta">' + this.selection.count + '</span>' : '';

        token.innerHTML = '<span class="edpsy-post-lookup__token-label">' + label + '</span>' + count;

        var remove = document.createElement('button');
        remove.type = 'button';
        remove.className = 'button-link edpsy-post-lookup__remove';
        remove.textContent = getString('clear');
        remove.addEventListener('click', this.onRemoveSelection.bind(this));
        token.appendChild(remove);

        this.selectionList.appendChild(token);
    };

    LookupControl.prototype.clearSelection = function (message) {
        this.selection = null;
        if (this.valueInput) {
            this.valueInput.value = '';
        }
        this.control.setting.set(this.lookupType === 'post' ? 0 : '');
        this.renderSelection();
        this.updateStatus('');
        if (this.notice && message) {
            this.notice.textContent = message;
        }
        if (this.lookupType === 'tag' && this.tagFeedback) {
            this.tagFeedback.textContent = '';
        }
    };

    LookupControl.prototype.onRemoveSelection = function (event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
        }
        this.clearSelection();
    };

    LookupControl.prototype.selectItem = function (item) {
        if (!item) {
            return;
        }

        if (this.lookupType === 'post') {
            this.selection = item;
            this.control.setting.set(parseInt(item.id, 10) || 0);
        } else {
            this.selection = {
                slug: item.slug,
                name: item.name,
                count: item.count,
            };
            this.control.setting.set(item.slug || '');
        }

        this.renderSelection();
        this.closeList();
    };

    LookupControl.prototype.onTagChanged = function () {
        var _this = this;
        if (this.lookupType === 'post') {
            if (this.selection && this.selection.id) {
                fetchLookup('post', {
                    include: this.selection.id,
                    tag: this.currentTag,
                    category: this.categoryFilter,
                }).then(function (data) {
                    var item = data && data.items ? data.items.find(function (candidate) {
                        return parseInt(candidate.id, 10) === parseInt(_this.selection.id, 10);
                    }) : null;
                    if (!item || item.matches_tag === false) {
                        _this.clearSelection(getString('selectionCleared'));
                    } else {
                        _this.selection = item;
                        _this.renderSelection();
                    }
                }).catch(function () {
                    _this.clearSelection(getString('selectionCleared'));
                });
            }

            this.state.nextPage = 1;
            this.state.items = [];
            this.state.hasMore = true;
            this.loadResults(true);
        }
    };

    LookupControl.prototype.checkTagAvailability = function () {
        var _this = this;
        if (this.lookupType !== 'tag' || !this.selection || !this.selection.slug || !this.tagFeedback) {
            return;
        }

        fetchLookup('post', {
            tag: this.selection.slug,
            per_page: 1,
            page: 1,
        }).then(function (data) {
            var hasPosts = data && data.items && data.items.length;
            _this.tagFeedback.textContent = hasPosts ? '' : getString('tagHasNoPosts');
        }).catch(function () {
            _this.tagFeedback.textContent = '';
        });
    };

    api.controlConstructor['edpsy-post-lookup'] = api.Control.extend({
        ready: function () {
            if (!this.lookupControl) {
                this.lookupControl = new LookupControl(this);
            }
        },
    });
})(window.wp && window.wp.customize, window);
