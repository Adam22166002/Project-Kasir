<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
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

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
Route::get('/kasir/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi'); 
Route::post('/kasir/reset', [KasirController::class, 'resetKasir'])->name('kasir.reset');
Route::post('/kasir/complete-setup', 'KasirController@completeSetup')->name('kasir.complete-setup');
Route::resource('/produk', ProdukController::class);
Route::post('/produk/{product}/update-price', [ProdukController::class, 'updatePrice'])->name('produk.update.price');
Route::patch('/produk/{product}/update-stock', [ProdukController::class, 'updateStock'])->name('produk.update.stock');
Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::post('/transaksi', [TransaksiController::class, 'simpanTransaksi'])->name('transaksi.simpan');

