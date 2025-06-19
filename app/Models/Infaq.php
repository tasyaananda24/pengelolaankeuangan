<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Infaq extends Model
{
    use HasFactory;

    protected $fillable = ['santri_id', 'tanggal', 'jumlah', 'bulan', 'keterangan'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
