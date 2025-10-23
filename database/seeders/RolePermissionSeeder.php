<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // Asset Permissions
            ['name' => 'view-assets', 'description' => 'Lihat daftar asset'],
            ['name' => 'create-assets', 'description' => 'Tambah asset baru'],
            ['name' => 'edit-assets', 'description' => 'Edit asset'],
            ['name' => 'delete-assets', 'description' => 'Hapus asset'],
            ['name' => 'view-asset-categories', 'description' => 'Lihat kategori asset'],
            ['name' => 'manage-asset-categories', 'description' => 'Kelola kategori asset'],

            // Maintenance Permissions
            ['name' => 'view-maintenance', 'description' => 'Lihat jadwal maintenance'],
            ['name' => 'create-maintenance', 'description' => 'Buat jadwal maintenance'],
            ['name' => 'edit-maintenance', 'description' => 'Edit jadwal maintenance'],
            ['name' => 'delete-maintenance', 'description' => 'Hapus jadwal maintenance'],

            // Report Permissions
            ['name' => 'view-reports', 'description' => 'Lihat laporan'],
            ['name' => 'create-reports', 'description' => 'Buat laporan'],
            ['name' => 'export-reports', 'description' => 'Export laporan'],

            // Building & Room Permissions
            ['name' => 'view-buildings', 'description' => 'Lihat daftar gedung'],
            ['name' => 'manage-buildings', 'description' => 'Kelola gedung'],
            ['name' => 'view-rooms', 'description' => 'Lihat daftar ruangan'],
            ['name' => 'manage-rooms', 'description' => 'Kelola ruangan'],

            // User Management Permissions
            ['name' => 'view-users', 'description' => 'Lihat daftar pengguna'],
            ['name' => 'create-users', 'description' => 'Tambah pengguna'],
            ['name' => 'edit-users', 'description' => 'Edit pengguna'],
            ['name' => 'delete-users', 'description' => 'Hapus pengguna'],

            // RBAC Permissions
            ['name' => 'manage-roles', 'description' => 'Kelola role'],
            ['name' => 'manage-permissions', 'description' => 'Kelola permission'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        // Create Roles
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'description' => 'Administrator dengan akses penuh ke semua fitur sistem',
        ]);

        $admin = Role::create([
            'name' => 'Admin',
            'description' => 'Administrator dengan akses ke manajemen asset dan pengguna',
        ]);

        $manager = Role::create([
            'name' => 'Manager',
            'description' => 'Manager dengan akses ke asset dan laporan',
        ]);

        $staff = Role::create([
            'name' => 'Staff',
            'description' => 'Staff dengan akses terbatas untuk melihat asset',
        ]);

        $teknisi = Role::create([
            'name' => 'Teknisi',
            'description' => 'Teknisi maintenance dengan akses ke jadwal dan log maintenance',
        ]);

        // Assign Permissions to Roles

        // Super Admin - semua permission
        $superAdmin->permissions()->attach(Permission::all());

        // Admin - hampir semua kecuali manage roles & permissions
        $admin->permissions()->attach(Permission::whereNotIn('name', ['manage-roles', 'manage-permissions'])->get());

        // Manager - view & report focused
        $manager->permissions()->attach(Permission::whereIn('name', [
            'view-assets',
            'view-asset-categories',
            'view-maintenance',
            'view-reports',
            'create-reports',
            'export-reports',
            'view-buildings',
            'view-rooms',
        ])->get());

        // Staff - view only
        $staff->permissions()->attach(Permission::whereIn('name', [
            'view-assets',
            'view-asset-categories',
            'view-buildings',
            'view-rooms',
        ])->get());

        // Teknisi - maintenance focused
        $teknisi->permissions()->attach(Permission::whereIn('name', [
            'view-assets',
            'view-maintenance',
            'create-maintenance',
            'edit-maintenance',
            'create-reports',
        ])->get());

        // Create Sample Users
        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@ombe.co.id',
            'password' => Hash::make('password'),
        ]);
        $superAdminUser->roles()->attach($superAdmin);

        $adminUser = User::create([
            'name' => 'Admin User',
            'email' => 'admin@ombe.co.id',
            'password' => Hash::make('password'),
        ]);
        $adminUser->roles()->attach($admin);

        $managerUser = User::create([
            'name' => 'Manager User',
            'email' => 'manager@ombe.co.id',
            'password' => Hash::make('password'),
        ]);
        $managerUser->roles()->attach($manager);

        $staffUser = User::create([
            'name' => 'Staff User',
            'email' => 'staff@ombe.co.id',
            'password' => Hash::make('password'),
        ]);
        $staffUser->roles()->attach($staff);

        $teknisiUser = User::create([
            'name' => 'Teknisi User',
            'email' => 'teknisi@ombe.co.id',
            'password' => Hash::make('password'),
        ]);
        $teknisiUser->roles()->attach($teknisi);

        $this->command->info('Roles, Permissions, and Users created successfully!');
    }
}
