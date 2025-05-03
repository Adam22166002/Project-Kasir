<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua transaksi dengan item transaksi dan produk terkait
        $transactions = Transaksi::with('transaksiItem.product')->get();
        $today = Carbon::today();
        
        // Ambil semua produk
        $products = Produk::all();
        
        // Ambil transaksi hari ini
        $todaySales = Transaksi::whereDate('transaction_date', $today)
                       ->orderBy('created_at', 'desc')
                       ->get();
        
        // Hitung total penjualan hari ini
        $totalPenjualan = $todaySales->sum('total_price');
        
        // Hitung total produk terjual hari ini
        $totalProdukTerjual = $todaySales->sum('total_quantity');

        // Gabungkan data item transaksi berdasarkan produk
        $produkTerjual = collect();
        $labaRugi = $this->labaRugi();
        $modalAwal = DB::table('modals')->where('date', '<', now()->startOfMonth())->sum('amount');
        $labaBersih = $this->hitungLabaBersih();  // Misal ada fungsi untuk menghitung laba bersih
        $modalAkhir = $modalAwal + $labaBersih;

        // neraca
        // Ambil data kas, persediaan, dan modal dari database
    $kas = DB::table('kas')->sum('amount');
    $persediaan = DB::table('persediaan')->sum('quantity');
    $totalAset = $kas + $persediaan;
    $modal = DB::table('modals')->sum('amount');
    $modalKeluar = DB::table('modals')
        ->where('type', 'out')
        ->whereMonth('date', date('m'))
        ->whereYear('date', date('Y'))
        ->sum('amount');

        foreach ($todaySales as $transaction) {
            foreach ($transaction->transaksiItem as $item) {
                $produkTerjual->push([
                    'product_id' => $item->product_id,
                    'name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                    'date' => $transaction->transaction_date
                ]);
            }
        }

        // Kelompokkan berdasarkan produk dan hitung total quantity dan total harga
        $produkTerjualGrouped = $produkTerjual
            ->groupBy('product_id')
            ->map(function ($items) {
                return [
                    'name' => $items->first()['name'],
                    'total_quantity' => $items->sum('quantity'),
                    'total_price' => $items->sum('subtotal'),
                    'dates' => $items->pluck('date')->unique()->implode(', '),
                ];
            });

        // Kirim data ke view
        return view('pages.dashboard', compact(
            'products', 
            'todaySales', 
            'totalPenjualan', 
            'totalProdukTerjual',
            'transactions',
            'produkTerjualGrouped',
            'labaBersih',
            'labaRugi',
            'modalAwal',
            'modalKeluar',
            'modalAkhir','kas', 'persediaan', 'totalAset', 'modal'

        ));
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

    // Modal keluar bulan ini
    $modalKeluar = DB::table('modals')
        ->where('type', 'out')
        ->whereMonth('date', date('m'))
        ->whereYear('date', date('Y'))
        ->sum('amount');

    $labaKotor = $pendapatan - $hpp;
    $labaBersih = $labaKotor - $modalKeluar;

    return [
        'pendapatan' => $pendapatan,
        'hpp' => $hpp,
        'modalKeluar' => $modalKeluar,
        'labaKotor' => $labaKotor,
        'labaBersih' => $labaBersih,
    ];
}
private function hitungLabaBersih()
{
    // Contoh perhitungan laba bersih berdasarkan transaksi
    $pendapatan = DB::table('pendapatan')->sum('amount');
    $pengeluaran = DB::table('pengeluaran')->sum('amount');
    
    return $pendapatan - $pengeluaran;
}

}
