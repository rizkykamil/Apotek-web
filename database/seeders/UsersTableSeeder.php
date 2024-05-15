<?php

namespace Database\Seeders;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'id' => Uuid::uuid4(),
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
            'password' => bcrypt('admin123'),
        ];

        $operator = [
            'id' => Uuid::uuid4(),
            'name' => 'Oprator',
            'email' => 'op@gmail.com',
            'role' => 'operator',
            'password' => bcrypt('oprator123'),
        ];

        DB::table('users')->insert($admin);
        DB::table('users')->insert($operator);
    }
}
