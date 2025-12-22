@extends('layouts.villa')

@section('title', 'About Us - Villa Manayasa: Our Story')

@section('content')
<section class="hero-about section">
    <div class="slideshow-bg" id="hero-slider-about"></div>
    <div class="container hero-content">
        <h1 class="text-en">Our Story, Your Sanctuary</h1>
        <h1 class="text-id hidden">Kisah Kami, Tempat Perlindungan Anda</h1>
        <p class="tagline-hero">
            <span class="text-en">More than just a stay—it's a journey into Northern Bali's tranquility.</span>
            <span class="text-id hidden">Lebih dari sekadar menginap—ini adalah perjalanan menuju ketenangan Bali Utara.</span>
        </p>
    </div>
</section>

<section class="story-section container section">
    <div class="two-column-layout">
        <div class="content-text">
            <h2 class="text-en">Creating Tranquility in Lovina</h2>
            <h2 class="text-id hidden">Menciptakan Ketenangan di Lovina</h2>
            <p class="text-en">Villa Manayasa began with a simple dream: to create a private haven where guests could fully immerse themselves in the authentic, peaceful rhythm of North Bali. We meticulously designed this space to blend traditional Balinese architecture with modern comfort, ensuring every corner offers a connection to nature.</p>
            <p class="text-en">Our commitment is to provide a personalized, intimate escape far from the crowded south. From the moment you arrive, you're treated not just as a guest, but as family. This villa is our heart poured out onto the peaceful streets of Lovina.</p>

            <p class="text-id hidden">Villa Manayasa dimulai dengan mimpi sederhana: menciptakan surga pribadi di mana para tamu dapat sepenuhnya merasakan ritme damai dan otentik Bali Utara. Kami merancang ruang ini dengan cermat untuk memadukan arsitektur tradisional Bali dengan kenyamanan modern, memastikan setiap sudut menawarkan koneksi dengan alam.</p>
            <p class="text-id hidden">Komitmen kami adalah untuk menyediakan liburan yang personal dan intim jauh dari keramaian selatan. Sejak Anda tiba, Anda diperlakukan bukan hanya sebagai tamu, tetapi sebagai keluarga. Vila ini adalah hati kami yang tertuang di jalanan Lovina yang damai.</p>
        </div>
        <div class="content-image">
            <img src="{{ asset('assets/story-image-1.jpg') }}" alt="Villa Manayasa Exterior">
        </div>
    </div>

    <div class="two-column-layout reverse-columns">
        <div class="content-text">
            <h2 class="text-en">Our Mission: Personalized Balinese Hospitality</h2>
            <h2 class="text-id hidden">Misi Kami: Keramahan Bali yang Personal</h2>
            <p class="text-en">Our mission extends beyond providing luxury accommodation. We strive to offer an experience rooted in authentic Balinese hospitality. This includes connecting our guests with local culture, arranging unique tours like dolphin watching at sunrise, and ensuring a restful stay.</p>
            <p class="text-en">We believe that true tranquility comes from attention to detail, from the freshness of your morning breakfast to the cleanliness of your private pool. We are dedicated to making Villa Manayasa the most memorable part of your Bali adventure.</p>

            <p class="text-id hidden">Misi kami melampaui penyediaan akomodasi mewah. Kami berusaha menawarkan pengalaman yang berakar pada keramahan otentik Bali. Ini termasuk menghubungkan tamu kami dengan budaya lokal, mengatur tur unik seperti melihat lumba-lumba saat matahari terbit, dan memastikan masa tinggal yang tenang.</p>
            <p class="text-id hidden">Kami percaya bahwa ketenangan sejati berasal dari perhatian terhadap detail, mulai dari kesegaran sarapan pagi Anda hingga kebersihan kolam renang pribadi Anda. Kami berdedikasi untuk menjadikan Villa Manayasa bagian paling berkesan dari petualangan Bali Anda.</p>
        </div>
        <div class="content-image">
            <img src="{{ asset('assets/story-image-2.jpg') }}" alt="Villa Manayasa Interior">
        </div>
    </div>
</section>

