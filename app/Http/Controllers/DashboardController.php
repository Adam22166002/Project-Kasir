<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = Transaksi::with('transaksiItem.product')->get();
        $today = Carbon::today();
        
        // Ambil semua produk
        $products = Produk::all();
        
        // Tentukan jika setup sudah selesai (ada produk, harga, dan stok yang sudah diatur)
        $setupComplete = $products->count() > 0 && 
                         $products->where('price', '>', 0)->count() > 0 && 
                         $products->where('stock', '>', 0)->count() > 0;
        
        // Ambil transaksi hari ini
        $todaySales = Transaksi::whereDate('transaction_date', $today)
                       ->orderBy('created_at', 'desc')
                       ->get();
        
        // Hitung total penjualan hari ini
        $totalPenjualan = $todaySales->sum('total_price');
        
        // Hitung total produk terjual hari ini
        $totalProdukTerjual = $todaySales->sum('total_quantity');

            session()->flash('setup_complete', 'Semua pengaturan produk, harga, dan stok telah selesai. Anda dapat mulai melakukan transaksi.');
            return view('pages.dashboard', compact(
            'products', 
            'setupComplete', 
            'todaySales', 
            'totalPenjualan', 
            'totalProdukTerjual',
            'transactions'
        ));
    }
    
}