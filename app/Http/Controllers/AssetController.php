<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        $assets = Asset::with(['trxAssets', 'kategori', 'user', 'gudang'])
            ->where('inout_aset', 'in')
            ->get();

        return response()->json($assets);
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $asset = Asset::create($validated);

        return response()->json($asset, 201);
    }

    public function show(Asset $asset)
    {
        if ($asset->inout_aset !== 'in') {
            return response()->json(['message' => 'Aset tidak ditemukan'], 404);
        }

        $asset->load(['trxAssets', 'kategori', 'user', 'gudang']);

        return response()->json($asset);
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $this->validateData($request);

        $asset->update($validated);

        return response()->json($asset);
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();

        return response()->json(['message' => 'Aset berhasil dihapus']);
    }

    protected function validateData(Request $request)
    {
        return $request->validate([
            'kd_gudang' => 'required|string|max:4',
            'name_asets' => 'required|string|max:30',
            'spec' => 'required',
            'tipe_aset' => 'required|string|max:50',
            'harga' => 'required|numeric',
            'serial_number' => 'required|string|max:25',
            'inout_aset' => 'required|in:in,out',
            'cover_photo' => 'required|string',
            'tanggal_perolehan' => 'required|date',
            'id_kat_aset' => 'required|integer',
            'id_user' => 'required|integer',
        ]);
    }
}
