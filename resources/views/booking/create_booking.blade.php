<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan | {{ $kamar->tipe_kamar }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fc; }
        .input-field {
            @apply w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500;
        }
        /* Style untuk input tanggal agar ikon kalender lebih terlihat */
        input[type="date"]::-webkit-calendar-picker-indicator {
            @apply cursor-pointer opacity-100 block w-6 h-6;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

    <div class="max-w-4xl w-full mx-auto p-4 lg:p-6">
        <!-- Tampilkan pesan sukses atau error dari Controller -->
        @if (session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg shadow-md" role="alert">
                <p class="font-bold">Gagal Memesan!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-2xl p-8 lg:p-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Konfirmasi Pemesanan</h1>
            <p class="text-lg text-gray-600 mb-8 font-medium">Kamar yang Anda Pilih: <span class="text-green-600 font-semibold">{{ $kamar->tipe_kamar }} (No. {{ $kamar->nomor_kamar }})</span></p>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <!-- Field tersembunyi untuk ID Kamar dan Harga Per Malam -->
                <input type="hidden" name="kamar_id" value="{{ $kamar->id }}">
                <input type="hidden" id="harga-per-malam" value="{{ $kamar->harga_per_malam }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    
                    <!-- Kiri: Rincian Kamar dan Harga -->
                    <div class="p-6 rounded-xl border border-gray-200 bg-gray-50 h-full">
                        <h3 class="text-xl font-bold text-green-700 mb-4 border-b pb-2 border-gray-200">Rincian Kamar</h3>
                        
                        <!-- Rincian Statis Kamar -->
                        <div class="text-gray-700 space-y-2 mb-6">
                            <p><span class="font-semibold">Tipe:</span> {{ $kamar->tipe_kamar }}</p>
                            <p><span class="font-semibold">Harga/Malam:</span> Rp{{ number_format($kamar->harga_per_malam, 0, ',', '.') }}</p>
                            <p><span class="font-semibold">Kapasitas:</span> {{ $kamar->kapasitas_tamu }} Tamu</p>
                        </div>

                        <!-- Ringkasan Perjalanan Dinamis -->
                        <div class="p-4 bg-white rounded-lg border border-green-300 shadow-inner">
                            <h4 class="text-lg font-bold text-green-800 mb-2">Ringkasan Biaya</h4>
                            <p class="text-gray-600 text-sm">Total menginap: <span id="total-malam" class="font-bold text-green-600">0</span> Malam</p>
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xl font-extrabold text-red-600">Total Harga Penuh: <span id="total-harga-display">Rp0</span></p>
                            </div>
                        </div>
                    </div>

                    <!-- Kanan: Input Data Pemesanan -->
                    <div class="space-y-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-4 border-b pb-2 border-gray-200">Informasi Tamu Utama</h3>
                        
                        <!-- Input Nama Tamu -->
                        <div>
                            <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap Tamu *</label>
                            <input type="text" name="guest_name" id="guest_name" required 
                                    value="{{ old('guest_name', Auth::check() ? Auth::user()->name : '') }}" 
                                    class="input-field">
                            @error('guest_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- PERBAIKAN: TAMBAH INPUT EMAIL -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" id="email" required 
                                    value="{{ old('email', Auth::check() ? Auth::user()->email : '') }}" 
                                    class="input-field" placeholder="Masukkan alamat email Anda">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- PERBAIKAN: TAMBAH INPUT NOMOR TELEPON -->
                        <div>
                            <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon *</label>
                            <!-- Pastikan nama field di sini adalah 'phone_number' atau 'phone' sesuai yang diminta validasi Controller -->
                            <input type="tel" name="phone_number" id="phone_number" required 
                                    value="{{ old('phone_number') }}" 
                                    class="input-field" placeholder="Contoh: 081234567890">
                            @error('phone_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Input Tanggal Check-in -->
                        <div>
                            <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in *</label>
                            <input type="date" name="check_in_date" id="check_in_date" required 
                                    min="{{ \Carbon\Carbon::today()->toDateString() }}" 
                                    value="{{ old('check_in_date', $checkInDate ?? '') }}"
                                    class="input-field">
                            @error('check_in_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- Input Tanggal Check-out -->
                        <div>
                            <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-out *</label>
                            <input type="date" name="check_out_date" id="check_out_date" required 
                                    value="{{ old('check_out_date', $checkOutDate ?? '') }}"
                                    class="input-field">
                            @error('check_out_date')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Tombol Aksi (Batal dan Submit) -->
                <div class="flex justify-between items-center pt-8 border-t border-gray-200 mt-8">
                    <!-- Tombol Batal/Kembali - MENGGUNAKAN URL LANGSUNG SEBAGAI FALLBACK -->
                    <a href="{{ url('/rooms') }}" 
                       class="flex items-center space-x-2 text-gray-600 hover:text-red-600 font-semibold py-3 px-4 rounded-xl transition duration-200 border border-gray-300 hover:bg-gray-100">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span>Batal (Kembali ke Pilihan Kamar)</span>
                    </a>

                    <!-- Tombol Submit -->
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-200 text-lg flex items-center space-x-2">
                        <span>Lanjut ke Pembayaran</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </button>
                </div>

            </form>

            <!-- Tampilkan Error Umum -->
            @if ($errors->any())
                <div class="mt-8 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <p class="font-bold">Perhatian, terdapat kesalahan pada formulir:</p>
                    <ul class="list-disc ml-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>
    
    <script>
        // Ambil elemen-elemen yang diperlukan
        const checkInInput = document.getElementById('check_in_date');
        const checkOutInput = document.getElementById('check_out_date');
        const totalMalamSpan = document.getElementById('total-malam');
        const totalHargaDisplay = document.getElementById('total-harga-display');
        const hargaPerMalam = parseInt(document.getElementById('harga-per-malam').value);
        
        // Fungsi untuk meng-handle perubahan tanggal Check-out minimum
        function updateMinCheckOut() {
            const checkInDate = checkInInput.value;
            
            if (checkInDate) {
                const checkIn = new Date(checkInDate);
                const nextDay = new Date(checkIn);
                nextDay.setDate(checkIn.getDate() + 1);
                
                // Format ke YYYY-MM-DD
                const minCheckOutDate = nextDay.toISOString().split('T')[0];
                
                checkOutInput.min = minCheckOutDate;
                
                // Jika check-out yang sudah diisi kurang dari minimal baru, set ke minimal baru
                if (checkOutInput.value && checkOutInput.value <= checkInDate) {
                    checkOutInput.value = minCheckOutDate;
                } else if (!checkOutInput.value) {
                     // Isi otomatis check-out ke H+1 jika belum diisi
                    checkOutInput.value = minCheckOutDate;
                }
            } else {
                 // Reset min date jika check-in kosong
                 checkOutInput.min = '';
            }
        }

        // Fungsi untuk menghitung dan memperbarui total harga
        function calculateAndDisplayPrice() {
            const checkInValue = checkInInput.value;
            const checkOutValue = checkOutInput.value;
            
            let totalNights = 0;
            let totalPrice = 0;

            if (checkInValue && checkOutValue) {
                const checkIn = new Date(checkInValue);
                const checkOut = new Date(checkOutValue);
                
                // Hitung selisih dalam milidetik
                const diffTime = checkOut.getTime() - checkIn.getTime();
                // Hitung selisih dalam hari (malam)
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
                
                if (diffDays > 0) {
                    totalNights = diffDays;
                    totalPrice = totalNights * hargaPerMalam;
                }
            }
            
            // Format harga ke mata uang Rupiah
            const formattedPrice = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(totalPrice);
            
            // Update tampilan
            totalMalamSpan.textContent = totalNights;
            totalHargaDisplay.textContent = formattedPrice;
        }
        
        // Listener saat perubahan Check-in & Check-out
        checkInInput.addEventListener('change', () => {
            updateMinCheckOut();
            calculateAndDisplayPrice();
        });
        checkOutInput.addEventListener('change', calculateAndDisplayPrice);

        // Panggil saat load untuk memastikan min date check-out dan harga sudah ter-set dengan benar
        window.onload = function() {
            updateMinCheckOut();
            calculateAndDisplayPrice();
        };

    </script>
</body>
</html>