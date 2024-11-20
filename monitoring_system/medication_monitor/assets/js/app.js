document.addEventListener('DOMContentLoaded', function() {
    const carouselInner = document.querySelector('.carousel-inner');
    const nextButton = document.querySelector('.carousel-control.next');
    const prevButton = document.querySelector('.carousel-control.prev');
    let currentIndex = 0;

    nextButton.addEventListener('click', () => {
        const items = document.querySelectorAll('.carousel-item');
        currentIndex = (currentIndex + 1) % items.length;
        carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
    });

    prevButton.addEventListener('click', () => {
        const items = document.querySelectorAll('.carousel-item');
        currentIndex = (currentIndex - 1 + items.length) % items.length;
        carouselInner.style.transform = `translateX(-${currentIndex * 100}%)`;
    });

    // Optionally, add keyboard navigation
    document.addEventListener('keydown', (event) => {
        if (event.key === 'ArrowRight') {
            nextButton.click();
        } else if (event.key === 'ArrowLeft') {
            prevButton.click();
        }
    });
});