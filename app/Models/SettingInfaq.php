<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingInfaq extends Model
{
    use HasFactory;

    protected $table = 'setting_infaq'; // pastikan sesuai dengan nama tabel di database

    protected $fillable = [
        'bulan',
        'jumlah',
        'keterangan',
    ];
}
