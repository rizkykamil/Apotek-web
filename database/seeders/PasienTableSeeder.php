<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PasienTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pasiens')->insert([
            // rondom uuid
            'id' => Uuid::uuid4(),
            'no_rekam_medis' => rand(1000000000, 9999999999),
            'nama_pasien' => Str::random(10),
            'no_ktp' => rand(1000000000000000, 9999999999999999),
            'tanggal_lahir' => Carbon::now()->subYears(rand(1, 80))->format('Y-m-d'),
            'alamat' => Str::random(20),
            'no_telepon' => '08' . rand(1000000000, 99999999999),
        ]);
    }
}
