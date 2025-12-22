@extends('layouts.villa')

@section('title', 'Edit Data Kamar')

@section('content')
    {{-- HEADER PAGE --}}
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight flex items-center">
                <i class="fas fa-edit mr-3 text-teal-600 dark:text-teal-400"></i>
                Edit Data Kamar: {{ $kamar->tipe_kamar ?? 'ID N/A' }} 
                <span class="text-xl font-mono text-gray-500 dark:text-gray-400 ml-4 border-l-2 pl-4">Nomor: {{ $kamar->nomor_kamar ?? 'N/A' }}</span>
            </h2>
        </div>
    </header>

    {{-- KONTEN UTAMA - FORMULIR EDIT --}}
    <div class="py-6 sm:py-10 bg-gray-100 dark:bg-gray-900 min-h-screen"> 
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8"> 

            {{-- FORM CARD --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl p-6 sm:p-8">

                {{-- BLOK UNTUK MENAMPILKAN SEMUA ERROR VALIDASI --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                        <p class="font-bold">Gagal Update: Periksa Data Anda!</p>
                        <ul class="mt-2 list-disc list-inside text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                {{-- FORM: Mengarah ke route update, wajib menggunakan method PUT/PATCH --}}
                <form method="POST" action="{{ route('kamar.update', $kamar) }}">
                    @csrf
                    @method('PUT')
                    
                    {{-- FIX KRITIS: Menggunakan old() untuk memastikan nomor_kamar tetap terisi saat validasi gagal. --}}
                    <input type="hidden" name="nomor_kamar" value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}">

                    {{-- Section 1: Detail Kamar dan Nomor --}}
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Informasi Dasar Kamar
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        {{-- Field KRITIS: NOMOR KAMAR (HANYA DISPLAY, GUNAKAN DISABLED DAN READONLY) --}}
                        <div>
                            <label for="nomor_kamar_display" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nomor Kamar</label>
                            <input type="text" id="nomor_kamar_display" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-lg shadow-sm bg-gray-100 dark:bg-gray-700 cursor-not-allowed"
                                value="{{ $kamar->nomor_kamar }}" disabled readonly>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor kamar tidak dapat diubah.</p>
                            {{-- Error dari field hidden 'nomor_kamar' tetap ditampilkan di sini --}}
                            @error('nomor_kamar')
                                <p class="mt-1 text-xs text-red-500">Error: {{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field: TIPE KAMAR (Gunakan old() dengan fallback ke data $kamar) --}}
                        <div>
                            <label for="tipe_kamar" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipe Kamar <span class="text-red-500">*</span></label>
                            <input type="text" name="tipe_kamar" id="tipe_kamar" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                                value="{{ old('tipe_kamar', $kamar->tipe_kamar) }}" required>
                            @error('tipe_kamar')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                        {{-- Field: HARGA PER MALAM --}}
                        <div>
                            <label for="harga_per_malam" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Harga per Malam (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="harga_per_malam" id="harga_per_malam" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                                value="{{ old('harga_per_malam', $kamar->harga_per_malam) }}" required min="0">
                            @error('harga_per_malam')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Field: KAPASITAS TAMU --}}
                        <div>
                            <label for="kapasitas_tamu" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kapasitas Tamu Maksimal <span class="text-red-500">*</span></label>
                            <input type="number" name="kapasitas_tamu" id="kapasitas_tamu" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm"
                                value="{{ old('kapasitas_tamu', $kamar->kapasitas_tamu) }}" required min="1">
                            @error('kapasitas_tamu')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Section 2: Status dan Deskripsi --}}
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200 border-b pb-2 border-gray-200 dark:border-gray-700">
                        Status & Fasilitas
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        
                        {{-- Field: STATUS KAMAR --}}
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Status Kamar <span class="text-red-500">*</span></label>
                            <select name="status" id="status" 
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm" required>
                                
                                @php 
                                    // Mengambil status yang saat ini dipilih (old data atau dari $kamar)
                                    $currentStatus = old('status', $kamar->status);
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
                    
                    {{-- Field: DESKRIPSI --}}
                    <div class="mb-6">
                        <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi & Fasilitas Kamar</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 focus:ring-teal-500 rounded-lg shadow-sm">{{ old('deskripsi', $kamar->deskripsi) }}</textarea>
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

                        {{-- Tombol Simpan/Update --}}
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-teal-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest shadow-lg hover:bg-teal-700 active:bg-teal-900 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <i class="fas fa-save mr-2"></i> SIMPAN PERUBAHAN
                        </button>
                    </div>

                </form>
            </div>
            
            {{-- OPTIONAL: CARD HAPUS KAMAR (DIBAWAH FORM UTAMA) --}}
            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl p-6 sm:p-8 border-2 border-red-500 dark:border-red-600">
                <h3 class="text-xl font-semibold mb-4 text-red-600 dark:text-red-400">
                    Zona Bahaya: Hapus Kamar
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Tindakan ini akan menghapus kamar ini secara permanen dari sistem.
                </p>
                
                <form action="{{ route('kamar.destroy', $kamar) }}" method="POST" 
                    onsubmit="return confirm('ANDA YAKIN INGIN MENGHAPUS KAMAR INI PERMANEN? Semua data terkait akan hilang.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-lg font-semibold text-white uppercase tracking-widest shadow-lg hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <i class="fas fa-trash-alt mr-2"></i> HAPUS KAMAR INI
                    </button>
                </form>
            </div>

        </div>
    </div>
@endsection