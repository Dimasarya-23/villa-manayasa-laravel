@extends('layouts.villa')

@section('content')

{{-- KONTEN HEADER --}}

<header class="bg-white dark:bg-gray-800 shadow">
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
<div class="flex flex-col md:flex-row items-start md:items-center justify-between space-y-3 md:space-y-0">
<h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight flex items-center">
<i class="fas fa-users-cog mr-3 text-red-600 dark:text-red-400"></i>
Manajemen Pengguna (User Access)
</h2>
{{-- Tombol untuk menambah pengguna baru (DINONAKTIFKAN KARENA RUTE USER.CREATE TIDAK DIDEFINISIKAN/DIEXCEPT DI ROUTES) --}}
{{--
<a href="{{ route('user.create') }}"
class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest shadow-lg hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
<i class="fas fa-user-plus mr-2"></i> TAMBAH PENGGUNA BARU
</a>
--}}
<span class="text-sm text-gray-500 dark:text-gray-400 font-medium">Pengguna baru ditambahkan melalui proses Registrasi.</span>
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

    {{-- NOTIFIKASI ERROR (Sesuai logika destroy di Controller) --}}
    @if (session('error'))
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md dark:bg-red-900/30 dark:border-red-400 dark:text-red-300" role="alert">
            <p class="font-bold">Gagal!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif

    {{-- FORM FILTER DAN PENCARIAN --}}
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg rounded-xl p-6 mb-6 border border-gray-200 dark:border-gray-700">
        <form action="{{ route('user.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <div class="md:col-span-2"> 
                <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cari Pengguna</label>
                <input type="text" name="search" id="search" placeholder="Cari nama atau email pengguna..." value="{{ request('search') }}"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm">
            </div>
            
            <div> 
                <label for="role_filter" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Filter Peran (Role)</label>
                <select name="role_filter" id="role_filter" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm">
                    <option value="">Semua Peran</option>
                    <option value="Admin" {{ request('role_filter') == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Staff" {{ request('role_filter') == 'Staff' ? 'selected' : '' }}>Staff</option>
                    <option value="Guest" {{ request('role_filter') == 'Guest' ? 'selected' : '' }}>Guest (Tamu)</option>
                </select>
            </div>
            
            <div class="flex justify-start md:justify-end space-x-2">
                <button type="submit" 
                        class="w-full md:w-auto px-4 py-2.5 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition duration-150 ease-in-out shadow-md flex items-center justify-center">
                    <i class="fas fa-filter mr-1"></i> Filter
                </button>
                @if(request('search') || request('role_filter'))
                    <a href="{{ route('user.index') }}" class="w-full md:w-auto px-4 py-2.5 bg-gray-300 text-gray-800 font-bold rounded-lg hover:bg-gray-400 transition duration-150 ease-in-out shadow-md flex items-center justify-center">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- TABEL DATA PENGGUNA --}}
    {{-- Menggunakan data $users yang dikirim dari Controller --}}
    @if(isset($users) && $users->count() > 0)
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
        <div class="overflow-x-auto">
            
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">No.</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">NAMA PENGGUNA</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">EMAIL</th>
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">PERAN (ROLE)</th>
                            {{-- Kolom status dihapus agar sinkron dengan Controller dan Model default Laravel --}}
                            <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        
                        {{-- Loop menggunakan data $users yang sesungguhnya --}}
                        @foreach($users as $user) 
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-200">
                                {{ $users->firstItem() + $loop->index }} {{-- Menghitung index dengan mempertimbangkan pagination --}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-base text-gray-900 dark:text-gray-100">{{ $user->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                     $role = strtolower($user->role ?? 'guest'); 
                                     $roleClass = [
                                         'admin' => 'bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100',
                                         'staff' => 'bg-blue-100 text-blue-800 dark:bg-blue-800 dark:text-blue-100',
                                         'guest' => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                     ];
                                     $roleText = [
                                         'admin' => 'Administrator',
                                         'staff' => 'Staff',
                                         'guest' => 'Tamu',
                                     ];
                                     $currentRoleClass = $roleClass[$role] ?? $roleClass['guest'];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $currentRoleClass }} shadow-sm">
                                    {{ $roleText[$role] ?? $user->role }}
                                </span>
                            </td>
                            {{-- Kolom status dihilangkan --}}
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm space-x-2">
                                
                                {{-- EDIT --}}
                                <a href="{{ route('user.edit', $user) }}" title="Edit Detail Pengguna" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white transition duration-150 ease-in-out rounded-lg font-medium inline-flex items-center justify-center text-sm w-20 py-2 shadow-md">
                                    <i class="fas fa-user-edit text-xs mr-1"></i> EDIT
                                </a>
                                
                                {{-- HAPUS --}}
                                <form action="{{ route('user.destroy', $user) }}" method="POST" class="inline" 
                                    onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}? Tindakan ini tidak dapat dibatalkan.');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus Pengguna" 
                                        class="bg-red-500 hover:bg-red-600 text-white transition duration-150 ease-in-out rounded-lg font-medium inline-flex items-center justify-center text-sm w-20 py-2 shadow-md"
                                        @if (auth()->user()->id === $user->id) disabled title="Tidak bisa menghapus akun sendiri" @endif>
                                        <i class="fas fa-trash-alt text-xs mr-1"></i> HAPUS
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>

        {{-- Pagination --}}
        <div class="p-4 border-t dark:border-gray-700 bg-white dark:bg-gray-800">
            {{-- Menambahkan appends() agar filter/pencarian tetap aktif saat pindah halaman --}}
            {{ $users->appends(request()->except('page'))->links() }} 
        </div>

    </div>
    @else
        {{-- Tampilan saat data kosong --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl">
            <p class="text-center text-gray-500 dark:text-gray-400 py-8 text-lg">
                <i class="fas fa-info-circle mr-2"></i> Tidak ada data pengguna yang ditemukan. Silakan coba filter atau pencarian lain.
            </p>
        </div>
    @endif

</div>


</div>

@endsection