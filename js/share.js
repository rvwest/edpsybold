// Native share button functionality
// Uses the Web Share API when available

(function () {
  document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('share-button');
    if (!btn) {
      return;
    }

    if (!navigator.share) {
      // Hide the button if Web Share API is not supported
      btn.style.display = 'none';
      return;
    }

    btn.addEventListener('click', function (e) {
      e.preventDefault();
      var shareData = {
        title: document.title,
        url: window.location.href
      };
      navigator.share(shareData).catch(function (err) {
        // User may cancel share or share may fail; log for debugging
        console.error('Share failed', err);
      });
    });
  });
})();

