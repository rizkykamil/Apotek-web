<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_poli');
            $table->text('keluhan');
            $table->enum('status', ['diperoses', 'dibayarkan', 'batal', 'selesai'])->default('diperoses');
            $table->decimal('harga', 10, 3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
