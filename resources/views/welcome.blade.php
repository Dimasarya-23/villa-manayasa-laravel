@extends('layouts.villa')

@section('title', 'Villa Manayasa | Exclusive Boutique Retreat Lovina, Bali')

@section('content')
<section class="hero-index">
    <div id="hero-slider" class="hero-slider-bg"></div>
    <div class="container hero-content">
        <h1 class="text-en">Find Your Tranquil Moment in Lovina</h1>
        <h1 class="text-id hidden">Temukan Ketenangan Anda di Lovina</h1>

        <p class="tagline-hero">
            <span class="text-en">A sanctuary of serenity. Our exclusive boutique villa, perfectly nestled in nature, with the magic of Lovina's dolphins just minutes away.</span>
            <span class="text-id hidden">Suaka kemewahan dan ketenangan. Villa boutique kami yang eksklusif, tersembunyi di pelukan alam, dengan keajaiban lumba-lumba Lovina yang berjarak sekejap.</span>
        </p>

        <div class="cta-buttons">
            @auth
                <a href="{{ url('/dashboard') }}" class="btn-primary">
                    <span class="text-en">Go to Dashboard</span>
                    <span class="text-id hidden">Ke Dashboard</span>
                </a>
            @else
                <a href="{{ route('contact') }}" class="btn-primary">
                    <span class="text-en">Book Your Stay</span>
                    <span class="text-id hidden">Pesan Sekarang</span>
                </a>
                <a href="{{ route('about') }}" class="btn-secondary">
                    <span class="text-en">Explore Villa</span>
                    <span class="text-id hidden">Jelajahi Vila</span>
                </a>
            @endauth
        </div>
    </div>
</section>

<section class="features-section container">
    <h2 style="text-align: center;">
        <span class="text-en">Our Key Features & Amenities</span>
        <span class="text-id hidden">Fitur & Fasilitas Utama Kami</span>
    </h2>
    <p style="text-align: center; margin-bottom: 30px;" class="text-en">Everything you need for a comfortable and relaxing vacation.</p>
    <p style="text-align: center; margin-bottom: 30px;" class="text-id hidden">Semua yang Anda butuhkan untuk liburan yang nyaman dan menenangkan.</p>

    <div class="features-grid">
        <div class="feature-item">
            <img src="{{ asset('assets/icon-pool.png') }}" alt="Infinity Pool Icon" class="feature-icon">
            <h3 class="text-en">Infinity Pool</h3>
            <h3 class="text-id hidden">Kolam Renang Infinity</h3>
            <p class="text-en">Relax and unwind with stunning views of the surrounding bamboo tree.</p>
            <p class="text-id hidden">Bersantailah dan rileks sambil menikmati pemandangan pohon bambu yang menakjubkan di sekitarnya.</p>
        </div>

        <div class="feature-item">
            <img src="{{ asset('assets/icon-kitchen.png') }}" alt="Communal Kitchen Icon" class="feature-icon">
            <h3 class="text-en">Communal Kitchen</h3>
            <h3 class="text-id hidden">Dapur Bersama</h3>
            <p class="text-en">Fully-equipped kitchen available for all guests to prepare their meals.</p>
            <p class="text-id hidden">Dapur lengkap tersedia untuk semua tamu menyiapkan makanan mereka.</p>
        </div>

        <div class="feature-item">
            <img src="{{ asset('assets/icon-wifi.png') }}" alt="High-Speed WiFi Icon" class="feature-icon">
            <h3 class="text-en">High-Speed WiFi</h3>
            <h3 class="text-id hidden">WiFi Kecepatan Tinggi</h3>
            <p class="text-en">Stay connected with our free and fast Wi-Fi access throughout the villa.</p>
            <p class="text-id hidden">Tetap terhubung dengan akses Wi-Fi gratis dan cepat di seluruh area vila.</p>
        </div>

        <div class="feature-item">
            <img src="{{ asset('assets/icon-dolphin.png') }}" alt="Dolphin Icon" class="feature-icon">
            <h3 class="text-en">Dolphin Watching Tours</h3>
            <h3 class="text-id hidden">Tur Melihat Lumba-Lumba</h3>
            <p class="text-en">We can organize early morning tours to see the famous Lovina dolphins.</p>
            <p class="text-id hidden">Kami dapat mengatur tur pagi hari untuk melihat lumba-lumba Lovina yang terkenal.</p>
        </div>

        <div class="feature-item">
            <img src="{{ asset('assets/icon-transport.png') }}" alt="Transport Icon" class="feature-icon">
            <h3 class="text-en">Transport & Shuttle</h3>
            <h3 class="text-id hidden">Transportasi & Antar-Jemput</h3>
            <p class="text-en">Arrange airport transfers or local transport with our trusted drivers.</p>
            <p class="text-id hidden">Atur antar-jemput bandara atau transportasi lokal dengan pengemudi terpercaya kami.</p>
        </div>

        <div class="feature-item">
            <img src="{{ asset('assets/icon-tour.png') }}" alt="Lovina Tour Icon" class="feature-icon">
            <h3 class="text-en">Local Lovina Tours</h3>
            <h3 class="text-id hidden">Tur Lokal Lovina</h3>
            <p class="text-en">Explore waterfalls, temples, and hot springs near North Bali with our guidance.</p>
            <p class="text-id hidden">Jelajahi air terjun, pura, dan air panas di dekat Bali Utara dengan panduan kami.</p>
        </div>
    </div>
