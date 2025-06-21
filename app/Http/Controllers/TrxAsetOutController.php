<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use App\Models\TrxAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxAsetOutController extends Controller
{
    // GET: Menampilkan semua aset yang statusnya "out"
    public function index()
    {
        $data = TrxAset::where('trx_status', 'out')
                        ->whereNull('tanggal_kembali')
                        ->get();

        return response()->json($data);
    }

    // POST: Proses pengembalian aset, ubah status transaksi ke "out"
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_trx' => 'required|exists:trx_asets,id_trx',
        ]);

        DB::beginTransaction();

        try {
            $trx = TrxAset::findOrFail($validated['id_trx']);

            // Update transaksi jadi "in" dan isi tanggal kembali
            $trx->update([
                'trx_status' => 'in',
                'tanggal_kembali' => now(),
            ]);

            // Update status aset jadi "in"
            Aset::where('id_asets', $trx->id_asets)
                ->update(['inout_aset' => 'in']);

            DB::commit();
            return response()->json(['message' => 'Aset berhasil dikembalikan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'error' => 'Gagal mengembalikan aset.',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
