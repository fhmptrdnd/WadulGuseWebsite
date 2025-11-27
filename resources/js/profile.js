document.addEventListener('DOMContentLoaded', function() {
    console.log('Profile Script Loaded');
});

/**
 * Membuka Modal
 * Fungsi dibuat global (window.) agar bisa dipanggil dari atribut onclick HTML
 */
window.openModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.remove('hidden');
        // Tambahkan sedikit animasi fade-in jika ingin (opsional, via CSS class)
        modal.classList.add('fade-in');
    }
};

/**
 * Menutup Modal
 */
window.closeModal = function(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
    }
};

/**
 * Fitur Tambahan: Tutup Modal dengan tombol ESC
 */
document.addEventListener('keydown', function(event) {
    if (event.key === "Escape") {
        // Cari modal yang sedang terbuka, atau spesifik ID
        closeModal('editProfileModal');
    }
});
