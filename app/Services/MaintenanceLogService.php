<?php

namespace App\Services;

use App\Models\MaintenanceLog;
use App\Repositories\MaintenanceLogRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class MaintenanceLogService
{
    public function __construct(
        protected MaintenanceLogRepository $logRepository
    ) {}

    /**
     * Get paginated maintenance logs.
     */
    public function getPaginatedLogs(int $perPage = 25): LengthAwarePaginator
    {
        return $this->logRepository->getPaginated($perPage);
    }

    /**
     * Advanced search logs with filters.
     */
    public function advancedSearchLogs(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        return $this->logRepository->advancedSearch($filters, $perPage);
    }

    /**
     * Find log by ID.
     */
    public function findLogById(int $id): ?MaintenanceLog
    {
        return $this->logRepository->findById($id);
    }

    /**
     * Create new maintenance log.
     */
    public function createLog(array $data): MaintenanceLog
    {
        return $this->logRepository->create($data);
    }

    /**
     * Update maintenance log.
     */
    public function updateLog(MaintenanceLog $log, array $data): MaintenanceLog
    {
        return $this->logRepository->update($log, $data);
    }

    /**
     * Delete maintenance log.
     */
    public function deleteLog(MaintenanceLog $log): bool
    {
        return $this->logRepository->delete($log);
    }
}
