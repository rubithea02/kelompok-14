<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TrxAset;
use App\Models\KategoriAset;
use App\Models\User;
use App\Models\Gudang;
class Asset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aset';
    protected $primaryKey = 'id_asets';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'kd_gudang', 'name_asets', 'spec', 'tipe_aset', 'harga',
        'serial_number', 'inout_aset', 'cover_photo', 'tanggal_perolehan',
        'id_kat_aset', 'id_user'
    ];

    public function trxAssets()
    {
        return $this->hasMany(TrxAset::class, 'id_asets');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriAset::class, 'id_kat_aset');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function gudang()
    {
        return $this->belongsTo(Gudang::class, 'kd_gudang', 'kd_gudang');
    }
}
