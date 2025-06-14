<?php

namespace App\Http\Controllers;

use App\Models\Aset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class AssetController extends Controller
{
    public function index()
    {
        return response()->json(Aset::all(), 200);
    }

    public function store(Request $request)
    {
        \Log::info('Request received', $request->all());
        $validator = Validator::make($request->all(), [
            'kd_gudang' => 'required|string|max:4',
            'name_asets' => 'required|string|max:30',
            'spec' => 'required|string',
            'tipe_aset' => 'required|string|max:50',
            'harga' => 'required|numeric',
            'serial_number' => 'required|string|max:25',
            'inout_aset' => 'required|in:in,out',
            'cover_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'tanggal_perolehan' => 'required|date',
            'id_kat_aset' => 'required|integer',
            'id_user' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $path = null;
        if ($request->hasFile('cover_photo')) {
            $path = $request->file('cover_photo')->store('cover_photos', 'public');
        }

        $aset = Aset::create([
            ...$request->except('cover_photo'),
            'cover_photo' => $path,
        ]);

        return response()->json($aset, 201);
    }

    public function show($id)
    {
        $aset = Aset::find($id);
        return $aset ? response()->json($aset) : response()->json(['message' => 'Not Found'], 404);
    }

    public function update(Request $request, $id)
    {
        $aset = Aset::find($id);
        if (!$aset) return response()->json(['message' => 'Not Found'], 404);

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

        $data = $request->all();

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
        if (!$aset) return response()->json(['message' => 'Not Found'], 404);

        if ($aset->cover_photo && Storage::disk('public')->exists($aset->cover_photo)) {
            Storage::disk('public')->delete($aset->cover_photo);
        }

        $aset->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
