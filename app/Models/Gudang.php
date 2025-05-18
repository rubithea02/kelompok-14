<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gudang extends Model
{
    protected $table = 'gudang';

    protected $primaryKey = 'kd_gudang';
    public $incrementing = false; // karena pk berupa string
    protected $keyType = 'string';

    public $timestamps = false;

    protected $fillable = [
        'kd_gudang',
        'nama_gudang',
        'alamat_gudang',
        'koordinat',
    ];
}
