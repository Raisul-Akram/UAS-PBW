<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat akun admin default jika belum ada
        User::firstOrCreate(
            ['email' => 'admin@bengkel.com'],
            [
                'name' => 'Admin Bengkel',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
