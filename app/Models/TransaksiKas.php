<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransaksiKas extends Model
{
    protected $table = 'transaksi_kas';
    protected $fillable = ['tanggal', 'keterangan', 'jenis', 'jumlah', 'jenis_transaksi'];
    public $timestamps = false;
}
