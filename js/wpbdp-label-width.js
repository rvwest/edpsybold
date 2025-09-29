(function () {
    'use strict';

    var BLOCK_CONFIGS = [
        {
            blockSelector: '.wpbdp-metadata-block',
            labelSelector: '.field-label'
        },
        {
            blockSelector: '.event-listing-meta',
            labelSelector: '.label'
        },
        {
            blockSelector: '.job-listing-meta',
            labelSelector: '.label'
        }
    ];
    var resizeObserver = null;
    var scheduled = false;
    var observedBlocks = null;
    var requestFrame =
        window.requestAnimationFrame || function (callback) {
            return window.setTimeout(callback, 16);
        };

    function toArray(nodeList) {
        return Array.prototype.slice.call(nodeList);
    }

    function clearInlineWidths(labels) {
        labels.forEach(function (label) {
            label.style.width = '';
            label.style.minWidth = '';
        });
    }

    function getMaxLabelWidth(labels) {
        var maxWidth = 0;

        labels.forEach(function (label) {
            var width = label.getBoundingClientRect().width;
            if (width > maxWidth) {
                maxWidth = width;
            }
        });

        return maxWidth;
    }

    function applyLabelWidth(labels, width) {
        if (!width) {
            return;
        }

        labels.forEach(function (label) {
            label.style.width = width + 'px';
            label.style.minWidth = width + 'px';
        });
    }

    function updateBlock(block, labelSelector) {
        if (!block) {
            return;
        }

        var labels = toArray(block.querySelectorAll(labelSelector));
        if (!labels.length) {
            return;
        }

        clearInlineWidths(labels);
        var maxWidth = getMaxLabelWidth(labels);
        applyLabelWidth(labels, Math.ceil(maxWidth));
    }

    function updateAllBlocks() {
        var hasAnyBlocks = false;

        BLOCK_CONFIGS.forEach(function (config) {
            var blocks = document.querySelectorAll(config.blockSelector);
            if (!blocks.length) {
                return;
            }

            hasAnyBlocks = true;
            toArray(blocks).forEach(function (block) {
                updateBlock(block, config.labelSelector);
            });
        });

        return hasAnyBlocks;
    }

    function scheduleUpdate() {
        if (scheduled) {
            return;
        }

        scheduled = true;
        requestFrame(function () {
            scheduled = false;
            updateAllBlocks();
        });
    }

    function observeBlocks(blocks) {
        if (typeof window.ResizeObserver !== 'function') {
            return;
        }

        if (!resizeObserver) {
            resizeObserver = new window.ResizeObserver(function (entries) {
                entries.forEach(function (entry) {
                    scheduleUpdate();
                });
            });
        }

        if (!observedBlocks && typeof window.WeakSet === 'function') {
            observedBlocks = new window.WeakSet();
        }

        blocks.forEach(function (block) {
            if (observedBlocks && observedBlocks.has(block)) {
                return;
            }

            resizeObserver.observe(block);
            if (observedBlocks) {
                observedBlocks.add(block);
            }
        });
    }

    function init() {
        var hadBlocks = updateAllBlocks();
        if (!hadBlocks) {
            return;
        }

        BLOCK_CONFIGS.forEach(function (config) {
            var blocks = toArray(document.querySelectorAll(config.blockSelector));
            if (!blocks.length) {
                return;
            }

            observeBlocks(blocks);
        });

        window.addEventListener('resize', scheduleUpdate);
        window.addEventListener('orientationchange', scheduleUpdate);

        if (document.fonts && typeof document.fonts.ready === 'object' && typeof document.fonts.ready.then === 'function') {
            document.fonts.ready.then(scheduleUpdate).catch(function () {
                // Ignore font loading errors.
            });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
