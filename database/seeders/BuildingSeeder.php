<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Seeder;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $buildings = [
            [
                'building_code' => 'GD-UTAMA',
                'name' => 'Gedung Utama OMBÉ',
                'description' => 'Gedung utama PT. Panen Embun Kemakmuran dengan 2 lantai yang mencakup area produksi, kantor, dan fasilitas pendukung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Building::insert($buildings);
    }
}
