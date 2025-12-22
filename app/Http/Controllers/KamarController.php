<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kamar;
// use Illuminate\Support\Facades\DB; 

class KamarController extends Controller
{
    /**
     * Tampilkan daftar kamar dengan fitur pencarian, filter status, dan statistik.
     */
    public function index(Request $request)
    {
        $stats = [
            'total_units' => Kamar::count(),
            'available'   => Kamar::where('status', 'Available')->count(),
            'occupied'    => Kamar::where('status', 'Occupied')->count(),
            'cleaning'    => Kamar::where('status', 'Cleaning')->count(),
            'maintenance' => Kamar::where('status', 'Maintenance')->count(),
            'other'       => Kamar::whereNotIn('status', ['Available', 'Occupied', 'Cleaning', 'Maintenance'])->count(),
        ];

        $query = Kamar::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                // Asumsi kolom 'tipe_kamar' dan 'nomor_kamar' ada untuk pencarian
                $q->where('tipe_kamar', 'like', "%{$search}%")
                  ->orWhere('nomor_kamar', 'like', "%{$search}%"); 
            });
        }

        if ($statusFilter = $request->get('status_filter')) {
            if ($statusFilter === 'Closed') {
                $query->whereNotIn('status', ['Available', 'Occupied', 'Cleaning', 'Maintenance']);
            } else {
                $query->where('status', $statusFilter);
            }
        }
        
        $kamars = $query->orderBy('id', 'asc')->paginate(10)->withQueryString(); 

        return view('kamar.index', [
            'kamars' => $kamars,
            'stats'  => $stats,
        ]);
    }
    
    public function create()
    {
        return view('kamar.create');
    }

    /**
     * Menyimpan kamar yang baru dibuat ke database.
     * Perbaikan: Mengabaikan 'nomor_kamar' dari validasi dan penyimpanan sementara.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk. Hapus validasi 'nomor_kamar' sementara.
        $request->validate([
            // 'nomor_kamar' => 'required|string|max:10|unique:kamars,nomor_kamar', // DIHILANGKAN SEMENTARA
            'tipe_kamar' => 'required|string|max:255',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Available,Occupied,Cleaning,Maintenance,Closed',
            'kapasitas_tamu' => 'required|integer|min:1', 
        ]);

        // 2. Ambil semua data, KECUALIKAN 'nomor_kamar' agar tidak ada error SQL.
        $dataToCreate = $request->except(['nomor_kamar']);

        Kamar::create($dataToCreate);

        return redirect()->route('kamar.index')->with('success', 'Kamar baru berhasil ditambahkan! (Nomor kamar diabaikan sementara).');
    }

    public function edit(Kamar $kamar)
    {
        return view('kamar.edit', compact('kamar'));
    }

    /**
     * Memperbarui kamar yang ditentukan di database.
     * Perbaikan: Memastikan 'nomor_kamar' diabaikan dari update.
     */
    public function update(Request $request, Kamar $kamar)
    {
        // PERBAIKAN KRITIS: Mempertahankan validasi tanpa 'nomor_kamar'.
        $request->validate([
            'tipe_kamar' => 'required|string|max:255',
            'harga_per_malam' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|in:Available,Occupied,Cleaning,Maintenance,Closed',
            'kapasitas_tamu' => 'required|integer|min:1', 
        ]);

        // Ambil semua data dari request, lalu KECUALIKAN 'nomor_kamar'
        // agar tidak terjadi error karena kolom tersebut tidak ada di DB (atau tidak boleh diubah).
        $dataToUpdate = $request->except(['nomor_kamar']);
        
        $kamar->update($dataToUpdate);

        return redirect()->route('kamar.index')->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroy(Kamar $kamar)
    {
        $kamar->delete();

        return redirect()->route('kamar.index')->with('success', 'Kamar berhasil dihapus.');
    }
}