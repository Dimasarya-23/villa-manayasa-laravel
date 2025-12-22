@extends('layouts.villa')

@section('content')

{{-- KONTEN HEADER --}}

<header class="bg-white dark:bg-gray-800 shadow">
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
<h2 class="font-bold text-3xl text-gray-800 dark:text-gray-100 leading-tight">
<i class="fas fa-user-edit mr-3 text-blue-600 dark:text-blue-400"></i>
Edit Pengguna
</h2>
</div>
</header>

{{-- KONTEN UTAMA PAGE --}}

<div class="py-6 sm:py-10 bg-gray-100 dark:bg-gray-900 min-h-screen">
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

    {{-- KONTEN UTAMA DENGAN SHADOW DAN ROUNDED CORNER --}}
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl rounded-xl p-6 border border-gray-200 dark:border-gray-700">

        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4 border-b pb-2">
            Mengedit Pengguna: {{ $user->name }} ({{ $user->email }})
        </h3>

        <form method="POST" action="{{ route('user.update', $user->id) }}">
            @csrf
            @method('PATCH') {{-- Menggunakan PATCH/PUT untuk update --}}

            <!-- Field Nama -->
            <div class="mt-4">
                <label for="name" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required autofocus
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm mt-1" />
                @error('name') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <!-- Field Email -->
            <div class="mt-4">
                <label for="email" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Alamat Email</label>
                <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm mt-1" />
                @error('email') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>
            
            <!-- Field Role -->
            <div class="mt-4">
                <label for="role" class="block font-medium text-sm text-gray-700 dark:text-gray-300">Role Pengguna</label>
                <select id="role" name="role" 
                    class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-red-500 dark:focus:border-red-600 focus:ring-red-500 dark:focus:ring-red-600 rounded-lg shadow-sm mt-1">
                    {{-- Sesuaikan opsi role dengan model Anda (Admin, Staff, Guest) --}}
                    <option value="Admin" {{ old('role', $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Staff" {{ old('role', $user->role) == 'Staff' ? 'selected' : '' }}>Staff</option>
                    <option value="Guest" {{ old('role', $user->role) == 'Guest' ? 'selected' : '' }}>Guest (Tamu)</option>
                </select>
                @error('role') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-start mt-6 space-x-3">
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 transition duration-150 ease-in-out shadow-md flex items-center">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
                
                <a href="{{ route('user.index') }}" 
                   class="px-4 py-2 bg-gray-300 text-gray-800 font-bold rounded-lg hover:bg-gray-400 transition duration-150 ease-in-out shadow-md flex items-center">
                    Batal
                </a>
            </div>
        </form>

    </div> 
</div> 


</div>

@endsection