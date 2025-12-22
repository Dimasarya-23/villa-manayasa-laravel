{{-- resources/views/profile/profile-guest.blade.php
    Wrapper Desain Khusus untuk Pengguna Tamu (Guest)
--}}

<div class="container mx-auto py-12 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center sm:text-left">
        <i class="fas fa-user-circle text-indigo-600 mr-2"></i> Profil Tamu
    </h2>
    
    {{-- Menampilkan Pesan Status --}}
    @if (session('status'))
        {{-- Menggunakan warna Indigo untuk status berhasil --}}
        <div class="bg-indigo-100 border-l-4 border-indigo-500 text-indigo-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
            <p>
                @if (session('status') == 'profile-updated')
                    Profil berhasil diperbarui!
                @elseif (session('status') == 'password-updated')
                    Kata sandi berhasil diperbarui!
                @endif
            </p>
        </div>
    @endif

    {{-- Wrapper utama untuk form (mengatur jarak dan lebar) --}}
    <div class="profile-forms-wrapper" style="display: flex; flex-direction: column; gap: 35px; max-width: 800px; margin: 0 auto;">

        {{-- 1. INFORMASI PROFIL (Warna Indigo untuk Aksen) --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-indigo-600">
             <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 flex items-center">
                <i class="fas fa-id-card text-indigo-600 mr-3"></i> Informasi Pribadi & Foto Profil
            </h3>
            {{-- MEMUAT PARTIALS YANG SUDAH ADA --}}
            @include('profile.partials.update-profile-information-form')
        </div>

        {{-- 2. UPDATE PASSWORD (Warna Merah untuk Aksi Kritis) --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-red-600">
             <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 flex items-center">
                 <i class="fas fa-lock text-red-600 mr-3"></i> Ubah Kata Sandi
            </h3>
            {{-- MEMUAT PARTIALS YANG SUDAH ADA --}}
            @include('profile.partials.update-password-form')
        </div>

        {{-- 3. DELETE ACCOUNT (Warna Abu-abu/Netral) --}}
        <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-gray-400">
             <h3 class="text-xl font-semibold text-gray-700 mb-4 pb-2 flex items-center">
                <i class="fas fa-trash-alt text-gray-600 mr-3"></i> Hapus Akun
            </h3>
            {{-- MEMUAT PARTIALS YANG SUDAH ADA --}}
            @include('profile.partials.delete-user-form')
        </div>
        
    </div>
</div>