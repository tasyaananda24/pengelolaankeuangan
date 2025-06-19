<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory;

    protected $fillable = ['santri_id', 'tanggal', 'jumlah', 'jenis', 'keterangan'];

    // Relasi dengan model Santri
    public function santri()
    {
        return $this->belongsTo(Santri::class, 'santri_id');
    }
}
