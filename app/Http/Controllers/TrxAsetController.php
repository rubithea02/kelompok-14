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
            'kd_cabang' => 'required|string|max:10',
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

        $trx->update($request->only([
            'kd_cabang',
            'name_asset',
            'tipe_asset',
            'serial_number',
            'kd_aktiva',
            'lokasi',
            'tanggal_keluar',
            'tanggal_kembail',
            'id_peminjam',
            'id_asets',
        ]));

        return response()->json($trx);
    }

    // DELETE: Soft delete aset "pinjam"
    public function destroy($id)
    {
        $trx = TrxAset::where('id_trx', $id)->where('trx_status', 'pinjam')->firstOrFail();
        $trx->delete();

        return response()->json(['message' => 'Data deleted successfully.']);
    }



    public function indexService()
    {
        $services = TrxAset::where('trx_status', 'service')->get();
        return response()->json($services);
    }

    public function storeService(Request $request)
    {
        $validated = $request->validate([
            'kd_cabang' => 'required|string|max:10',
            'name_asset' => 'required|string|max:30',
            'tipe_asset' => 'required|string|max:50',
            'ip_mac' => 'nullable|string|max:20',
            'serial_number' => 'required|string|max:25',
            'trx_status' => 'required|in:service',
            'kd_aktiva' => 'required|string|max:15',
            'lokasi' => 'nullable|string|max:50',
            'tanggal_keluar' => 'required|date',
            'tanggal_kembali' => 'nullable|date',
            'id_peminjam' => 'nullable|integer',
            'id_asets' => 'required|integer',
        ]);

        $validated['trx_status'] = 'service';

        $trx = TrxAset::create($validated);
        return response()->json($trx, 201);
    }

    public function updateService(Request $request, $id)
    {
        $trx = TrxAset::where('trx_status', 'service')->findOrFail($id);

        $validated = $request->validate([
            'kd_cabang' => 'sometimes|string|max:10',
            'name_asset' => 'sometimes|string|max:30',
            'tipe_asset' => 'sometimes|string|max:50',
            'ip_mac' => 'sometimes|string|max:20',
            'serial_number' => 'sometimes|string|max:25',
            'kd_aktiva' => 'sometimes|string|max:15',
            'lokasi' => 'sometimes|string|max:50',
            'tanggal_keluar' => 'sometimes|date',
            'tanggal_kembali' => 'nullable|date',
            'id_peminjam' => 'nullable|integer',
            'id_asets' => 'sometimes|integer',
        ]);

        $trx->update($validated);
        return response()->json($trx);
    }


    public function destroyService($id)
    {
        $service = TrxAset::where('trx_status', 'service')->findOrFail($id);
        $service->delete();

        return response()->json(['message' => 'Service record deleted']);
    }

}
