<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari & Pilih Kamar</title>
    <!-- Asumsi Anda memuat Tailwind CSS atau menggunakan stack Blade (seperti app.css) -->
</head>
<body class="bg-gray-100 min-h-screen">

<div class="container mx-auto p-4 sm:p-8">
    
    <h1 class="text-3xl font-extrabold text-indigo-800 mb-6 border-b pb-2">Pilih Kamar Anda</h1>

    <!-- 1. FORM PENCARIAN TANGGAL -->
    <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Cari Ketersediaan</h2>
        <form method="GET" action="{{ route('rooms.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            
            <div>
                <label for="check_in_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-in</label>
                <input type="date" id="check_in_date" name="check_in_date" required 
                       value="{{ request('check_in_date') }}" 
                       min="{{ now()->toDateString() }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
            </div>

            <div>
                <label for="check_out_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Check-out</label>
                <input type="date" id="check_out_date" name="check_out_date" required 
                       value="{{ request('check_out_date') }}"
                       min="{{ now()->addDay()->toDateString() }}"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 p-2.5">
            </div>

            <div class="col-span-1 md:col-span-2">
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-lg transition duration-150 shadow-md">
                    Cari Kamar Tersedia
                </button>
            </div>
        </form>
    </div>

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- 2. DAFTAR KAMAR TERSEDIA -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        
        @forelse ($rooms as $kamar)
        <div class="bg-white rounded-xl shadow-xl overflow-hidden transform hover:scale-[1.02] transition duration-300">
            <!-- Placeholder Gambar Kamar -->
            <div class="h-48 bg-indigo-500/10 flex items-center justify-center text-indigo-800 font-semibold text-lg">
                
            </div>

            <div class="p-6">
                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $kamar->nama_kamar }}</h3>
                <p class="text-sm text-gray-500 mb-4">{{ $kamar->deskripsi_singkat }}</p>

                <div class="flex justify-between items-center mb-4 border-t pt-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Harga/Malam</p>
                        <p class="text-xl font-extrabold text-green-600">
                            Rp {{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-medium text-gray-500">Tipe</p>
                        <span class="inline-block bg-indigo-100 text-indigo-800 text-xs font-semibold px-3 py-1 rounded-full">
                            {{ $kamar->tipe }}
                        </span>
                    </div>
                </div>

                <!-- Tombol Booking -->
                @if (request('check_in_date') && request('check_out_date'))
                    <a href="{{ route('booking.create', [
                        'kamar' => $kamar->id,
                        'check_in' => request('check_in_date'),
                        'check_out' => request('check_out_date')
                    ]) }}" 
                       class="w-full inline-block text-center bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 rounded-lg transition duration-150 shadow-lg mt-2">
                        Pesan Sekarang
                    </a>
                @else
                    <button class="w-full bg-gray-300 text-gray-600 font-bold py-2 rounded-lg cursor-not-allowed mt-2" disabled>
                        Pilih Tanggal Dulu
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-2">Mohon masukkan tanggal untuk melanjutkan pemesanan.</p>
                @endif
            </div>
        </div>
        @empty
        <!-- Tampilan Jika Kamar Tidak Ditemukan -->
        <div class="col-span-full bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-md" role="alert">
            <p class="font-bold">Tidak Ditemukan!</p>
            <p>Maaf, tidak ada kamar yang tersedia untuk tanggal yang Anda pilih atau saat ini. Coba ubah tanggal pencarian Anda.</p>
        </div>
        @endforelse

    </div>
</div>

</body>
</html>