<section class="core-values-section section">
    <div class="container">
        <h2 class="text-en">Core Values That Define Us</h2>
        <h2 class="text-id hidden">Nilai Inti yang Mendefinisikan Kami</h2>

        <div class="core-values-single-column">
            <div class="value-card" style="margin-bottom: 30px; text-align: center;">
                <h3 class="text-en">Authenticity</h3>
                <h3 class="text-id hidden">Keaslian</h3>
                <p class="text-en" style="text-align: center;">Integrating the spiritual and natural elements of Lovina into the guest experience, ensuring a genuine Bali retreat.</p>
                <p class="text-id hidden" style="text-align: center;">Mengintegrasikan elemen spiritual dan alami Lovina ke dalam pengalaman tamu, memastikan liburan Bali yang otentik.</p>
            </div>
            <div class="value-card" style="margin-bottom: 30px; text-align: center;">
                <h3 class="text-en">Tranquility</h3>
                <h3 class="text-id hidden">Ketenangan</h3>
                <p class="text-en" style="text-align: center;">Dedicated to creating a peaceful, quiet environment, far from the noise of tourist crowds.</p>
                <p class="text-id hidden" style="text-align: center;">Berdedikasi untuk menciptakan lingkungan yang damai dan tenang, jauh dari hiruk pikuk keramaian turis.</p>
            </div>
            <div class="value-card" style="margin-bottom: 30px; text-align: center;">
                <h3 class="text-en">Personal Service</h3>
                <h3 class="text-id hidden">Layanan Personal</h3>
                <p class="text-en" style="text-align: center;">Offering tailored recommendations and arranging special requests to make every stay unique.</p>
                <p class="text-id hidden" style="text-align: center;">Menawarkan rekomendasi yang disesuaikan dan mengatur permintaan khusus untuk menjadikan setiap masa inap unik.</p>
            </div>
            <div class="value-card" style="margin-bottom: 30px; text-align: center;">
                <h3 class="text-en">Community</h3>
                <h3 class="text-id hidden">Komunitas</h3>
                <p class="text-en" style="text-align: center;">Working closely with local guides and businesses to support the Lovina community.</p>
                <p class="text-id hidden" style="text-align: center;">Bekerja sama erat dengan pemandu dan bisnis lokal untuk mendukung komunitas Lovina.</p>
            </div>
        </div>
    </div>
</section>

<section class="our-team-section container section">
    <h2 class="text-en">Meet Our Dedicated Team</h2>
    <h2 class="text-id hidden">Temui Tim Kami yang Berdedikasi</h2>
    <div class="team-grid">
        <div class="team-member">
            <img src="{{ asset('assets/team-manager.jpg') }}" alt="Team Manager">
            <h4>
                <span class="text-en">Kadek Erna</span>
                <span class="text-id hidden">Kadek Erna</span>
            </h4>
            <p>
                <span class="text-en">Team 1</span>
                <span class="text-id hidden">Tim 1</span>
            </p>
        </div>
        <div class="team-member">
            <img src="{{ asset('assets/team-housekeeping.jpg') }}" alt="Housekeeper">
            <h4>
                <span class="text-en">Dimas Arya</span>
                <span class="text-id hidden">Dimas Arya</span>
            </h4>
            <p>
                <span class="text-en">Team 2</span>
                <span class="text-id hidden">Tim 2</span>
            </p>
        </div>
        <div class="team-member">
            <img src="{{ asset('assets/team-chef.jpg') }}" alt="Chef">
            <h4>
                <span class="text-en">Putu Cipta</span>
                <span class="text-id hidden">Putu Cipta</span>
            </h4>
            <p>
                <span class="text-en">Team 3</span>
                <span class="text-id hidden">Tim 3</span>
            </p>
        </div>
    </div>
</section>

