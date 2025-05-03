<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendapatan extends Model
{
    use HasFactory;

    protected $table = 'pendapatan';

    protected $fillable = [
        'transaksi_id',
        'amount',
        'description',
        'date',
    ];

    // Relasi ke transaksi
    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}
