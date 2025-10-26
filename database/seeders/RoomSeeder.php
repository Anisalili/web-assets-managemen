<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get buildings
        $produksi1 = Building::where('building_code', 'GD-001')->first();
        $produksi2 = Building::where('building_code', 'GD-002')->first();
        $gudang = Building::where('building_code', 'GD-003')->first();
        $kantor = Building::where('building_code', 'GD-004')->first();
        $workshop = Building::where('building_code', 'GD-005')->first();

        $rooms = [
            // Gedung Produksi 1
            [
                'room_code' => 'R-001',
                'building_id' => $produksi1->id,
                'name' => 'Ruang Produksi Cup',
                'description' => 'Ruang produksi untuk kemasan cup 220ml',
            ],
            [
                'room_code' => 'R-002',
                'building_id' => $produksi1->id,
                'name' => 'Ruang Produksi Botol',
                'description' => 'Ruang produksi untuk kemasan botol berbagai ukuran',
            ],
            [
                'room_code' => 'R-003',
                'building_id' => $produksi1->id,
                'name' => 'Ruang Quality Control',
                'description' => 'Ruang pemeriksaan kualitas produk',
            ],

            // Gedung Produksi 2
            [
                'room_code' => 'R-004',
                'building_id' => $produksi2->id,
                'name' => 'Ruang Produksi Galon',
                'description' => 'Ruang produksi untuk kemasan galon 19L',
            ],
            [
                'room_code' => 'R-005',
                'building_id' => $produksi2->id,
                'name' => 'Ruang Packing',
                'description' => 'Ruang pengemasan dan labeling produk',
            ],

            // Gudang Penyimpanan
            [
                'room_code' => 'R-006',
                'building_id' => $gudang->id,
                'name' => 'Gudang Bahan Baku',
                'description' => 'Penyimpanan bahan baku produksi',
            ],
            [
                'room_code' => 'R-007',
                'building_id' => $gudang->id,
                'name' => 'Gudang Produk Jadi',
                'description' => 'Penyimpanan produk siap distribusi',
            ],

            // Gedung Kantor
            [
                'room_code' => 'R-008',
                'building_id' => $kantor->id,
                'name' => 'Ruang Direktur',
                'description' => 'Ruang kerja direktur utama',
            ],
            [
                'room_code' => 'R-009',
                'building_id' => $kantor->id,
                'name' => 'Ruang Admin & Keuangan',
                'description' => 'Ruang kerja bagian administrasi dan keuangan',
            ],
            [
                'room_code' => 'R-010',
                'building_id' => $kantor->id,
                'name' => 'Ruang IT',
                'description' => 'Ruang kerja tim IT dan server',
            ],

            // Workshop Maintenance
            [
                'room_code' => 'R-011',
                'building_id' => $workshop->id,
                'name' => 'Workshop Mekanik',
                'description' => 'Area perbaikan mesin dan peralatan mekanik',
            ],
            [
                'room_code' => 'R-012',
                'building_id' => $workshop->id,
                'name' => 'Gudang Spare Part',
                'description' => 'Penyimpanan suku cadang dan spare part',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
