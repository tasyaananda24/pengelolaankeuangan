<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTabungansTable extends Migration
{
    public function up()
    {
        Schema::create('tabungans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('santri_id')->constrained()->onDelete('cascade');  // Menghubungkan dengan tabel santris
            $table->date('tanggal');
            $table->decimal('jumlah', 15, 2);  // Jumlah setoran/penarikan
            $table->enum('jenis', ['setoran', 'penarikan']);  // Jenis transaksi
            $table->text('keterangan')->nullable();  // Keterangan untuk penarikan (optional)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tabungans');
    }
}