<section class="gallery-section container section">
    <h2 class="text-en">Gallery of Tranquility</h2>
    <h2 class="text-id hidden">Galeri Ketenangan</h2>

    {{-- Pool Slider --}}
    <div class="room-category-wrapper">
        <div class="room-header">
            <h3 class="text-en">The Infinity Pool Area</h3>
            <h3 class="text-id hidden">Area Kolam Renang Infinity</h3>
            <p class="text-en">Enjoy our central 6 meter pool with a sun deck and ocean views.</p>
            <p class="text-id hidden">Nikmati kolam renang sentral 6 meter kami dengan dek berjemur dan pemandangan laut.</p>
        </div>
        <div class="slider-container">
            <div id="pool-slider-inner" class="slider">
                @for($i = 1; $i <= 3; $i++)
                <div class="room-slide slide">
                    <img src="{{ asset('assets/pool-' . $i . '.jpg') }}" alt="Pool View {{ $i }}" class="slide-image-full">
                </div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveSlide(-1, 'pool')">❮</button>
            <button class="next-slide" onclick="moveSlide(1, 'pool')">❯</button>
            <div id="dots-pool" class="slider-dots"></div>
        </div>
    </div>

    {{-- Dining Slider --}}
    <div class="room-category-wrapper">
        <div class="room-header">
            <h3 class="text-en">Dining & Breakfast Area</h3>
            <h3 class="text-id hidden">Area Makan & Sarapan</h3>
            <p class="text-en">The open-air dining area, perfect for enjoying a fresh breakfast with a view.</p>
            <p class="text-id hidden">Area makan terbuka, sempurna untuk menikmati sarapan segar dengan pemandangan.</p>
        </div>
        <div class="slider-container">
            <div id="dining-slider-inner" class="slider">
                @for($i = 1; $i <= 3; $i++)
                <div class="room-slide slide">
                    <img src="{{ asset('assets/dining-' . $i . '.jpg') }}" alt="Dining Area {{ $i }}" class="slide-image-full">
                </div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveSlide(-1, 'dining')">❮</button>
            <button class="next-slide" onclick="moveSlide(1, 'dining')">❯</button>
            <div id="dots-dining" class="slider-dots"></div>
        </div>
    </div>

    {{-- Garden Slider --}}
    <div class="room-category-wrapper">
        <div class="room-header">
            <h3 class="text-en">Lush Tropical Garden</h3>
            <h3 class="text-id hidden">Taman Tropis yang Rindang</h3>
            <p class="text-en">A space dedicated to relaxation and finding peace under the Bali sun.</p>
            <p class="text-id hidden">Sebuah ruang yang didedikasikan untuk relaksasi dan menemukan kedamaian di bawah matahari Bali.</p>
        </div>
        <div class="slider-container">
            <div id="garden-slider-inner" class="slider">
                @for($i = 1; $i <= 2; $i++)
                <div class="room-slide slide">
                    <img src="{{ asset('assets/garden-' . $i . '.jpg') }}" alt="Garden View {{ $i }}" class="slide-image-full">
                </div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveSlide(-1, 'garden')">❮</button>
            <button class="next-slide" onclick="moveSlide(1, 'garden')">❯</button>
            <div id="dots-garden" class="slider-dots"></div>
        </div>
    </div>

    {{-- Surroundings Slider --}}
    <div class="room-category-wrapper">
        <div class="room-header">
            <h3 class="text-en">Surroundings & Lovina View</h3>
            <h3 class="text-id hidden">Sekitar Villa & Pemandangan Lovina</h3>
            <p class="text-en">Majestic bamboo tree views and peaceful walks around Villa Manayasa.</p>
            <p class="text-id hidden">Pemandangan pohon bambu yang megah dan jalan-jalan yang damai di sekitar Villa Manayasa.</p>
        </div>
        <div class="slider-container">
            <div id="surroundings-slider-inner" class="slider">
                @for($i = 1; $i <= 3; $i++)
                <div class="room-slide slide">
                    <img src="{{ asset('assets/surroundings-' . $i . '.jpg') }}" alt="Surroundings {{ $i }}" class="slide-image-full">
                </div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveSlide(-1, 'surroundings')">❮</button>
            <button class="next-slide" onclick="moveSlide(1, 'surroundings')">❯</button>
            <div id="dots-surroundings" class="slider-dots"></div>
        </div>
    </div>
</section>

<section class="cta-banner container">
    <h2 class="text-en">Ready for Your Lovina Escape?</h2>
    <h2 class="text-id hidden">Siap untuk Liburan Lovina Anda?</h2>
    <p class="text-en">Book your private stay at Villa Manayasa now for an unforgettable Balinese experience.</p>
    <p class="text-id hidden">Pesan masa inap pribadi Anda di Villa Manayasa sekarang untuk pengalaman Bali yang tak terlupakan.</p>
    <div class="cta-buttons">
        <a href="https://booking.com/villamanayasa" target="_blank" class="btn-secondary">
            <span class="text-en">Check Availability</span>
            <span class="text-id hidden">Cek Ketersediaan</span>
        </a>
    </div>
</section>
@endsection