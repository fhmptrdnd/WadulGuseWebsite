document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Panel JS Ready');

    // 1. Inisialisasi Status Awal Form
    // Cek semua dropdown status saat halaman dimuat, barangkali ada input old() dari validasi error
    const allStatusSelects = document.querySelectorAll('select[id^="status_"]');
    allStatusSelects.forEach(select => {
        const reportId = select.id.split('_')[1];
        handleStatusChange(select, reportId);
    });

    // 2. Auto Hide Alert (Notifikasi Sukses)
    const alertBox = document.getElementById('alert-box');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.remove();
            }, 500);
        }, 4000); // Hilang setelah 4 detik
    }
});

/**
 * Fungsi Toggle Tampilkan/Sembunyikan Form Edit
 * Dipanggil oleh tombol "Proses Laporan"
 */
window.toggleForm = function(elementId) {
    const form = document.getElementById(elementId);
    if (form) {
        form.classList.toggle('hidden');
    }
}

/**
 * Logika Utama Form Laporan
 * Mengatur field mana yang wajib/muncul berdasarkan status yang dipilih
 */
window.handleStatusChange = function(selectElement, reportId) {
    const status = selectElement.value;

    // Ambil elemen wrapper (Group)
    const groupOpd = document.getElementById('group-opd-' + reportId);
    const groupPrio = document.getElementById('group-prio-' + reportId);
    const groupFoto = document.getElementById('group-foto-' + reportId);

    // Ambil input asli (untuk set attribut required)
    const inputOpd = document.getElementById('opd_' + reportId);
    const inputPrio = document.getElementById('prio_' + reportId);
    const inputFeedback = document.getElementById('feedback_' + reportId);

    // Reset required dulu
    if(inputOpd) inputOpd.removeAttribute('required');
    if(inputPrio) inputPrio.removeAttribute('required');
    if(inputFeedback) inputFeedback.removeAttribute('required');

    // LOGIKA 1: Jika Status VERIFIED -> Wajib pilih OPD & Prioritas
    if (status === 'verified') {
        groupOpd.classList.remove('hidden');
        groupPrio.classList.remove('hidden');
        if(inputOpd) inputOpd.setAttribute('required', 'required');
        if(inputPrio) inputPrio.setAttribute('required', 'required');
    } else {
        groupOpd.classList.add('hidden');
        groupPrio.classList.add('hidden');
    }

    // LOGIKA 2: Jika Status ON_PROGRESS / DONE -> Boleh upload foto bukti
    if (status === 'on_progress' || status === 'done' || status === 'verified') {
        groupFoto.classList.remove('hidden');
    } else {
        groupFoto.classList.add('hidden');
    }

    // LOGIKA 3: Jika Status ON_PROGRESS / DONE / REJECTED -> Wajib isi Feedback
    if (status === 'on_progress' || status === 'done' || status === 'rejected') {
        if(inputFeedback) inputFeedback.setAttribute('required', 'required');
    }
};
