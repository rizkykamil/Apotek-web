<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JenisProduk extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('jenis_produks')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4(),
            'nama' => 'Obat',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('jenis_produks')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4(),
            'nama' => 'Suplemen',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('jenis_produks')->insert([
            'id' => \Ramsey\Uuid\Uuid::uuid4(),
            'nama' => 'Vitamin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
