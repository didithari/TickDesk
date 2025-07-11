window.addEventListener('load', function () {
  if (!location.pathname.includes('/dev/chatdev')) {
    console.log('[chatdev.js] loaded but not on /dev/chatdev');
    return;
  }

  console.log('[chatdev.js] running...');

  const chatBody = document.getElementById('chatBody');
  if (chatBody) {
    setTimeout(() => {
      chatBody.scrollTop = chatBody.scrollHeight;
    }, 100);
  }

  const images = document.querySelectorAll('.chat-image-clickable');
  const modalImage = document.getElementById('modalImage');
  const modalEl = document.getElementById('imageModal');

  if (images.length && modalImage && modalEl) {
    const modal = new bootstrap.Modal(modalEl);
    images.forEach(img => {
      img.addEventListener('click', () => {
        modalImage.src = img.src;
        modal.show();
      });
    });
  }
});