</section>

<section class="our-rooms-section container">
    <h2 style="text-align: center;">
        <span class="text-en">Our Comfortable Rooms</span>
        <span class="text-id hidden">Kamar Nyaman Kami</span>
    </h2>
    <p style="text-align: center; margin-bottom: 30px;" class="text-en">Choose the perfect room for your needs, from a cozy Twin Bed to a spacious Family Room with a balcony.</p>
    <p style="text-align: center; margin-bottom: 30px;" class="text-id hidden">Pilih kamar yang sempurna untuk kebutuhan Anda, mulai dari Twin Bed yang nyaman hingga Family Room yang luas dengan balkon.</p>

    {{-- Room 1 --}}
    <div class="room-category-wrapper">
        <div class="room-header">
            <h3 class="text-en">Room 1 (Twin Bed)</h3>
            <p class="text-en">Perfect for friends or solo travelers. Features two single beds, AC, and a private bathroom (Room 1).</p>
            <h3 class="text-id hidden">Kamar 1 (Twin Bed)</h3>
            <p class="text-id hidden">Sempurna untuk teman atau pelancong solo. Dilengkapi dua tempat tidur single, AC, dan kamar mandi pribadi (Kamar 1).</p>
        </div>
        <div class="slider-container" id="slider-room1">
            <div class="slider" id="room1-slider-inner">
                @for($i = 1; $i <= 6; $i++)
                <div class="slide room-slide"><img src="{{ asset('assets/room1-' . $i . '.jpg') }}" alt="Room 1 Image {{ $i }}" class="slide-image-full"></div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveRoomSlide(-1, 'room1')">❮</button>
            <button class="next-slide" onclick="moveRoomSlide(1, 'room1')">❯</button>
            <div class="slider-dots" id="dots-room1"></div>
        </div>
    </div>

    {{-- Room 2 --}}
    <div class="room-category-wrapper" style="margin-top: 50px;">
        <div class="room-header">
            <h3 class="text-en">Room 2 (Double Bed)</h3>
            <p class="text-en">A cozy retreat for couples. Features one queen-sized bed, AC, and a private bathroom (Room 2).</p>
            <h3 class="text-id hidden">Kamar 2 (Double Bed)</h3>
            <p class="text-id hidden">Tempat peristirahatan yang nyaman untuk pasangan. Dilengkapi satu tempat tidur queen, AC, dan kamar mandi pribadi (Kamar 2).</p>
        </div>
        <div class="slider-container" id="slider-room2">
            <div class="slider" id="room2-slider-inner">
                @for($i = 1; $i <= 6; $i++)
                <div class="slide room-slide"><img src="{{ asset('assets/room2-' . $i . '.jpg') }}" alt="Room 2 Image {{ $i }}" class="slide-image-full"></div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveRoomSlide(-1, 'room2')">❮</button>
            <button class="next-slide" onclick="moveRoomSlide(1, 'room2')">❯</button>
            <div class="slider-dots" id="dots-room2"></div>
        </div>
    </div>

    {{-- Room 3 --}}
    <div class="room-category-wrapper" style="margin-top: 50px;">
        <div class="room-header">
            <h3 class="text-en">Room 3 (Double Bed)</h3>
            <p class="text-en">A cozy retreat for couples. Features one queen-sized bed, AC, and a private bathroom (Room 3).</p>
            <h3 class="text-id hidden">Kamar 3 (Double Bed)</h3>
            <p class="text-id hidden">Tempat peristirahatan yang nyaman untuk pasangan. Dilengkapi satu tempat tidur queen, AC, dan kamar mandi pribadi (Kamar 3).</p>
        </div>
        <div class="slider-container" id="slider-room3">
            <div class="slider" id="room3-slider-inner">
                @for($i = 1; $i <= 6; $i++)
                <div class="slide room-slide"><img src="{{ asset('assets/room3-' . $i . '.jpg') }}" alt="Room 3 Image {{ $i }}" class="slide-image-full"></div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveRoomSlide(-1, 'room3')">❮</button>
            <button class="next-slide" onclick="moveRoomSlide(1, 'room3')">❯</button>
            <div class="slider-dots" id="dots-room3"></div>
        </div>
    </div>

    {{-- Room 4 --}}
    <div class="room-category-wrapper" style="margin-top: 50px;">
        <div class="room-header">
            <h3 class="text-en">Room 4 (Double Bed with Balcony)</h3>
            <p class="text-en">Spacious room with a private balcony overlooking the bamboo tree, perfect for extended stays (Room 4).</p>
            <h3 class="text-id hidden">Kamar 4 (Double Bed dengan Balkon)</h3>
            <p class="text-id hidden">Kamar luas dengan balkon pribadi menghadap pohon bambu, sempurna untuk masa menginap yang lama (Kamar 4).</p>
        </div>
        <div class="slider-container" id="slider-room4">
            <div class="slider" id="room4-slider-inner">
                @for($i = 1; $i <= 6; $i++)
                <div class="slide room-slide"><img src="{{ asset('assets/room4-' . $i . '.jpg') }}" alt="Room 4 Image {{ $i }}" class="slide-image-full"></div>
                @endfor
            </div>
            <button class="prev-slide" onclick="moveRoomSlide(-1, 'room4')">❮</button>
            <button class="next-slide" onclick="moveRoomSlide(1, 'room4')">❯</button>
            <div class="slider-dots" id="dots-room4"></div>
        </div>
    </div>

    <div style="text-align: center; margin-top: 50px;">
        <a href="{{ route('contact') }}" class="btn-primary">
            <span class="text-en">Check Availability</span>
            <span class="text-id hidden">Cek Ketersediaan</span>
        </a>
    </div>
