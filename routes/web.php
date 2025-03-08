<?php

use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [KasirController::class, 'dashboard'])->name('dashboard');
Route::get('/kasir', [KasirController::class, 'kasir'])->name('kasir');
Route::resource('/produk', ProdukController::class);
Route::get('/history', [KasirController::class, 'history'])->name('history');
Route::post('/transaksi', [TransaksiController::class, 'simpanTransaksi'])->name('transaksi.simpan');
