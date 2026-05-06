document.addEventListener('DOMContentLoaded', function () {
    var card = document.getElementById('mytheme-external-links-card');
    if (!card) return;

    var headings = document.querySelectorAll('.wps-card .wps-card__title h2');
    var topCountriesCard = null;

    for (var i = 0; i < headings.length; i++) {
        if (headings[i].textContent.trim().indexOf('Top Countries') === 0) {
            topCountriesCard = headings[i].closest('.wps-card');
            break;
        }
    }

    if (topCountriesCard) {
        topCountriesCard.parentNode.insertBefore(card, topCountriesCard);
    }
});
