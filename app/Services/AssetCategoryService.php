<?php

namespace App\Services;

use App\Models\AssetCategory;
use App\Repositories\AssetCategoryRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class AssetCategoryService
{
    public function __construct(
        protected AssetCategoryRepository $categoryRepository
    ) {}

    /**
     * Get all categories.
     */
    public function getAllCategories(): Collection
    {
        return $this->categoryRepository->getAll();
    }

    /**
     * Get paginated categories.
     */
    public function getPaginatedCategories(int $perPage = 25): LengthAwarePaginator
    {
        return $this->categoryRepository->getPaginated($perPage);
    }

    /**
     * Search categories by name.
     */
    public function searchCategories(string $query, int $perPage = 25): LengthAwarePaginator
    {
        return $this->categoryRepository->search($query, $perPage);
    }

    /**
     * Find category by ID.
     */
    public function findCategoryById(int $id): ?AssetCategory
    {
        return $this->categoryRepository->findById($id);
    }

    /**
     * Create new category.
     */
    public function createCategory(array $data): AssetCategory
    {
        return $this->categoryRepository->create($data);
    }

    /**
     * Update category.
     */
    public function updateCategory(AssetCategory $category, array $data): AssetCategory
    {
        $this->categoryRepository->update($category, $data);

        return $category->fresh();
    }

    /**
     * Delete category.
     * Validates that category has no assets before deletion.
     */
    public function deleteCategory(AssetCategory $category): bool
    {
        // Check if category has assets
        if ($this->categoryRepository->hasAssets($category)) {
            $assetsCount = $this->categoryRepository->countAssets($category);
            throw new \Exception("Gagal menghapus kategori. Masih ada {$assetsCount} aset yang terhubung.");
        }

        return $this->categoryRepository->delete($category);
    }

    /**
     * Get total categories count.
     */
    public function getTotalCategories(): int
    {
        return $this->categoryRepository->count();
    }

    /**
     * Check if category can be deleted.
     */
    public function canDelete(AssetCategory $category): bool
    {
        return !$this->categoryRepository->hasAssets($category);
    }
}
