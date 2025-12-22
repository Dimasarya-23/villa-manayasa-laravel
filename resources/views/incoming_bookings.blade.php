@extends('layouts.villa')

@section('content')

    {{-- Hanya untuk Admin dan Staff --}}
    @if (Auth::user()->role === 'admin' || Auth::user()->role === 'Staff')

        <div class="p-6 bg-gray-100 min-h-screen">
            <div class="max-w-7xl mx-auto">
                
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-800">Tugas Persiapan Kamar (3 Hari Mendatang)</h1>
                    <span class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold shadow-md">
                        Total {{ $incomingBookings->count() }} Pemesanan
                    </span>
                </div>

                <p class="text-gray-600 mb-8">
                    Ini adalah daftar pemesanan terkonfirmasi yang akan check-in dalam 3 hari ke depan. Pastikan semua kamar ditandai sebagai 'Siap' sebelum batas waktu check-in.
                </p>

                {{-- Mock Data Mapping: Sesuaikan dengan data asli Anda --}}
                @php
                    // Data warna yang konsisten dengan Dashboard Anda
                    $statusColors = [
                        'Pending' => 'bg-yellow-100 text-yellow-800',
                        'Pembersihan' => 'bg-blue-100 text-blue-800',
                        'Siap' => 'bg-green-100 text-green-800',
                        'Maintenance' => 'bg-red-100 text-red-800',
                    ];
                @endphp

                @if ($incomingBookings->isEmpty())
                    <div class="text-center p-10 bg-white rounded-xl shadow-lg border border-gray-200">
                        <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.103a2.007 2.007 0 00-1.239-1.341C16.883 4.226 15.53 4 14 4a6 6 0 00-6 6c0 1.258.375 2.476 1.077 3.498L5 17h14l-2.923-4.502c.702-1.022 1.077-2.24 1.077-3.498a6 6 0 00-6-6z"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-700">Area Villa Tenang!</h3>
                        <p class="text-gray-500">Tidak ada pemesanan yang akan check-in dalam 3 hari ke depan. Semua kamar sedang santai.</p>
                    </div>
                @else
                    
                    <div class="bg-white shadow-xl rounded-xl overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kamar & Tamu</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Check-in / Check-out</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Persiapan</th>
                                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($incomingBookings as $booking)
                                    <tr>
                                        {{-- Kolom Kamar & Tamu --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->kamar->room_number ?? 'N/A' }} ({{ $booking->kamar->tipe_kamar ?? 'Dihapus' }})</div>
                                            <div class="text-xs text-gray-500 font-semibold">{{ $booking->nama_tamu ?? 'Tamu Unknown' }}</div>
                                            <div class="text-xs text-indigo-500">ID #{{ $booking->id }}</div>
                                        </td>
                                        
                                        {{-- Kolom Check-in/out --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <p><i class="fas fa-sign-in-alt text-green-500 mr-2"></i> {{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }}</p>
                                            <p><i class="fas fa-sign-out-alt text-red-500 mr-2"></i> {{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }}</p>
                                        </td>

                                        {{-- Kolom Durasi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ \Carbon\Carbon::parse($booking->check_in_date)->diffInDays($booking->check_out_date) }} Malam
                                        </td>

                                        {{-- Kolom Status Persiapan (ACTIONABLE) --}}
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                // Asumsi $booking->preparation_status tersedia, jika tidak, default ke 'Pending'
                                                $status = $booking->preparation_status ?? 'Pending';
                                            @endphp
                                            <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $status }}
                                            </span>
                                        </td>

                                        {{-- Kolom Aksi --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('bookings.show', $booking->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Detail</a>
                                            {{-- Contoh Tombol Aksi Update Status --}}
                                            <button 
                                                class="text-sm text-yellow-600 hover:text-yellow-800"
                                                onclick="updateStatus({{ $booking->id }}, 'Siap')"
                                            >
                                                <i class="fas fa-check-circle"></i> Tandai Siap
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Script Mock untuk Update Status --}}
        <script>
            function updateStatus(bookingId, newStatus) {
                // Di sini Anda akan menggunakan AJAX (misalnya Axios atau Fetch) untuk memanggil Controller Laravel
                console.log(`Mengirim permintaan update status untuk Booking ID: ${bookingId} menjadi ${newStatus}`);
                
                // Peringatan ini harus diganti dengan modal/notifikasi Toast di lingkungan produksi
                alert(`Status Booking #${bookingId} diperbarui menjadi ${newStatus}. (Ini hanya simulasi)`);

                // Dalam implementasi nyata, Anda akan memiliki kode seperti ini:
                /*
                fetch('/api/bookings/' + bookingId + '/status', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Pastikan token CSRF terkirim
                    },
                    body: JSON.stringify({ status: newStatus })
                })
                .then(response => response.json())
                .then(data => {
                    // Refresh halaman atau update baris tabel secara dinamis
                    window.location.reload(); 
                })
                .catch(error => {
                    console.error('Error updating status:', error);
                });
                */
            }
        </script>

    @else
        
        {{-- Tampilan Akses Ditolak --}}
        <div class="text-center p-10">
            <h1 class="text-2xl font-bold text-red-500">Akses Ditolak</h1>
            <p class="text-gray-600">Anda tidak memiliki izin untuk mengakses halaman manajemen ini.</p>
        </div>
        
    @endif

@endsection