<?php

namespace Database\Seeders;

use App\Models\Jasa;
use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Get admin role from existing roles table
        $adminRole = Role::where('name', 'admin')->first();

        // If admin role doesn't exist, create it
        if (!$adminRole) {
            $adminRole = Role::create([
                'name' => 'admin',
                'description' => 'Administrator with full access'
            ]);
        }

        // Create admin user
        User::firstOrCreate(
            ['email' => 'admin@solusitukang.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('admin123'),
                'phone_number' => '081234567890',
                'address' => 'Jl. Admin No. 1, Jakarta',
                'role_id' => $adminRole->id,
            ]
        );

        $this->call([
            JasaSeeder::class,
            SubJasaSeeder::class,
            LocationSeeder::class
        ]);
    }
}
