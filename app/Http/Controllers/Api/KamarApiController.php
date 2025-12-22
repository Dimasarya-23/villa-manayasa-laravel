<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KamarApiController extends Controller
{
    // 1. GET: Menampilkan daftar kamar
    public function index()
    {
        $kamars = Kamar::all();
        return response()->json([
            'status' => true,
            'message' => 'Data kamar berhasil diambil',
            'data' => $kamars
        ], 200);
    }

    // 2. POST: Menambah kamar baru
    public function store(Request $request)
    {
        // Pastikan baris di bawah ini diawali dengan $validator dan baris sebelumnya sudah ada ;
        $validator = Validator::make($request->all(), [
            'tipe_kamar'      => 'required|string|max:50',
            'harga_per_malam' => 'required|numeric|min:0',
            'status'          => 'required|in:Available,Occupied,Cleaning,Maintenance',
            'kapasitas_tamu'  => 'required|integer|min:1',
        ], [
            'required' => ':attribute wajib diisi.',
            'in'       => 'Status tidak valid.',
            'numeric'  => 'Harga harus angka.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi gagal',
                'errors'  => $validator->errors()
            ], 400);
        }

        $kamar = Kamar::create($request->all());

        return response()->json([
            'status'  => true,
            'message' => 'Produk (Kamar) berhasil ditambahkan',
            'data'    => $kamar
        ], 201);
    }

    // 3. DELETE: Menghapus data
    public function destroy($id)
    {
        $kamar = Kamar::find($id);

        if (!$kamar) {
            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan',
                'data'    => null
            ], 404);
        }

        $kamar->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Produk (Kamar) berhasil dihapus',
            'data'    => null
        ], 200);
    }
}