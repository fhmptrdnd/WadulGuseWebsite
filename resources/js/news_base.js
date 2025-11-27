document.addEventListener('DOMContentLoaded', function() {
    console.log('News Management Script Loaded');

    // ==========================================
    // 1. CHARACTER COUNTER (CREATE & EDIT)
    // ==========================================
    function setupCharCount(inputId, displayId) {
        const input = document.getElementById(inputId);
        const display = document.getElementById(displayId);
        if (input && display) {
            const update = () => { display.textContent = input.value.length; };
            input.addEventListener('input', update);
            update(); // init
        }
    }

    setupCharCount('kontenCreate', 'charCountCreate');
    setupCharCount('editKonten', 'charCountEdit');

    // ==========================================
    // 2. LIVE SEARCH
    // ==========================================
    const searchInput = document.getElementById('newsSearchInput');
    const newsItems = document.querySelectorAll('.news-item');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const term = e.target.value.toLowerCase();
            newsItems.forEach(item => {
                const title = item.querySelector('.news-title').textContent.toLowerCase();
                item.style.display = title.includes(term) ? 'flex' : 'none';
            });
        });
    }
});

// ==========================================
// 3. LOGIKA MODAL (CREATE & EDIT)
// ==========================================
window.openModal = function(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
};

window.closeModal = function(modalId) {
    document.getElementById(modalId).classList.add('hidden');
};

/**
 * Membuka Modal Edit dan Mengisi Datanya
 * Data diambil dari atribut 'data-*' pada tombol edit
 */
window.openEditModal = function(button) {
    // 1. Ambil data dari tombol
    const title = button.getAttribute('data-title');
    const content = button.getAttribute('data-content');
    const imageUrl = button.getAttribute('data-image');
    const updateUrl = button.getAttribute('data-update-url');

    // 2. Isi Form Edit
    document.getElementById('editJudul').value = title;
    document.getElementById('editKonten').value = content;
    document.getElementById('editNewsForm').action = updateUrl;

    // 3. Update Character Count Manual
    document.getElementById('charCountEdit').textContent = content.length;

    // 4. Handle Preview Gambar
    const imgPreview = document.getElementById('editImagePreview');
    const noImageText = document.getElementById('noImagePlaceholder');

    if (imageUrl && imageUrl !== "") {
        imgPreview.src = imageUrl;
        imgPreview.classList.remove('hidden');
        noImageText.classList.add('hidden');
    } else {
        imgPreview.classList.add('hidden');
        noImageText.classList.remove('hidden');
    }

    // 5. Tampilkan Modal
    openModal('editNewsModal');
};

// ==========================================
// 4. CONFIRM DELETE
// ==========================================
window.confirmDelete = function(event) {
    if (!confirm("Yakin hapus berita ini?")) {
        event.preventDefault();
        return false;
    }
    return true;
};
