<?php

namespace App\Repositories;

use App\Models\MaintenanceSchedule;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceScheduleRepository
{
    /**
     * Get paginated maintenance schedules with relations.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return MaintenanceSchedule::with([
            "asset.category",
            "asset.room.building",
        ])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Advanced search schedules with filters.
     */
    public function advancedSearch(
        array $filters,
        int $perPage = 25,
    ): LengthAwarePaginator {
        $query = MaintenanceSchedule::with([
            "asset.category",
            "asset.room.building",
        ]);

        // Search by asset name, assigned_to, description
        if (!empty($filters["search"])) {
            $search = $filters["search"];
            $query->where(function ($q) use ($search) {
                $q->where("assigned_to", "like", "%{$search}%")
                    ->orWhere("description", "like", "%{$search}%")
                    ->orWhereHas("asset", function ($assetQuery) use ($search) {
                        $assetQuery
                            ->where("name", "like", "%{$search}%")
                            ->orWhere("asset_code", "like", "%{$search}%");
                    });
            });
        }

        // Filter by asset_id
        if (!empty($filters["asset_id"])) {
            $query->where("asset_id", $filters["asset_id"]);
        }

        // Filter by status
        if (!empty($filters["status"]) && is_array($filters["status"])) {
            $query->whereIn("status", $filters["status"]);
        }

        // Filter by frequency
        if (!empty($filters["frequency"]) && is_array($filters["frequency"])) {
            $query->whereIn("frequency", $filters["frequency"]);
        }

        // Filter by date range
        if (!empty($filters["date_from"])) {
            $query->where("scheduled_date", ">=", $filters["date_from"]);
        }

        if (!empty($filters["date_to"])) {
            $query->where("scheduled_date", "<=", $filters["date_to"]);
        }

        // Filter by assigned_to (untuk teknisi)
        if (!empty($filters["assigned_to"])) {
            $query->where("assigned_to", $filters["assigned_to"]);
        }

        return $query->latest("scheduled_date")->paginate($perPage);
    }

    /**
     * Find schedule by ID with relations.
     */
    public function findById(int $id): ?MaintenanceSchedule
    {
        return MaintenanceSchedule::with([
            "asset.category",
            "asset.room.building",
            "logs",
        ])->find($id);
    }

    /**
     * Create new schedule.
     */
    public function create(array $data): MaintenanceSchedule
    {
        return MaintenanceSchedule::create($data);
    }

    /**
     * Update schedule.
     */
    public function update(
        MaintenanceSchedule $schedule,
        array $data,
    ): MaintenanceSchedule {
        $schedule->update($data);
        return $schedule->fresh(["asset.category", "asset.room.building"]);
    }

    /**
     * Delete schedule.
     */
    public function delete(MaintenanceSchedule $schedule): bool
    {
        return $schedule->delete();
    }
}
