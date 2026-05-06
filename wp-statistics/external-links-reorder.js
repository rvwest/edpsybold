document.addEventListener('DOMContentLoaded', function () {

    // ── 1. Move External Links card above Top Countries ────────────────────────
    var card = document.getElementById('mytheme-external-links-card');
    if (card) {
        var headings = document.querySelectorAll('.wps-card .wps-card__title h2');
        for (var i = 0; i < headings.length; i++) {
            if (headings[i].textContent.trim().indexOf('Top Countries') === 0) {
                headings[i].closest('.wps-card').parentNode.insertBefore(card, headings[i].closest('.wps-card'));
                break;
            }
        }
    }

    // ── 2. Inject total external clicks into the At a Glance panel ─────────────
    var totalEl = document.getElementById('mytheme-wps-ext-clicks-total');
    if (!totalEl) return;

    var total = parseInt(totalEl.dataset.total, 10) || 0;

    var headings = document.querySelectorAll('.wps-card .wps-card__title h2');
    for (var j = 0; j < headings.length; j++) {
        if (headings[j].textContent.trim() === 'At a Glance') {
            var inside = headings[j].closest('.wps-card').querySelector('.inside');
            if (!inside) break;

            var stat = document.createElement('div');
            stat.className = 'mytheme-wps-stat-item';
            stat.innerHTML =
                '<span class="mytheme-wps-stat-label">External Clicks</span>' +
                '<span class="mytheme-wps-stat-value">' + total.toLocaleString() + '</span>';
            inside.appendChild(stat);
            break;
        }
    }
});
