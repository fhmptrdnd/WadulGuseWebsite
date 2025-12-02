document.addEventListener('DOMContentLoaded', function() {
    console.log('News Management Script Loaded (Server-Side Search)');

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

    // NOTE: Live Search Logic telah dihapus karena sekarang menggunakan Server-Side Search via Controller
});

// ==========================================
// 2. LOGIKA MODAL (CREATE & EDIT)
// ==========================================
window.openModal = function(modalId) {
    document.getElementById(modalId).classList.remove('hidden');
};

window.closeModal = function(modalId) {
    document.getElementById(modalId).classList.add('hidden');
};

/**
 * Membuka Modal Edit dan Mengisi Datanya
 */
window.openEditModal = function(button) {
    const title = button.getAttribute('data-title');
    const content = button.getAttribute('data-content');
    const imageUrl = button.getAttribute('data-image');
    const updateUrl = button.getAttribute('data-update-url');

    document.getElementById('editJudul').value = title;
    document.getElementById('editKonten').value = content;
    document.getElementById('editNewsForm').action = updateUrl;
    document.getElementById('charCountEdit').textContent = content.length;

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

    openModal('editNewsModal');
};

// ==========================================
// 3. CONFIRM DELETE
// ==========================================
window.confirmDelete = function(event) {
    if (!confirm("Yakin hapus berita ini?")) {
        event.preventDefault();
        return false;
    }
    return true;
};
