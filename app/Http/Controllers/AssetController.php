<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class AssetController extends Controller
{
    public function index()
    {
        return response()->json(Aset::all(), 200);
    }

    public function store(Request $request)
    {
        // Logging hanya data penting (jangan log semua input mentah)
        Log::info('Storing new Aset', [
            'name_asets' => $request->input('name_asets'),
            'serial_number' => $request->input('serial_number'),
            'user_id' => $request->input('id_user')
        ]);

        // Validasi data
        $validator = Validator::make($request->all(), [
            'kd_gudang' => 'required|string|max:4',
            'name_asets' => 'required|string|max:30',
            'spec' => 'required|string',
            'tipe_aset' => 'required|string|max:50',
            'harga' => 'required|numeric',
            'serial_number' => 'required|string|max:25|unique:asets,serial_number',
            'inout_aset' => 'required|in:in,out',
            'cover_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_perolehan' => 'required|date',
            'id_kat_aset' => 'required|integer|exists:kat_asets,id',
            'id_user' => 'required|integer|exists:users,id',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        // Simpan file cover foto
        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('cover_photos', 'public');
        } else {
            return response()->json([
                'error' => 'File cover_photo tidak ditemukan.'
            ], 400);
        }

        // Simpan ke database
        $aset = Aset::create([
            'kd_gudang' => $request->kd_gudang,
            'name_asets' => $request->name_asets,
            'spec' => $request->spec,
            'tipe_aset' => $request->tipe_aset,
            'harga' => $request->harga,
            'serial_number' => $request->serial_number,
            'inout_aset' => $request->inout_aset,
            'cover_photo' => $path,
            'tanggal_perolehan' => $request->tanggal_perolehan,
            'id_kat_aset' => $request->id_kat_aset,
            'id_user' => $request->id_user,
        ]);

        return response()->json([
            'message' => 'Aset berhasil disimpan.',
            'data' => $aset
        ], 201);
    }

    public function show($id)
    {
        $aset = Aset::with('gudang')->find($id);

        if (!$aset) {
            return response()->json(['message' => 'Aset tidak ditemukan'], 404);
        }

        return response()->json($aset);
    }


    public function update(Request $request, $id)
    {
        $aset = Aset::find($id);
        if (!$aset) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'kd_gudang' => 'sometimes|required|string|max:4',
            'name_asets' => 'sometimes|required|string|max:30',
            'spec' => 'sometimes|required|string',
            'tipe_aset' => 'sometimes|required|string|max:50',
            'harga' => 'sometimes|required|numeric',
            'serial_number' => 'sometimes|required|string|max:25',
            'inout_aset' => 'sometimes|required|in:in,out',
            'cover_photo' => 'sometimes|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_perolehan' => 'sometimes|required|date',
            'id_kat_aset' => 'sometimes|required|integer',
            'id_user' => 'sometimes|required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $data = $request->except('cover_photo');

        if ($request->hasFile('cover_photo')) {
            if ($aset->cover_photo && Storage::disk('public')->exists($aset->cover_photo)) {
                Storage::disk('public')->delete($aset->cover_photo);
            }

            $data['cover_photo'] = $request->file('cover_photo')->store('cover_photos', 'public');
        }

        $aset->update($data);

        return response()->json($aset);
    }

    public function destroy($id)
    {
        $aset = Aset::find($id);
        if (!$aset) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        if ($aset->cover_photo && Storage::disk('public')->exists($aset->cover_photo)) {
            Storage::disk('public')->delete($aset->cover_photo);
        }

        $aset->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
