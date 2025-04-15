<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Karyawan 2',
                'email' => 'karyawan2@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'Karyawan',
            ],
            ]);
    }
}
