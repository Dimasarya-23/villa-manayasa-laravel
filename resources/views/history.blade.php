@extends('layouts.villa')

@section('title', 'Riwayat Pemesanan Anda')

@section('content')
    <div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-extrabold text-gray-900 mb-8 tracking-tight">
            Riwayat Pemesanan Anda
        </h2>

        {{-- Logika untuk menampilkan pesan jika riwayat kosong --}}
        @if ($histories->isEmpty())
            <div class="bg-indigo-50 border-l-4 border-indigo-500 text-indigo-700 p-6 rounded-xl shadow-lg" role="alert">
                <p class="font-bold text-xl mb-2">Tidak Ada Riwayat Ditemukan</p>
                <p>Anda belum memiliki pemesanan yang tercatat. Saatnya merencanakan liburan mewah Anda!</p>
                <p class="mt-4">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                        Cari Kamar Sekarang
                    </a>
                </p>
            </div>
        @else
            {{-- Grid Riwayat Pemesanan dengan Tampilan Card --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($histories as $reservation)
                    @php
                        // Logika untuk menentukan warna status badge
                        $statusText = $reservation->status ?? 'Unknown';
                        $statusClasses = [
                            'Completed' => 'bg-green-100 text-green-800 border-green-400',
                            'Pending Payment' => 'bg-yellow-100 text-yellow-800 border-yellow-400', // PENTING: Ganti 'Pending' jadi 'Pending Payment'
                            'Canceled' => 'bg-red-100 text-red-800 border-red-400',
                            'Confirmed' => 'bg-blue-100 text-blue-800 border-blue-400',
                        ][$statusText] ?? 'bg-gray-100 text-gray-600 border-gray-400';
                        
                        // Icon berdasarkan status 
                        $statusIcon = [
                            'Completed' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'Pending Payment' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.3 16c-.77 1.333.192 3 1.732 3z',
                            'Canceled' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                            'Confirmed' => 'M4 4v5h.582m15.356 2A8.966 8.966 0 0112 21a9 9 0 01-8.666-6c-.347.013-.679.034-1 .061V4m7 3.75L12 11m0 0l-3-3m3 3V3',
                        ][$statusText] ?? 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2';
                    @endphp

                    {{-- Card untuk Setiap Pemesanan --}}
                    <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition duration-300 transform hover:scale-[1.02] overflow-hidden border border-gray-200">
                        
                        {{-- Header Card dengan Kode dan Status --}}
                        <div class="p-5 border-b bg-indigo-50 border-indigo-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900 truncate">
                                {{-- FIX 1: Menggunakan booking_code atau fallback ke ID untuk menghilangkan #N/A --}}
                                #{{ $reservation->booking_code ?? $reservation->id ?? 'N/A' }}
                            </h3>
                            <span class="inline-flex items-center px-3 py-1.5 text-xs font-semibold rounded-full border {{ $statusClasses }} shadow-sm">
                                <svg class="w-4 h-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $statusIcon }}" />
                                </svg>
                                {{ $statusText }}
                            </span>
                        </div>

                        {{-- Body Card: Detail Pemesanan --}}
                        <div class="p-5 space-y-4">
                            
                            {{-- FIX 2: Tipe Kamar (Mengambil dari relasi kamar) --}}
                            <div class="flex justify-between items-center text-sm">
                                <span class="font-medium text-gray-500 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Tipe Kamar
                                </span>
                                <span class="font-semibold text-gray-800">
                                    {{-- Mengambil Nama Kamar dari relasi ->kamar->nama_kolom. Disarankan menggunakan 'name' atau 'tipe' --}}
                                    {{ $reservation->kamar->name ?? $reservation->kamar->tipe ?? 'Nama Kamar Tidak Ditemukan' }}
                                </span>
                            </div>

                            {{-- Check-in/Check-out Dates --}}
                            <div class="grid grid-cols-2 gap-4 border-t border-dashed pt-4">
                                {{-- Check-in --}}
                                <div class="text-center">
                                    <p class="text-xs font-medium text-gray-500 mb-1 uppercase">Check-in</p>
                                    <p class="text-lg font-extrabold text-indigo-600">
                                        {{ \Carbon\Carbon::parse($reservation->check_in_date)->format('d') }}
                                        <span class="text-sm font-semibold block text-gray-700">{{ \Carbon\Carbon::parse($reservation->check_in_date)->format('M Y') }}</span>
                                    </p>
                                </div>
                                {{-- Check-out --}}
                                <div class="text-center">
                                    <p class="text-xs font-medium text-gray-500 mb-1 uppercase">Check-out</p>
                                    <p class="text-lg font-extrabold text-pink-600">
                                        {{ \Carbon\Carbon::parse($reservation->check_out_date)->format('d') }}
                                        <span class="text-sm font-semibold block text-gray-700">{{ \Carbon\Carbon::parse($reservation->check_out_date)->format('M Y') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Card: Total Biaya dan Aksi --}}
                        <div class="p-5 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                            <div class="text-left">
                                <p class="text-xs font-medium text-gray-500 uppercase">Total Biaya</p>
                                <p class="text-xl font-bold text-red-600">
                                    Rp {{ number_format($reservation->total_cost ?? $reservation->total_price ?? 0, 0, ',', '.') }}
                                </p>
                            </div>
                            <a href="{{ route('booking.payment_info', ['bookingId' => $reservation->id]) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg shadow-md text-white bg-indigo-500 hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                                Lihat Detail
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
        @endif
    </div>
@endsection