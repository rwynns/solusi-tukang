<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Location;

class TukangSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding 25 tukang dengan nama berbeda di 19 kecamatan Grobogan...');

        $locations = Location::all();
        $totalTukang = 25;
        $locationCount = $locations->count();

        // Daftar nama acak (25 nama unik/tidak pasaran)
        $names = [
            'Budi Santoso', 'Joko Pranoto', 'Andi Wijaya', 'Eko Saputro', 'Dedi Kurniawan',
            'Fajar Ramadhan', 'Gilang Permana', 'Hendra Susilo', 'Ilham Maulana', 'Johan Iskandar',
            'Kiki Prasetya', 'Lukman Hakim', 'Miko Suryana', 'Niko Wahyudi', 'Oki Firmansyah',
            'Pandu Mahesa', 'Rian Setiawan', 'Seno Ardi', 'Teguh Raharjo', 'Ujang Kusuma',
            'Vino Alamsyah', 'Wahyu Hidayat', 'Yogi Saputra', 'Zaki Ramadhan', 'Raka Wicaksono'
        ];

        for ($i = 0; $i < $totalTukang; $i++) {
            $location = $locations[$i % $locationCount];
            $name = $names[$i];

            $userId = DB::table('users')->insertGetId([
                'name' => $name,
                'email' => 'tukang' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'phone_number' => '0812' . rand(10000000, 99999999),
                'address' => 'Alamat di ' . $location->name,
                'role_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $profileId = DB::table('tukang_profiles')->insertGetId([
                'user_id' => $userId,
                'location_id' => $location->id,
                'bio' => 'Saya, ' . $name . ', adalah tukang yang melayani area ' . $location->name,
                'profile_photo' => 'profile-photos/default.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('tukang_skills')->insert([
                'tukang_profile_id' => $profileId,
                'sub_jasa_id' => rand(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $this->command->info("Tukang {$name} ditempatkan di " . $location->name);
        }

        $this->command->info('✅ Seeder tukang berhasil dibuat!');
    }
}
