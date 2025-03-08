<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function simpanTransaksi(Request $request)
    {
        DB::beginTransaction();
        try {
            // Buat transaksi baru
            $transaksi = Transaksi::create([
                'total_harga' => $request->total,
                'total_quantity' => array_sum(array_column($request->items, 'quantity')),
                'tanggal_transaksi' => now()->toDateString()
            ]);

            // Simpan item transaksi
            foreach ($request->items as $item) {
                TransaksiItem::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $item['productId'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal']
                ]);

                // Update stok produk
                $produk = Produk::findOrFail($item['productId']);
                $produk->decrement('stock', $item['quantity']);
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}