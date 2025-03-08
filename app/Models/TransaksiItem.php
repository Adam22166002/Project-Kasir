<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_transaksi', 
        'id_produk', 
        'jumlah', 
        'subtotal'
    ];

    // Relasi dengan produk
    public function product()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi dengan transaksi
    public function transaction()
    {
        return $this->belongsTo(Transaksi::class);
    }
}

