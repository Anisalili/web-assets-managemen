<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Mesin Produksi',
                'description' => 'Mesin-mesin untuk proses produksi air mineral',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Komputer & Laptop',
                'description' => 'Perangkat komputer untuk administrasi dan operasional',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Furniture Kantor',
                'description' => 'Meja, kursi, lemari dan furniture kantor lainnya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kendaraan',
                'description' => 'Kendaraan operasional dan distribusi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alat Laboratorium',
                'description' => 'Peralatan untuk quality control dan testing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Elektronik',
                'description' => 'Peralatan elektronik seperti AC, printer, scanner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Alat Safety',
                'description' => 'Peralatan keselamatan kerja',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        AssetCategory::insert($categories);

        $this->command->info('Asset Categories seeded successfully!');
    }
}
