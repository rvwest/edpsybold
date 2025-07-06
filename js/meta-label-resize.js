(function() {
  function adjustMetaLabelWidth() {
    const labels = document.querySelectorAll('.meta-item .label');
    if (!labels.length) return;

    // Only apply on narrow viewports
    if (window.innerWidth <= 782) {
      let maxWidth = 0;
      labels.forEach(label => {
        label.style.width = 'auto';
        const width = label.offsetWidth;
        if (width > maxWidth) maxWidth = width;
      });
      labels.forEach(label => {
        label.style.width = maxWidth + 'px';
      });
    } else {
      labels.forEach(label => {
        label.style.width = '';
      });
    }
  }

  document.addEventListener('DOMContentLoaded', adjustMetaLabelWidth);
  window.addEventListener('resize', adjustMetaLabelWidth);
})();
