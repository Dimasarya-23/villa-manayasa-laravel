<!DOCTYPE html>

<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Instruksi Pembayaran Pemesanan #{{ $booking->id }}</title>
<script src="https://cdn.tailwindcss.com"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }

/* Styling baru untuk badge angka di dalam judul */
.instruction-number-badge {
    /* Menggunakan background sesuai warna langkah */
    @apply flex items-center justify-center w-8 h-8 text-white text-lg font-extrabold rounded-full shadow-md flex-shrink-0;
}
/* Menghapus semua CSS counter sebelumnya */
</style>
</head>
<body class="min-h-screen">

<div class="max-w-4xl mx-auto p-4 lg:p-10">
    <div class="bg-white rounded-xl shadow-2xl p-8 lg:p-12 border-t-8 border-blue-600">
        
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Berhasil!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="text-center mb-10">
            <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Pemesanan Berhasil Dibuat!</h1>
            <p class="text-xl text-gray-600">Langkah selanjutnya adalah menyelesaikan pembayaran.</p>
        </div>

        <!-- Ringkasan Pemesanan -->
        <div class="mb-10 p-6 bg-blue-50 rounded-lg border border-blue-200 shadow-inner">
            <h2 class="text-2xl font-bold text-blue-800 mb-4 border-b pb-2 border-blue-300">Ringkasan Pemesanan</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg">
                <p><span class="font-semibold text-gray-700">Nomor Booking:</span> <span class="text-blue-600 font-extrabold">#{{ $booking->id }}</span></p>
                <p><span class="font-semibold text-gray-700">Tamu Utama:</span> {{ $booking->guest_name }}</p>
                <p><span class="font-semibold text-gray-700">Tipe Kamar:</span> {{ $booking->kamar->tipe_kamar }}</p>
                <p><span class="font-semibold text-gray-700">Tanggal Check-in:</span> {{ \Carbon\Carbon::parse($booking->check_in_date)->isoFormat('D MMMM Y') }}</p>
                <p><span class="font-semibold text-gray-700">Tanggal Check-out:</span> {{ \Carbon\Carbon::parse($booking->check_out_date)->isoFormat('D MMMM Y') }}</p>
                <p><span class="font-semibold text-gray-700">Total Harga:</span> <span class="text-red-600 font-bold">Rp{{ number_format($booking->total_price, 0, ',', '.') }}</span></p>
            </div>
        </div>

        <!-- Instruksi Pembayaran -->
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Instruksi Pembayaran (Deposit)</h2>

        <!-- FIX: Menggunakan tata letak baru yang terintegrasi -->
        <div class="space-y-8">
            
            <!-- Langkah 1: Transfer DP -->
            <!-- FIX: Layout diperbaiki dengan p-6 dan border kiri yang tebal -->
            <div class="p-6 bg-yellow-50 rounded-xl shadow-lg border-l-8 border-yellow-500">
                <h3 class="text-2xl font-extrabold text-gray-800 mb-3 flex items-center">
                    <span class="instruction-number-badge bg-yellow-500 mr-3">1</span>
                    Transfer Down Payment (DP)
                </h3>
                <p class="text-gray-700 mb-3">
                    Total harga pemesanan Anda adalah **Rp{{ number_format($booking->total_price, 0, ',', '.') }}**. 
                    Mohon lakukan transfer Down Payment (DP) sebesar **50%** dari total harga untuk mengunci pemesanan Anda.
                </p>
                
                <div class="bg-yellow-100 p-4 rounded-lg border border-yellow-300 inline-block">
                    <p class="text-lg font-bold text-yellow-900">Jumlah DP Wajib (50%):</p>
                    <p class="text-3xl font-extrabold text-red-700">Rp{{ number_format($dpAmount, 0, ',', '.') }}</p>
                </div>
                
                <p class="text-sm text-red-600 mt-2 font-semibold">Batas Waktu Pembayaran: <span class="font-bold">{{ \Carbon\Carbon::now()->addHours(2)->isoFormat('HH:mm, D MMMM Y') }}</span></p>
                <p class="text-sm text-gray-500 mt-1">*Pemesanan akan otomatis dibatalkan jika DP tidak diterima setelah batas waktu.</p>
            </div>

            <!-- Langkah 2: Detail Rekening -->
            <div class="p-6 bg-blue-50 rounded-xl shadow-lg border-l-8 border-blue-600">
                <h3 class="text-2xl font-extrabold text-gray-800 mb-3 flex items-center">
                    <span class="instruction-number-badge bg-blue-600 mr-3">2</span>
                    Gunakan Rekening Transfer Ini
                </h3>
                <div class="bg-blue-100 p-4 rounded-lg border border-blue-300 space-y-2">
                    <p class="text-2xl font-extrabold text-blue-900 flex items-center">
                        <!-- Icon BCA sederhana -->
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm1 14.776V7.224h-2V16.776h2zm-4.776-4.776l-1.01-1.01 1.01-1.01-1.01-1.01 1.01-1.01 1.01 1.01 1.01-1.01 1.01 1.01 1.01-1.01 1.01 1.01-1.01 1.01 1.01 1.01z"/></svg>
                        Bank Central Asia (BCA)
                    </p>
                    <p class="text-lg font-semibold text-gray-800">No. Rekening:</p>
                    <p class="text-3xl font-extrabold text-green-700" id="bca-number">6755476882</p>
                    <p class="text-lg font-semibold text-gray-800">Atas Nama: Dimas Arya Pratama</p>
                    <button type="button" onclick="copyToClipboard('bca-number')" class="text-sm text-blue-600 hover:text-blue-800 underline">Salin Nomor Rekening</button>
                </div>
            </div>

            <!-- Langkah 3: Konfirmasi Pembayaran -->
            <div class="p-6 bg-green-50 rounded-xl shadow-lg border-l-8 border-green-500">
                <h3 class="text-2xl font-extrabold text-gray-800 mb-3 flex items-center">
                    <span class="instruction-number-badge bg-green-500 mr-3">3</span>
                    Konfirmasi Pembayaran via WhatsApp
                </h3>
                <p class="text-gray-700 mb-3">Setelah transfer DP berhasil, segera konfirmasi pembayaran Anda dengan mengirimkan bukti transfer ke:</p>
                
                <a href="https://wa.me/6281234567890?text=Halo%20saya%20sudah%20transfer%20DP%20untuk%20booking%20%23{{ $booking->id }}.%20Mohon%20dicek." 
                    class="inline-flex items-center space-x-2 text-xl font-extrabold text-white bg-green-500 hover:bg-green-600 px-6 py-3 rounded-xl transition duration-200 shadow-lg transform hover:scale-[1.02]"
                    target="_blank">
                    <!-- Icon WhatsApp -->
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12.001 0C6.159 0 1.625 4.536 1.625 10.378c0 1.815.485 3.52 1.378 5.013l-1.42 4.908 5.045-1.332c1.41.776 3.012 1.189 4.373 1.189 5.842 0 10.375-4.535 10.375-10.378C22.375 4.536 17.842 0 12.001 0zm0 18.917c-1.424 0-2.822-.444-4.008-1.295l-.286-.17-.306.081-3.175.839.849-3.086-.195-.31c-.933-1.488-1.422-3.197-1.422-4.974 0-4.99 4.076-9.066 9.066-9.066 4.991 0 9.066 4.076 9.066 9.066 0 4.99-4.075 9.066-9.066 9.066z"></path><path d="M16.92 13.567c-.207-.104-1.22-.601-1.411-.67-.191-.07-.33-.105-.471.105-.141.209-.542.67-.665.808-.124.138-.246.155-.456.052-.21-.104-.88-.323-1.673-1.034-.619-.556-1.036-1.243-1.161-1.46-.124-.216-.013-.335.091-.437.086-.084.191-.209.294-.313.104-.105.139-.175.209-.292.07-.118.035-.221-.018-.327-.052-.104-.471-1.135-.644-1.554-.173-.418-.346-.36-.47-.367-.124-.006-.265-.008-.405-.008.016.038.032.07.032.106.006.115-.028.24-.044.354-.035.251-.106.634-.106 1.025 0 2.05 1.503 3.993 3.486 4.887 1.983.894 4.198.665 4.864.558.156-.027.424-.174.557-.279.132-.105.21-.318.106-.527-.104-.21-.338-.337-.48-.41z"></path></svg>
                    <span>WhatsApp (0812-3456-7890)</span>
                </a>
            </div>

            <!-- Langkah 4: Pelunasan -->
            <div class="p-6 bg-gray-50 rounded-xl shadow-lg border-l-8 border-gray-500">
                <h3 class="text-2xl font-extrabold text-gray-800 mb-3 flex items-center">
                    <span class="instruction-number-badge bg-gray-500 mr-3">4</span>
                    Pelunasan Sisa Pembayaran
                </h3>
                <p class="text-gray-700">Sisa pembayaran sebesar 
                    <!-- Perhitungan Sisa Pembayaran -->
                    <span class="font-bold text-xl text-blue-600">Rp{{ number_format($booking->total_price - $dpAmount, 0, ',', '.') }}</span> 
                    akan dibayarkan secara tunai pada saat Anda Check-in di lokasi.
                </p>
                <p class="text-sm text-gray-500 mt-1">*Pelunasan di tempat hanya menerima pembayaran tunai.</p>
            </div>
        </div>

        <div class="mt-12 pt-6 border-t border-gray-200 flex justify-center">
             <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-xl shadow-lg transition duration-200 text-lg flex items-center space-x-2">
                 <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                 <span>Kembali ke Dashboard</span>
             </a>
        </div>
        
    </div>
