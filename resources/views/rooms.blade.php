<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kamar | Villa Manayasa</title>
    <!-- Load Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (Versi 5.15.4) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
    <!-- Alpine.js (Opsional, untuk fungsionalitas lanjutan) -->
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.2/dist/alpine.min.js" defer></script>
    
    <style>
        /* Menggunakan font Inter untuk tampilan modern */
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f7f7;
        }
        /* Styling untuk Galeri Carousel */
        .gallery-container {
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }
        .gallery-item {
            scroll-snap-align: start;
            flex: 0 0 100%;
            transition: transform 0.3s ease-in-out;
        }
        .gallery-scroll-button {
            transition: background-color 0.3s, opacity 0.3s;
        }
        input[type="date"] {
            /* Menyesuaikan input date agar terlihat bagus di Tailwind */
            @apply w-full p-3 border border-gray-300 rounded-lg focus:ring-teal-500 focus:border-teal-500 shadow-sm transition duration-150 ease-in-out;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col">

    <!-- HEADER: Title Section -->
    <div class="relative bg-emerald-600 h-24 flex items-center justify-between px-4 sm:px-6 lg:px-8 rounded-b-xl shadow-2xl">
        
        <!-- Tombol Kembali ke Dashboard -->
        <!-- Gunakan route 'dashboard' atau route yang sesuai dengan halaman utama Anda -->
        <a href="{{ route('dashboard') }}" class="absolute top-1/2 left-4 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 sm:p-3 rounded-full transition duration-300 shadow-lg z-20">
            <i class="fas fa-arrow-left text-lg"></i>
        </a>
        
        <div class="relative p-2 pb-4 ml-12 sm:ml-16">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-snug">
                Pilih Tanggal & Kamar
            </h1>
            <p class="text-white/80 text-base sm:text-lg font-light">
                Cek ketersediaan kamar secara dinamis.
            </p>
        </div>
    </div>
    
    <div class="p-4 sm:p-6 lg:p-8 relative z-10 flex-grow">

        <header class="text-center mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-emerald-800 tracking-tight">
                Daftar Kamar Villa Manayasa
            </h1>
            <p class="text-xl text-gray-600 mt-2">
                Masukkan tanggal untuk melihat kamar mana saja yang tersedia untuk Anda.
            </p>
        </header>
        
        <!-- FORM PENCARIAN TANGGAL -->
        <div class="max-w-4xl mx-auto mb-12">
            <!-- Route 'rooms.index' dipanggil oleh BookingController::showRooms -->
            <!-- Catatan: Karena ini adalah file HTML statis, route Laravel tidak akan berfungsi dalam preview. -->
            <form action="#" method="GET" class="bg-white p-6 md:p-8 rounded-2xl shadow-xl border-t-4 border-teal-600 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
                
                <!-- Input Check-in -->
                <div class="flex-1 w-full">
                    <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-calendar-check text-teal-600 mr-1"></i> Check-in Date
                    </label>
                    <input type="date" id="check_in_date" name="check_in_date" required 
                            value="{{ request('check_in_date', date('Y-m-d')) }}"
                            min="{{ date('Y-m-d') }}" <!-- Tanggal minimum hari ini -->
                            >
                </div>

                <!-- Input Check-out -->
                <div class="flex-1 w-full">
                    <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-1">
                        <i class="fas fa-calendar-times text-red-600 mr-1"></i> Check-out Date
                    </label>
                    <input type="date" id="check_out_date" name="check_out_date" required 
                            value="{{ request('check_out_date', date('Y-m-d', strtotime('+1 day'))) }}"
                            min="{{ date('Y-m-d', strtotime('+1 day')) }}" <!-- Tanggal minimum besok -->
                            >
                </div>
                
                <!-- Tombol Cari -->
                <button type="submit" class="w-full md:w-auto mt-6 md:mt-0 px-8 py-3 bg-emerald-600 text-white font-bold rounded-xl hover:bg-emerald-700 transition duration-300 shadow-lg transform hover:scale-[1.02]">
                    <i class="fas fa-search mr-2"></i> Cari Kamar
                </button>
            </form>
        </div>
        
        <!-- Pesan Error/Success dari Controller -->
        <!-- Karena ini statis, bagian ini hanya sebagai placeholder jika data kamar kosong -->
        @if ($rooms->isEmpty())
             <div class="max-w-4xl mx-auto mt-16 p-8 bg-white rounded-2xl shadow-xl text-center border-l-4 border-yellow-500">
                <i class="fas fa-box-open text-6xl text-yellow-500 mb-4"></i>
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Belum ada kamar yang tersedia</h2>
                <p class="text-gray-600">Silakan hubungi administrator atau coba ganti tanggal pencarian Anda.</p>
            </div>
        @else
            <div class="space-y-10 max-w-6xl mx-auto">
                {{-- Urutan Kamar akan mengikuti urutan ID di database --}}
                @foreach ($rooms as $room)
                    <div class="room-card bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col lg:flex-row transform transition duration-500 ease-in-out hover:shadow-emerald-300/50" data-room-id="{{ $room->id }}" data-room-title="{{ $room->tipe_kamar }}">
                        
                        <!-- KOLOM KIRI: GALERI FOTO -->
                        <div class="lg:w-1/2 relative h-80 lg:h-auto bg-gray-100 overflow-hidden">
                            <div id="gallery-{{ $room->id }}" class="gallery-container flex w-full h-full overflow-x-auto snap-x snap-mandatory">
                                @for ($i = 1; $i <= 5; $i++)
                                    <div class="gallery-item relative flex-shrink-0 w-full h-full">
                                        {{-- Gambar dari folder public/assets dengan format Room{ID}-{NOMOR}.jpg --}}
                                        <img src="{{ asset('assets/Room' . $room->id . '-' . $i . '.jpg') }}" 
                                            alt="Foto Kamar {{ $room->tipe_kamar }} - {{ $i }}" 
                                            class="w-full h-full object-cover"
                                            onerror="this.src='https://placehold.co/1000x800/10b981/FFFFFF?text=Foto+{{ $i }}+Tidak+Tersedia'">
                                        <div class="absolute bottom-0 left-0 bg-black bg-opacity-40 p-3 w-full text-white text-base font-medium">
                                            Geser untuk melihat {{ $i }}/5 foto
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            
                            {{-- Kontrol Navigasi Carousel --}}
                            <button onclick="scrollGallery('{{ $room->id }}', -1)" class="gallery-scroll-button absolute top-1/2 left-4 transform -translate-y-1/2 bg-white bg-opacity-70 text-gray-800 p-3 rounded-full hover:bg-opacity-90 z-10 shadow-lg">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                            <button onclick="scrollGallery('{{ $room->id }}', 1)" class="gallery-scroll-button absolute top-1/2 right-4 transform -translate-y-1/2 bg-white bg-opacity-70 text-gray-800 p-3 rounded-full hover:bg-opacity-90 z-10 shadow-lg">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>

                        <!-- KOLOM KANAN: DETAIL & BOOKING -->
                        <div class="lg:w-1/2 p-6 md:p-10 flex flex-col justify-between">
                            
                            <!-- JUDUL DAN DESKRIPSI -->
                            <div class="mb-6">
                                <h2 class="text-3xl md:text-4xl font-extrabold text-emerald-700 tracking-tight mb-2">
                                    {{ $room->tipe_kamar }}
                                </h2>
                                <p class="text-base text-gray-600 leading-relaxed">
                                    {{ $room->deskripsi ?? 'Kamar ini menawarkan kenyamanan maksimal dan perlengkapan lengkap untuk pengalaman menginap yang tak terlupakan.' }}
                                </p>
                            </div>

                            <!-- FASILITAS KAMAR -->
                            <div class="mb-6">
                                <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-3 flex items-center">
                                    <i class="fas fa-list-check text-emerald-500 mr-2"></i> Fasilitas Kamar
                                </h3>
                                <ul class="grid grid-cols-2 gap-3 text-sm md:text-base text-gray-700" id="facilities-{{ $room->id }}">
                                    {{-- List fasilitas akan di-populate oleh JS setelah DOM Load --}}
                                </ul>
                            </div>
                            
                            <!-- HARGA DAN TOMBOL PESAN -->
                            <div class="pt-6 border-t border-gray-100">
                                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                                    <div>
                                        <p class="text-lg font-medium text-gray-500">Kapasitas Tamu</p>
                                        <p class="text-2xl font-bold text-gray-800">
                                            <i class="fas fa-user-friends text-emerald-500 mr-2"></i> {{ $room->kapasitas_tamu }} Orang
                                        </p>
                                    </div>
                                    <div class="text-left md:text-right mt-4 md:mt-0">
                                        <p class="text-lg font-medium text-gray-500">Harga Per Malam</p>
                                        <p class="text-4xl font-extrabold text-red-600">
                                            Rp {{ number_format($room->harga_per_malam ?? 0, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- TOMBOL PESAN (Meneruskan Tanggal yang Dipilih) -->
                                <a href="{{ route('booking.create', [
                                    'kamar' => $room->id, 
                                    'check_in' => request('check_in_date'), 
                                    'check_out' => request('check_out_date')
                                ]) }}" 
                                    class="w-full block bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-4 rounded-xl text-center transition duration-300 shadow-lg shadow-emerald-500/50 transform hover:scale-[1.01] text-xl">
                                    <i class="fas fa-arrow-right-to-bracket mr-2"></i> PESAN SEKARANG
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <!-- FOOTER -->
    <footer class="bg-gray-800 mt-12 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-gray-400">
            <p class="mb-2">
                &copy; {{ date('Y') }} Villa Manayasa. Hak Cipta Dilindungi.
            </p>
            <div class="flex justify-center space-x-4 text-sm">
                <a href="#" class="hover:text-white transition duration-200">Kebijakan Privasi</a>
                <span class="text-gray-600">|</span>
                <a href="#" class="hover:text-white transition duration-200">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>


    <script>
        // Data Fasilitas Standar untuk Kamar Double Bed
        const doubleBedFacilities = [
            { icon: 'fas fa-bed', name: 'Kasur Double' }, 
            { icon: 'fas fa-tv', name: 'Smart TV 32"' },
            { icon: 'fas fa-fan', name: 'AC' },
            { icon: 'fas fa-toilet', name: 'Kamar Mandi Dalam' },
            { icon: 'fas fa-box', name: 'Brankas' },
            { icon: 'fas fa-tshirt', name: 'Perlengkapan Mandi' }
        ];

        // Data tiruan (mock data) untuk fasilitas per tipe kamar.
        const mockFacilities = {
            // KAMAR 1: TWIN BED ROOM
            'TWIN BED ROOM - ROOM 1': [
                { icon: 'fas fa-bed', name: 'Kasur Twin' },
                { icon: 'fas fa-tv', name: 'Smart TV 32"' },
                { icon: 'fas fa-fan', name: 'AC' },
                { icon: 'fas fa-toilet', name: 'Kamar Mandi Dalam' },
                { icon: 'fas fa-box', name: 'Brankas' },
                { icon: 'fas fa-tshirt', name: 'Perlengkapan Mandi' }
            ],
            // KAMAR 2: DOUBLE BED ROOM - Menggunakan data Fasilitas Standar Double Bed
            'DOUBLE BED ROOM - ROOM 2': doubleBedFacilities,
            
            // KAMAR 3: DELUXE DOUBLE BED ROOM - Menggunakan data Fasilitas Standar Double Bed (SAMA DENGAN ROOM 2)
            'DELUXE DOUBLE BED ROOM - ROOM 3': doubleBedFacilities, // Fasilitas sudah disamakan
            
            // KAMAR 4: SUPERIOR DELUXE FAMILY ROOM
            'SUPERIOR DELUXE FAMILY ROOM - ROOM 4': [
                { icon: 'fas fa-bed', name: 'Kasur Superior' }, 
                { icon: 'fas fa-fan', name: 'AC dan Kipas' }, 
                { icon: 'fas fa-couch', name: 'Sofa Bed' }, 
                { icon: 'fas fa-tv', name: 'Smart TV 32"' }, 
                { icon: 'fas fa-sun', name: 'Balkon Area' }, 
                { icon: 'fas fa-box', name: '1 Brankas' } 
            ],
            'default': [
                { icon: 'fas fa-wifi', name: 'Wi-Fi Cepat' },
                { icon: 'fas fa-fan', name: 'AC' },
                { icon: 'fas fa-toilet', name: 'Kamar Mandi Dalam' },
                { icon: 'fas fa-tshirt', name: 'Perlengkapan Mandi' },
            ]
        };

        // Fungsi untuk menggeser galeri foto
        function scrollGallery(roomId, direction) {
            const gallery = document.getElementById(`gallery-${roomId}`);
            if (gallery) {
                const scrollWidth = gallery.clientWidth;
                gallery.scrollBy({
                    left: direction * scrollWidth,
                    behavior: 'smooth'
                });
            }
        }
        
        // Inisialisasi Fasilitas dan Logic Tanggal
        document.addEventListener('DOMContentLoaded', () => {
            // Logic Populate Fasilitas
            const roomCards = document.querySelectorAll('.room-card');
            roomCards.forEach(card => {
                const roomId = card.getAttribute('data-room-id');
                const facilitiesContainer = document.getElementById(`facilities-${roomId}`);
                // Ambil data-room-title dari elemen, lalu trim
                const roomTitle = card.getAttribute('data-room-title').trim();

                const facilities = mockFacilities[roomTitle] || mockFacilities['default'];
                
                if (facilitiesContainer) {
                    facilitiesContainer.innerHTML = ''; 
                    facilities.forEach(item => {
                        const li = document.createElement('li');
                        li.className = 'flex items-center space-x-2';
                        li.innerHTML = `<i class="${item.icon} text-emerald-500 text-lg w-5 text-center"></i><span>${item.name}</span>`;
                        facilitiesContainer.appendChild(li);
                    });
                }
            });

            // Logic Pembatasan Tanggal
            const checkInInput = document.getElementById('check_in_date');
            const checkOutInput = document.getElementById('check_out_date');

            // Set default min date for check-in to today
            const today = new Date().toISOString().split('T')[0];
            checkInInput.setAttribute('min', today);

            // Update minimum date for check-out based on check-in
            const updateCheckOutMinDate = () => {
                let checkInValue = checkInInput.value;
                if (!checkInValue) {
                    checkInInput.value = today; // Set value if empty
                    checkInValue = today;
                }
                
                let minCheckoutDate = new Date(checkInValue);
                minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
                
                const minDateString = minCheckoutDate.toISOString().split('T')[0];
                checkOutInput.setAttribute('min', minDateString);
                
                // Pastikan check-out tidak mendahului check-in
                if (checkOutInput.value <= checkInValue) {
                    checkOutInput.value = minDateString;
                }
            };

            // Panggil saat halaman dimuat
            updateCheckOutMinDate();

            // Panggil saat check-in berubah
            checkInInput.addEventListener('change', updateCheckOutMinDate);
        });
    </script>
</body>
</html>