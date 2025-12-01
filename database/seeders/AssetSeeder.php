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
        // Get categories
        $mesinProduksi = AssetCategory::where(
            "name",
            "Mesin Produksi",
        )->first();
        $komputer = AssetCategory::where("name", "Komputer & Laptop")->first();
        $furniture = AssetCategory::where("name", "Furniture Kantor")->first();
        $kendaraan = AssetCategory::where("name", "Kendaraan")->first();
        $elektronik = AssetCategory::where("name", "Elektronik")->first();

        // Get specific rooms based on new structure
        $ruangFillingBotol = Room::where("room_code", "LT1-011")->first();
        $ruangFillingGalon = Room::where("room_code", "LT1-009")->first();
        $ruangFillingCup = Room::where("room_code", "LT1-010")->first();
        $ruangQC = Room::where("room_code", "LT1-018")->first();
        $areaProduksi = Room::where("room_code", "LT1-015")->first();
        $ruangServer = Room::where("room_code", "LT1-024")->first();
        $ruangDirektur = Room::where("room_code", "LT1-032")->first();
        $ruangFinance = Room::where("room_code", "LT2-005")->first();
        $ruangHRD = Room::where("room_code", "LT1-026")->first();
        $ruangMarketing = Room::where("room_code", "LT2-007")->first();
        $ruangManagerPlant = Room::where("room_code", "LT1-027")->first();
        $gudangProdukJadi = Room::where("room_code", "LT1-014")->first();
        $areaWasherGalon = Room::where("room_code", "LT1-008")->first();

        $assets = [
            // Mesin Produksi - Ruang Filling Botol
            [
                "asset_code" => "AST-MP-001",
                "name" => "Mesin Filling Botol Otomatis",
                "category_id" => $mesinProduksi->id,
                "room_id" => $ruangFillingBotol->id,
                "status" => "aktif",
                "owner" => "Bagian Produksi",
                "purchase_date" => "2023-01-15",
                "value" => 150000000,
                "notes" =>
                    "Mesin filling untuk botol 600ml di Ruang Filling Botol",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-MP-002",
                "name" => "Mesin Labeling Botol",
                "category_id" => $mesinProduksi->id,
                "room_id" => $ruangFillingBotol->id,
                "status" => "aktif",
                "owner" => "Bagian Produksi",
                "purchase_date" => "2023-02-20",
                "value" => 85000000,
                "notes" => "Mesin untuk pemasangan label produk botol",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-MP-003",
                "name" => "Conveyor Belt System",
                "category_id" => $mesinProduksi->id,
                "room_id" => $areaProduksi->id,
                "status" => "dalam_perbaikan",
                "owner" => "Bagian Produksi",
                "purchase_date" => "2022-11-10",
                "value" => 45000000,
                "notes" =>
                    "Sistem conveyor sepanjang 50 meter di Area Produksi",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-MP-004",
                "name" => "Mesin Filling Galon Otomatis",
                "category_id" => $mesinProduksi->id,
                "room_id" => $ruangFillingGalon->id,
                "status" => "aktif",
                "owner" => "Bagian Produksi",
                "purchase_date" => "2023-03-10",
                "value" => 180000000,
                "notes" =>
                    "Mesin filling untuk galon 19L di Ruang Filling Galon",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-MP-005",
                "name" => "Mesin Filling Cup",
                "category_id" => $mesinProduksi->id,
                "room_id" => $ruangFillingCup->id,
                "status" => "aktif",
                "owner" => "Bagian Produksi",
                "purchase_date" => "2023-04-05",
                "value" => 95000000,
                "notes" => "Mesin filling untuk cup 220ml di Ruang Filling Cup",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-MP-006",
                "name" => "Mesin Washer Galon",
                "category_id" => $mesinProduksi->id,
                "room_id" => $areaWasherGalon->id,
                "status" => "aktif",
                "owner" => "Bagian Produksi",
                "purchase_date" => "2022-12-20",
                "value" => 120000000,
                "notes" => "Mesin pencuci galon otomatis di Area Washer Galon",
                "created_at" => now(),
                "updated_at" => now(),
            ],

            // Komputer & Laptop
            [
                "asset_code" => "AST-IT-001",
                "name" => "Laptop HP Pavilion 14",
                "category_id" => $komputer->id,
                "room_id" => $ruangFinance->id,
                "status" => "aktif",
                "owner" => "Bagian Finance",
                "purchase_date" => "2024-03-01",
                "value" => 8500000,
                "notes" => "Laptop untuk staff Finance dan Accounting",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-IT-002",
                "name" => "Desktop PC Dell OptiPlex",
                "category_id" => $komputer->id,
                "room_id" => $ruangManagerPlant->id,
                "status" => "aktif",
                "owner" => "Manager Plant",
                "purchase_date" => "2024-01-15",
                "value" => 12000000,
                "notes" => "PC untuk Manager Plant",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-IT-003",
                "name" => "Laptop Lenovo ThinkPad",
                "category_id" => $komputer->id,
                "room_id" => $ruangFinance->id,
                "status" => "rusak",
                "owner" => "Bagian Finance",
                "purchase_date" => "2021-08-20",
                "value" => 9000000,
                "notes" => "Layar rusak, menunggu perbaikan",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-IT-004",
                "name" => "Laptop Asus ROG",
                "category_id" => $komputer->id,
                "room_id" => $ruangServer->id,
                "status" => "aktif",
                "owner" => "Bagian IT",
                "purchase_date" => "2024-02-10",
                "value" => 18000000,
                "notes" => "Laptop untuk IT Server Management",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-IT-005",
                "name" => "PC Dell Precision Workstation",
                "category_id" => $komputer->id,
                "room_id" => $ruangQC->id,
                "status" => "aktif",
                "owner" => "Bagian QC",
                "purchase_date" => "2023-11-20",
                "value" => 15000000,
                "notes" => "PC untuk Quality Control data analysis",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-IT-006",
                "name" => "Laptop MacBook Pro",
                "category_id" => $komputer->id,
                "room_id" => $ruangMarketing->id,
                "status" => "aktif",
                "owner" => "Bagian Marketing",
                "purchase_date" => "2024-01-05",
                "value" => 25000000,
                "notes" => "Laptop untuk desain marketing",
                "created_at" => now(),
                "updated_at" => now(),
            ],

            // Furniture
            [
                "asset_code" => "AST-FR-001",
                "name" => "Meja Kerja Kayu Jati Executive",
                "category_id" => $furniture->id,
                "room_id" => $ruangDirektur->id,
                "status" => "aktif",
                "owner" => "General Affairs",
                "purchase_date" => "2023-05-10",
                "value" => 3500000,
                "notes" => "Meja direktur di Ruang Direktur Lt. 1",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-FR-002",
                "name" => "Kursi Direktur Ergonomis",
                "category_id" => $furniture->id,
                "room_id" => $ruangDirektur->id,
                "status" => "aktif",
                "owner" => "General Affairs",
                "purchase_date" => "2023-05-10",
                "value" => 2500000,
                "notes" => "Kursi direktur dengan sandaran punggung adjustable",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-FR-003",
                "name" => "Meja Kerja Staff (Set 5)",
                "category_id" => $furniture->id,
                "room_id" => $ruangFinance->id,
                "status" => "aktif",
                "owner" => "General Affairs",
                "purchase_date" => "2023-06-15",
                "value" => 7500000,
                "notes" => "Set meja untuk staff Finance dan Accounting",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-FR-004",
                "name" => "Kursi Staff (Set 10)",
                "category_id" => $furniture->id,
                "room_id" => $ruangFinance->id,
                "status" => "aktif",
                "owner" => "General Affairs",
                "purchase_date" => "2023-06-15",
                "value" => 5000000,
                "notes" => "Set kursi untuk staff Finance dan Marketing",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-FR-005",
                "name" => "Meja Meeting Besar",
                "category_id" => $furniture->id,
                "room_id" => Room::where("room_code", "LT1-030")->first()->id,
                "status" => "aktif",
                "owner" => "General Affairs",
                "purchase_date" => "2023-07-20",
                "value" => 8000000,
                "notes" =>
                    "Meja meeting kapasitas 12 orang di Ruang Meeting Lt. 1",
                "created_at" => now(),
                "updated_at" => now(),
            ],

            // Kendaraan
            [
                "asset_code" => "AST-VH-001",
                "name" => "Toyota Avanza 2023",
                "category_id" => $kendaraan->id,
                "room_id" => null,
                "status" => "aktif",
                "owner" => "Pool Kendaraan",
                "purchase_date" => "2023-07-01",
                "value" => 250000000,
                "notes" => "Kendaraan operasional direksi",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-VH-002",
                "name" => "Mitsubishi L300 Pick Up",
                "category_id" => $kendaraan->id,
                "room_id" => null,
                "status" => "aktif",
                "owner" => "Pool Kendaraan",
                "purchase_date" => "2022-03-15",
                "value" => 180000000,
                "notes" => "Pick up untuk distribusi lokal",
                "created_at" => now(),
                "updated_at" => now(),
            ],

            // Elektronik
            [
                "asset_code" => "AST-EL-001",
                "name" => "AC Split 3 PK Daikin",
                "category_id" => $elektronik->id,
                "room_id" => $ruangServer->id,
                "status" => "aktif",
                "owner" => "Bagian IT",
                "purchase_date" => "2023-09-01",
                "value" => 8500000,
                "notes" => "AC untuk Ruang Server",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-EL-002",
                "name" => "Printer HP LaserJet Pro",
                "category_id" => $elektronik->id,
                "room_id" => $ruangFinance->id,
                "status" => "aktif",
                "owner" => "Bagian Finance",
                "purchase_date" => "2023-05-20",
                "value" => 3200000,
                "notes" => "Printer untuk Finance dan Accounting",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-EL-003",
                "name" => "AC Split 2 PK LG (Set 3)",
                "category_id" => $elektronik->id,
                "room_id" => $ruangQC->id,
                "status" => "aktif",
                "owner" => "Bagian Umum",
                "purchase_date" => "2023-08-15",
                "value" => 18000000,
                "notes" => "AC untuk Ruang QC, Ruang Sample, dan Retain Sample",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-EL-004",
                "name" => "Printer Canon ImageRunner",
                "category_id" => $elektronik->id,
                "room_id" => $ruangHRD->id,
                "status" => "aktif",
                "owner" => "Bagian HRD",
                "purchase_date" => "2023-10-10",
                "value" => 4500000,
                "notes" => "Printer multifungsi untuk HRD",
                "created_at" => now(),
                "updated_at" => now(),
            ],
            [
                "asset_code" => "AST-EL-005",
                "name" => "CCTV System (Set 16 Camera)",
                "category_id" => $elektronik->id,
                "room_id" => $ruangServer->id,
                "status" => "aktif",
                "owner" => "Bagian Security",
                "purchase_date" => "2023-11-01",
                "value" => 25000000,
                "notes" =>
                    "Sistem CCTV untuk seluruh gedung, DVR di Ruang Server",
                "created_at" => now(),
                "updated_at" => now(),
            ],
        ];

        foreach ($assets as $assetData) {
            $asset = Asset::create($assetData);

            // Create initial status history (skip for now - will be added after users seeded)
            // AssetStatusHistory will be created in MaintenanceSeeder after User table is populated
        }

        $this->command->info(
            "Assets and Asset Status History seeded successfully!",
        );
    }
}
