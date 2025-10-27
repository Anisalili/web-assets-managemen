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
                'building_code' => 'GD-001',
                'name' => 'Gedung Produksi 1',
                'description' => 'Gedung utama produksi air mineral OMBÉ dengan kapasitas produksi 10.000 botol per hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_code' => 'GD-002',
                'name' => 'Gedung Produksi 2',
                'description' => 'Gedung produksi tambahan untuk memenuhi peningkatan permintaan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_code' => 'GD-003',
                'name' => 'Gudang Penyimpanan',
                'description' => 'Gudang untuk penyimpanan bahan baku dan produk jadi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_code' => 'GD-004',
                'name' => 'Gedung Kantor',
                'description' => 'Gedung kantor administrasi dan manajemen PT. Panen Embun Kemakmuran',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'building_code' => 'GD-005',
                'name' => 'Workshop Maintenance',
                'description' => 'Workshop untuk perawatan dan perbaikan mesin produksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Building::insert($buildings);
    }
}
