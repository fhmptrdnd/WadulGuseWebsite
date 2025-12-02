document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin Dashboard Script Loaded');

    // 1. OPEN ADMIN MODAL
    window.openAdminModal = function(card) {
        const d = card.dataset;
        const isFinal = d.isFinal === 'true';

        // --- A. ISI DETAIL LAPORAN (KIRI) ---
        document.getElementById('modalTitle').textContent = d.title;
        document.getElementById('modalUser').textContent = d.user;
        document.getElementById('modalDate').textContent = d.date;
        document.getElementById('modalLocation').textContent = d.location || '-';
        document.getElementById('modalDesc').textContent = d.desc;

        document.getElementById('modalOpdDisplay').textContent = d.opdName || 'Belum ditentukan';
        document.getElementById('modalPrioritasDisplay').textContent = (d.prioritas || '-');

        // Badge Status
        const badge = document.getElementById('modalStatusBadge');
        badge.textContent = d.status;
        badge.className = "inline-block px-3 py-1 rounded-full text-xs font-bold text-white mb-3 uppercase shadow-sm";
        if(d.status === 'pending') badge.classList.add('bg-pink-500');
        else if(d.status === 'verified') badge.classList.add('bg-green-500');
        else if(d.status === 'on_progress') badge.classList.add('bg-blue-500');
        else if(d.status === 'done') badge.classList.add('bg-emerald-600');
        else badge.classList.add('bg-red-500');

        // Foto Pelapor
        const photoCont = document.getElementById('modalPhotoContainer');
        if (d.photo && d.photo !== '') {
            photoCont.classList.remove('hidden');
            document.getElementById('modalPhoto').src = d.photo;
            document.getElementById('modalPhotoLink').href = d.photo;
        } else {
            photoCont.classList.add('hidden');
        }

        // --- B. ATUR FORM (READ ONLY VS EDITABLE) ---
        const formAlert = document.getElementById('finalStatusAlert');
        const formOverlay = document.getElementById('formDisabledOverlay');
        const btnSubmit = document.getElementById('btnSubmitAdmin');

        // Reset Form Values
        const form = document.getElementById('adminProcessForm');
        form.action = d.action;
        document.getElementById('inputStatus').value = d.status;
        document.getElementById('inputFeedback').value = d.feedback || '';
        document.getElementById('inputOpd').value = d.opd || '';
        document.getElementById('inputPrioritas').value = d.prioritas || 'rendah';

        // Foto Admin
        const adminPhotoBox = document.getElementById('existingAdminPhoto');
        if (d.adminPhoto && d.adminPhoto !== '') {
            adminPhotoBox.classList.remove('hidden');
            document.getElementById('imgAdminPhoto').src = d.adminPhoto;
        } else {
            adminPhotoBox.classList.add('hidden');
        }

        // Trigger field visibility logic
        toggleAdminFields();

        // LOGIKA KUNCI FORM
        if (isFinal) {
            // Mode Baca Saja
            formAlert.classList.remove('hidden');
            formOverlay.classList.remove('hidden'); // Tutup akses klik
            btnSubmit.classList.add('hidden'); // Sembunyikan tombol simpan

            // Disable inputs secara manual juga biar aman
            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.disabled = true);
        } else {
            // Mode Edit
            formAlert.classList.add('hidden');
            formOverlay.classList.add('hidden');
            btnSubmit.classList.remove('hidden');

            const inputs = form.querySelectorAll('input, select, textarea');
            inputs.forEach(input => input.disabled = false);
        }

        // Tampilkan Modal
        document.getElementById('adminProcessModal').classList.remove('hidden');
    };

    // 2. CLOSE MODAL
    window.closeAdminModal = function() {
        document.getElementById('adminProcessModal').classList.add('hidden');
    };

    // 3. LOGIKA FORM DINAMIS
    window.toggleAdminFields = function() {
        const status = document.getElementById('inputStatus').value;
        const groupOpd = document.getElementById('groupOpdPrioritas');
        const groupFoto = document.getElementById('groupAdminPhoto');
        const labelFeedbackReq = document.getElementById('feedbackRequired');

        const inputOpd = document.getElementById('inputOpd');
        const inputPrio = document.getElementById('inputPrioritas');
        const inputFeedback = document.getElementById('inputFeedback');

        // Reset
        inputOpd.removeAttribute('required');
        inputPrio.removeAttribute('required');
        inputFeedback.removeAttribute('required');
        labelFeedbackReq.classList.add('hidden');

        // Logic 1: OPD & Prioritas (Visible jika Verified/Progress/Done)
        if (['verified', 'on_progress', 'done'].includes(status)) {
            groupOpd.classList.remove('hidden');
            if (status === 'verified') {
                inputOpd.setAttribute('required', 'required');
                inputPrio.setAttribute('required', 'required');
            }
        } else {
            groupOpd.classList.add('hidden');
        }

        // Logic 2: Foto (Visible jika Verified/Progress/Done)
        if (['verified', 'on_progress', 'done'].includes(status)) {
            groupFoto.classList.remove('hidden');
        } else {
            groupFoto.classList.add('hidden');
        }

        // Logic 3: Feedback Wajib (Progress/Done/Rejected)
        if (['on_progress', 'done', 'rejected'].includes(status)) {
            inputFeedback.setAttribute('required', 'required');
            labelFeedbackReq.classList.remove('hidden');
        }
    };
});
