<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataSantri extends Model
{
    use HasFactory;

    protected $table = 'datasantri'; // <== sesuai dengan nama tabel di database

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'usia',
        'alamat',
        'no_hp',
    ];
}
