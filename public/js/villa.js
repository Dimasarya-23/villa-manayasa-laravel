document.addEventListener('DOMContentLoaded', () => {
    // ===================================================
    // 1. LANGUAGE SWITCHER (EN/ID)
    // ===================================================
    const langEn = document.querySelectorAll('.text-en');
    const langId = document.querySelectorAll('.text-id');
    const langSwitcherLinks = document.querySelectorAll('.language-switcher a');

    // Default language is English (EN)
    let currentLang = 'en';

    function updateLanguageDisplay() {
        langEn.forEach(el => el.classList.toggle('hidden', currentLang !== 'en'));
        langId.forEach(el => el.classList.toggle('hidden', currentLang !== 'id'));

        // Update active class on switcher links
        langSwitcherLinks.forEach(link => {
            if (link.classList.contains(`lang-${currentLang}`)) {
                link.classList.add('active-lang');
            } else {
                link.classList.remove('active-lang');
            }
        });
    }

    langSwitcherLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            if (link.classList.contains('lang-en')) {
                currentLang = 'en';
            } else if (link.classList.contains('lang-id')) {
                currentLang = 'id';
            }
            updateLanguageDisplay();
        });
    });

    // Initialize display
    updateLanguageDisplay();


    // ===================================================
    // 2. HERO BACKGROUND SLIDER (Index & About)
    // ===================================================
    const heroImages = [
        '/assets/hero-1.jpg',
        '/assets/hero-2.jpg',
        '/assets/hero-3.png'
    ];
    let currentHeroIndex = 0;

    // Logic for index.html hero slider
    const heroSlider = document.getElementById('hero-slider');
    if (heroSlider) {
        heroSlider.style.backgroundImage = `url(${heroImages[currentHeroIndex]})`;

        function changeHeroSlide() {
            currentHeroIndex = (currentHeroIndex + 1) % heroImages.length;
            heroSlider.style.backgroundImage = `url(${heroImages[currentHeroIndex]})`;
        }

        // Change every 5 seconds
        setInterval(changeHeroSlide, 5000);
    }

    // Logic for about.html hero slider (if element exists)
    const heroSliderAbout = document.getElementById('hero-slider-about');
    if (heroSliderAbout) {
        heroSliderAbout.style.backgroundImage = `url(${heroImages[currentHeroIndex]})`;

        function changeHeroSlideAbout() {
            currentHeroIndex = (currentHeroIndex + 1) % heroImages.length;
            heroSliderAbout.style.backgroundImage = `url(${heroImages[currentHeroIndex]})`;
        }

        // Change every 5 seconds
        setInterval(changeHeroSlideAbout, 5000);
    }


    // ===================================================
    // 3. ROOM CAROUSEL SLIDER (Index & About)
    // ===================================================

    // Global object to store current slide index for each slider
    const slideIndexes = {};

    function initializeSlider(sliderId, dotsId, slideCount) {
        slideIndexes[sliderId] = 0;
        const dotsContainer = document.getElementById(dotsId);

        if (!dotsContainer) return; // Exit if element not found

        // Create dots
        for (let i = 0; i < slideCount; i++) {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            dot.dataset.slideIndex = i;
            dot.addEventListener('click', () => {
                currentSlide(i, sliderId);
            });
            dotsContainer.appendChild(dot);
        }

        // Show initial slide and dot
        showSlides(0, sliderId);
    }

    function showSlides(n, sliderId) {
        const sliderInner = document.getElementById(`${sliderId}-slider-inner`);
        const slides = sliderInner ? sliderInner.querySelectorAll('.room-slide, .slide') : [];
        const dotsContainer = document.getElementById(`dots-${sliderId}`);
        const dots = dotsContainer ? dotsContainer.querySelectorAll('.dot') : [];

        if (slides.length === 0) return;

        // Loop the index
        if (n >= slides.length) { slideIndexes[sliderId] = 0; }
        if (n < 0) { slideIndexes[sliderId] = slides.length - 1; }

        // Hide all slides and remove active class from dots
        slides.forEach(slide => slide.style.display = 'none');
        dots.forEach(dot => dot.classList.remove('active'));

        // Show current slide
        slides[slideIndexes[sliderId]].style.display = 'block';

        // Activate current dot
        if (dots[slideIndexes[sliderId]]) {
            dots[slideIndexes[sliderId]].classList.add('active');
        }
    }

    // Function called by Prev/Next buttons
    window.moveRoomSlide = function(n, sliderId) {
        slideIndexes[sliderId] += n;
        showSlides(slideIndexes[sliderId], sliderId);
    }

    // 🔥 NEW: Global function for gallery sliders on About page
    window.moveSlide = function(n, sliderId) {
        slideIndexes[sliderId] += n;
        showSlides(slideIndexes[sliderId], sliderId);
    }

    // Function called by dots
    function currentSlide(n, sliderId) {
        slideIndexes[sliderId] = n;
        showSlides(slideIndexes[sliderId], sliderId);
    }


    // --- Initialization for all rooms on index.html ---
    const roomSliders = [
        { id: 'room1', count: 6 },
        { id: 'room2', count: 6 },
        { id: 'room3', count: 6 },
        { id: 'room4', count: 6 }
    ];

    roomSliders.forEach(slider => {
        initializeSlider(slider.id, `dots-${slider.id}`, slider.count);
    });

    
    // 🔥 NEW: Initialization for galleries on about.html
    const gallerySliders = [
        { id: 'pool', count: 3 },
        { id: 'dining', count: 3 },
        { id: 'garden', count: 2 },
        { id: 'surroundings', count: 3 }
    ];

    gallerySliders.forEach(slider => {
        initializeSlider(slider.id, `dots-${slider.id}`, slider.count);
    });

    // ===================================================
    // 4. GOOGLE MAPS EMBED (Contact Page Only)
    // ===================================================
    const mapPlaceholder = document.getElementById('google-map-embed');
    if (mapPlaceholder) {
        // Embed code untuk Villa Manayasa Lovina
        const iframe = document.createElement('iframe');
        iframe.setAttribute('src', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3947.514785461943!2d115.01377827506263!3d-8.172439591834907!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd98013f9f44c4f%3A0xf60399d82121e780!2sVilla%20Manayasa%20Lovina!5e0!3m2!1sen!2sid!4v1700000000000!5m2!1sen!2sid');
        iframe.setAttribute('width', '100%');
        iframe.setAttribute('height', '450');
        iframe.setAttribute('style', 'border:0;');
        iframe.setAttribute('allowfullscreen', '');
        iframe.setAttribute('loading', 'lazy');
        iframe.setAttribute('referrerpolicy', 'no-referrer-when-downgrade');

        mapPlaceholder.appendChild(iframe);
    }
    // --- ABOUT PAGE SLIDESHOW LOGIC ---

// Data gambar untuk slideshow About
const aboutImages = [
    'assets/hero-about-1.jpg', 
    'assets/hero-about-2.jpg',
    'assets/hero-about-3.jpg'
];
let currentAboutIndex = 0;

// Function untuk memuat gambar background About
function updateAboutBackground() {
    const sliderElement = document.getElementById('hero-slider-about');
    if (sliderElement) {
        // Mendapatkan path lengkap asset
        const baseUrl = window.location.origin;
        const imageUrl = `${baseUrl}/${aboutImages[currentAboutIndex]}`;
        
        sliderElement.style.backgroundImage = `url('${imageUrl}')`;
        currentAboutIndex = (currentAboutIndex + 1) % aboutImages.length;
    }
}

// Panggil fungsi saat dokumen dimuat dan atur interval
document.addEventListener('DOMContentLoaded', () => {
    // Panggil sekali untuk memuat gambar pertama
    updateAboutBackground(); 
    
    // Atur interval (misalnya, ganti gambar setiap 6 detik)
    if (document.getElementById('hero-slider-about')) {
        setInterval(updateAboutBackground, 6000); // Ganti gambar setiap 6 detik
    }
});
// --- END ABOUT PAGE SLIDESHOW LOGIC ---
});