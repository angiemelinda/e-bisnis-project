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
        $this->call([
            CategorySeeder::class,
            // ProductSeeder::class, // Disabled - use manual product creation instead
        ]);

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

        // Seed default Dropshipper
        User::updateOrCreate(
            ['email' => 'dropshipper@example.com'],
            [
                'name' => 'Dropshipper Demo',
                'email' => 'dropshipper@example.com',
                'password' => Hash::make('dropshipper123'),
                'phone' => '081234567892',
                'role' => 'dropshipper',
            ]
        );

        // Seed default Supplier
        User::updateOrCreate(
            ['email' => 'supplier@example.com'],
            [
                'name' => 'Supplier Demo',
                'email' => 'supplier@example.com',
                'password' => Hash::make('supplier123'),
                'phone' => '081234567892',
                'role' => 'supplier',
            ]
        );
    }
}
