<?php

namespace App\Services;

use App\Models\Room;
use App\Repositories\RoomRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoomService
{
    public function __construct(
        protected RoomRepository $roomRepository
    ) {}

    /**
     * Get all rooms.
     */
    public function getAllRooms(): Collection
    {
        return $this->roomRepository->getAll();
    }

    /**
     * Get paginated rooms.
     */
    public function getPaginatedRooms(int $perPage = 25): LengthAwarePaginator
    {
        return $this->roomRepository->getPaginated($perPage);
    }

    /**
     * Advanced search rooms with filters.
     */
    public function advancedSearchRooms(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        return $this->roomRepository->advancedSearch($filters, $perPage);
    }

    /**
     * Find room by ID.
     */
    public function findRoomById(int $id): ?Room
    {
        return $this->roomRepository->findById($id);
    }

    /**
     * Create new room.
     */
    public function createRoom(array $data): Room
    {
        return $this->roomRepository->create($data);
    }

    /**
     * Update room.
     */
    public function updateRoom(Room $room, array $data): Room
    {
        $this->roomRepository->update($room, $data);

        return $room->fresh('building');
    }

    /**
     * Delete room.
     */
    public function deleteRoom(Room $room): bool
    {
        return $this->roomRepository->delete($room);
    }

    /**
     * Get total rooms count.
     */
    public function getTotalRooms(): int
    {
        return $this->roomRepository->count();
    }

    /**
     * Get rooms by building.
     */
    public function getRoomsByBuilding(int $buildingId): Collection
    {
        return $this->roomRepository->getByBuilding($buildingId);
    }
}
