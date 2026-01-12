<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Petugas
        DB::table('users')->insert([
            [
                'name' => 'Yanto',
                'email' => 'yanto@example.com',
                'password' => Hash::make('admin'),
                'role' => 'petugas',
                'nis' => null,
                'kelas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Udin',
                'email' => 'udin@example.com',
                'password' => Hash::make('admin'),
                'role' => 'petugas',
                'nis' => null,
                'kelas' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Siswa
        DB::table('users')->insert([
            [
                'name' => 'Satriyo',
                'email' => 'satriyo@example.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'nis' => '10101',
                'kelas' => 'XII RPL 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alfa',
                'email' => 'alfa@example.com',
                'password' => Hash::make('password'),
                'role' => 'siswa',
                'nis' => '10102',
                'kelas' => 'XI RPL 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
