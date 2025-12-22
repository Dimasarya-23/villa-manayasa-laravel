{{-- resources/views/profile/profile-admin.blade.php
    Wrapper Desain Khusus untuk Pengguna Admin/Staff
--}}

{{-- PERBAIKAN LEBAR AKHIR: Menggunakan max-w-2xl (paling sempit, 512px) untuk tampilan yang fokus di tengah. 
    Hanya menahan max-width dan centering (mx-auto, py-12) di container ini. --}}
<div class="max-w-2xl mx-auto py-12">
    
    {{-- Judul dan Padding Horizontal Diterapkan di Sini --}}
    <h2 class="text-3xl font-bold text-gray-800 mb-10 text-center px-4 sm:px-6 lg:px-8"> 
        <i class="fas fa-user-shield text-blue-600 mr-2"></i> Kelola Profil Admin/Staff
    </h2>
    
    {{-- Menampilkan Pesan Status --}}
    @if (session('status'))
        {{-- Memberikan margin horizontal pada alert agar tidak menempel ke tepi layar di mobile --}}
        <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 mb-6 rounded-lg shadow-md mx-4 sm:mx-6 lg:mx-8" role="alert">
            <p>
                @if (session('status') == 'profile-updated')
                    Profil Admin/Staff berhasil diperbarui!
                @elseif (session('status') == 'password-updated')
                    Kata sandi berhasil diperbarui!
                @endif
            </p>
        </div>
    @endif

    {{-- Wrapper utama form dengan jarak antar bagian, ditambah padding horizontal --}}
    <div class="space-y-6 px-4 sm:px-6 lg:px-8">
        
        {{-- 1. INFORMASI PROFIL (Aksen Biru) --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-blue-600">
            <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 flex items-center">
                <i class="fas fa-id-badge text-blue-600 mr-3"></i> Informasi Admin & Foto Profil
            </h3>
            {{-- MEMUAT PARTIALS YANG SUDAH ADA --}}
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- 2. UPDATE PASSWORD (Aksen Merah) --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-red-600">
            <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 flex items-center">
                 <i class="fas fa-key text-red-600 mr-3"></i> Ubah Kata Sandi
            </h3>
            {{-- MEMUAT PARTIALS YANG SUDAH ADA --}}
            @include('profile.partials.update-password-form')
        </div>

        {{-- 3. DELETE ACCOUNT (Aksen Abu-abu/Netral) --}}
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-l-4 border-gray-400">
             <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 flex items-center">
                <i class="fas fa-exclamation-triangle text-gray-700 mr-3"></i> Hapus Akun
            </h3>
            {{-- MEMUAT PARTIALS YANG SUDAH ADA --}}
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>