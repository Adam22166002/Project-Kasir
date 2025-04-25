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
            'produkTerjualGrouped'
        ));
    }
}
