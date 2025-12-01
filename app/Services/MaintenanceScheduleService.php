<?php

namespace App\Services;

use App\Models\MaintenanceSchedule;
use App\Repositories\MaintenanceScheduleRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceScheduleService
{
    public function __construct(
        protected MaintenanceScheduleRepository $scheduleRepository,
    ) {}

    /**
     * Get paginated maintenance schedules.
     */
    public function getPaginatedSchedules(
        int $perPage = 25,
    ): LengthAwarePaginator {
        return $this->scheduleRepository->getPaginated($perPage);
    }

    /**
     * Advanced search schedules with filters.
     */
    public function advancedSearchSchedules(
        array $filters,
        int $perPage = 25,
    ): LengthAwarePaginator {
        return $this->scheduleRepository->advancedSearch($filters, $perPage);
    }

    /**
     * Find schedule by ID.
     */
    public function findScheduleById(int $id): ?MaintenanceSchedule
    {
        return $this->scheduleRepository->findById($id);
    }

    /**
     * Create new maintenance schedule.
     */
    public function createSchedule(array $data): MaintenanceSchedule
    {
        // Handle image upload
        if (
            isset($data["image_path"]) &&
            $data["image_path"] instanceof \Illuminate\Http\UploadedFile
        ) {
            $data["image_path"] = $data["image_path"]->store(
                "maintenance-schedules",
                "public",
            );
        }

        return $this->scheduleRepository->create($data);
    }

    /**
     * Update maintenance schedule.
     */
    public function updateSchedule(
        MaintenanceSchedule $schedule,
        array $data,
    ): MaintenanceSchedule {
        // Handle image upload
        if (
            isset($data["image_path"]) &&
            $data["image_path"] instanceof \Illuminate\Http\UploadedFile
        ) {
            // Delete old image if exists
            if (
                $schedule->image_path &&
                \Storage::disk("public")->exists($schedule->image_path)
            ) {
                \Storage::disk("public")->delete($schedule->image_path);
            }
            $data["image_path"] = $data["image_path"]->store(
                "maintenance-schedules",
                "public",
            );
        }

        return $this->scheduleRepository->update($schedule, $data);
    }

    /**
     * Delete maintenance schedule.
     */
    public function deleteSchedule(MaintenanceSchedule $schedule): bool
    {
        return $this->scheduleRepository->delete($schedule);
    }
}
