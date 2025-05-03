<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran';

    protected $fillable = [
        'modal_id',
        'amount',
        'description',
        'date',
    ];

    // Relasi ke modal
    public function modal()
    {
        return $this->belongsTo(Modal::class, 'modal_id');
    }
}
