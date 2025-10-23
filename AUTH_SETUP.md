# Sistem Autentikasi & RBAC

## Overview
Sistem autentikasi dengan Role-Based Access Control (RBAC) yang dinamis untuk aplikasi Manajemen Asset OMBÉ.

## Fitur Utama
- ✅ Login/Logout
- ✅ Role-Based Access Control (RBAC) dinamis
- ✅ Permission-based middleware
- ✅ Dashboard dengan Star Admin 2 template
- ✅ Sidebar menu yang dinamis berdasarkan permissions

## Roles & Permissions

### Default Roles:
1. **Super Admin** - Akses penuh ke semua fitur
2. **Admin** - Akses manajemen asset dan pengguna (tanpa RBAC management)
3. **Manager** - Akses view dan laporan
4. **Staff** - Akses view terbatas
5. **Teknisi** - Fokus pada maintenance

### Permission Categories:
- **Asset Management**: view-assets, create-assets, edit-assets, delete-assets, view-asset-categories, manage-asset-categories
- **Maintenance**: view-maintenance, create-maintenance, edit-maintenance, delete-maintenance
- **Reports**: view-reports, create-reports, export-reports
- **Buildings & Rooms**: view-buildings, manage-buildings, view-rooms, manage-rooms
- **User Management**: view-users, create-users, edit-users, delete-users
- **RBAC**: manage-roles, manage-permissions

## Default Users

| Email | Password | Role |
|-------|----------|------|
| superadmin@ombe.co.id | password | Super Admin |
| admin@ombe.co.id | password | Admin |
| manager@ombe.co.id | password | Manager |
| staff@ombe.co.id | password | Staff |
| teknisi@ombe.co.id | password | Teknisi |

## Cara Menggunakan

### 1. Run Migration & Seeder
```bash
php artisan migrate:fresh --seed
```

### 2. Start Development Server
```bash
php artisan serve
```

### 3. Login
Buka browser dan akses: http://localhost:8000/login

Login dengan salah satu user di atas.

## Struktur File

### Models
- `app/Models/User.php` - User model dengan RBAC methods
- `app/Models/Role.php` - Role model
- `app/Models/Permission.php` - Permission model

### Middleware
- `app/Http/Middleware/CheckRole.php` - Check user role
- `app/Http/Middleware/CheckPermission.php` - Check user permission

### Controllers
- `app/Http/Controllers/Auth/LoginController.php` - Handle login
- `app/Http/Controllers/Auth/LogoutController.php` - Handle logout
- `app/Http/Controllers/Dashboard/DashboardController.php` - Dashboard

### Views
- `resources/views/layouts/app.blade.php` - Main layout
- `resources/views/layouts/partials/navbar.blade.php` - Top navigation
- `resources/views/layouts/partials/sidebar.blade.php` - Side navigation (dinamis berdasarkan permissions)
- `resources/views/layouts/partials/footer.blade.php` - Footer
- `resources/views/auth/login.blade.php` - Login page
- `resources/views/dashboard/index.blade.php` - Dashboard page

## Penggunaan Middleware

### Role-based Protection
```php
Route::middleware('role:Super Admin,Admin')->group(function () {
    // Routes yang hanya bisa diakses oleh Super Admin atau Admin
});
```

### Permission-based Protection
```php
Route::middleware('permission:view-assets')->group(function () {
    // Routes yang hanya bisa diakses oleh user dengan permission 'view-assets'
});
```

### Multiple Middleware
```php
Route::middleware(['auth', 'role:Admin', 'permission:create-assets'])->group(function () {
    // Routes dengan multiple protection
});
```

## Menambah Role Baru

Sistem ini dirancang agar RBAC bisa dikelola secara dinamis tanpa hardcode. Untuk menambah role baru:

1. Tambahkan role via interface RBAC Management (Super Admin only)
2. Assign permissions ke role tersebut
3. Sidebar akan otomatis menyesuaikan berdasarkan permissions
4. Route middleware akan otomatis mengecek permissions

## Helper Methods di User Model

```php
// Check specific role
auth()->user()->hasRole('Super Admin')

// Check any of given roles
auth()->user()->hasAnyRole(['Admin', 'Manager'])

// Check specific permission
auth()->user()->hasPermission('view-assets')

// Get all permissions
auth()->user()->getAllPermissions()
```

## Catatan Penting

1. **Sidebar Dinamis**: Menu sidebar akan muncul/hilang berdasarkan permissions user
2. **Route Protection**: Gunakan middleware `role` atau `permission` untuk proteksi route
3. **Scalable**: Sistem ini tidak hardcode, sehingga bisa dikembangkan dengan menambah permissions via database
4. **Security**: Password di-hash menggunakan bcrypt

## Next Steps

- [ ] Implementasi CRUD untuk Asset Management
- [ ] Implementasi Maintenance Management
- [ ] Implementasi Reports
- [ ] Implementasi User Management UI
- [ ] Implementasi RBAC Management UI (untuk Super Admin)
