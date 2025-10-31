<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class UpdateMaintenancePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Updating maintenance permissions...');

        // Delete old maintenance permissions
        $oldPermissions = ['view-maintenance', 'create-maintenance', 'edit-maintenance', 'delete-maintenance'];
        Permission::whereIn('name', $oldPermissions)->delete();
        $this->command->info('Deleted old maintenance permissions.');

        // Create new maintenance permissions
        $newPermissions = [
            // Maintenance Schedule Permissions
            ['name' => 'view-maintenance-schedules', 'description' => 'Lihat jadwal pemeliharaan'],
            ['name' => 'create-maintenance-schedules', 'description' => 'Tambah jadwal pemeliharaan'],
            ['name' => 'update-maintenance-schedules', 'description' => 'Edit jadwal pemeliharaan'],
            ['name' => 'delete-maintenance-schedules', 'description' => 'Hapus jadwal pemeliharaan'],

            // Maintenance Log Permissions
            ['name' => 'view-maintenance-logs', 'description' => 'Lihat log pemeliharaan'],
            ['name' => 'create-maintenance-logs', 'description' => 'Tambah log pemeliharaan'],
            ['name' => 'update-maintenance-logs', 'description' => 'Edit log pemeliharaan'],
            ['name' => 'delete-maintenance-logs', 'description' => 'Hapus log pemeliharaan'],
        ];

        foreach ($newPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission['name']], $permission);
        }

        $this->command->info('Created new maintenance permissions.');

        // Update role permissions
        $superAdmin = Role::where('name', 'Super Admin')->first();
        $admin = Role::where('name', 'Admin')->first();
        $manager = Role::where('name', 'Manager')->first();
        $teknisi = Role::where('name', 'Teknisi')->first();

        if ($superAdmin) {
            // Super Admin gets all permissions
            $superAdmin->permissions()->sync(Permission::all());
            $this->command->info('Updated Super Admin permissions.');
        }

        if ($admin) {
            // Admin gets all except manage roles & permissions
            $adminPermissions = Permission::whereNotIn('name', ['manage-roles', 'manage-permissions'])->pluck('id');
            $admin->permissions()->sync($adminPermissions);
            $this->command->info('Updated Admin permissions.');
        }

        if ($manager) {
            // Manager - view & report focused
            $managerPermissions = Permission::whereIn('name', [
                'view-assets',
                'view-asset-categories',
                'view-maintenance-schedules',
                'view-maintenance-logs',
                'view-reports',
                'create-reports',
                'export-reports',
                'view-buildings',
                'view-rooms',
            ])->pluck('id');
            $manager->permissions()->sync($managerPermissions);
            $this->command->info('Updated Manager permissions.');
        }

        if ($teknisi) {
            // Teknisi - maintenance focused
            $teknisiPermissions = Permission::whereIn('name', [
                'view-assets',
                'update-assets',
                'view-asset-categories',
                'view-maintenance-schedules',
                'create-maintenance-schedules',
                'update-maintenance-schedules',
                'view-maintenance-logs',
                'create-maintenance-logs',
                'update-maintenance-logs',
                'create-reports',
            ])->pluck('id');
            $teknisi->permissions()->sync($teknisiPermissions);
            $this->command->info('Updated Teknisi permissions.');
        }

        $this->command->info('Maintenance permissions updated successfully!');
    }
}
