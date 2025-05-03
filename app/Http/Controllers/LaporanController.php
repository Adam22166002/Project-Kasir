<?php

namespace App\Http\Controllers;

use App\Models\Modal;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\Transaksi;
// use Barryvdh\DomPDF\PDF;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    // public function perubahanModal()
    // {
    //     $setoran = Modal::where('type', 'in')->sum('amount');
    //     $pengambilan = Modal::where('type', 'out')->sum('amount');

    //     $modalAwal = 10000000; // bisa ambil dari database jika ingin lebih dinamis
    //     $modalAkhir = $modalAwal + $setoran - $pengambilan;
    //     $totalModal = Modal::sum('amount');
    //     $laba = Transaksi::sum('total_price'); // asumsi pengeluaran = 0

    //     $modalAkhir = $totalModal + $laba;

    //     return view('laporan.perubahan_modal', compact(
    //         'modalAwal', 'setoran', 'pengambilan', 'modalAkhir','totalModal', 'laba', 'modalAkhir'
    //     ));
    // }
    public function PerubahanModal()
{
    // Ambil data modal awal, laba bersih dan modal akhir
    $modalAwal = DB::table('modals')->sum('amount');
    // $laba = $this->hitungLabaBersih();  // Misal ada fungsi untuk menghitung laba bersih
    

    $modalKeluar = DB::table('modals')
        ->where('type', 'out')
        ->whereMonth('date', date('m'))
        ->whereYear('date', date('Y'))
        ->sum('amount');
    $pendapatan = Transaksi::whereMonth('transaction_date', date('m'))
        ->whereYear('transaction_date', date('Y'))
        ->sum('total_price');
        $hpp = DB::table('transaction_items')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->whereMonth('transactions.transaction_date', date('m'))
        ->whereYear('transactions.transaction_date', date('Y'))
        ->sum(DB::raw('transaction_items.quantity * products.cost_price'));
        $modal = DB::table('modals')->sum('amount');

    $labaKotor = $pendapatan - $hpp;
    $labaBersih = $labaKotor - $modalKeluar;
    $modalAkhir = $modalAwal + $labaBersih;

    return view('laporan.perubahan_modal', compact('modalAwal', 'labaBersih', 'modalAkhir'));
}

private function hitungLabaBersih()
{
    // Contoh perhitungan laba bersih berdasarkan transaksi
    $pendapatan = DB::table('pendapatan')->sum('amount');
    $pengeluaran = DB::table('pengeluaran')->sum('amount');
    
    return $pendapatan - $pengeluaran;
}


    public function neraca()
{
    // Ambil data kas, persediaan, dan modal dari database
    $kas = DB::table('kas')->sum('amount');
    $persediaan = DB::table('persediaan')->sum('quantity');
    $totalAset = $kas + $persediaan;
    $modal = DB::table('modals')->sum('amount');
    $pendapatan = Transaksi::whereMonth('transaction_date', date('m'))
        ->whereYear('transaction_date', date('Y'))
        ->sum('total_price');
    $hpp = DB::table('transaction_items')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->whereMonth('transactions.transaction_date', date('m'))
        ->whereYear('transactions.transaction_date', date('Y'))
        ->sum(DB::raw('transaction_items.quantity * products.cost_price'));
    $labaKotor = $pendapatan - $hpp;
    
    return view('laporan.neraca', compact('kas', 'persediaan', 'labaKotor','totalAset', 'modal'));
}

public function labaRugi()
{
    $pendapatan = Transaksi::whereMonth('transaction_date', date('m'))
        ->whereYear('transaction_date', date('Y'))
        ->sum('total_price');

    $hpp = DB::table('transaction_items')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->whereMonth('transactions.transaction_date', date('m'))
        ->whereYear('transactions.transaction_date', date('Y'))
        ->sum(DB::raw('transaction_items.quantity * products.cost_price'));
        $modal = DB::table('modals')->sum('amount');

    // Modal keluar bulan ini
    $modalKeluar = DB::table('modals')
        ->where('type', 'out')
        ->whereMonth('date', date('m'))
        ->whereYear('date', date('Y'))
        ->sum('amount');

    $labaKotor = $pendapatan - $hpp;
    $labaBersih = $labaKotor - $modalKeluar;

    return view('laporan.laba_rugi', compact('pendapatan','hpp','labaKotor','modal','modalKeluar','labaBersih'));
}
public function cetakLabaPDF()
{
    $pendapatan = Transaksi::whereMonth('transaction_date', date('m'))
        ->whereYear('transaction_date', date('Y'))
        ->sum('total_price');

    $hpp = DB::table('transaction_items')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->whereMonth('transactions.transaction_date', date('m'))
        ->whereYear('transactions.transaction_date', date('Y'))
        ->sum(DB::raw('transaction_items.quantity * products.cost_price'));

    $modal = DB::table('modals')->sum('amount');

    $modalKeluar = DB::table('modals')
        ->where('type', 'out')
        ->whereMonth('date', date('m'))
        ->whereYear('date', date('Y'))
        ->sum('amount');

    $labaKotor = $pendapatan - $hpp;
    $labaBersih = $labaKotor - $modalKeluar;

    $pdf = PDF::loadView('laporan.laba', compact('pendapatan', 'hpp', 'modal', 'modalKeluar', 'labaKotor', 'labaBersih'));
    return $pdf->download('laporan_laba.pdf');
}

public function cetakNeracaPDF()
{
    $kas = DB::table('kas')->sum('amount');
    $persediaan = DB::table('persediaan')->sum('quantity');
    $totalAset = $kas + $persediaan;
    $modal = DB::table('modals')->sum('amount');

    $pendapatan = Transaksi::whereMonth('transaction_date', date('m'))
        ->whereYear('transaction_date', date('Y'))
        ->sum('total_price');

    $hpp = DB::table('transaction_items')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->whereMonth('transactions.transaction_date', date('m'))
        ->whereYear('transactions.transaction_date', date('Y'))
        ->sum(DB::raw('transaction_items.quantity * products.cost_price'));

    $labaKotor = $pendapatan - $hpp;

    $pdf = PDF::loadView('laporan.cetak_neraca', compact('kas', 'persediaan', 'totalAset', 'modal', 'labaKotor'));
    return $pdf->download('laporan_neraca.pdf');
}


public function cetakModalPDF()
{
    $modalAwal = DB::table('modals')->sum('amount');

    $modalKeluar = DB::table('modals')
        ->where('type', 'out')
        ->whereMonth('date', date('m'))
        ->whereYear('date', date('Y'))
        ->sum('amount');

    $pendapatan = Transaksi::whereMonth('transaction_date', date('m'))
        ->whereYear('transaction_date', date('Y'))
        ->sum('total_price');

    $hpp = DB::table('transaction_items')
        ->join('products', 'transaction_items.product_id', '=', 'products.id')
        ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
        ->whereMonth('transactions.transaction_date', date('m'))
        ->whereYear('transactions.transaction_date', date('Y'))
        ->sum(DB::raw('transaction_items.quantity * products.cost_price'));

    $labaKotor = $pendapatan - $hpp;
    $labaBersih = $labaKotor - $modalKeluar;
    $modalAkhir = $modalAwal + $labaBersih;

    $pdf = PDF::loadView('laporan.modal', compact('modalAwal', 'labaBersih', 'modalAkhir'));
    return $pdf->download('laporan_modal.pdf');
}




}
