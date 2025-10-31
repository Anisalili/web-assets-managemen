<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceSchedule;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding maintenance schedules and logs...');

        // Get all assets
        $assets = Asset::all();

        if ($assets->isEmpty()) {
            $this->command->warn('No assets found. Please seed assets first.');
            return;
        }

        // Create maintenance schedules
        $this->command->info('Creating maintenance schedules...');

        // Terjadwal (upcoming) - 15 schedules
        MaintenanceSchedule::factory()
            ->count(15)
            ->terjadwal()
            ->create();

        // Selesai (completed) - 20 schedules
        MaintenanceSchedule::factory()
            ->count(20)
            ->selesai()
            ->create();

        // Dibatalkan (cancelled) - 5 schedules
        MaintenanceSchedule::factory()
            ->count(5)
            ->dibatalkan()
            ->create();

        $this->command->info('Created 40 maintenance schedules.');

        // Create maintenance logs
        $this->command->info('Creating maintenance logs...');

        // Logs with related schedule (30 logs)
        MaintenanceLog::factory()
            ->count(30)
            ->withSchedule()
            ->create();

        // Standalone logs (no schedule) - 20 logs
        MaintenanceLog::factory()
            ->count(20)
            ->standalone()
            ->create();

        $this->command->info('Created 50 maintenance logs.');
        $this->command->info('Maintenance data seeded successfully!');
    }
}
