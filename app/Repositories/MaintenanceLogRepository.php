<?php

namespace App\Repositories;

use App\Models\MaintenanceLog;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceLogRepository
{
    /**
     * Get paginated maintenance logs with relations.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return MaintenanceLog::with(['asset.category', 'asset.room.building', 'schedule'])
            ->latest('date_performed')
            ->paginate($perPage);
    }

    /**
     * Advanced search logs with filters.
     */
    public function advancedSearch(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        $query = MaintenanceLog::with(['asset.category', 'asset.room.building', 'schedule']);

        // Search by asset name, performed_by, result
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('performed_by', 'like', "%{$search}%")
                  ->orWhere('result', 'like', "%{$search}%")
                  ->orWhereHas('asset', function ($assetQuery) use ($search) {
                      $assetQuery->where('name', 'like', "%{$search}%")
                                 ->orWhere('asset_code', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by asset_id
        if (!empty($filters['asset_id'])) {
            $query->where('asset_id', $filters['asset_id']);
        }

        // Filter by schedule_id
        if (!empty($filters['schedule_id'])) {
            $query->where('schedule_id', $filters['schedule_id']);
        }

        // Filter by date range
        if (!empty($filters['date_from'])) {
            $query->where('date_performed', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->where('date_performed', '<=', $filters['date_to']);
        }

        return $query->latest('date_performed')->paginate($perPage);
    }

    /**
     * Find log by ID with relations.
     */
    public function findById(int $id): ?MaintenanceLog
    {
        return MaintenanceLog::with(['asset.category', 'asset.room.building', 'schedule'])
            ->find($id);
    }

    /**
     * Create new log.
     */
    public function create(array $data): MaintenanceLog
    {
        return MaintenanceLog::create($data);
    }

    /**
     * Update log.
     */
    public function update(MaintenanceLog $log, array $data): MaintenanceLog
    {
        $log->update($data);
        return $log->fresh(['asset.category', 'asset.room.building', 'schedule']);
    }

    /**
     * Delete log.
     */
    public function delete(MaintenanceLog $log): bool
    {
        return $log->delete();
    }
}
