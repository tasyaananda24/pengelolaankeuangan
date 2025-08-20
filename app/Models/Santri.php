<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory;
        protected $fillable = [
        'kode_santri',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'nama_ortu',
        'no_hp',
        'status'
    ];
    public function tabungans()
    {
        return $this->hasMany(Tabungan::class, 'santri_id');
    }
    // app/Models/Santri.php
// Santri.php
public function infaqs()
{
    return $this->hasMany(Infaq::class);
}
public function infaq()
{
    return $this->hasMany(Infaq::class);
}



}
