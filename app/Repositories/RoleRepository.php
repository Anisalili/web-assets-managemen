<?php

namespace App\Repositories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository
{
    /**
     * Get all roles.
     */
    public function getAll(): Collection
    {
        return Role::orderBy('name')->get();
    }

    /**
     * Get paginated roles with users and permissions count.
     */
    public function getPaginated(int $perPage = 25): LengthAwarePaginator
    {
        return Role::withCount('users', 'permissions')
            ->paginate($perPage);
    }

    /**
     * Find role by ID with relations.
     */
    public function findById(int $id): ?Role
    {
        return Role::with('permissions')->find($id);
    }

    /**
     * Create new role.
     */
    public function create(array $data): Role
    {
        return Role::create($data);
    }

    /**
     * Update role.
     */
    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    /**
     * Delete role.
     */
    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    /**
     * Sync role permissions.
     */
    public function syncPermissions(Role $role, array $permissionIds): void
    {
        $role->permissions()->sync($permissionIds);
    }

    /**
     * Detach all permissions from role.
     */
    public function detachPermissions(Role $role): void
    {
        $role->permissions()->detach();
    }

    /**
     * Get roles count.
     */
    public function count(): int
    {
        return Role::count();
    }

    /**
     * Check if role has users.
     */
    public function hasUsers(Role $role): bool
    {
        return $role->users()->exists();
    }

    /**
     * Count users in role.
     */
    public function countUsers(Role $role): int
    {
        return $role->users()->count();
    }
}
