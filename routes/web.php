<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ModalController;
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
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('/modal', ModalController::class)->only(['index', 'create', 'store']);
    Route::get('/kasir', [KasirController::class, 'index'])->name('kasir');
    Route::post('/kasir/reset', [KasirController::class, 'resetKasir'])->name('kasir.reset');
    Route::post('/kasir/complete-setup', 'KasirController@completeSetup')->name('kasir.complete-setup');
    Route::resource('/produk', ProdukController::class);
    Route::get('/history', [HistoryController::class, 'index'])->name('history');
    Route::post('/simpan-transaksi', [TransaksiController::class, 'simpanTransaksi'])->name('simpan.transaksi');
    Route::get('/transaksi/{id}/detail', [TransaksiController::class, 'detail'])->name('transaction.detail');
    Route::get('/laporan/perubahan-modal', [LaporanController::class, 'perubahanModal'])->name('laporan.perubahan-modal');
    Route::get('/laporan/laba-rugi', [LaporanController::class, 'labaRugi'])->name('laporan.laba-rugi');
    Route::get('/laporan/neraca', [LaporanController::class, 'neraca'])->name('laporan.neraca');
    Route::resource('/modal', ModalController::class);
    Route::get('/laporan-laba/pdf', [LaporanController::class, 'cetakLabaPDF'])->name('laporan.laba.pdf');
Route::get('/laporan-neraca/pdf', [LaporanController::class, 'cetakNeracaPDF'])->name('laporan.neraca.pdf');
Route::get('/laporan-modal/pdf', [LaporanController::class, 'cetakModalPDF'])->name('laporan.modal.pdf');
});


