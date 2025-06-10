<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrxAset extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id_trx';

    protected $table = 'trx_asets';

    protected $fillable = [
        'kd_cabang',
        'name_asset',
        'tipe_asset',
        'ip_mac',
        'serial_number',
        'trx_status',
        'kd_aktiva',
        'lokasi',
        'tanggal_keluar',
        'tanggal_kembali',
        'id_peminjam',
        'id_asets',
    ];

    protected $dates = ['deleted_at'];


    public function peminjam()
    {
        return $this->belongsTo(Peminjam::class, 'id_peminjam');
    }

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_asets');
    }
}
