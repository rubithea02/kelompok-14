<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;

class AsetController extends Controller
{
    // Menampilkan semua aset
    public function index()
    {
        $assets = Aset::with(['gudang', 'kat_asset', 'user'])->get();
        return response()->json([
            'status' => true,
            'data' => $assets
        ]);
    }

    // Menyimpan aset baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kd_gudang' => 'required|string',
            'name_assets' => 'required|string',
            'spec' => 'nullable|string',
            'tipe_asset' => 'nullable|string',
            'ip_mac' => 'nullable|string',
            'tanggal_perolehan' => 'required|date',
            'harga' => 'required|numeric',
            'serial_number' => 'required|string',
            'kd_aktiva' => 'nullable|string',
            'inout_asset' => 'required|in:in,out',
            'kat_asset_id_kat_asset' => 'required|integer',
            'Users_id_user' => 'required|integer',
        ]);

        $asset = Asset::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'Aset berhasil ditambahkan',
            'data' => $asset
        ]);
    }

    // Menampilkan detail aset
    public function show($id)
    {
        $asset = Aset::with(['gudang', 'kategori', 'user'])->findOrFail($id);
        return response()->json($asset);
    }

    // Mengupdate aset
    public function update(Request $request, $id)
    {
        $asset = Aset::findOrFail($id);

        $asset->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Aset berhasil diperbarui',
            'data' => $asset
        ]);
    }

    // Menghapus aset
    public function destroy($id)
    {
        $asset = Aset::findOrFail($id);
        $asset->delete();

        return response()->json([
            'status' => true,
            'message' => 'Aset berhasil dihapus'
        ]);
    }
}
