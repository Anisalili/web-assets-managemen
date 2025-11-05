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
        // Get building
        $gedungUtama = Building::where('building_code', 'GD-UTAMA')->first();

        $rooms = [
            // ==================== LANTAI 1 ====================

            // Area Kimia & Utility
            [
                'room_code' => 'LT1-001',
                'building_id' => $gedungUtama->id,
                'name' => 'Gudang Kimia',
                'description' => 'Penyimpanan bahan kimia untuk produksi',
            ],
            [
                'room_code' => 'LT1-002',
                'building_id' => $gedungUtama->id,
                'name' => 'Material Galon',
                'description' => 'Penyimpanan material galon kosong',
            ],
            [
                'room_code' => 'LT1-003',
                'building_id' => $gedungUtama->id,
                'name' => 'Parkir Forklift',
                'description' => 'Area parkir forklift',
            ],
            [
                'room_code' => 'LT1-004',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Kompresor',
                'description' => 'Ruang mesin kompresor',
            ],
            [
                'room_code' => 'LT1-005',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Water Treatment',
                'description' => 'Ruang pengolahan air',
            ],
            [
                'room_code' => 'LT1-006',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Gudang Kotak Produk',
                'description' => 'Gudang penyimpanan kotak produk',
            ],

            // Area Pencucian Galon
            [
                'room_code' => 'LT1-007',
                'building_id' => $gedungUtama->id,
                'name' => 'Area Prewash Galon',
                'description' => 'Area pencucian awal galon',
            ],
            [
                'room_code' => 'LT1-008',
                'building_id' => $gedungUtama->id,
                'name' => 'Area Washer Galon',
                'description' => 'Area mesin pencucian galon',
            ],

            // Area Filling & Produksi
            [
                'room_code' => 'LT1-009',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Filling Galon',
                'description' => 'Ruang pengisian galon',
            ],
            [
                'room_code' => 'LT1-010',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Filling Cup',
                'description' => 'Ruang pengisian cup',
            ],
            [
                'room_code' => 'LT1-011',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Filling Botol',
                'description' => 'Ruang pengisian botol',
            ],
            [
                'room_code' => 'LT1-012',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Ganti',
                'description' => 'Ruang ganti karyawan produksi',
            ],
            [
                'room_code' => 'LT1-013',
                'building_id' => $gedungUtama->id,
                'name' => 'Storage',
                'description' => 'Area penyimpanan sementara',
            ],

            // Area Produksi & Gudang
            [
                'room_code' => 'LT1-014',
                'building_id' => $gedungUtama->id,
                'name' => 'Gudang Produk Jadi',
                'description' => 'Gudang penyimpanan produk jadi',
            ],
            [
                'room_code' => 'LT1-015',
                'building_id' => $gedungUtama->id,
                'name' => 'Area Produksi',
                'description' => 'Area produksi utama',
            ],
            [
                'room_code' => 'LT1-016',
                'building_id' => $gedungUtama->id,
                'name' => 'Loading Barang',
                'description' => 'Area loading dan unloading barang',
            ],

            // Area Quality Control
            [
                'room_code' => 'LT1-017',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Sample',
                'description' => 'Ruang penyimpanan sample produk',
            ],
            [
                'room_code' => 'LT1-018',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang QC',
                'description' => 'Ruang Quality Control',
            ],
            [
                'room_code' => 'LT1-019',
                'building_id' => $gedungUtama->id,
                'name' => 'Retain Sample',
                'description' => 'Ruang penyimpanan retain sample',
            ],

            // Area Operasional & Teknik
            [
                'room_code' => 'LT1-020',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Panel',
                'description' => 'Ruang panel kontrol listrik',
            ],
            [
                'room_code' => 'LT1-021',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Adm Gudang',
                'description' => 'Ruang administrasi gudang',
            ],
            [
                'room_code' => 'LT1-022',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Sparepart Teknong',
                'description' => 'Ruang sparepart teknologi',
            ],
            [
                'room_code' => 'LT1-023',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Adm Teknik',
                'description' => 'Ruang administrasi teknik',
            ],
            [
                'room_code' => 'LT1-024',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Server',
                'description' => 'Ruang server IT',
            ],

            // Area Manajemen Lantai 1
            [
                'room_code' => 'LT1-025',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Produksi',
                'description' => 'Ruang kepala produksi',
            ],
            [
                'room_code' => 'LT1-026',
                'building_id' => $gedungUtama->id,
                'name' => 'R. HRD',
                'description' => 'Ruang HRD',
            ],
            [
                'room_code' => 'LT1-027',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Manager Plant',
                'description' => 'Ruang Manager Plant',
            ],

            // Fasilitas Umum Lantai 1
            [
                'room_code' => 'LT1-028',
                'building_id' => $gedungUtama->id,
                'name' => 'Toilet Lt. 1 (Area 1)',
                'description' => 'Toilet area pertama lantai 1',
            ],
            [
                'room_code' => 'LT1-029',
                'building_id' => $gedungUtama->id,
                'name' => 'Toilet Lt. 1 (Area 2)',
                'description' => 'Toilet area kedua lantai 1',
            ],
            [
                'room_code' => 'LT1-030',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Meeting Lt. 1',
                'description' => 'Ruang meeting lantai 1',
            ],
            [
                'room_code' => 'LT1-031',
                'building_id' => $gedungUtama->id,
                'name' => 'Lobby Lt. 1',
                'description' => 'Lobby lantai 1',
            ],
            [
                'room_code' => 'LT1-032',
                'building_id' => $gedungUtama->id,
                'name' => 'Ruang Direktur Lt. 1',
                'description' => 'Ruang direktur di lantai 1',
            ],

            // ==================== LANTAI 2 ====================

            // Area Teknik Lantai 2
            [
                'room_code' => 'LT2-001',
                'building_id' => $gedungUtama->id,
                'name' => 'Final Tank',
                'description' => 'Tangki final untuk proses produksi',
            ],
            [
                'room_code' => 'LT2-002',
                'building_id' => $gedungUtama->id,
                'name' => 'AHU',
                'description' => 'Air Handling Unit',
            ],

            // Area Gudang Lantai 2
            [
                'room_code' => 'LT2-003',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Gudang HRD',
                'description' => 'Gudang dokumen HRD',
            ],
            [
                'room_code' => 'LT2-004',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Gudang Finance',
                'description' => 'Gudang dokumen finance',
            ],

            // Area Kantor Lantai 2
            [
                'room_code' => 'LT2-005',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Finance Dan Accounting',
                'description' => 'Ruang finance dan accounting',
            ],
            [
                'room_code' => 'LT2-006',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Admin Logistik',
                'description' => 'Ruang administrasi logistik',
            ],
            [
                'room_code' => 'LT2-007',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Marketing',
                'description' => 'Ruang marketing',
            ],
            [
                'room_code' => 'LT2-008',
                'building_id' => $gedungUtama->id,
                'name' => 'Manager Finance',
                'description' => 'Ruang manager finance',
            ],

            // Fasilitas Umum Lantai 2
            [
                'room_code' => 'LT2-009',
                'building_id' => $gedungUtama->id,
                'name' => 'Toilet Lt. 2',
                'description' => 'Toilet lantai 2',
            ],
            [
                'room_code' => 'LT2-010',
                'building_id' => $gedungUtama->id,
                'name' => 'R. Meeting Lt. 2',
                'description' => 'Ruang meeting lantai 2',
            ],
            [
                'room_code' => 'LT2-011',
                'building_id' => $gedungUtama->id,
                'name' => 'Kamar Direktur',
                'description' => 'Kamar/ruang istirahat direktur',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
