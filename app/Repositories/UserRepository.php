<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserRepository
{
    /**
     * Get all users with roles.
     */
    public function getAllWithRoles(): Collection
    {
        return User::with('roles')->get();
    }

    /**
     * Get paginated users with roles.
     */
    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return User::with('roles')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Find user by ID with roles.
     */
    public function findById(int $id): ?User
    {
        return User::with('roles')->find($id);
    }

    /**
     * Find user by email.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Create new user.
     */
    public function create(array $data): User
    {
        return User::create($data);
    }

    /**
     * Update user.
     */
    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Delete user.
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }

    /**
     * Check if email exists (excluding specific user ID).
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $query = User::where('email', $email);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }

    /**
     * Sync user roles.
     */
    public function syncRoles(User $user, array $roleIds): void
    {
        $user->roles()->sync($roleIds);
    }

    /**
     * Get users count.
     */
    public function count(): int
    {
        return User::count();
    }

    /**
     * Search users by name or email.
     */
    public function search(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return User::with('roles')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('email', 'like', "%{$query}%");
            })
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Advanced search users with filters.
     */
    public function advancedSearch(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = User::with('roles');

        // Search by name or email
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by roles
        if (!empty($filters['roles']) && is_array($filters['roles'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->whereIn('roles.id', $filters['roles']);
            });
        }

        return $query->latest()->paginate($perPage);
    }
}
