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

document.getElementById('messageTextarea').addEventListener('keydown', function(event) {
    if (event.key === 'Enter') {
        if (event.shiftKey) {
            // Jika Shift + Enter ditekan, buat paragraf baru (default behavior)
            return;
        } else {
            // Jika hanya Enter ditekan, kirim pesan
            event.preventDefault(); // Menghentikan form submit otomatis
            document.querySelector('form').submit(); // Kirim form
        }
    }
});


document.getElementById('image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        const imageUrl = e.target.result;
        const imageContainer = document.getElementById('selectedImageContainer');
        const imageElement = document.getElementById('selectedImage');
        const removeButton = document.getElementById('removeImage');
        
        imageElement.src = imageUrl;
        imageContainer.style.display = 'block';
        
        removeButton.addEventListener('click', function() {
          imageContainer.style.display = 'none';
          document.getElementById('image').value = ''; // Reset input file
        });
      };
      reader.readAsDataURL(file);
    }
  });