<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            Informasi Profil
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            Perbarui informasi akun dan alamat email profil Anda.
        </p>
    </header>

    <!-- PENTING: Tambahkan enctype="multipart/form-data" di sini! -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Bagian Tampilan Foto Profil Saat Ini -->
        <div>
            <label for="current_photo" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Foto Profil Saat Ini:</label>
            <div class="flex items-center space-x-4">
                @if (Auth::user()->foto_profil)
                    <!-- PENTING: Memuat dari folder storage menggunakan helper asset() -->
                    <img src="{{ asset('storage/' . Auth::user()->foto_profil) }}" 
                         alt="Foto Profil" 
                         class="w-20 h-20 object-cover rounded-full shadow-lg border border-gray-300 dark:border-gray-600">
                @else
                    <!-- Placeholder jika tidak ada foto -->
                    <div class="w-20 h-20 flex items-center justify-center bg-gray-200 dark:bg-gray-700 rounded-full text-gray-500 dark:text-gray-400 text-3xl font-bold">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Input Upload Foto Profil Baru -->
        <div>
            <x-input-label for="foto_profil" :value="__('Ganti Foto Profil (Max 2MB)')" />
            
            <!-- PENTING: Pastikan name adalah 'foto_profil' sesuai Controller -->
            <x-text-input id="foto_profil" name="foto_profil" type="file" class="mt-1 block w-full p-2 border border-gray-300 dark:border-gray-700 rounded-md" />
            
            <x-input-error class="mt-2" :messages="$errors->get('foto_profil')" />
        </div>

        <!-- Input Nama -->
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- Input Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                        Alamat email Anda belum terverifikasi.
                        <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Klik di sini untuk mengirim ulang email verifikasi.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                            Tautan verifikasi baru telah dikirim ke alamat email Anda.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'Profil berhasil diperbarui!')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>