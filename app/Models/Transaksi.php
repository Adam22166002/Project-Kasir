<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_harga', 
        'jumlah_total', 
        'tanggal_transaksi'
    ];

    // Relasi dengan transaksi items
    public function transaksiItem()
    {
        return $this->hasMany(TransaksiItem::class);
    }

    // Mutator untuk format total harga
    public function getTotalHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->total_price, 0, ',', '.');
    }
}
