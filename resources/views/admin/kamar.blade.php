<x-app-layout>

<!-- 
    ========================================================================================
    INI ADALAH HEADER SLOT (Menggantikan <header> di luar section)
    Content di sini akan mengisi <x-slot name="header"> di app.blade.php
    ========================================================================================
-->
<x-slot name="header">
    <h2 class="font-semibold text-3xl text-gray-800 leading-tight">
        {{ __('Manajemen Data Kamar') }}
    </h2>
</x-slot>

<!-- 
    ========================================================================================
    INI ADALAH CONTENT UTAMA (Mengisi default $slot)
    Menyalin semua konten yang tadinya ada di dalam @section('content')
    ========================================================================================
-->
<div class="py-6 bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- ================================================================= --}}
        {{-- BAGIAN STATISTIK (Menggunakan data dari $stats dari Controller) --}}
        {{-- ================================================================= --}}
        <h3 class="text-2xl font-bold mb-4 text-gray-800">Ringkasan Status Kamar</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">

            {{-- Kartu 1: Total Unit --}}
            <div class="bg-indigo-500 text-white p-5 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center">
                <p class="text-4xl font-extrabold">{{ $stats['total_units'] ?? 0 }}</p>
                <p class="text-sm uppercase font-semibold opacity-90">TOTAL UNIT</p>
            </div>

            {{-- Kartu 2: Tersedia (Available) --}}
            <div class="bg-emerald-600 text-white p-5 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center">
                <p class="text-4xl font-extrabold">{{ $stats['available'] ?? 0 }}</p>
                <p class="text-sm uppercase font-semibold opacity-90">TERSEDIA</p>
            </div>

            {{-- Kartu 3: Ditempati (Occupied) --}}
            <div class="bg-red-600 text-white p-5 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center">
                <p class="text-4xl font-extrabold">{{ $stats['occupied'] ?? 0 }}</p>
                <p class="text-sm uppercase font-semibold opacity-90">DITEMPATI</p>
            </div>

            {{-- Kartu 4: Pembersihan (Cleaning) --}}
            <div class="bg-yellow-500 text-white p-5 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center">
                <p class="text-4xl font-extrabold">{{ $stats['cleaning'] ?? 0 }}</p>
                <p class="text-sm uppercase font-semibold opacity-90">PEMBERSIHAN</p>
            </div>

            {{-- Kartu 5: Maintenance/Lainnya --}}
            <div class="bg-gray-600 text-white p-5 rounded-xl shadow-lg hover:shadow-xl transition duration-300 text-center">
                {{-- Menjumlahkan Maintenance dan status "other" --}}
                <p class="text-4xl font-extrabold">{{ ($stats['maintenance'] ?? 0) + ($stats['other'] ?? 0) }}</p>
                <p class="text-sm uppercase font-semibold opacity-90">PERBAIKAN/LAIN</p>
            </div>
        </div>

        {{-- BAGIAN FILTER DAN PENCARIAN --}}
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h4 class="text-xl font-bold text-gray-700">Tabel Data Kamar</h4>
                {{-- Target link ini adalah rute untuk menampilkan form pembuatan kamar baru --}}
                <a href="{{ route('kamar.create') ?? '#' }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-150">
                    + Tambah Kamar Baru
                </a>
            </div>
            
            <form action="{{ route('kamar.index') }}" method="GET" class="mb-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="search" id="search" placeholder="Cari tipe atau nomor kamar..." value="{{ request('search') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <select name="status_filter" id="status_filter"
                                class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Status</option>
                            @foreach(['Available', 'Occupied', 'Cleaning', 'Maintenance', 'Closed'] as $status)
                                <option value="{{ $status }}" {{ request('status_filter') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex space-x-2">
                        <button type="submit" class="bg-green-700 hover:bg-green-800 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md flex-1">
                            Filter
                        </button>
                        <a href="{{ route('kamar.index') }}" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg transition duration-150 shadow-md flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        {{-- BAGIAN TABEL DATA KAMAR --}}
        <div class="bg-white shadow-xl sm:rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No.</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor & Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga/Malam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kamars as $index => $kamar)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <span class="font-bold text-base">{{ $kamar->tipe_kamar }}</span> 
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 font-semibold">
                                Rp. {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $color = match($kamar->status) {
                                        'Available' => 'bg-green-100 text-green-800',
                                        'Occupied' => 'bg-red-100 text-red-800',
                                        'Cleaning' => 'bg-yellow-100 text-yellow-800',
                                        'Maintenance' => 'bg-orange-100 text-orange-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ $kamar->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium flex justify-center space-x-2">
                                {{-- Tombol Edit --}}
                                <a href="{{ route('kamar.edit', $kamar->id) }}" class="text-indigo-600 hover:text-white hover:bg-indigo-600 p-2 rounded-full transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zm-3.182 2.828L7.414 9.414 4 13.828V17h3.172l4.414-4.414-2.828-2.828z" />
                                    </svg>
                                </a>
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus kamar {{ $kamar->tipe_kamar }}? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-white hover:bg-red-600 p-2 rounded-full transition duration-150">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-base font-medium text-gray-500 bg-gray-50">
                                Tidak ada data kamar yang ditemukan berdasarkan kriteria filter/pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


    </div>
</div>


</x-app-layout>