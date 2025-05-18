<?php

namespace App\Http\Controllers;

use App\Models\Gudang;
use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::all();
        return view('kode_cabang', compact('gudangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kd_gudang' => 'required|string|max:4|unique:gudang,kd_gudang',
            'nama_gudang' => 'required|string|max:45',
            'alamat_gudang' => 'required|string|max:45',
            'koordinat' => 'required|string|max:45',
        ]);

        Gudang::create($request->only(['kd_gudang', 'nama_gudang', 'alamat_gudang', 'koordinat']));

        return redirect('/gudang')->with('success', 'Data cabang berhasil ditambahkan.');
    }

    public function edit($kd_gudang)
    {
        $gudangs = Gudang::all();
        $edit = Gudang::findOrFail($kd_gudang);

        return view('kode_cabang', compact('gudangs', 'edit'));
    }

    public function update(Request $request, $kd_gudang)
    {
        $request->validate([
            'nama_gudang' => 'required|string|max:45',
            'alamat_gudang' => 'required|string|max:45',
            'koordinat' => 'required|string|max:45',
        ]);

        $gudang = Gudang::findOrFail($kd_gudang);

        // Update hanya fields yang diizinkan, kd_gudang tidak berubah
        $gudang->update($request->only(['nama_gudang', 'alamat_gudang', 'koordinat']));

        return redirect('/gudang')->with('success', 'Data cabang berhasil diupdate.');
    }

    public function destroy($kd_gudang)
    {
        Gudang::destroy($kd_gudang);

        return redirect('/gudang')->with('success', 'Data cabang berhasil dihapus.');
    }
}
