<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aset;
use App\Models\TrxAset;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Status Aset Keseluruhan (baik, rusak, hilang)
        $asetStatus = Aset::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // 2. Proporsi Aset Dipinjam vs Tidak Dipinjam
        $dipinjam = TrxAset::where('trx_status', 'dipinjam')->count(); // FIXED
        $totalAset = Aset::count();
        $tersedia = $totalAset - $dipinjam;

        // 3. Distribusi Kerusakan per Kategori
        $kerusakanPerKategori = DB::table('aset')
            ->join('kat_aset', 'aset.kat_aset_id', '=', 'kat_aset.id')
            ->where('aset.status', 'rusak') // FIXED
            ->select('kat_aset.nama_kat as kategori', DB::raw('count(*) as jumlah'))
            ->groupBy('kat_aset.nama_kat')
            ->get();

        // 4. Tren Kerusakan Bulanan
        $trenBulanan = Aset::where('status', 'rusak') // FIXED
            ->select(DB::raw("DATE_FORMAT(updated_at, '%Y-%m') as bulan"), DB::raw("count(*) as rusak"))
            ->groupBy('bulan')
            ->orderBy('bulan', 'asc')
            ->limit(6)
            ->get();

        return response()->json([
            'aset_keseluruhan' => $asetStatus,
            'proporsi_dipinjam' => [
                'dipinjam' => $dipinjam,
                'tersedia' => $tersedia,
            ],
            'kerusakan_per_kategori' => $kerusakanPerKategori,
            'tren_bulanan' => $trenBulanan,
        ]);
    }
}