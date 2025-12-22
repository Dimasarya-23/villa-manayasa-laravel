@extends('layouts.villa')

@section('title', 'Tambah Kamar Baru')

@section('content')
    {{-- HEADER PAGE --}}
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight flex items-center">
                <i class="fas fa-plus-circle mr-3 text-teal-600 dark:text-teal-400"></i>
                Formulir Tambah Kamar Baru
            </h2>
        </div>
    </header>

    {{-- KONTEN UTAMA - FORMULIR CREATE --}}
    <div class="py-6 sm:py-10 bg-gray-100 dark:bg-gray-900 min-h-screen"> 
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> 

            {{-- FORM CARD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl p-6 sm:p-8">

                {{-- FORM: Mengarah ke route store dengan method POST --}}
                <form method="POST" action="{{ route('kamar.store') }}">
                    @csrf

                    {{-- Section 1: Detail Tipe Kamar dan Harga --}}
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Informasi Dasar Kamar
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        {{-- Field: TIPE KAMAR --}}
                        <div>
                            <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Kamar <span class="text-red-500">*</span></label>
                            <input type="text" name="tipe_kamar" id="tipe_kamar" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                                value="{{ old('tipe_kamar') }}" placeholder="Contoh: Deluxe Double Bed" required>
                            @error('tipe_kamar')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field: HARGA PER MALAM --}}
                        <div>
                            <label for="harga_per_malam" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga per Malam (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="harga_per_malam" id="harga_per_malam" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                                value="{{ old('harga_per_malam') }}" placeholder="Contoh: 550000" required min="0">
                            @error('harga_per_malam')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Section 2: Kapasitas dan Status Awal --}}
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Kapasitas & Status Awal
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        {{-- Field: KAPASITAS TAMU --}}
                        <div>
                            <label for="kapasitas_tamu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kapasitas Tamu Maksimal <span class="text-red-500">*</span></label>
                            <input type="number" name="kapasitas_tamu" id="kapasitas_tamu" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                                value="{{ old('kapasitas_tamu') }}" placeholder="Contoh: 2" required min="1">
                            @error('kapasitas_tamu')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field: STATUS KAMAR (Default: Available) --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Kamar Awal <span class="text-red-500">*</span></label>
                            <select name="status" id="status" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" required>
                                
                                @php 
                                    $currentStatus = old('status', 'Available'); // Default ke 'Available'
                                    $options = [
                                        'Available' => 'Tersedia', 
                                        'Occupied' => 'Ditempati', 
                                        'Cleaning' => 'Pembersihan', 
                                        'Maintenance' => 'Maintenance', 
                                        'Closed' => 'Tutup'
                                    ];
                                @endphp
                                
                                @foreach($options as $key => $value)
                                    <option value="{{ $key }}" {{ $currentStatus == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Field: DESKRIPSI (Sudah ada di DB sekarang!) --}}
                    <div class="mb-6">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi & Fasilitas Kamar</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4" placeholder="Detail fasilitas, pemandangan, dan catatan penting kamar."
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Section 3: Tombol Aksi --}}
                    <div class="flex items-center justify-end space-x-3 mt-8 pt-4 border-t border-gray-200 dark:border-gray-700">
                        
                        {{-- Tombol Batal/Kembali --}}
                        <a href="{{ route('kamar.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg shadow-md transition duration-150 ease-in-out">
                            <i class="fas fa-times-circle mr-2"></i> BATAL
                        </a>

                        {{-- Tombol Simpan/Tambah --}}
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest shadow-lg hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-check-circle mr-2"></i> TAMBAH KAMAR
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection