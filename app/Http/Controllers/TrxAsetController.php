<?php

namespace App\Http\Controllers;

use App\Models\TrxAset;
use Illuminate\Http\Request;

class TrxAsetController extends Controller
{
    // GET: Menampilkan semua aset dengan status "pinjam"
    public function index()
    {
        $data = TrxAset::where('trx_status', 'pinjam')->get();
        return response()->json($data);
    }

    // POST: Menambahkan aset baru dengan status "pinjam"
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kd_cabang' => ['required', 'string', 'size:4', 'regex:/^[A-Za-z0-9]{4}$/'],
            'name_asset' => 'required|string|max:30',
            'tipe_asset' => 'required|string|max:50',
            'serial_number' => 'required|string|max:25',
            'kd_aktiva' => 'required|string|max:15',
            'lokasi' => 'required|string|max:50',
            'tanggal_keluar' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'id_peminjam' => 'required|integer',
            'id_asets' => 'required|integer',
        ]);

        $validated['trx_status'] = 'pinjam';

        $trx = TrxAset::create($validated);
        return response()->json($trx, 201);
    }

    // PUT: Update data berdasarkan ID dan status pinjam
    public function update(Request $request, $id)
    {
        $trx = TrxAset::where('id_trx', $id)->where('trx_status', 'pinjam')->firstOrFail();

        $validated = $request->validate([
            'kd_cabang' => ['required', 'string', 'size:4', 'regex:/^[A-Za-z0-9]{4}$/'],
            'name_asset' => 'required|string|max:30',
            'tipe_asset' => 'required|string|max:50',
            'serial_number' => 'required|string|max:25',
            'kd_aktiva' => 'required|string|max:15',
            'lokasi' => 'required|string|max:50',
            'tanggal_keluar' => 'nullable|date',
            'tanggal_kembali' => 'nullable|date',
            'id_peminjam' => 'required|integer',
            'id_asets' => 'required|integer',
        ]);

        $trx->update($validated);

        return response()->json($trx);
    }

    // DELETE: Soft delete aset "pinjam"
    public function destroy($id)
    {
        $trx = TrxAset::where('id_trx', $id)->where('trx_status', 'pinjam')->firstOrFail();
        $trx->delete();

        return response()->json(['message' => 'Data deleted successfully.']);
    }
}
