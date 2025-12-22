<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Menggunakan @yield('title') untuk judul dinamis --}}
        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        
        <!-- Font Awesome Icons CDN (Digunakan untuk ikon di dashboard) -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" xintegrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJzL3a6PBLTAA/TDEqOFEfCjEY/MhH5pG2fE/qK0L/5A+rCgVn4Q15L8mQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        
        <!-- Chart.js untuk grafik di dashboard -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

        <!-- CSS KUSTOM VILLA MANAYASA (Jika ada) -->
        {{-- Jika Anda tidak menggunakan file 'css/villa.css', hapus baris ini --}}
        {{-- <link href="{{ asset('css/villa.css') }}" rel="stylesheet"> --}} 
        
        <!-- Jika Anda menggunakan Vite untuk asset lokal, uncomment baris di bawah ini -->
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900 flex flex-col">
            
            {{-- Asumsi Anda memiliki file 'layouts.navigation' yang berisi navigasi --}}
            @include('layouts.navigation')

            <!-- Page Heading (Untuk Blade Templating) -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-grow">
                {{-- {{ $slot }} DIHAPUS karena menyebabkan error saat menggunakan @extends --}}
                
                {{-- Konten dari @section('content') di file turunan (misal: dashboard.blade.php) akan masuk di sini --}}
                @yield('content')
            </main>
            
            <!-- FOOTER TELAH DIHAPUS SESUAI PERMINTAAN -->
            
        </div>
    </body>
</html>