<?
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persediaan extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'quantity', 'cost_price', 'selling_price', 'date'];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id');
    }
}
