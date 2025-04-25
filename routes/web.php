<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\StepController;
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

// // Step 1:
// Route::get('/', [StepController::class, 'showStep1'])->name('step1');
// Step 2:
// Route::get('/setup_produk', [StepController::class, 'showStep2'])->name('step2');

// // Step 3: 
// Route::get('/setup_harga', [StepController::class, 'showStep3'])->name('step3');
// Route::post('/produk/update-price/{id}', [ProdukController::class, 'updatePrice'])->name('produk.update.price');
// // Step 4:
// Route::get('/setup_stock', [StepController::class, 'showStep4'])->name('step4');
// Route::post('/produk/update-stock/{id}', [ProdukController::class, 'updateStock'])->name('produk.update.stock');

//setup selesai
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
// Route::get('/kasir/transaksi', [KasirController::class, 'transaksi'])->name('kasir.transaksi'); 
Route::post('/kasir/reset', [KasirController::class, 'resetKasir'])->name('kasir.reset');
// Route::post('/kasir/reset', [KasirController::class, 'reset'])->name('kasir.reset');
Route::post('/kasir/complete-setup', 'KasirController@completeSetup')->name('kasir.complete-setup');
Route::resource('/produk', ProdukController::class);
// Route::post('/produk/{product}/update-price', [ProdukController::class, 'updatePrice'])->name('produk.update.price');
// Route::patch('/produk/{product}/update-stock', [ProdukController::class, 'updateStock'])->name('produk.update.stock');
Route::get('/history', [HistoryController::class, 'index'])->name('history');
Route::post('/simpan-transaksi', [TransaksiController::class, 'simpanTransaksi'])->name('simpan.transaksi');
Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'detail'])->name('transaction.detail');
// Route::post('/reset-kasir', [KasirController::class, 'resetKasir'])->name('reset.kasir');
// Route::post('/kasir/reset', [KasirController::class, 'reset'])->name('kasir.reset');


