document.addEventListener('DOMContentLoaded', function() {
    console.log('News List Script Loaded (Server Side Search)');

    // 1. ANIMASI MASUK (Fade In) - Tetap Dipertahankan
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

    // NOTE: Logika searching JS dihapus karena sudah diganti Controller Laravel.
});
