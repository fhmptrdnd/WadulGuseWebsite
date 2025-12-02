document.addEventListener('DOMContentLoaded', function() {
    console.log('User Management Script Loaded (Server Side Search Only)');

    // Logika pencarian JS dihapus karena sudah diganti Controller Laravel.
    // Jika Anda ingin Auto-Submit saat dropdown diganti, uncomment kode di bawah:
    /*
    const filterSelect = document.querySelector('select[name="filter"]');
    if(filterSelect) {
        filterSelect.addEventListener('change', function() {
            this.form.submit();
        });
    }
    */
});

// Fungsi Konfirmasi Action (Tetap Dipertahankan)
window.confirmAction = function(event, actionType, userName) {
    const message = `Yakin ingin ${actionType} user "${userName}"?`;
    if (!confirm(message)) {
        event.preventDefault();
        return false;
    }
    return true;
};
