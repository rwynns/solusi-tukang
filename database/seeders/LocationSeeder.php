<?php

namespace Database\Seeders;

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Brati',
            'Gabus',
            'Geyer',
            'Godong',
            'Grobogan',
            'Gubug',
            'Karangrayung',
            'Kedungjati',
            'Klambu',
            'Kradenan',
            'Ngaringan',
            'Penawangan',
            'Pulokulon',
            'Purwodadi',
            'Tanggungharjo',
            'Tawangharjo',
            'Tegowanu',
            'Toroh',
            'Wirosari'
        ];

        $this->command->info('Seeding locations...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        Location::truncate();

        foreach ($locations as $locationName) {
            try {
                Location::create([
                    'name' => $locationName
                ]);
                $this->command->info("Added location: {$locationName}");
            } catch (\Exception $e) {
                $this->command->error("Failed to add location {$locationName}: {$e->getMessage()}");
            }
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->command->info('Location seeding completed!');
    }
}