</section>

<section class="testimonial-section container">
    <h2 style="text-align: center;">
        <span class="text-en">What Our Guests Say</span>
        <span class="text-id hidden">Apa Kata Tamu Kami</span>
    </h2>
    <div class="testimonial-grid">
        <div class="testimonial-card">
            <blockquote class="text-en">"the bedroom is lovely, nicely decorated with attention to the details. Same for the bathroom it gave me a luxury vibe compared to most of the other accommodations seen in Indonesia, open-air bathroom to feel more connected to nature and good to avoid humidity, very kind and friendly staff, many options to choose from for breakfast."</blockquote>
            <p class="author text-en">— Desirée., Netherland</p>
            <blockquote class="text-id hidden">"Kamar tidurnya indah, didekorasi dengan apik dan memperhatikan detail. Begitu pula dengan kamar mandinya, memberikan kesan mewah dibandingkan kebanyakan akomodasi lain di Indonesia. Kamar mandinya terbuka sehingga terasa lebih menyatu dengan alam. Dan bagus untuk menghindari kelembapan, stafnya sangat ramah dan baik, banyak pilihan sarapan."</blockquote>
            <p class="author text-id hidden">— Desirée., Belanda</p>
        </div>
        <div class="testimonial-card">
            <blockquote class="text-en">"The Rooms were clean. The Staff especially Dimas was very helpful and co-operative. He helped me by giving me a ride on his scooter to the nearest restaurant and get packed dinner as we checked in late in the evening. The breakfast was good."</blockquote>
            <p class="author text-en">— Pankaaj., United Arab Emirates</p>
            <blockquote class="text-id hidden">"Kamarnya bersih. Stafnya, terutama Dimas, sangat membantu dan kooperatif. Dia membantu saya dengan mengantar saya naik skuternya ke restoran terdekat dan menyiapkan makan malam karena kami check-in larut malam. Sarapannya enak."</blockquote>
            <p class="author text-id hidden">— Pankaaj., Uni Emirate Arab</p>
        </div>
        <div class="testimonial-card">
            <blockquote class="text-en">"The staff were so lovely and helpful. The breakfast was tasty and plentiful.. great omelette! The room was very clean, and with good aircon. I don't normally watch TV but the flat screen tv with youtube film selections was so greatly appreciated when it was raining so heavy that going out was not an option. Wifi was excellent too. All in all I enjoyed my short stay and have already booked the next."</blockquote>
            <p class="author text-en">— Gwyneth., Germany</p>
            <blockquote class="text-id hidden">"Stafnya sangat ramah dan membantu. Sarapannya lezat dan berlimpah. Omeletnya luar biasa! Kamarnya sangat bersih dan ber-AC. Saya biasanya tidak menonton TV, tetapi TV layar datar dengan pilihan film YouTube sangat saya hargai ketika hujan deras sehingga tidak bisa keluar rumah. Wi-Fi-nya juga sangat bagus. Secara keseluruhan, saya menikmati kunjungan singkat saya dan sudah memesan untuk kunjungan berikutnya."</blockquote>
            <p class="author text-id hidden">— Gwyneth., Jerman</p>
        </div>
    </div>
</section>

<section class="cta-banner container">
    <h2 class="text-en">Ready to Book Your Tranquil Stay?</h2>
    <h2 class="text-id hidden">Siap Memesan Penginapan Tenang Anda?</h2>
    <p class="text-en">Don't hesitate to contact us anytime. Our team is ready to assist you!</p>
    <p class="text-id hidden">Jangan ragu untuk menghubungi kami kapan saja. Tim kami siap membantu Anda!</p>
    <div class="cta-buttons">
        <a href="https://wa.me/6281213751532" class="btn-primary" target="_blank">
            <span class="text-en">WhatsApp Us</span>
            <span class="text-id hidden">WhatsApp Kami</span>
        </a>
        <a href="https://booking.com/villamanayasa" class="btn-secondary" target="_blank">
            <span class="text-en">Book via Booking.com</span>
            <span class="text-id hidden">Pesan via Booking.com</span>
        </a>
    </div>
</section>
@endsection