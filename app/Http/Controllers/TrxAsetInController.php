<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\TrxAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxAsetInController extends Controller
{
    // GET: Menampilkan semua aset dengan status "in"
    public function index()
    {
        $data = Aset::where('inout_aset', 'in')->get();
        return response()->json($data);
    }

    // POST: Menambahkan transaksi aset keluar (pinjam)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kd_cabang' => ['required', 'string', 'max:10'],
            'name_asset' => 'required|string|max:30',
            'tipe_asset' => 'required|string|max:50',
            'serial_number' => 'required|string|max:25',
            'kd_aktiva' => 'required|string|max:15',
            'lokasi' => 'required|string|max:50',
            'id_peminjam' => 'required|integer',
            'id_asets' => 'required|integer',
        ]);

        // Tambahkan status transaksi dan tanggal keluar otomatis
        $validated['trx_status'] = 'out';
        $validated['tanggal_keluar'] = now();

        // Transaksi database untuk menjaga konsistensi
        DB::beginTransaction();

        try {
            // Simpan transaksi
            $trx = TrxAset::create($validated);

            // Update aset menjadi 'out'
            Aset::where('id_asets', $validated['id_asets'])
                ->update(['inout_aset' => 'out']);

            DB::commit();
            return response()->json($trx, 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Gagal menyimpan transaksi.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
