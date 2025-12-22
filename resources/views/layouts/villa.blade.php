<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Villa Manayasa | Exclusive Boutique Retreat Lovina, Bali')</title>
    
    {{-- KRUSIAL: Memuat Tailwind/Vite CSS di sini agar kelas seperti max-w-2xl berfungsi --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- CSS KUSTOM VILLA MANAYASA (Dimuat setelah Tailwind agar bisa menimpa, sesuai best practice) --}}
    <link rel="stylesheet" href="{{ asset('css/villa.css') }}?v=<?php echo time(); ?>">
    
    <link rel="icon" type="image/png" href="{{ asset('assets/villa-logo.png') }}">
    {{-- Font Awesome untuk Ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> 

    {{-- KRUSIAL: Memuat CSS tambahan dari view anak (dashboard.blade.php) di sini --}}
    @stack('styles')
</head>
<body>
    <header class="main-villa-header">
        {{-- INLINE STYLE AGAR FLEX GARANSI BERFUNGSI (Header Tampil Horizontal) --}}
        <div class="header-content-wrapper" 
              style="display: flex !important; justify-content: space-between !important; align-items: center !important; flex-wrap: wrap !important; padding: 10px 20px !important;"> 
            
            <div class="logo-group" style="display: flex !important; align-items: center !important; gap: 14px !important;">
                <img src="{{ asset('assets/villa-logo.png') }}" alt="Villa Manayasa Logo" class="header-logo">
                <div class="brand-text">
                    <h1 class="text-en" style="margin: 0 !important;">Villa Manayasa</h1>
                    <p class="tagline class="text-en" style="margin: 0 !important;">Your Tranquil Escape in Lovina, Bali</p>
                    <h1 class="text-id hidden">Villa Manayasa</h1>
                    <p class="tagline class="text-id hidden">Surga Damai Anda di Lovina, Bali</p>
                </div>
            </div>
            
            <nav style="display: flex !important; align-items: center !important; gap: 16px !important;">
                <ul class="nav-menu" style="display: flex !important; margin: 0 !important; padding: 0 !important; list-style: none !important;">
                    <li><a href="{{ url('/') }}" class="{{ request()->is('/') ? 'active' : '' }}">
                        <span class="text-en">Home</span><span class="text-id hidden">Beranda</span>
                    </a></li>
                    <li><a href="{{ route('about') }}" class="{{ request()->is('about') ? 'active' : '' }}">
                        <span class="text-en">About</span><span class="text-id hidden">Tentang</span>
                    </a></li>
                    <li><a href="{{ route('contact') }}" class="{{ request()->is('contact') ? 'active' : '' }}">
                        <span class="text-en">Contact</span><span class="text-id hidden">Kontak</span>
                    </a></li>
                    
                    {{-- LOGIKA BARU UNTUK NAVIGASI BERDASARKAN ROLE --}}
                    @auth
                        {{-- Cek apakah user adalah Admin. Asumsi role admin bernilai 'admin' --}}
                        @if (Auth::user()->role === 'admin') 
                            {{-- TAMPILKAN MENU LENGKAP UNTUK ADMIN (Menu Lama) --}}
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle"> 
                                    {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu"> 
                                    <li><a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                    <li><a href="{{ route('kamar.index') }}"><i class="fas fa-bed"></i> Manajemen Kamar</a></li>
                                    <li><a href="{{ url('/management/users') }}"><i class="fas fa-users"></i> Manajemen Pengguna</a></li>
                                    <li><a href="{{ route('profile.edit') }}"><i class="fas fa-user-edit"></i> Profile</a></li>
                                    
                                    {{-- LOGOUT --}}
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                                <i class="fas fa-sign-out-alt"></i> Logout
                                            </a>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            {{-- TAMPILKAN MENU KHUSUS TAMU (Menggunakan file navigation-guest.blade.php) --}}
                            @include('layouts.navigation-guest')
                        @endif
                    @else
                        <li><a href="{{ route('login') }}" class="login-button">
                            Login
                        </a></li>
                    @endauth
                </ul>
                <div class="language-switcher">
                    <a href="#" class="lang-en active-lang">EN</a> |
                    <a href="#" class="lang-id">ID</a>
                </div>
            </nav>
        </div>
    </header>

    <main>
        {{-- Konten yang ditaruh di sini akan mendapatkan benefit dari Tailwind CSS --}}
        @yield('content')
    </main>

    <footer class="main-villa-footer">
        <div class="container">
            {{-- INLINE STYLE AGAR GRID GARANSI BERFUNGSI (Footer Tampil 3 Kolom) --}}
            <div class="footer-content" 
                 style="display: grid !important; grid-template-columns: repeat(3, 1fr) !important; gap: 60px !important;">
                <div class="footer-info">
                    <h3 style="text-align: left !important;">Villa Manayasa</h3>
                    <p>Jl. Arteriwico Gg. Tekukur<br> Desa Kalibukbuk, Kec. Buleleng<br> Kabupaten Buleleng, Bali</p>
                </div>
                <div class="footer-contact">
                    <h3 class="text-en" style="text-align: left !important;">Contact Information</h3>
                    <h3 class="text-id hidden">Informasi Kontak</h3>
                    <p>WhatsApp: 081213751532<br> Email: villamanayasa@gmail.com</p>
                    <p><span class="text-en">Official Booking:</span><span class="text-id hidden">Pemesanan Resmi:</span> <a href="https://booking.com/villamanayasa" target="_blank">booking.com/villamanayasa</a></p>
                </div>
                <div class="footer-social">
                    <h3 class="text-en" style="text-align: left !important;">Connect With Us</h3>
                    <h3 class="text-id hidden">Terhubung Dengan Kami</h3>
                    <div class="social-list">
                        <p>
                            <img src="{{ asset('assets/icon-instagram.png') }}" alt="Instagram Icon" class="social-icon">
                            <a href="https://www.instagram.com/villa_manayasa" target="_blank">villa_manayasa</a>
                        </p>
                        <p>
                            <img src="{{ asset('assets/icon-facebook.png') }}" alt="Facebook Icon" class="social-icon">
                            <a href="https://www.facebook.com/VillaManayasa" target="_blank">Villa Manayasa</a>
                        </p>
                        <p>
                            <img src="{{ asset('assets/icon-tiktok.png') }}" alt="TikTok Icon" class="social-icon">
                            <a href="https://www.tiktok.com/Villa_Manayasa" target="_blank">Villa_Manayasa</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 Villa Manayasa. All Rights Reserved. | Designed By Dimas Software</p>
            </div>
        </div>
    </footer>
    
    <script src="{{ asset('js/villa.js') }}"></script>
    @stack('scripts') 

</body>
</html>