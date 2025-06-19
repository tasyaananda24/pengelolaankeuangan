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
    Schema::create('datasantri', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
        $table->integer('usia');
        $table->string('alamat');
        $table->string('no_hp');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datasantri');
    }
};
