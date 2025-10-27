<?php

namespace App\Repositories;

use App\Models\Asset;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AssetRepository
{
    /**
     * Get paginated assets with relations.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return Asset::with(['category', 'room.building'])
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Advanced search assets with filters.
     * Optimized: LIKE only on indexed/searchable columns (asset_code, name, owner)
     */
    public function advancedSearch(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        $query = Asset::with(['category', 'room.building']);

        // Search by asset_code, name, owner (indexed columns only)
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('asset_code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%")
                  ->orWhere('owner', 'like', "%{$search}%");
            });
        }

        // Filter by categories (exact match, no LIKE - better performance)
        if (!empty($filters['category_id']) && is_array($filters['category_id'])) {
            $query->whereIn('category_id', $filters['category_id']);
        }

        // Filter by rooms (exact match)
        if (!empty($filters['room_id']) && is_array($filters['room_id'])) {
            $query->whereIn('room_id', $filters['room_id']);
        }

        // Filter by status (exact match)
        if (!empty($filters['status']) && is_array($filters['status'])) {
            $query->whereIn('status', $filters['status']);
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Find asset by ID with relations.
     */
    public function findById(int $id): ?Asset
    {
        return Asset::with(['category', 'room.building', 'statusHistory.previousRoom', 'statusHistory.newRoom'])
            ->find($id);
    }

    /**
     * Create new asset.
     */
    public function create(array $data): Asset
    {
        return Asset::create($data);
    }

    /**
     * Update asset.
     */
    public function update(Asset $asset, array $data): bool
    {
        return $asset->update($data);
    }

    /**
     * Soft delete asset.
     */
    public function delete(Asset $asset): bool
    {
        return $asset->delete();
    }

    /**
     * Get assets count.
     */
    public function count(): int
    {
        return Asset::count();
    }

    /**
     * Check if asset_code exists (excluding specific asset ID).
     */
    public function assetCodeExists(string $assetCode, ?int $excludeId = null): bool
    {
        $query = Asset::where('asset_code', $assetCode);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Get all assets for specific category.
     */
    public function getByCategory(int $categoryId): Collection
    {
        return Asset::where('category_id', $categoryId)->get();
    }

    /**
     * Get all assets for specific room.
     */
    public function getByRoom(int $roomId): Collection
    {
        return Asset::where('room_id', $roomId)->get();
    }

    /**
     * Count assets by status.
     */
    public function countByStatus(string $status): int
    {
        return Asset::where('status', $status)->count();
    }
}
