<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Produk;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Carbon\Carbon;

class KasirController extends Controller
{
    public function index()
    {
        $products = Produk::where('stock', '>', 0)->get();
        return view('kasir.index', compact('products'));
    }
    
    public function checkout(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);
        
        // Mulai transaksi database
        \Illuminate\Support\Facades\DB::beginTransaction();
        
        try {
            // Buat transaksi baru
            $transaction = new Transaksi();
            $transaction->transaction_date = now();
            $transaction->total_price = 0;
            $transaction->total_quantity = 0;
            $transaction->save();
            
            $totalPrice = 0;
            $totalQuantity = 0;
            
            // Proses setiap item
            foreach ($request->items as $item) {
                $product = Produk::findOrFail($item['product_id']);
                
                // Pastikan stok mencukupi
                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Stok {$product->name} tidak mencukupi!");
                }
                
                // Hitung subtotal
                $subtotal = $product->price * $item['quantity'];
                
                // Buat item transaksi
                $transactionItem = new TransaksiItem();
                $transactionItem->transaction_id = $transaction->id;
                $transactionItem->product_id = $product->id;
                $transactionItem->quantity = $item['quantity'];
                $transactionItem->subtotal = $subtotal;
                $transactionItem->save();
                
                // Kurangi stok produk
                $product->stock -= $item['quantity'];
                $product->save();
                
                // Update total
                $totalPrice += $subtotal;
                $totalQuantity += $item['quantity'];
            }
            
            // Update data transaksi
            $transaction->total_price = $totalPrice;
            $transaction->total_quantity = $totalQuantity;
            $transaction->save();
            
            // Commit transaksi
            \Illuminate\Support\Facades\DB::commit();
            
            return response()->json([
                'success' => true,
                'transaction' => $transaction,
                'message' => 'Transaksi berhasil disimpan!'
            ]);
            
        } catch (\Exception $e) {
            // Rollback jika terjadi error
            \Illuminate\Support\Facades\DB::rollback();
            
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }
    public function resetKasir()
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::today();

        // Hapus semua transaksi hari ini
        Transaksi::whereDate('created_at', $today)->delete();

        // Hapus semua produk (atau produk yang sudah terjual hari ini jika diperlukan)
        Produk::whereDate('created_at', $today)->delete();

        // Redirect kembali dengan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Kasir telah berhasil direset.');
    }
}