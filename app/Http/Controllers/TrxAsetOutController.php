<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrxAsetOutController extends Controller
{
    public function index()
    {
        try {
            $data = DB::table('trx_asets')
                ->join('aset', 'trx_asets.id_asets', '=', 'aset.id_asets')
                ->join('peminjam', 'trx_asets.id_peminjam', '=', 'peminjam.id_peminjam')
                ->where('trx_asets.trx_status', 'out')
                ->whereNull('trx_asets.tanggal_kembali')
                ->select(
                    'trx_asets.id_trx',
                    'trx_asets.tanggal_keluar',
                    'trx_asets.trx_status',
                    'aset.name_asets',
                    'aset.tipe_aset',
                    'aset.serial_number',
                    'trx_asets.lokasi',
                    'aset.kd_gudang',
                    'peminjam.nama_karyawan',
                    'peminjam.nik_karyawan'
                )
                ->get();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan saat mengambil data.'], 500);
        }
    }
}
