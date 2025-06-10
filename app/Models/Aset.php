<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use SoftDeletes;

    protected $table = 'assets';
    protected $primaryKey = 'id_assets';

    protected $fillable = [
        'kd_gudang',
        'name_assets',
        'spec',
        'tipe_asset',
        'ip_mac',
        'tanggal_perolehan',
        'harga',
        'serial_number',
        'kd_aktiva',
        'inout_asset',
        'kat_asset_id_kat_asset',
        'Users_id_user',
    ];

    // Relasi ke Gudang
    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'kd_gudang', 'kd_gudang');
    }

    // Relasi ke Kategori Aset
    public function kategori()
    {
        return $this->belongsTo(KategoriAset::class, 'kat_asset_id_kat_asset');
    }

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'Users_id_user');
    }

    // Relasi ke Transaksi Aset
    public function transaksi()
    {
        return $this->hasMany(TrxAset::class, 'id_assets');
    }
}
