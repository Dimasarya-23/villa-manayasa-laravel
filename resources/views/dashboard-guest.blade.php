<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Tamu Villa</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* ======================================= */
        /* CUSTOM STYLES & ANIMATIONS */
        /* ======================================= */

        /* 1. STATUS RESERVASI CARD STYLING (Lunas) */
        .card-reservation-main {
            background: linear-gradient(135deg, #08ffb1ff 0%, #10b981 100%);
            box-shadow: 0 12px 24px rgba(0, 255, 119, 0.4); 
            color: white;
        }

        /* CARD STATUS PENDING/BELUM LUNAS */
        .card-status-pending {
            /* Vibrant Purple/Pink */
            background: linear-gradient(135deg, #9333ea 0%, #d946ef 100%);
            box-shadow: 0 12px 24px rgba(147, 51, 234, 0.4); 
            color: white;
        }

        /* 2. HOVER EFFECT UNTUK KARTU (Lift Up Dramatis) */
        .dashboard-card-hover {
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .dashboard-card-hover:hover {
            transform: translateY(-8px); 
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.25), 0 8px 10px rgba(0, 0, 0, 0.15); 
        }

        /* 3. STYLING UNTUK TOMBOL LAYANAN (Push Effect) */
        .service-button {
            transition: all 0.15s ease-out;
            /* Border bawah digunakan sebagai shadow 3D */
            border-bottom-width: 4px; 
            border-bottom-style: solid;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }
        
        /* Definisi warna border bawah untuk push effect */
        .bg-red-600.service-button { border-bottom-color: #8c1616; }
        .bg-teal-600.service-button { border-bottom-color: #0f766e; }
        .bg-yellow-600.service-button { border-bottom-color: #a87103; }
        .bg-purple-600.service-button { border-bottom-color: #551c96; }

        .service-button:active {
            transform: translateY(4px); /* Pushed down */
            border-bottom-width: 0; 
            box-shadow: 0 0 0 0 rgba(0, 0, 0, 0.1); 
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

@php
    // =========================================================================
    // LOGIKA PEMBANTU PHP
    // =========================================================================
    $waNumber = '6281213751532'; // Nomor WA Villa
    $userName = Auth::user()->name ?? 'Tamu Yth.';
    
    // Variabel $latestActiveReservation dikirim dari Controller
    $latestReservation = $latestActiveReservation ?? null; 
    
    // Variabel yang digunakan untuk template di bawahnya:
    $latestKamar = $latestReservation?->kamar ?? null;
    // PENTING: Mendefinisikan $roomNumber dengan nilai yang akan dicari di view
    $roomNumber = $latestKamar->nomor_kamar ?? 'N/A'; // Menggunakan 'N/A' sebagai default
    $roomNumberDisplay = $roomNumber; // Digunakan di dalam @if / @else di bawah
    
    // Fungsi untuk membuat tautan WA
    $generateWaLink = function($serviceType, $initialText) use ($waNumber, $userName, $roomNumber) {
        $message = "Halo, saya membutuhkan " . $serviceType . " di Villa Manayasa. Nama saya " . $userName . " dan saya menginap di Kamar " . $roomNumber . ". " . $initialText;
        return 'https://wa.me/' . $waNumber . '?text=' . urlencode($message);
    };

    $linkBantuan = $generateWaLink("Panggilan Bantuan Darurat", "Mohon segera dibantu.");
    $linkHousekeeping = $generateWaLink("Layanan Housekeeping/Bersihkan Kamar", "Kapan waktu terbaik untuk membersihkan kamar?");
    $linkPerpanjang = $generateWaLink("Permintaan Perpanjangan Inap", "Mohon informasi ketersediaan dan prosedur selanjutnya.");
    
    // =========================================================================
@endphp


<div class="font-sans">

    {{-- HEADER VISUAL INTERAKTIF --}}
    <div class="relative bg-emerald-600 h-28 flex items-end justify-start px-4 sm:px-8 lg:px-12 rounded-b-3xl shadow-2xl">
        <div class="relative p-2 pb-4">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-white leading-snug">
                Selamat Datang, <span class="text-amber-200">{{ $userName }}</span>!
            </h1>
            <p class="text-white/80 text-base sm:text-lg font-light">
                Dashboard Tamu Lovina, Bali.
            </p>
        </div>
    </div>

    <div class="p-4 sm:p-8 lg:p-12 relative z-10 -mt-8">

        {{-- BARIS 1: STATUS RESERVASI AKTIF (DINAMIS) --}}
        @if (isset($latestReservation))
            @php
                $statusCardClass = ($latestReservation->status === 'paid') ? 'card-reservation-main' : 'card-status-pending';
                $checkInDate = \Carbon\Carbon::parse($latestReservation->check_in_date);
                $checkOutDate = \Carbon\Carbon::parse($latestReservation->check_out_date);
                $totalNights = $checkInDate->diffInDays($checkOutDate);
                $roomType = $latestKamar->tipe_kamar ?? 'Kamar Tidak Ditemukan';
                // $roomNumberDisplay sudah didefinisikan di block @php di atas
            @endphp

            <div class="{{ $statusCardClass }} p-6 sm:p-8 mb-8 rounded-2xl dashboard-card-hover">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div>
                        <p class="text-xs font-semibold mb-1 uppercase tracking-wider opacity-80">Reservasi Terbaru Anda</p>
                        <h2 class="text-2xl sm:text-3xl font-extrabold mb-1">
                            {{ $roomType }}
                        </h2>
                        
                        {{-- START: PERBAIKAN LOGIKA TAMPILAN KAMAR --}}
                        @if ($roomNumberDisplay !== 'N/A' && $latestReservation->status !== 'pending')
                            {{-- TAMPIL JIKA KAMAR SUDAH DIALOKASIKAN DAN BUKAN PENDING--}}
                            <p class="text-base font-light opacity-90">Nomor Kamar: <span class="font-bold">{{ $roomNumberDisplay }}</span></p>
                        @elseif ($latestReservation->status === 'pending')
                            {{-- TAMPIL JIKA STATUS MASIH PENDING --}}
                             <p class="text-base font-light opacity-90 italic">
                                Menunggu konfirmasi pembayaran Anda.
                            </p>
                        @else
                            {{-- TAMPIL JIKA BELUM DIALOKASIKAN / KAMAR = N/A --}}
                            <p class="text-base font-light opacity-90 italic">
                                Aktivitas menginap Anda sedang disiapkan.
                            </p>
                        @endif
                        {{-- END: PERBAIKAN LOGIKA TAMPILAN KAMAR --}}
                        
                    </div>
                    
                    {{-- Status Badge & Icon --}}
                    <div class="mt-4 sm:mt-0 flex flex-col items-end">
                        <span class="px-3 py-1 rounded-full text-sm font-bold shadow-md
                            @if($latestReservation->status === 'paid') bg-green-900 @else bg-fuchsia-900 @endif">
                            STATUS: {{ strtoupper($latestReservation->status) }}
                        </span>
                        <i class="mt-3 {{ ($latestReservation->status === 'paid') ? 'fas fa-key' : 'fas fa-clock' }} text-5xl opacity-30"></i>
                    </div>
                </div>
                
                {{-- Detail Tanggal --}}
                <div class="mt-5 pt-5 border-t border-white/40 grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    
                    {{-- Check-in --}}
                    <div class="p-2 border-r border-white/30">
                        <p class="text-xs font-medium opacity-80">Check-in</p>
                        <p class="text-2xl font-bold">{{ $checkInDate->format('d M') }}</p>
                        <p class="text-xs font-light">{{ $checkInDate->format('Y') }}</p>
                    </div>
                    
                    {{-- Check-out --}}
                    <div class="p-2 md:border-r border-white/30">
                        <p class="text-xs font-medium opacity-80">Check-out</p>
                        <p class="text-2xl font-bold">{{ $checkOutDate->format('d M') }}</p>
                        <p class="text-xs font-light">{{ $checkOutDate->format('Y') }}</p>
                    </div>

                    {{-- Total Malam --}}
                    <div class="p-2 bg-white/10 rounded-lg">
                        <p class="text-xs font-medium opacity-80">Total Malam</p>
                        <p class="text-2xl font-extrabold">{{ $totalNights }}</p>
                        <p class="text-xs font-light">Malam</p>
                    </div>
                    
                    {{-- Link Aksi --}}
                    <div class="p-2 flex flex-col justify-center space-y-1">
                        <a href="{{ route('booking.payment_info', $latestReservation->id) }}" class="inline-flex justify-center items-center text-xs font-bold text-yellow-300 hover:text-yellow-100 transition duration-150 ease-in-out bg-black/20 p-2 rounded-lg">
                            <i class="fas fa-receipt mr-2"></i> LIHAT INVOICE & DETAIL
                        </a>
                        @if($latestReservation->status !== 'paid')
                            <a href="{{ route('booking.payment_info', $latestReservation->id) }}" class="inline-flex justify-center items-center text-xs font-bold text-red-300 hover:text-red-100 transition duration-150 ease-in-out bg-black/20 p-2 rounded-lg">
                                <i class="fas fa-money-check-alt mr-2"></i> SELESAIKAN PEMBAYARAN
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @else
            {{-- Tampilan jika tidak ada reservasi aktif --}}
            <div class="bg-white p-8 text-gray-800 mb-8 rounded-2xl shadow-xl border-t-4 border-emerald-600 text-center dashboard-card-hover">
                <i class="fas fa-exclamation-circle text-5xl text-emerald-600 mb-4 animate-bounce"></i>
                <h2 class="text-2xl font-extrabold mb-1 text-gray-800">Tidak Ada Reservasi Ditemukan</h2>
                <p class="text-lg font-light mb-6 text-gray-600">Jadikan Lovina sebagai tempat istirahat Anda selanjutnya.</p>
                <a href="{{ route('rooms.index') }}" class="inline-flex items-center px-8 py-3 border border-transparent text-lg font-medium rounded-full shadow-lg text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-offset-2 focus:ring-emerald-500 transition duration-300">
                    <i class="fas fa-calendar-alt mr-3"></i> PESAN KAMAR SEKARANG
                </a>
            </div>
        @endif


        {{-- BARIS 2: LAYANAN & INFO --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Kolom Kiri: Layanan Cepat (lg:col-span-2) --}}
            <div class="lg:col-span-2">
                <div class="bg-white p-6 rounded-2xl shadow-xl border-t-4 border-emerald-600 dashboard-card-hover h-full flex flex-col">
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-concierge-bell text-emerald-600 mr-3 text-3xl"></i>
                        Akses Layanan Cepat Villa
                    </h2>
                    <p class="text-sm text-gray-600 mb-6 font-semibold border-b pb-4">
                        Hubungi staf kami atau pesan layanan kamar dengan sekali sentuh via WhatsApp.
                    </p>

                    <div class="flex-grow grid grid-cols-2 gap-4 sm:gap-6"> 
                        
                        <a href="{{ $linkBantuan }}" target="_blank" class="service-button flex flex-col items-center justify-center p-3 h-28 bg-red-600 text-white rounded-xl shadow-xl hover:bg-red-700">
                            <i class="fas fa-bell text-3xl mb-1"></i>
                            <span class="text-sm font-semibold mt-1">Panggil Bantuan</span>
                            <span class="text-xs font-light opacity-90">(Chat Staf)</span>
                        </a>

                        <a href="{{ route('rooms.index') }}" class="service-button flex flex-col items-center justify-center p-3 h-28 bg-teal-600 text-white rounded-xl shadow-xl hover:bg-teal-700">
                            <i class="fas fa-bed text-3xl mb-1"></i>
                            <span class="text-sm font-semibold mt-1">Pesan Kamar Baru</span>
                            <span class="text-xs font-light opacity-90">(Reservasi Tambahan)</span>
                        </a>
                        
                        <a href="{{ $linkHousekeeping }}" target="_blank" class="service-button flex flex-col items-center justify-center p-3 h-28 bg-yellow-600 text-white rounded-xl shadow-xl hover:bg-yellow-700">
                            <i class="fas fa-broom text-3xl mb-1"></i>
                            <span class="text-sm font-semibold mt-1">Housekeeping</span>
                            <span class="text-xs font-light opacity-90">(Bersihkan Kamar)</span>
                        </a>

                        <a href="{{ $linkPerpanjang }}" target="_blank" class="service-button flex flex-col items-center justify-center p-3 h-28 bg-purple-600 text-white rounded-xl shadow-xl hover:bg-purple-700">
                            <i class="fas fa-calendar-plus text-3xl mb-1"></i>
                            <span class="text-sm font-semibold mt-1">Perpanjang Inap</span>
                            <span class="text-xs font-light opacity-90">(Cek Ketersediaan)</span>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Status Box Berwarna --}}
            <div class="lg:space-y-6 flex flex-col space-y-6">
                
                {{-- Kartu Info Kontak Darurat (Merah - Darurat) --}}
                <div class="bg-red-600 p-6 rounded-2xl shadow-xl text-white dashboard-card-hover">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-white">Kontak Darurat</h3>
                        <i class="fas fa-exclamation-triangle text-3xl opacity-70"></i>
                    </div>
                    <div class="text-center bg-red-700/70 p-3 rounded-lg border border-red-500">
                        <p class="text-3xl font-extrabold tracking-wider">
                            0812-1375-1532
                        </p>
                        <p class="text-sm opacity-90 mt-1">Manajer Villa Siaga: Dimas Arya</p>
                    </div>
                </div>

                {{-- Kartu Akses Cepat Akun (Kuning - Perhatian/Aksi) --}}
                <div class="bg-yellow-600 p-6 rounded-2xl shadow-xl text-white dashboard-card-hover">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-white">Akses Akun Anda</h3>
                        <i class="fas fa-user-circle text-3xl opacity-70"></i>
                    </div>
                    <p class="text-sm opacity-90 mb-4">
                        Kelola profil, kata sandi, dan riwayat pemesanan.
                    </p>
                    
                    <div class="flex space-x-3">
                        <a href="{{ route('profile.edit') }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-base font-medium rounded-lg shadow-md text-yellow-700 bg-white hover:bg-gray-100 transition duration-150">
                            <i class="fas fa-cog mr-2"></i>
                            Profil
                        </a>
                        <a href="{{ route('history') }}" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-base font-medium rounded-lg shadow-md text-yellow-700 bg-white hover:bg-gray-100 transition duration-150">
                            <i class="fas fa-history mr-2"></i>
                            Riwayat
                        </a>
                    </div>

                </div>
                
                {{-- Kartu Info WiFi (Biru - Informasi) --}}
                <div class="bg-blue-600 p-6 rounded-2xl shadow-xl text-white dashboard-card-hover">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-xl font-bold text-white">Akses WiFi Gratis</h3>
                        <i class="fas fa-wifi text-3xl opacity-70"></i>
                    </div>
                    <div class="bg-blue-700/70 p-3 rounded-lg border border-blue-500">
                        <div class="flex justify-between items-center mb-1">
                            <p class="text-sm opacity-90 font-medium">SSID (Jaringan):</p>
                            <p class="text-lg font-extrabold">VillaManayasa_Guest</p>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-blue-500/50">
                            <p class="text-sm opacity-90 font-medium">Kata Sandi:</p>
                            <p class="text-lg font-extrabold">Manayasa2025</p>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil status reservasi dari PHP ke variabel JS
            var currentStatus = "{{ $latestReservation?->status ?? 'none' }}"; 

            // KONFIGURASI WAKTU (dalam milidetik)
            var refreshInterval = (currentStatus === 'pending') ? 5000 : 60000; // Menggabungkan logika refresh

            console.log('Mode Realtime Aktif: Refresh setiap ' + (refreshInterval/1000) + ' detik.');

            setTimeout(function() {
                localStorage.setItem('scrollPosition', window.scrollY);
                window.location.reload();
            }, refreshInterval);

            // Logic untuk mengembalikan posisi scroll setelah reload
            var scrollPos = localStorage.getItem('scrollPosition');
            if (scrollPos !== null) {
                window.scrollTo(0, scrollPos);
                localStorage.removeItem('scrollPosition'); 
            }
        });
    </script>
</div>
</body>
</html>