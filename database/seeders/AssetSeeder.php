<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetStatusHistory;
use App\Models\Room;
use Illuminate\Database\Seeder;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get categories and rooms
        $mesinProduksi = AssetCategory::where('name', 'Mesin Produksi')->first();
        $komputer = AssetCategory::where('name', 'Komputer & Laptop')->first();
        $furniture = AssetCategory::where('name', 'Furniture Kantor')->first();
        $kendaraan = AssetCategory::where('name', 'Kendaraan')->first();
        $elektronik = AssetCategory::where('name', 'Elektronik')->first();

        $rooms = Room::all();

        $assets = [
            // Mesin Produksi
            [
                'asset_code' => 'AST-MP-001',
                'name' => 'Mesin Filling Otomatis',
                'category_id' => $mesinProduksi->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'Bagian Produksi',
                'purchase_date' => '2023-01-15',
                'value' => 150000000,
                'notes' => 'Mesin filling untuk botol 600ml',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-MP-002',
                'name' => 'Mesin Labeling',
                'category_id' => $mesinProduksi->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'Bagian Produksi',
                'purchase_date' => '2023-02-20',
                'value' => 85000000,
                'notes' => 'Mesin untuk pemasangan label produk',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-MP-003',
                'name' => 'Conveyor Belt System',
                'category_id' => $mesinProduksi->id,
                'room_id' => $rooms->random()->id,
                'status' => 'dalam_perbaikan',
                'owner' => 'Bagian Produksi',
                'purchase_date' => '2022-11-10',
                'value' => 45000000,
                'notes' => 'Sistem conveyor sepanjang 50 meter',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Komputer & Laptop
            [
                'asset_code' => 'AST-IT-001',
                'name' => 'Laptop HP Pavilion 14',
                'category_id' => $komputer->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'Bagian IT',
                'purchase_date' => '2024-03-01',
                'value' => 8500000,
                'notes' => 'Laptop untuk staff administrasi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-IT-002',
                'name' => 'Desktop PC Dell OptiPlex',
                'category_id' => $komputer->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'Bagian IT',
                'purchase_date' => '2024-01-15',
                'value' => 12000000,
                'notes' => 'PC untuk kepala bagian',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-IT-003',
                'name' => 'Laptop Lenovo ThinkPad',
                'category_id' => $komputer->id,
                'room_id' => $rooms->random()->id,
                'status' => 'rusak',
                'owner' => 'Bagian Finance',
                'purchase_date' => '2021-08-20',
                'value' => 9000000,
                'notes' => 'Layar rusak, menunggu perbaikan',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Furniture
            [
                'asset_code' => 'AST-FR-001',
                'name' => 'Meja Kerja Kayu Jati',
                'category_id' => $furniture->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'General Affairs',
                'purchase_date' => '2023-05-10',
                'value' => 3500000,
                'notes' => 'Meja direktur',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-FR-002',
                'name' => 'Kursi Kantor Ergonomis',
                'category_id' => $furniture->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'General Affairs',
                'purchase_date' => '2023-05-10',
                'value' => 1500000,
                'notes' => 'Kursi dengan sandaran punggung adjustable',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kendaraan
            [
                'asset_code' => 'AST-VH-001',
                'name' => 'Toyota Avanza 2023',
                'category_id' => $kendaraan->id,
                'room_id' => null,
                'status' => 'aktif',
                'owner' => 'Pool Kendaraan',
                'purchase_date' => '2023-07-01',
                'value' => 250000000,
                'notes' => 'Kendaraan operasional direksi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-VH-002',
                'name' => 'Mitsubishi L300 Pick Up',
                'category_id' => $kendaraan->id,
                'room_id' => null,
                'status' => 'aktif',
                'owner' => 'Pool Kendaraan',
                'purchase_date' => '2022-03-15',
                'value' => 180000000,
                'notes' => 'Pick up untuk distribusi lokal',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Elektronik
            [
                'asset_code' => 'AST-EL-001',
                'name' => 'AC Split 2 PK Daikin',
                'category_id' => $elektronik->id,
                'room_id' => $rooms->random()->id,
                'status' => 'aktif',
                'owner' => 'Bagian Umum',
                'purchase_date' => '2023-09-01',
                'value' => 6500000,
                'notes' => 'AC untuk ruang server',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'asset_code' => 'AST-EL-002',
                'name' => 'Printer HP LaserJet Pro',
                'category_id' => $elektronik->id,
                'room_id' => $rooms->random()->id,
                'status' => 'non-aktif',
                'owner' => 'Bagian Administrasi',
                'purchase_date' => '2020-05-20',
                'value' => 3200000,
                'notes' => 'Printer cadangan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($assets as $assetData) {
            $asset = Asset::create($assetData);

            // Create initial status history
            AssetStatusHistory::create([
                'asset_id' => $asset->id,
                'previous_room_id' => null,
                'new_room_id' => $asset->room_id,
                'previous_status' => null,
                'new_status' => $asset->status,
                'changed_by' => 'System Seeder',
                'change_date' => now(),
                'notes' => 'Data awal dari seeder',
            ]);
        }

        $this->command->info('Assets and Asset Status History seeded successfully!');
    }
}
