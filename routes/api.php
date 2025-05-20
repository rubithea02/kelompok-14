<?php

use App\Http\Controllers\PeminjamController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('peminjam', [PeminjamController::class, 'index']); // Menampilkan semua peminjam
Route::get('peminjam/{id}', [PeminjamController::class, 'show']); // Menampilkan peminjam berdasarkan ID
Route::post('peminjam', [PeminjamController::class, 'store']); // Menyimpan peminjam baru
Route::put('peminjam/{id}', [PeminjamController::class, 'update']); // Mengupdate peminjam
Route::delete('peminjam/{id}', [PeminjamController::class, 'destroy']); // Menghapus peminjam
