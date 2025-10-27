<?php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetStatusHistory;
use App\Repositories\AssetRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AssetService
{
    public function __construct(
        protected AssetRepository $assetRepository
    ) {}

    /**
     * Get paginated assets.
     */
    public function getPaginatedAssets(int $perPage = 25): LengthAwarePaginator
    {
        return $this->assetRepository->getPaginated($perPage);
    }

    /**
     * Advanced search assets with filters.
     */
    public function advancedSearchAssets(array $filters, int $perPage = 25): LengthAwarePaginator
    {
        return $this->assetRepository->advancedSearch($filters, $perPage);
    }

    /**
     * Find asset by ID.
     */
    public function findAssetById(int $id): ?Asset
    {
        return $this->assetRepository->findById($id);
    }

    /**
     * Create new asset with initial status history.
     */
    public function createAsset(array $data): Asset
    {
        DB::beginTransaction();

        try {
            // Create asset
            $asset = $this->assetRepository->create($data);

            // Record initial status history
            AssetStatusHistory::create([
                'asset_id' => $asset->id,
                'previous_room_id' => null,
                'new_room_id' => $data['room_id'] ?? null,
                'previous_status' => null,
                'new_status' => $data['status'],
                'changed_by' => auth()->user()->name,
                'change_date' => now(),
                'notes' => 'Aset baru dibuat',
            ]);

            DB::commit();

            return $asset->fresh(['category', 'room.building']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update asset and record history if status/room changed.
     */
    public function updateAsset(Asset $asset, array $data): Asset
    {
        DB::beginTransaction();

        try {
            $oldStatus = $asset->status;
            $oldRoomId = $asset->room_id;
            $newStatus = $data['status'];
            $newRoomId = $data['room_id'] ?? null;

            // Update asset
            $this->assetRepository->update($asset, $data);

            // Record status/room change if changed
            if ($oldStatus !== $newStatus || $oldRoomId != $newRoomId) {
                AssetStatusHistory::create([
                    'asset_id' => $asset->id,
                    'previous_room_id' => $oldRoomId,
                    'new_room_id' => $newRoomId,
                    'previous_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'changed_by' => auth()->user()->name,
                    'change_date' => now(),
                    'notes' => $data['change_notes'] ?? 'Perubahan data aset',
                ]);
            }

            DB::commit();

            return $asset->fresh(['category', 'room.building']);
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Soft delete asset (Stock Off) and record final history.
     */
    public function deleteAsset(Asset $asset): bool
    {
        DB::beginTransaction();

        try {
            // Record final status before soft delete
            AssetStatusHistory::create([
                'asset_id' => $asset->id,
                'previous_room_id' => $asset->room_id,
                'new_room_id' => null,
                'previous_status' => $asset->status,
                'new_status' => 'stock_off',
                'changed_by' => auth()->user()->name,
                'change_date' => now(),
                'notes' => 'Aset di-stock off',
            ]);

            // Soft delete
            $result = $this->assetRepository->delete($asset);

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Check if asset_code exists.
     */
    public function assetCodeExists(string $assetCode, ?int $excludeId = null): bool
    {
        return $this->assetRepository->assetCodeExists($assetCode, $excludeId);
    }

    /**
     * Get total assets count.
     */
    public function getTotalAssets(): int
    {
        return $this->assetRepository->count();
    }

    /**
     * Count assets by status.
     */
    public function countAssetsByStatus(string $status): int
    {
        return $this->assetRepository->countByStatus($status);
    }
}
