(function () {
    'use strict';

    var METADATA_BLOCK_SELECTOR = '.wpbdp-metadata-block';
    var FIELD_LABEL_SELECTOR = '.field-label';
    var resizeObserver = null;
    var scheduled = false;
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

    function updateBlock(block) {
        if (!block) {
            return;
        }

        var labels = toArray(block.querySelectorAll(FIELD_LABEL_SELECTOR));
        if (!labels.length) {
            return;
        }

        clearInlineWidths(labels);
        var maxWidth = getMaxLabelWidth(labels);
        applyLabelWidth(labels, Math.ceil(maxWidth));
    }

    function updateAllBlocks() {
        var blocks = document.querySelectorAll(METADATA_BLOCK_SELECTOR);
        if (!blocks.length) {
            return;
        }

        toArray(blocks).forEach(updateBlock);
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

        blocks.forEach(function (block) {
            resizeObserver.observe(block);
        });
    }

    function init() {
        var blocks = document.querySelectorAll(METADATA_BLOCK_SELECTOR);
        if (!blocks.length) {
            return;
        }

        updateAllBlocks();
        observeBlocks(toArray(blocks));

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