</div>

<script>
    // Fungsi untuk menyalin teks (dipertahankan dari kode Anda, dengan perbaikan alert)
    function copyToClipboard(elementId) {
        // Hapus spasi dan pastikan hanya angka yang disalin
        const textToCopy = document.getElementById(elementId).innerText.replace(/\s/g, ''); 
        
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(() => {
                showCustomMessage('Nomor rekening berhasil disalin!');
            }).catch(err => {
                fallbackCopyTextToClipboard(textToCopy);
            });
        } else {
            fallbackCopyTextToClipboard(textToCopy);
        }
    }
    
    function fallbackCopyTextToClipboard(text) {
        const textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed"; 
        textArea.style.opacity = 0; 
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            const successful = document.execCommand('copy');
            if (successful) {
                showCustomMessage('Nomor rekening berhasil disalin!');
            } else {
                showCustomMessage('Gagal menyalin. Silakan salin manual.');
            }
        } catch (err) {
            showCustomMessage('Gagal menyalin. Silakan salin manual.');
        }
        document.body.removeChild(textArea);
    }
    
    // Custom function untuk menggantikan alert()
    function showCustomMessage(message) {
        let msgBox = document.createElement('div');
        msgBox.className = 'fixed bottom-5 right-5 bg-gray-800 text-white p-3 rounded-xl shadow-2xl transition-opacity duration-300 opacity-0 z-50';
        msgBox.innerText = message;
        document.body.appendChild(msgBox);
        
        // Animasi fade in
        setTimeout(() => msgBox.style.opacity = 1, 10);
        
        // Animasi fade out
        setTimeout(() => {
            msgBox.style.opacity = 0;
            setTimeout(() => msgBox.remove(), 300);
        }, 3000);
    }
</script>


</body>
</html>