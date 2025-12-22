@extends('layouts.villa')

@section('content')

    {{-- KONTEN HEADER --}}
    <header class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-3 md:space-y-0">
                <h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight flex items-center">
                    <i class="fas fa-bed mr-3 text-teal-600 dark:text-teal-400"></i>
                    Manajemen Data Kamar
                </h2>
                {{-- PERUBAHAN 1: TOMBOL TAMBAH KAMAR BARU menjadi KUNING --}}
                <a href="{{ route('kamar.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-full font-semibold text-xs text-gray-900 uppercase tracking-widest shadow-lg hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <i class="fas fa-plus mr-2"></i> TAMBAH KAMAR BARU
                </a>
            </div>
        </div>
    </header>

    {{-- KONTEN UTAMA PAGE --}}
    <div class="py-6 sm:py-10 bg-gray-100 dark:bg-gray-900 min-h-screen"> 
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8"> 

            {{-- NOTIFIKASI SUKSES --}}
            @if (session('success'))
                <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md dark:bg-green-900/30 dark:border-green-400 dark:text-green-300" role="alert">
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            @endif

            {{-- KARTU STATISTIK --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 sm:gap-6 mb-8">
                
                {{-- Card 1: Total Unit (Dark) --}}
                <a href="{{ route('kamar.index') }}" 
                    class="block bg-gray-800 text-white p-4 rounded-xl shadow-xl border-b-4 border-gray-900 flex flex-col justify-between w-full transition duration-300 transform hover:scale-[1.03] hover:shadow-2xl cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-extrabold uppercase opacity-100 tracking-wider">TOTAL UNIT</div>
                        <i class="fas fa-hotel text-2xl text-white/50"></i>
                    </div>
                    <div class="text-3xl font-extrabold mt-auto">{{ $stats['total_units'] ?? 0 }}</div> 
                </a>

                {{-- PERUBAHAN 2: Card 2: Tersedia (Menjadi HIJAU KUAT) --}}
                <a href="{{ route('kamar.index', ['status_filter' => 'Available']) }}" 
                    class="block bg-green-600 text-white p-4 rounded-xl shadow-xl border-b-4 border-green-700 flex flex-col justify-between w-full transition duration-300 transform hover:scale-[1.03] hover:shadow-2xl cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-extrabold uppercase opacity-100 tracking-wider">TERSEDIA</div>
                        <i class="fas fa-door-open text-2xl text-white/50"></i>
                    </div>
                    <div class="text-3xl font-extrabold mt-auto">{{ $stats['available'] ?? 0 }}</div>
                </a>

                {{-- Card 3: Ditempati (Red) --}}
                <a href="{{ route('kamar.index', ['status_filter' => 'Occupied']) }}" 
                    class="block bg-red-600 text-white p-4 rounded-xl shadow-xl border-b-4 border-red-700 flex flex-col justify-between w-full transition duration-300 transform hover:scale-[1.03] hover:shadow-2xl cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-extrabold uppercase opacity-100 tracking-wider">DITEMPATI</div>
                        <i class="fas fa-users text-2xl text-white/50"></i>
                    </div>
                    <div class="text-3xl font-extrabold mt-auto">{{ $stats['occupied'] ?? 0 }}</div>
                </a>

                {{-- PERUBAHAN 3: Card 4: Pembersihan (Menjadi KUNING GELAP yang menonjol) --}}
                <a href="{{ route('kamar.index', ['status_filter' => 'Cleaning']) }}" 
                    class="block bg-yellow-700 text-white p-4 rounded-xl shadow-xl border-b-4 border-yellow-800 flex flex-col justify-between w-full transition duration-300 transform hover:scale-[1.03] hover:shadow-2xl cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-extrabold uppercase opacity-100 tracking-wider">PEMBERSIHAN</div>
                        <i class="fas fa-broom text-2xl text-white/50"></i>
                    </div>
                    <div class="text-3xl font-extrabold mt-auto">{{ $stats['cleaning'] ?? 0 }}</div>
                </a>
                
                {{-- PERUBAHAN 4: Card 5: Maintenance (Menjadi BIRU MUDA) --}}
                <a href="{{ route('kamar.index', ['status_filter' => 'Maintenance']) }}" 
                    class="block bg-sky-500 text-gray-900 p-4 rounded-xl shadow-xl border-b-4 border-sky-700 flex flex-col justify-between w-full transition duration-300 transform hover:scale-[1.03] hover:shadow-2xl cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-extrabold uppercase opacity-100 tracking-wider">MAINTENANCE</div>
                        <i class="fas fa-tools text-2xl text-gray-900/50"></i>
                    </div>
                    <div class="text-3xl font-extrabold mt-auto text-gray-900">{{ $stats['maintenance'] ?? 0 }}</div>
                </a>

                {{-- Card 6: Tutup/Lain-lain (Gray/White Text) --}}
                <a href="{{ route('kamar.index', ['status_filter' => 'Closed']) }}" 
                    class="block bg-gray-500 text-white p-4 rounded-xl shadow-xl border-b-4 border-gray-600 flex flex-col justify-between w-full transition duration-300 transform hover:scale-[1.03] hover:shadow-2xl cursor-pointer">
                    <div class="flex justify-between items-start">
                        <div class="text-xs font-extrabold uppercase opacity-100 tracking-wider">TUTUP/LAIN</div>
                        <i class="fas fa-ban text-2xl text-white/50"></i>
                    </div>
                    <div class="text-3xl font-extrabold mt-auto">{{ $stats['other'] ?? 0 }}</div>
                </a>

            </div>
            
            {{-- FORM FILTER DAN PENCARIAN --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 mb-6 border border-gray-200 dark:border-gray-700">
                <form action="{{ route('kamar.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div class="md:col-span-2"> 
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Kamar</label>
                        <input type="text" name="search" id="search" placeholder="Cari nomor atau tipe kamar..." value="{{ request('search') }}"
                                class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600 rounded-lg shadow-sm">
                    </div>
                    
                    <div> 
                        <label for="status_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter Status</label>
                        <select name="status_filter" id="status_filter" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-teal-500 dark:focus:border-teal-600 focus:ring-teal-500 dark:focus:ring-teal-600 rounded-lg shadow-sm">
                            <option value="">Semua Status</option>
                            <option value="Available" {{ request('status_filter') == 'Available' ? 'selected' : '' }}>Available (Tersedia)</option>
                            <option value="Occupied" {{ request('status_filter') == 'Occupied' ? 'selected' : '' }}>Occupied (Ditempati)</option>
                            <option value="Cleaning" {{ request('status_filter') == 'Cleaning' ? 'selected' : '' }}>Cleaning (Pembersihan)</option>
                            <option value="Maintenance" {{ request('status_filter') == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="Closed" {{ request('status_filter') == 'Closed' ? 'selected' : '' }}>Closed (Tutup)</option>
                        </select>
                    </div>
                    
                    <div class="flex justify-start md:justify-end space-x-2">
                        <button type="submit" 
                                class="w-full md:w-auto px-4 py-2.5 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition duration-150 ease-in-out shadow-md flex items-center justify-center">
                            <i class="fas fa-filter mr-1"></i> Filter
                        </button>
                        @if(request('search') || request('status_filter'))
                            <a href="{{ route('kamar.index') }}" class="w-full md:w-auto px-4 py-2.5 bg-gray-300 text-gray-800 font-bold rounded-lg hover:bg-gray-400 transition duration-150 ease-in-out shadow-md flex items-center justify-center">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- TABEL DATA KAMAR (TIDAK DIUBAH KONTENNYA) --}}
            @if(isset($kamars) && $kamars->count() > 0)
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
                <div class="overflow-x-auto">
                    
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No.</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">NOMOR & TIPE KAMAR</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">HARGA/MALAM</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">STATUS</th>
                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">AKSI</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($kamars as $kamar)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                    {{ $nomor_urut = $kamars->firstItem() + $loop->index }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-bold text-base text-gray-900 dark:text-gray-100">
                                            {{ $kamar->nomor_kamar ?? 'ROOM - ' . $nomor_urut }}
                                        </div>
                                        <div class="text-sm text-teal-700 dark:text-teal-400 font-medium">{{ $kamar->tipe_kamar }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">ID: #{{ $kamar->id ?? 'N/A' }}</div> 
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-300 font-mono">Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @php
                                            $status = strtolower($kamar->status ?? 'unknown'); 
                                            $statusText = [
                                                'available' => 'Tersedia',
                                                'occupied' => 'Ditempati',
                                                'cleaning' => 'Pembersihan',
                                                'maintenance' => 'Maintenance',
                                                'closed' => 'Tutup',
                                                'unknown' => 'Tidak Diketahui',
                                            ];
                                            // Status badge di dalam tabel disinkronkan dengan warna kartu
                                            $statusClass = [
                                                'available' => 'bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100', 
                                                'occupied' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100', 
                                                'cleaning' => 'bg-yellow-200 text-yellow-800 dark:bg-yellow-700 dark:text-yellow-100', 
                                                'maintenance' => 'bg-sky-100 text-sky-800 dark:bg-sky-800 dark:text-sky-100', 
                                                'closed' => 'bg-gray-300 text-gray-800 dark:bg-gray-700 dark:text-gray-300', 
                                                'unknown' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                            ];
                                            $currentStatus = array_key_exists($status, $statusText) ? $status : 'unknown';
                                        @endphp
                                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass[$currentStatus] }} shadow-sm">
                                            {{ $statusText[$currentStatus] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm space-x-2">
                                        
                                        {{-- EDIT --}}
                                        <a href="{{ route('kamar.edit', $kamar) }}" title="Edit Detail dan Status Kamar" 
                                            class="bg-blue-500 hover:bg-blue-600 text-white transition duration-150 ease-in-out rounded-lg font-medium inline-flex items-center justify-center text-sm w-20 py-2 shadow-md">
                                            <i class="fas fa-edit text-xs mr-1"></i> EDIT
                                        </a>
                                        
                                        {{-- HAPUS --}}
                                        <form action="{{ route('kamar.destroy', $kamar) }}" method="POST" class="inline" 
                                            onsubmit="return confirm('Yakin ingin menghapus kamar {{ $kamar->nomor_kamar ?? 'ROOM - ' . $nomor_urut }} ({{ $kamar->tipe_kamar }})? Tindakan ini tidak dapat dibatalkan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Kamar" 
                                                class="bg-red-500 hover:bg-red-600 text-white transition duration-150 ease-in-out rounded-lg font-medium inline-flex items-center justify-center text-sm w-20 py-2 shadow-md">
                                                <i class="fas fa-trash-alt text-xs mr-1"></i> HAPUS
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        @if(method_exists($kamars, 'links'))
                            <div class="mt-4 p-4 border-t dark:border-gray-700 bg-white dark:bg-gray-800">
                                {{ $kamars->appends(request()->except('page'))->links() }}
                            </div>
                        @endif

                </div>
            </div>
            @else
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
                    <p class="text-center text-gray-500 dark:text-gray-400 py-8 text-lg">
                        <i class="fas fa-info-circle mr-2"></i> Tidak ada data kamar yang ditemukan.
                    </p>
                </div> 
            @endif

        </div>
    </div>
@endsection