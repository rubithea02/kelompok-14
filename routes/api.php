<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GudangController;
use App\Http\Controllers\KategoriAsetController;
use App\Http\Controllers\TrxAsetInController;
use App\Http\Controllers\TrxAsetOutController;
use App\Http\Controllers\TrxAsetController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\LaporanController;

// 🔓 Semua route berikut ini bisa diakses tanpa autentikasi (untuk testing)

// Auth
Route::post('login', [AuthController::class, 'login']);
Route::get('user', [AuthController::class, 'user']);
Route::post('logout', [AuthController::class, 'logout']);

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);

// Gudang
Route::get('gudang', [GudangController::class, 'index']);
Route::get('gudang/{id}', [GudangController::class, 'show']);
Route::post('gudang', [GudangController::class, 'store']);
Route::put('gudang/{id}', [GudangController::class, 'update']);
Route::delete('gudang/{id}', [GudangController::class, 'destroy']);

// Kategori Aset
Route::get('kategori-aset', [KategoriAsetController::class, 'index']);
Route::get('kategori-aset/{id}', [KategoriAsetController::class, 'show']);
Route::post('kategori-aset', [KategoriAsetController::class, 'store']);
Route::put('kategori-aset/{id}', [KategoriAsetController::class, 'update']);
Route::delete('kategori-aset/{id}', [KategoriAsetController::class, 'destroy']);

// Aset
Route::get('assets', [AssetController::class, 'index']);
Route::get('assets/{id}', [AssetController::class, 'show']);
Route::post('assets', [AssetController::class, 'store']);
Route::put('assets/{id}', [AssetController::class, 'update']);
Route::delete('assets/{id}', [AssetController::class, 'destroy']);

// Users (pegawai)
Route::get('users', [UserController::class, 'index']);
Route::get('users/{id}', [UserController::class, 'show']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{id}', [UserController::class, 'update']);
Route::delete('users/{id}', [UserController::class, 'destroy']);

// Peminjam
Route::get('peminjam', [PeminjamController::class, 'index']);
Route::get('peminjam/{id}', [PeminjamController::class, 'show']);
Route::post('peminjam', [PeminjamController::class, 'store']);
Route::put('peminjam/{id}', [PeminjamController::class, 'update']);
Route::delete('peminjam/{id}', [PeminjamController::class, 'destroy']);

// Transaksi Aset Masuk dan Keluar
Route::get('aset-in', [TrxAsetInController::class, 'index']);
Route::post('aset-in', [TrxAsetInController::class, 'store']);
Route::get('aset-keluar', [TrxAsetOutController::class, 'index']);
Route::post('/aset-keluar', [TrxAsetOutController::class, 'store']);

// Trx Aset (jika ada)
Route::post('trx-aset-in', [TrxAsetInController::class, 'store']);

// Filter tab Transaksi Aset
Route::get('aset-keluar', [TrxAsetOutController::class, 'filterByStatus']);
Route::get('/laporan/grouped', [LaporanController::class, 'groupedByStatus']);