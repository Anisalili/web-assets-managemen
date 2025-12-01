<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\AssetDamageReport;
use App\Models\AssetRepair;
use App\Models\User;
use Illuminate\Database\Seeder;

class DamageReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info("Seeding damage reports and repairs...");

        $assets = Asset::all();

        if ($assets->isEmpty()) {
            $this->command->warn("No assets found. Please seed assets first.");
            return;
        }

        // Get teknisi users
        $teknisiUsers = User::whereHas("roles", function ($query) {
            $query->where("name", "Teknisi");
        })->get();

        // Fallback to any user if no teknisi found
        if ($teknisiUsers->isEmpty()) {
            $teknisiUsers = User::limit(5)->get();
        }

        if ($teknisiUsers->isEmpty()) {
            $this->command->warn("No users found. Please seed users first.");
            return;
        }

        $damageTypes = [
            "mechanical",
            "electrical",
            "structural",
            "software",
            "hardware",
        ];
        $severities = ["ringan", "sedang", "berat"];
        $priorities = ["low", "medium", "high", "critical"];
        $statuses = ["dilaporkan", "dalam_proses", "selesai"];
        $repairStatuses = ["pending", "in_progress", "completed", "failed"];

        // Create 20 damage reports
        for ($i = 0; $i < 20; $i++) {
            $asset = $assets->random();
            $reportDate = now()->subDays(rand(1, 90));
            $status = $statuses[array_rand($statuses)];

            $reportedByUser = $teknisiUsers->random();
            $assignedUser = rand(0, 1) ? $teknisiUsers->random() : null;
            $resolvedByUser =
                $status === "selesai" && $assignedUser ? $assignedUser : null;

            $damageReport = AssetDamageReport::create([
                "asset_id" => $asset->id,
                "reported_by" => $reportedByUser->id,
                "assigned_to" => $assignedUser?->id,
                "report_date" => $reportDate,
                "severity" => $severities[array_rand($severities)],
                "damage_type" => $damageTypes[array_rand($damageTypes)],
                "priority" => $priorities[array_rand($priorities)],
                "description" =>
                    "Kerusakan pada " .
                    $asset->name .
                    ". Perlu penanganan segera.",
                "impact_on_operations" => rand(0, 1)
                    ? "Mengganggu operasional produksi"
                    : "Tidak mengganggu operasional",
                "estimated_repair_cost" => rand(0, 1)
                    ? rand(500000, 5000000)
                    : null,
                "status" => $status,
                "resolved_date" =>
                    $status === "selesai"
                        ? $reportDate->copy()->addDays(rand(1, 7))
                        : null,
                "resolved_by" => $resolvedByUser?->id,
            ]);

            // Create repair record if status is dalam_proses or selesai
            if (in_array($status, ["dalam_proses", "selesai"])) {
                $repairStartDate = $reportDate->copy()->addDays(1);
                $repairStatus =
                    $status === "selesai"
                        ? "completed"
                        : $repairStatuses[array_rand($repairStatuses)];

                $repairedByUser = $assignedUser ?? $teknisiUsers->random();

                AssetRepair::create([
                    "damage_report_id" => $damageReport->id,
                    "asset_id" => $asset->id,
                    "repair_start_date" => $repairStartDate,
                    "repair_end_date" =>
                        $repairStatus === "completed"
                            ? $repairStartDate->copy()->addDays(rand(1, 5))
                            : null,
                    "repaired_by" => $repairedByUser->id,
                    "assigned_to" => $assignedUser?->id,
                    "repair_description" =>
                        "Perbaikan untuk kerusakan: " .
                        $damageReport->description,
                    "spare_parts_used" => rand(0, 1)
                        ? "Spare part A, Spare part B"
                        : null,
                    "repair_cost" => rand(0, 1) ? rand(500000, 5000000) : null,
                    "status" => $repairStatus,
                    "notes" => rand(0, 1) ? "Perbaikan berjalan lancar" : null,
                ]);
            }
        }

        $this->command->info("Created 20 damage reports with related repairs.");
        $this->command->info("Damage reports and repairs seeded successfully!");
    }
}
