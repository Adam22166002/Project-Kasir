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
        $request->validate([
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.productId' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.subtotal' => 'required|numeric'
        ]);

        
        DB::beginTransaction();
        try {
            // Buat transaksi baru - using correct field name 'total_price' instead of 'total_harga'
            $transaksi = new Transaksi();
            $transaksi->total_price = $request->total; // Corrected field name
            $transaksi->total_quantity = array_sum(array_column($request->items, 'quantity'));
            $transaksi->transaction_date = now();
            $transaksi->save();

            // Simpan item transaksi dan update stok
            foreach ($request->items as $item) {
                $transaksiItem = new TransaksiItem(); // Use the correct model
                $transaksiItem->transaction_id = $transaksi->id; // Likely the correct field name
                $transaksiItem->product_id = $item['productId']; // Likely the correct field name
                $transaksiItem->quantity = $item['quantity'];
                $transaksiItem->subtotal = $item['subtotal'];
                $transaksiItem->save();

                // Update stok produk - using Product model based on error message
                $produk = Produk::findOrFail($item['productId']);
                
                // Kurangi stok
                $produk->stock = $produk->stock - $item['quantity'];
                $produk->save();
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan dan stok telah diperbarui']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
    public function detail($id)
{
    $transaksi = Transaksi::with('items.product')->find($id);

    if (!$transaksi) {
        return response()->json(['success' => false, 'message' => 'Transaksi tidak ditemukan']);
    }

    return response()->json([
        'success' => true,
        'transaction' => $transaksi->load('items.product')
    ]);
    
}
}