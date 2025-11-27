document.addEventListener('DOMContentLoaded', function() {
    console.log('News List Script Loaded');

    // 1. ANIMASI MASUK (Fade In)
    const newsCards = document.querySelectorAll('.news-card');
    newsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });

    // 2. LOGIKA SEARCHING
    const searchInput = document.getElementById('searchNewsPublic');
    const noResultState = document.getElementById('noSearchResult');
    const newsGrid = document.getElementById('newsGridContainer');
    const countDisplay = document.getElementById('newsCountDisplay');
    const initialCount = newsCards.length;

    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            const term = e.target.value.toLowerCase();
            let visibleCount = 0;

            newsCards.forEach(card => {
                const title = card.querySelector('.news-title').textContent.toLowerCase();
                // Opsional: Cari juga di konten ringkasan
                const content = card.querySelector('.news-content').textContent.toLowerCase();

                if (title.includes(term) || content.includes(term)) {
                    card.style.display = 'flex'; // Kembalikan display flex agar layout kartu tidak rusak
                    visibleCount++;

                    // Re-trigger animasi kecil saat muncul kembali (opsional, biar smooth)
                    card.style.opacity = '1';
                } else {
                    card.style.display = 'none';
                }
            });

            // Update Badge Count Realtime
            if(countDisplay) {
                countDisplay.textContent = visibleCount;
            }

            // Tampilkan/Sembunyikan Pesan "Tidak Ditemukan"
            if (visibleCount === 0 && term !== '') {
                noResultState.classList.remove('hidden');
                noResultState.classList.add('flex');
            } else {
                noResultState.classList.add('hidden');
                noResultState.classList.remove('flex');
            }
        });
    }
});
