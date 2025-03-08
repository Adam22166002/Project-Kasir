<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama_produk', 
        'harga_produk', 
        'stock', 
        'image_path'
    ];

    // Relasi dengan transaksi item
    public function transaksiItem()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    // Mutator untuk format harga
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }
}
