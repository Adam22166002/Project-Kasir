<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;
    protected $table = 'transaction_items';
    protected $fillable = [
        'transaction_id', 
        'product_id', 
        'quantity', 
        'subtotal'
    ];

    // Relasi dengan produk
    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }

    // Relasi dengan transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaksi::class, 'transaction_id');
    }

}

