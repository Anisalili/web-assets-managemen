<?php

namespace App\Repositories;

use App\Models\AssetCategory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AssetCategoryRepository
{
    /**
     * Get all categories.
     */
    public function getAll(): Collection
    {
        return AssetCategory::orderBy('name')->get();
    }

    /**
     * Get paginated categories with assets count.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return AssetCategory::withCount('assets')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Search categories by name.
     * Optimized: LIKE only on name column (indexed/searchable)
     */
    public function search(string $query, int $perPage = 25): LengthAwarePaginator
    {
        return AssetCategory::withCount('assets')
            ->where('name', 'like', "%{$query}%")
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find category by ID.
     */
    public function findById(int $id): ?AssetCategory
    {
        return AssetCategory::find($id);
    }

    /**
     * Create new category.
     */
    public function create(array $data): AssetCategory
    {
        return AssetCategory::create($data);
    }

    /**
     * Update category.
     */
    public function update(AssetCategory $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * Delete category.
     */
    public function delete(AssetCategory $category): bool
    {
        return $category->delete();
    }

    /**
     * Get categories count.
     */
    public function count(): int
    {
        return AssetCategory::count();
    }

    /**
     * Check if category has assets.
     */
    public function hasAssets(AssetCategory $category): bool
    {
        return $category->assets()->exists();
    }

    /**
     * Count assets in category.
     */
    public function countAssets(AssetCategory $category): int
    {
        return $category->assets()->count();
    }
}
