<?php

namespace App\Services;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoleService
{
    public function __construct(
        protected RoleRepository $roleRepository
    ) {}

    /**
     * Get all roles.
     */
    public function getAllRoles(): Collection
    {
        return $this->roleRepository->getAll();
    }

    /**
     * Get paginated roles.
     */
    public function getPaginatedRoles(int $perPage = 25): LengthAwarePaginator
    {
        return $this->roleRepository->getPaginated($perPage);
    }

    /**
     * Find role by ID.
     */
    public function findRoleById(int $id): ?Role
    {
        return $this->roleRepository->findById($id);
    }

    /**
     * Create new role with permissions.
     */
    public function createRole(array $data): Role
    {
        DB::beginTransaction();

        try {
            $role = $this->roleRepository->create([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            if (!empty($data['permissions'])) {
                $this->roleRepository->syncPermissions($role, $data['permissions']);
            }

            DB::commit();

            return $role->fresh('permissions');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update role with permissions.
     */
    public function updateRole(Role $role, array $data): Role
    {
        DB::beginTransaction();

        try {
            $this->roleRepository->update($role, [
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
            ]);

            $this->roleRepository->syncPermissions($role, $data['permissions'] ?? []);

            DB::commit();

            return $role->fresh('permissions');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete role.
     * Validates that role has no users before deletion.
     */
    public function deleteRole(Role $role): bool
    {
        DB::beginTransaction();

        try {
            // Check if role has users
            if ($this->roleRepository->hasUsers($role)) {
                throw new \Exception('Tidak dapat menghapus role yang masih memiliki user.');
            }

            // Detach all permissions
            $this->roleRepository->detachPermissions($role);

            // Delete role
            $result = $this->roleRepository->delete($role);

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Get total roles count.
     */
    public function getTotalRoles(): int
    {
        return $this->roleRepository->count();
    }

    /**
     * Check if role can be deleted.
     */
    public function canDelete(Role $role): bool
    {
        return !$this->roleRepository->hasUsers($role);
    }
}
