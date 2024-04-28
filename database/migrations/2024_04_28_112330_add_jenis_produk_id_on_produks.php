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
        Schema::table('produks', function (Blueprint $table) {
            $table->uuid('jenis_produk_id')->after('nama')->nullable();
            $table->foreign('jenis_produk_id')->references('id')->on('jenis_produks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropForeign(['jenis_produk_id']);
            $table->dropColumn('jenis_produk_id');
        });
    }
};
