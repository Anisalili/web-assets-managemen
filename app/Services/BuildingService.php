<?php

namespace App\Services;

use App\Models\Building;
use App\Repositories\BuildingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BuildingService
{
    public function __construct(
        protected BuildingRepository $buildingRepository
    ) {}

    /**
     * Get all buildings.
     */
    public function getAllBuildings(): Collection
    {
        return $this->buildingRepository->getAll();
    }

    /**
     * Get paginated buildings.
     */
    public function getPaginatedBuildings(int $perPage = 25): LengthAwarePaginator
    {
        return $this->buildingRepository->getPaginated($perPage);
    }

    /**
     * Search buildings.
     */
    public function searchBuildings(string $query, int $perPage = 25): LengthAwarePaginator
    {
        return $this->buildingRepository->search($query, $perPage);
    }

    /**
     * Find building by ID.
     */
    public function findBuildingById(int $id): ?Building
    {
        return $this->buildingRepository->findById($id);
    }

    /**
     * Create new building.
     */
    public function createBuilding(array $data): Building
    {
        return $this->buildingRepository->create($data);
    }

    /**
     * Update building.
     */
    public function updateBuilding(Building $building, array $data): Building
    {
        $this->buildingRepository->update($building, $data);

        return $building->fresh();
    }

    /**
     * Delete building.
     * Validates that building has no rooms before deletion.
     */
    public function deleteBuilding(Building $building): bool
    {
        // Check if building has rooms
        if ($this->buildingRepository->hasRooms($building)) {
            $roomsCount = $this->buildingRepository->countRooms($building);
            throw new \Exception("Gagal menghapus gedung. Masih ada {$roomsCount} ruangan yang terhubung.");
        }

        return $this->buildingRepository->delete($building);
    }

    /**
     * Get total buildings count.
     */
    public function getTotalBuildings(): int
    {
        return $this->buildingRepository->count();
    }

    /**
     * Check if building can be deleted.
     */
    public function canDelete(Building $building): bool
    {
        return !$this->buildingRepository->hasRooms($building);
    }
}
