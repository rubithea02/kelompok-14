<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'aset'; // Nama tabel
    protected $primaryKey = 'id_asets'; // Primary key custom
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'kd_gudang',
        'name_asets',
        'spec',
        'tipe_aset',
        'harga',
        'serial_number',
        'inout_aset',
        'cover_photo',
        'tanggal_perolehan',
        'id_kat_aset',
        'id_user',
    ];

    // Optional: Format date
    protected $dates = ['tanggal_perolehan', 'deleted_at'];

    // Optional: Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Optional: Relasi ke kategori aset
    public function kategori()
    {
        return $this->belongsTo(KategoriAset::class, 'id_kat_aset');
    }
}
