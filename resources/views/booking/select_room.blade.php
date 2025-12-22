<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Kamar | Villa Manayasa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fc; }
    </style>
</head>
<body class="min-h-screen">

    <div class="container mx-auto p-4 lg:p-10">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Pesan Kamar Anda</h1>
        <p class="text-lg text-gray-600 mb-8">Pilih kamar yang tersedia untuk melihat detail pemesanan.</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($availableRooms as $kamar)
                <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    <img src="https://placehold.co/600x400/008000/ffffff?text={{ urlencode($kamar->tipe_kamar) }}" 
                         alt="{{ $kamar->tipe_kamar }}" 
                         class="w-full h-48 object-cover">
                    
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $kamar->tipe_kamar }}</h2>
                        <p class="text-sm text-gray-500 mb-4">
                            Kapasitas: {{ $kamar->kapasitas_tamu }} Tamu Maksimal
                        </p>
                        
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-2xl font-bold text-green-700">
                                Rp{{ number_format($kamar->harga_per_malam, 0, ',', '.') }}
                            </span>
                            <span class="text-sm font-medium text-gray-500">
                                / Malam
                            </span>
                        </div>

                        <a href="{{ route('booking.create', $kamar) }}" 
                           class="w-full block text-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                            Pesan Sekarang
                        </a>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-xl text-red-500 p-10 bg-white rounded-xl shadow-md">
                    Maaf, saat ini tidak ada kamar yang tersedia untuk dipesan.
                </p>
            @endforelse
        </div>
    </div>
</body>
</html>