<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed default Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@example.com'],
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('superadmin123'),
                'phone' => '081234567890',
                'role' => 'super_admin',
            ]
        );

         //     Admin Produk
         User::updateOrCreate(
            ['email' => 'adminproduk@example.com'],
            [
                'name' => 'Admin Produk',
                'email' => 'adminproduk@example.com',
                'password' => Hash::make('admin123'),
                'phone' => '081234567891',
                'role' => 'admin_produk',
            ]
        );
    }
}
