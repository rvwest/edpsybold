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

    btn.addEventListener('click', async function (e) {
      e.preventDefault();
      var shareData = {
        title: btn.dataset.title || document.title,
        text: btn.dataset.text || '',
        url: btn.dataset.url || window.location.href
      };

      var imgUrl = btn.dataset.image;
      if (navigator.canShare && imgUrl) {
        try {
          var response = await fetch(imgUrl, { mode: 'cors' });
          var blob = await response.blob();
          var file = new File([blob], 'share.' + (blob.type.split('/').pop() || 'jpg'), { type: blob.type });
          if (navigator.canShare({ files: [file] })) {
            shareData.files = [file];
          }
        } catch (err) {
          // Ignore image errors and share without image
          console.error('Image fetch failed', err);
        }
      }

      try {
        await navigator.share(shareData);
      } catch (err) {
        // User may cancel share or share may fail; log for debugging
        console.error('Share failed', err);
      }
    });
  });
})();
