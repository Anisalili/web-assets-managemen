<?php

namespace App\Repositories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomRepository
{
    /**
     * Get all rooms with building relation.
     */
    public function getAll(): Collection
    {
        return Room::with('building')->orderBy('name')->get();
    }

    /**
     * Get paginated rooms with building relation.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return Room::with('building')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Advanced search rooms with filters.
     * Optimized: LIKE only on room_code and name (indexed columns)
     */
    public function advancedSearch(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        $query = Room::with('building');

        // Search by room_code and name only
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('room_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by building (exact match)
        if (!empty($filters['building_id'])) {
            $query->where('building_id', $filters['building_id']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Find room by ID with building relation.
     */
    public function findById(int $id): ?Room
    {
        return Room::with('building')->find($id);
    }

    /**
     * Create new room.
     */
    public function create(array $data): Room
    {
        return Room::create($data);
    }

    /**
     * Update room.
     */
    public function update(Room $room, array $data): bool
    {
        return $room->update($data);
    }

    /**
     * Delete room.
     */
    public function delete(Room $room): bool
    {
        return $room->delete();
    }

    /**
     * Get rooms count.
     */
    public function count(): int
    {
        return Room::count();
    }

    /**
     * Get rooms by building ID.
     */
    public function getByBuilding(int $buildingId): Collection
    {
        return Room::where('building_id', $buildingId)->orderBy('name')->get();
    }

    /**
     * Check if room_code exists (excluding specific room ID).
     */
    public function roomCodeExists(string $roomCode, ?int $excludeId = null): bool
    {
        $query = Room::where('room_code', $roomCode);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
