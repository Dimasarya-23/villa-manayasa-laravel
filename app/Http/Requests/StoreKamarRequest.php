<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKamarRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        // Ganti menjadi true jika otorisasi sudah diurus di middleware
        return true; 
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Tentukan ID kamar saat ini jika ini adalah permintaan 'update'
        $kamarId = $this->route('kamar') ? $this->route('kamar')->id : null;

        return [
            // Nomor kamar harus unik, tetapi abaikan kamar saat ini saat update
            'nomor_kamar' => [
                'required',
                'string',
                'max:20',
                // Rule untuk memastikan nomor kamar unik di tabel 'kamars'
                // Saat update, abaikan ID kamar yang sedang diedit
                'unique:kamars,nomor_kamar,' . $kamarId,
            ],
            'tipe_kamar' => [
                'required',
                'string',
                'in:Standar,Deluxe,Suite', // Hanya izinkan tipe yang valid
            ],
            'harga' => [
                'required',
                'integer',
                'min:10000', // Harga minimal 10 ribu
            ],
            'status' => [
                'required',
                'string',
                'in:Tersedia,Terisi,Perbaikan', // Hanya izinkan status yang valid
            ],
            'deskripsi' => [
                'nullable',
                'string',
                'max:500',
            ],
        ];
    }
    
    /**
     * Dapatkan nama atribut kustom untuk error yang ditentukan.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nomor_kamar' => 'Nomor Kamar',
            'tipe_kamar' => 'Tipe Kamar',
            'harga' => 'Harga',
            'status' => 'Status',
            'deskripsi' => 'Deskripsi',
        ];
    }
}