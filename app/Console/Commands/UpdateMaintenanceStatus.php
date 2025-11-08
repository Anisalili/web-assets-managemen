<?php

namespace App\Console\Commands;

use App\Models\MaintenanceSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateMaintenanceStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update maintenance schedule status based on scheduled date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Updating maintenance schedule statuses...');

        $today = Carbon::today();
        $updatedCount = 0;

        // Update status dari 'terjadwal' ke 'perlu_maintenance' jika sudah sampai tanggal
        $schedulesToUpdate = MaintenanceSchedule::where('status', MaintenanceSchedule::STATUS_TERJADWAL)
            ->whereDate('scheduled_date', '<=', $today)
            ->get();

        foreach ($schedulesToUpdate as $schedule) {
            $schedule->status = MaintenanceSchedule::STATUS_PERLU_MAINTENANCE;
            $schedule->save();
            $updatedCount++;

            $this->line("Updated schedule #{$schedule->id} for asset: {$schedule->asset->name}");
        }

        $this->info("Successfully updated {$updatedCount} maintenance schedule(s).");

        // Optional: Log overdue schedules (past deadline)
        $overdueCount = 0;
        $overdueSchedules = MaintenanceSchedule::where('status', MaintenanceSchedule::STATUS_PERLU_MAINTENANCE)
            ->get()
            ->filter(function ($schedule) {
                $deadline = $schedule->getDeadlineDate();
                return $deadline->isPast();
            });

        foreach ($overdueSchedules as $schedule) {
            $overdueCount++;
            $deadline = $schedule->getDeadlineDate()->format('Y-m-d');
            $this->warn("⚠ Schedule #{$schedule->id} is overdue (deadline: {$deadline})");
        }

        if ($overdueCount > 0) {
            $this->warn("Found {$overdueCount} overdue schedule(s) that need immediate attention!");
        }

        return Command::SUCCESS;
    }
}
