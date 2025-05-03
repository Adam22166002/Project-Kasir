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
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $product = new Produk();
        $product->name = $request->name;
        $product->price = $request->price; 
        $product->stock = $request->stock; 
        
        // if ($request->hasFile('image_path')) {
        //     // $image_path = $request->file('image_path')->store('products', 'public');
        //     // $product->image_path = $image_path;
        //     $image_path = $request->file('image_path')->move(public_path('products'));
        //     $product->image_path = 'products/' . $request->file('image_path')->hashName();
        // }
        if ($request->hasFile('image_path')) {
    $file = $request->file('image_path');
    $filename = $file->hashName(); // nama unik, biar nggak bentrok

    // Pindahkan file ke /public_html/products (hosting root)
    $file->move(public_path('products'), $filename);
    // $file->move(base_path('../public_html/products'), $filename);

    // Simpan path relatif ke database
    $product->image_path = 'products/' . $filename;
}

        
        $product->save();

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
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
    // $imagePath = $produk->image_path;
    // if ($request->hasFile('image_path')) {
    //     // $imagePath = $request->file('image_path')->store('products', 'public');
    //     $image_path = $request->file('image_path')->move(public_path('products'));
    //     $product->image_path = 'products/' . $request->file('image_path')->hashName();
    // }
    $imagePath = $produk->image_path;
    
    if ($request->hasFile('image_path')) {
        $file = $request->file('image_path');
        $filename = $file->hashName(); // nama unik
        // $file->move(public_path('products'), $filename);
        $file->move(public_path('products'), $filename);
    // $file->move(base_path('../public_html/products'), $filename);
        $imagePath = 'products/' . $filename;
    }

    $produk->update([
        'name' => $request->name,
        'price' => $request->price,
        'stock' => $request->stock,
        'image_path' => $imagePath,
    ]);

    return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
}


    // hapus
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('produk.index');
    }
}
