document.addEventListener('DOMContentLoaded', function() {
    console.log('User Dashboard Script Loaded');


    // 1. Live Search Logic
    const searchInput = document.getElementById('searchReportInput');
    const reportItems = document.querySelectorAll('.report-item');
    const noResultState = document.getElementById('noResultState');

    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            let hasResults = false;

            reportItems.forEach(item => {
                const title = item.querySelector('.report-title').textContent.toLowerCase();
                const desc = item.querySelector('.report-desc').textContent.toLowerCase();
                const status = item.querySelector('.report-status').textContent.toLowerCase();

                // Cari berdasarkan Judul, Deskripsi, atau Status
                if (title.includes(searchTerm) || desc.includes(searchTerm) || status.includes(searchTerm)) {
                    item.style.display = 'block';
                    hasResults = true;
                } else {
                    item.style.display = 'none';
                }
            });

            // Tampilkan pesan "Tidak Ditemukan" jika hasil 0
            if (!hasResults && searchTerm !== '') {
                noResultState.classList.remove('hidden');
            } else {
                noResultState.classList.add('hidden');
            }
        });
    }

    // 1. Notifikasi Floating
    const notifModal = document.getElementById('notificationModal');
    window.toggleNotification = function() {
        if (notifModal.classList.contains('hidden')) {
            notifModal.classList.remove('hidden');
            setTimeout(() => {
                notifModal.classList.remove('scale-90', 'opacity-0');
                notifModal.classList.add('scale-100', 'opacity-100');
            }, 10);
        } else {
            notifModal.classList.remove('scale-100', 'opacity-100');
            notifModal.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                notifModal.classList.add('hidden');
            }, 300);
        }
    };

    // 2. Modal Open/Close
    window.openModal = function(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    };

    window.closeModal = function(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    };

    // 3. Edit Modal with Photo Preview
    window.openEditModal = function(button) {
        // Ambil data
        const id = button.getAttribute('data-id');
        const title = button.getAttribute('data-title');
        const desc = button.getAttribute('data-desc');
        const loc = button.getAttribute('data-loc');
        const cat = button.getAttribute('data-cat');
        const url = button.getAttribute('data-url');
        const photoUrl = button.getAttribute('data-photo');

        // Isi Form
        document.getElementById('editTitle').value = title;
        document.getElementById('editDescription').value = desc;
        document.getElementById('editLocation').value = loc;
        document.getElementById('editCategory').value = cat;
        document.getElementById('editReportForm').action = url;

        // Handle Photo Preview
        const photoContainer = document.getElementById('editPhotoContainer');
        const photoImg = document.getElementById('editPhotoPreview');

        if (photoUrl && photoUrl !== '') {
            photoImg.src = photoUrl;
            photoContainer.classList.remove('hidden');
        } else {
            photoContainer.classList.add('hidden');
        }

        openModal('editReportModal');
    };
});
