<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GudangController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/gudang', [GudangController::class, 'index']);
Route::post('/gudang', [GudangController::class, 'store']);
Route::get('/gudang/{kd_gudang}/edit', [GudangController::class, 'edit']);
Route::put('/gudang/{kd_gudang}', [GudangController::class, 'update']);
Route::delete('/gudang/{kd_gudang}', [GudangController::class, 'destroy']);