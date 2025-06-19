<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk membuat tabel users.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['bendahara', 'ketua']);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Rollback migrasi: hapus tabel users.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
