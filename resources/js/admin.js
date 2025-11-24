// Logika JavaScript untuk Admin Dashboard

document.addEventListener('DOMContentLoaded', function() {
    console.log('Admin JS Loaded');

    // 1. Sidebar Toggle (Untuk Responsif Mobile - Optional)
    const sidebar = document.querySelector('aside');
    // Jika kamu nanti menambahkan tombol hamburger menu dengan id="sidebar-toggle"
    const toggleBtn = document.getElementById('sidebar-toggle');

    if(toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            // Contoh logic toggle class tailwind
            sidebar.classList.toggle('-translate-x-full');
        });
    }

    // 2. Efek Fade-Out untuk Notifikasi (Alert)
    const alertBox = document.querySelector('[role="alert"]');
    if (alertBox) {
        setTimeout(() => {
            alertBox.style.transition = "opacity 0.5s ease";
            alertBox.style.opacity = "0";
            setTimeout(() => {
                alertBox.remove();
            }, 500);
        }, 3000); // Hilang otomatis setelah 3 detik
    }

    // 3. Tab Switching Logic (Jika diperlukan manual handling di JS, meski sekarang sudah pakai Route Laravel)
    // Kode di bawah opsional jika kamu ingin menambahkan efek loading saat pindah halaman
    const navLinks = document.querySelectorAll('.nav-item');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            // Tambahkan efek loading atau visual feedback disini jika mau
        });
    });
});
