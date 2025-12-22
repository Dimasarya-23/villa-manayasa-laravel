{{--
    File: resources/views/layouts/navigation-guest.blade.php
    Ini adalah navigasi khusus untuk peran Tamu.
    Ini memastikan hanya menu yang relevan (Dashboard, Riwayat, Profile, Logout) yang muncul.
    
    Catatan: File ini harus di-include di resources/views/layouts/villa.blade.php
    di dalam tag <nav> dan di dalam blok @auth.
--}}

@auth
    {{-- Dropdown untuk User yang Sudah Login (Tamu) --}}
    {{-- Menampilkan nama user di header menu --}}
    <li class="dropdown">
        <a href="#" class="dropdown-toggle"> 
            {{ Auth::user()->name }}
        </a>
        <ul class="dropdown-menu"> 
            
            {{-- 1. Dashboard --}}
            <li><a href="{{ url('/dashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            
            {{-- 2. Riwayat Pemesanan --}}
            <li>
                {{-- Menggunakan route('history') yang sudah Anda pastikan terdaftar --}}
                <a href="{{ route('history') }}"><i class="fas fa-history"></i> Riwayat Pemesanan</a>
            </li>
            
            {{-- 3. Profile --}}
            <li>
                <a href="{{ route('profile.edit') }}"><i class="fas fa-user-edit"></i> Profile</a>
            </li>
            
            {{-- 4. LOGOUT --}}
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}" 
                       onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </form>
            </li>
        </ul>
    </li>
@else
    {{-- Jika belum login, tampilkan tombol Login --}}
    <li><a href="{{ route('login') }}" class="login-button">
        Login
    </a></li>
@endauth