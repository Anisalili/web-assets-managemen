<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository
    ) {}

    /**
     * Get all users with roles.
     */
    public function getAllUsers(): Collection
    {
        return $this->userRepository->getAllWithRoles();
    }

    /**
     * Get paginated users.
     */
    public function getPaginatedUsers(int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->getPaginated($perPage);
    }

    /**
     * Find user by ID.
     */
    public function findUserById(int $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    /**
     * Create new user with roles.
     */
    public function createUser(array $data): User
    {
        DB::beginTransaction();

        try {
            // Hash password
            $data['password'] = Hash::make($data['password']);

            // Create user
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            // Assign roles if provided
            if (isset($data['roles']) && is_array($data['roles'])) {
                $this->userRepository->syncRoles($user, $data['roles']);
            }

            DB::commit();

            return $user->load('roles');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Update user.
     */
    public function updateUser(User $user, array $data): User
    {
        DB::beginTransaction();

        try {
            $updateData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            // Update password if provided
            if (isset($data['password']) && !empty($data['password'])) {
                $updateData['password'] = Hash::make($data['password']);
            }

            // Update user
            $this->userRepository->update($user, $updateData);

            // Update roles if provided
            if (isset($data['roles']) && is_array($data['roles'])) {
                $this->userRepository->syncRoles($user, $data['roles']);
            }

            DB::commit();

            return $user->fresh('roles');
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Delete user.
     */
    public function deleteUser(User $user): bool
    {
        DB::beginTransaction();

        try {
            // Detach all roles
            $user->roles()->detach();

            // Delete user
            $result = $this->userRepository->delete($user);

            DB::commit();

            return $result;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Check if email exists.
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        return $this->userRepository->emailExists($email, $excludeId);
    }

    /**
     * Search users.
     */
    public function searchUsers(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->search($query, $perPage);
    }

    /**
     * Advanced search users with filters.
     */
    public function advancedSearchUsers(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return $this->userRepository->advancedSearch($filters, $perPage);
    }

    /**
     * Get total users count.
     */
    public function getTotalUsers(): int
    {
        return $this->userRepository->count();
    }
}
