<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Peminjam extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'peminjam';

    protected $fillable = [
        'nik_karyawan',
        'nama_karyawan',
        'kd_gudang',
    ];

    // untuk menghubungan dengan tabel lain (misalnya `Gudang`),
   
}
