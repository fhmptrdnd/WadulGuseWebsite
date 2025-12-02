document.addEventListener('DOMContentLoaded', function() {
    console.log('User Script Loaded Correctly');

    // 1. OPEN VIEW MODAL (FROM LIST CLICK)
    window.openViewModal = function(card) {
        const d = card.dataset;

        // Set Content
        document.getElementById('viewTitle').textContent = d.title;
        document.getElementById('viewDate').textContent = d.date;
        document.getElementById('viewCategory').textContent = d.category;
        document.getElementById('viewLocation').textContent = d.location;
        document.getElementById('viewDesc').textContent = d.desc;

        // Set Status Badge
        const badge = document.getElementById('viewStatusBadge');
        badge.textContent = d.status;
        badge.className = "absolute bottom-3 left-3 text-white text-xs font-bold px-3 py-1 rounded-full shadow-md uppercase";
        if(d.status === 'pending') badge.classList.add('bg-orange-500');
        else if(d.status === 'verified') badge.classList.add('bg-blue-500');
        else if(d.status === 'on_progress') badge.classList.add('bg-indigo-500');
        else if(d.status === 'done') badge.classList.add('bg-green-500');
        else badge.classList.add('bg-red-500');

        // Handle Photo
        const photoImg = document.getElementById('viewPhoto');
        const noPhoto = document.getElementById('viewNoPhoto');
        if (d.photo && d.photo !== '') {
            photoImg.src = d.photo;
            photoImg.classList.remove('hidden');
            noPhoto.classList.add('hidden');
        } else {
            photoImg.classList.add('hidden');
            noPhoto.classList.remove('hidden');
        }

        // Handle Feedback
        const feedbackSec = document.getElementById('viewFeedbackSection');
        if (d.feedback && d.feedback !== '') {
            feedbackSec.classList.remove('hidden');
            document.getElementById('viewFeedback').textContent = `"${d.feedback}"`;

            const adminPhotoCont = document.getElementById('viewAdminPhotoContainer');
            if (d.adminPhoto && d.adminPhoto !== '') {
                adminPhotoCont.classList.remove('hidden');
                document.getElementById('viewAdminPhoto').src = d.adminPhoto;
                document.getElementById('viewAdminPhotoLink').href = d.adminPhoto;
            } else {
                adminPhotoCont.classList.add('hidden');
            }
        } else {
            feedbackSec.classList.add('hidden');
        }

        // Handle Actions (Only if Pending)
        const actionBtns = document.getElementById('viewActionButtons');
        if (d.status === 'pending') {
            actionBtns.classList.remove('hidden');
            actionBtns.classList.add('flex'); // Pastikan flex agar layout rapi

            // Bind Edit Button
            const btnEdit = document.getElementById('btnEditFromView');
            btnEdit.onclick = function(e) {
                e.stopPropagation(); // Mencegah bubble event
                closeModal('viewReportModal');

                // Populate & Open Edit Modal
                populateEditModal(d);
            };

            // Bind Delete Form
            const formDelete = document.getElementById('formDeleteFromView');
            formDelete.action = d.deleteUrl;
        } else {
            actionBtns.classList.add('hidden');
            actionBtns.classList.remove('flex');
        }

        openModal('viewReportModal');
    };

    // Helper: Isi Form Edit
    function populateEditModal(d) {
        document.getElementById('editTitle').value = d.title;
        document.getElementById('editDescription').value = d.desc;
        document.getElementById('editLocation').value = d.location;
        document.getElementById('editCategory').value = d.category;
        document.getElementById('editReportForm').action = d.editUrl;

        const photoContainer = document.getElementById('editPhotoContainer');
        const photoImg = document.getElementById('editPhotoPreview');
        if (d.photo && d.photo !== '') {
            photoImg.src = d.photo;
            photoContainer.classList.remove('hidden');
        } else {
            photoContainer.classList.add('hidden');
        }
        openModal('editReportModal');
    }

    // 2. GENERIC MODAL LOGIC
    window.openModal = function(id) { document.getElementById(id).classList.remove('hidden'); };
    window.closeModal = function(id) { document.getElementById(id).classList.add('hidden'); };

    // 3. NOTIFICATION TOGGLE
    const notifModal = document.getElementById('notificationModal');
    window.toggleNotification = function() {
        if (notifModal.classList.contains('hidden')) {
            notifModal.classList.remove('hidden');
            setTimeout(() => notifModal.classList.remove('scale-90', 'opacity-0'), 10);
        } else {
            notifModal.classList.add('scale-90', 'opacity-0');
            setTimeout(() => notifModal.classList.add('hidden'), 300);
        }
    };
});
