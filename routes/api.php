<?php

use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\KategoriAsetController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GudangController;

use App\Http\Controllers\TrxAsetInController;
use App\Http\Controllers\TrxAsetOutController;


use App\Http\Controllers\TrxAsetController; //pinjam
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AuthController;


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

Route::get('users', [UserController::class, 'index']);// Tampil semua user

Route::middleware(['auth:sanctum', 'checkrole:admin'])->group(function () {

Route::get('kategori-aset', [KategoriAsetController::class, 'index']);
Route::get('kategori-aset/{id}', [KategoriAsetController::class, 'show']);
Route::post('kategori-aset', [KategoriAsetController::class, 'store']);
Route::put('kategori-aset/{id}', [KategoriAsetController::class, 'update']);
Route::delete('kategori-aset/{id}', [KategoriAsetController::class, 'destroy']);

Route::get('users/{id}', [UserController::class, 'show']);// Tampil user berdasarkan ID
Route::post('users', [UserController::class, 'store']);// Tambah user baru
Route::put('users/{id}', [UserController::class, 'update']);// Update data user
Route::delete('users/{id}', [UserController::class, 'destroy']);// Hapus user

Route::get('gudang', [GudangController::class, 'index']);
Route::get('gudang/{id}', [GudangController::class, 'show']);
Route::post('gudang', [GudangController::class, 'store']);
Route::put('gudang/{id}', [GudangController::class, 'update']);
Route::delete('gudang/{id}', [GudangController::class, 'destroy']);
});



Route::prefix('assets')->group(function () {
    Route::get('/', [AssetController::class, 'index']);
    Route::post('/', [AssetController::class, 'store']);
    Route::get('/{id}', [AssetController::class, 'show']);
    Route::put('/{id}', [AssetController::class, 'update']);
    Route::delete('/{id}', [AssetController::class, 'destroy']);
});
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

});

// SEMENTARA tanpa middleware auth
Route::prefix('aset-out')->group(function () {
    Route::get('/', [TrxAsetOutController::class, 'index']);
    Route::post('/', [TrxAsetOutController::class, 'store']);
});

Route::prefix('aset-in')->group(function () {
    Route::get('/', [TrxAsetInController::class, 'index']);
    Route::post('/', [TrxAsetInController::class, 'store']);
});

// routes/api.php
Route::get('/aset/{id}', [AssetController::class, 'show']);
Route::post('/trx-aset-in', [TrxAsetInController::class, 'store']);



