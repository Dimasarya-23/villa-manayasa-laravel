<div class="space-y-6">
<!-- Field: Nomor Kamar -->
<div class="w-full">
<label for="nomor_kamar" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Nomor Kamar</label>
<input
type="text"
name="nomor_kamar"
id="nomor_kamar"
value="{{ old('nomor_kamar', $kamar->nomor_kamar ?? '') }}"
placeholder="Contoh: 101 atau VIP-A"
class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out @error('nomor_kamar') border-red-500 @enderror"
required
>
@error('nomor_kamar')
<p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
@enderror
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Field: Tipe Kamar (Contoh: menggunakan select dengan opsi default) -->
    <div>
        <label for="tipe_kamar" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Tipe Kamar</label>
        <select 
            name="tipe_kamar" 
            id="tipe_kamar"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out @error('tipe_kamar') border-red-500 @enderror"
            required
        >
            @php
                $selectedTipe = old('tipe_kamar', $kamar->tipe_kamar ?? '');
            @endphp
            <option value="">-- Pilih Tipe --</option>
            <option value="Standar" {{ $selectedTipe == 'Standar' ? 'selected' : '' }}>Standar</option>
            <option value="Deluxe" {{ $selectedTipe == 'Deluxe' ? 'selected' : '' }}>Deluxe</option>
            <option value="Suite" {{ $selectedTipe == 'Suite' ? 'selected' : '' }}>Suite</option>
        </select>
        @error('tipe_kamar')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Field: Harga -->
    <div>
        <label for="harga" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Harga (Per Malam)</label>
        <input 
            type="number" 
            name="harga" 
            id="harga" 
            value="{{ old('harga', $kamar->harga ?? '') }}"
            placeholder="Masukkan harga kamar (misal: 350000)"
            min="0"
            class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out @error('harga') border-red-500 @enderror"
            required
        >
        @error('harga')
            <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

<!-- Field: Status (Contoh: menggunakan radio button atau select) -->
<div class="w-full">
    <label class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-2">Status Kamar</label>
    @php
        // Default status for new room is 'Tersedia' (Available)
        $selectedStatus = old('status', $kamar->status ?? 'Tersedia');
    @endphp

    <div class="flex flex-wrap gap-4">
        @foreach (['Tersedia', 'Terisi', 'Perbaikan'] as $statusOption)
            <label class="inline-flex items-center cursor-pointer">
                <input 
                    type="radio" 
                    name="status" 
                    value="{{ $statusOption }}" 
                    {{ $selectedStatus == $statusOption ? 'checked' : '' }}
                    class="form-radio h-4 w-4 text-teal-600 border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-teal-500 transition duration-150 ease-in-out"
                >
                <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ $statusOption }}</span>
            </label>
        @endforeach
    </div>
    
    @error('status')
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
    @enderror
</div>

<!-- Field: Deskripsi (Opsional) -->
<div class="w-full">
    <label for="deskripsi" class="block font-medium text-sm text-gray-700 dark:text-gray-300 mb-1">Deskripsi / Fasilitas</label>
    <textarea 
        name="deskripsi" 
        id="deskripsi" 
        rows="4" 
        placeholder="Jelaskan fasilitas utama atau detail khusus kamar ini..."
        class="mt-1 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 shadow-sm focus:border-teal-500 focus:ring-teal-500 transition duration-150 ease-in-out @error('deskripsi') border-red-500 @enderror"
    >{{ old('deskripsi', $kamar->deskripsi ?? '') }}</textarea>
    @error('deskripsi')
        <p class="text-sm text-red-600 dark:text-red-400 mt-1">{{ $message }}</p>
    @enderror
</div>


</div>