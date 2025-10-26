<?php

namespace App\Repositories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BuildingRepository
{
    /**
     * Get all buildings.
     */
    public function getAll(): Collection
    {
        return Building::orderBy('name')->get();
    }

    /**
     * Get paginated buildings with rooms count.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return Building::withCount('rooms')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Search buildings.
     * Optimized: LIKE only on building_code and name (indexed columns)
     */
    public function search(string $query, int $perPage = 25): LengthAwarePaginator
    {
        return Building::withCount('rooms')
            ->where(function ($q) use ($query) {
                $q->where('building_code', 'like', "%{$query}%")
                  ->orWhere('name', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find building by ID with relations.
     */
    public function findById(int $id): ?Building
    {
        return Building::withCount('rooms')
            ->with(['rooms' => function ($query) {
                $query->latest()->take(10);
            }])
            ->find($id);
    }

    /**
     * Create new building.
     */
    public function create(array $data): Building
    {
        return Building::create($data);
    }

    /**
     * Update building.
     */
    public function update(Building $building, array $data): bool
    {
        return $building->update($data);
    }

    /**
     * Delete building.
     */
    public function delete(Building $building): bool
    {
        return $building->delete();
    }

    /**
     * Get buildings count.
     */
    public function count(): int
    {
        return Building::count();
    }

    /**
     * Check if building has rooms.
     */
    public function hasRooms(Building $building): bool
    {
        return $building->rooms()->exists();
    }

    /**
     * Count rooms in building.
     */
    public function countRooms(Building $building): int
    {
        return $building->rooms()->count();
    }

    /**
     * Check if building_code exists (excluding specific building ID).
     */
    public function buildingCodeExists(string $buildingCode, ?int $excludeId = null): bool
    {
        $query = Building::where('building_code', $buildingCode);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
