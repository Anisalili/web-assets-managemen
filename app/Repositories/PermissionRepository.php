<?php

namespace App\Repositories;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

class PermissionRepository
{
    /**
     * Get all permissions.
     */
    public function getAll(): Collection
    {
        return Permission::orderBy('name')->get();
    }

    /**
     * Get all permissions grouped by prefix.
     */
    public function getAllGrouped(): SupportCollection
    {
        return Permission::all()->groupBy(function($permission) {
            // Group by prefix (before first hyphen)
            $parts = explode('-', $permission->name);
            return $parts[0] ?? 'other';
        });
    }

    /**
     * Get paginated permissions with roles count.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return Permission::withCount('roles')->paginate($perPage);
    }

    /**
     * Find permission by ID.
     */
    public function findById(int $id): ?Permission
    {
        return Permission::find($id);
    }

    /**
     * Get permissions count.
     */
    public function count(): int
    {
        return Permission::count();
    }
}
