document.addEventListener('DOMContentLoaded', function() {
    console.log('User Management Script Loaded (With Filters)');

    const searchInput = document.getElementById('searchInput');
    const searchFilter = document.getElementById('searchFilter');
    const tableRows = document.querySelectorAll('.user-row');

    // Fungsi utama untuk filter tabel
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const filterType = searchFilter.value; // 'name', 'nik', atau 'email'

        tableRows.forEach(row => {
            // Mapping Index Kolom:
            // 0 = Nama (di dalam div, jadi butuh .textContent)
            // 1 = NIK
            // 2 = Email

            let textToCheck = "";

            if (filterType === 'name') {
                // Ambil text dari kolom pertama (Nama)
                textToCheck = row.children[0].textContent.toLowerCase();
            } else if (filterType === 'nik') {
                // Ambil text dari kolom kedua (NIK)
                textToCheck = row.children[1].textContent.toLowerCase();
            } else if (filterType === 'email') {
                // Ambil text dari kolom ketiga (Email)
                textToCheck = row.children[2].textContent.toLowerCase();
            }

            // Logika Display
            // Jika searchTerm kosong ATAU text cocok, tampilkan row
            if (searchTerm === "" || textToCheck.includes(searchTerm)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event Listener: Jalankan filter saat ngetik
    if (searchInput) {
        searchInput.addEventListener('keyup', filterTable);
    }

    // Event Listener: Jalankan filter saat dropdown diganti
    if (searchFilter) {
        searchFilter.addEventListener('change', function() {
            // Bersihkan input saat ganti filter biar tidak bingung (Opsional, tapi UX bagus)
            // searchInput.value = '';
            // filterTable();

            // Atau biarkan input tetap ada, dan langsung filter ulang berdasarkan kategori baru:
            filterTable();
            searchInput.focus();
        });
    }
});

// Fungsi Konfirmasi Action (Sweet Alert Style Native)
window.confirmAction = function(event, actionType, userName) {
    const message = `Yakin ingin ${actionType} user "${userName}"?`;
    if (!confirm(message)) {
        event.preventDefault();
        return false;
    }
    return true;
};
