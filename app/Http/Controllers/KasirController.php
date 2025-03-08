<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function dashboard()
    {
        $todaySales = Transaksi::whereDate('created_at', today())->get();
        $totalPenjualan = $todaySales->sum('total_price'); // variable total penjualan untuk memanggil variable today sales dari jumlah total harga
        $totalProdukTerjual = $todaySales->sum('total_quantity');//

        return view('pages.dashboard', compact('todaySales','totalPenjualan', 'totalProdukTerjual'));
    }

    public function kasir()
    {
        $products = Produk::all(); //variable produk untuk memanggil semua data dari table produk
        return view('pages.kasir', compact('products'));
    }

    public function stok()
    {
        $products = Produk::all();
        return view('pages.stok', compact('products'));
    }

    public function history()
    {
        $transactions = Transaksi::latest()->get();
        return view('pages.history', compact('transactions'));
    }
}