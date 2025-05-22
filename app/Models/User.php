<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'users';  // Nama tabel sesuai migrasi

    protected $primaryKey = 'id_user'; // Primary key khusus sesuai migrasi

    protected $fillable = [
        'email_karyawan',
        'nama_karyawan',
        'nik_user',
        'role',
        'password_user',
        'id_gudang',
    ];

    // Jika ingin, kamu bisa tambahkan relasi ke tabel lain di sini, misal:
    // public function gudang()
    // {
    //     return $this->belongsTo(Gudang::class, 'id_gudang');
    // }
}