<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Display a listing of the products
    public function index()
    {
        $products = Produk::all();
        return view('produk.index', compact('products'));
    }

    // Show the form for creating a new product
    public function create()
    {
        return view('produk.create');
    }

    // Store a newly created product in storage
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $product = new Produk();
        $product->name = $request->name;
        $product->price = 0; 
        $product->stock = 0; 
        
        if ($request->hasFile('image_path')) {
            $image_path = $request->file('image_path')->store('products', 'public');
            $product->image_path = $image_path;
        }
        
        $product->save();

        return redirect()->route('dashboard')->with('success', 'Produk berhasil ditambahkan!');
    }

    // Display the specified product
    public function show($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.show', compact('produk'));
    }

    // Show the form for editing the specified product
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('produk.edit', compact('produk'));
    }

    // Update the specified product in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $produk = Produk::findOrFail($id);

        // Handle image upload if exists
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('products', 'public');
            $produk->image_path = $imagePath;
        } else {
            $imagePath = $produk->image_path;
        }
        

        $produk->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('produk.index');
    }

    // hapus
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index');
    }

    public function updatePrice(Request $request, Produk $product)
    {
        $request->validate([
            'price' => 'required|numeric|min:0',
        ]);
        
        $product->price = $request->price;
        $product->save();
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Harga produk berhasil diperbarui!');
    }
    
    public function updateStock(Request $request, Produk $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);
        
        $product->stock = $request->stock;
        $product->save();
        
        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        
        return redirect()->back()->with('success', 'Stok produk berhasil diperbarui!');
    }
}
