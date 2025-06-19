<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('transaksi_kas', function (Blueprint $table) {
        $table->id();
        $table->date('tanggal');
        $table->string('keterangan');
        $table->enum('jenis', ['kredit', 'debit']);
        $table->bigInteger('jumlah');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_kas');
    }
};
