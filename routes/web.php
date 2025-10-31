<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');

    // Asset Management Routes
    Route::middleware('permission:view-assets')->group(function () {
        Route::resource('assets', App\Http\Controllers\Management\AssetController::class);
    });

    Route::middleware('permission:view-asset-categories')->group(function () {
        Route::resource('asset-categories', App\Http\Controllers\Management\AssetCategoryController::class)->except(['show']);
    });

    // Maintenance Routes
    Route::middleware('permission:view-maintenance-schedules')->group(function () {
        Route::resource('maintenance-schedules', App\Http\Controllers\Management\MaintenanceScheduleController::class);
    });

    Route::middleware('permission:view-maintenance-logs')->group(function () {
        Route::resource('maintenance-logs', App\Http\Controllers\Management\MaintenanceLogController::class);
    });

    // Reports Routes
    Route::middleware('permission:view-reports')->group(function () {
        Route::get('/reports/assets', function () {
            return 'Asset Reports';
        })->name('reports.assets');

        Route::get('/reports/damage', function () {
            return 'Damage Reports';
        })->name('reports.damage');
    });

    // Buildings & Rooms Routes
    Route::middleware('permission:view-buildings')->group(function () {
        Route::resource('buildings', App\Http\Controllers\Management\BuildingController::class);
        Route::resource('rooms', App\Http\Controllers\Management\RoomController::class);
    });

    // User Management - berbasis permission
    Route::middleware('permission:view-users')->group(function () {
        Route::resource('users', App\Http\Controllers\Management\UserController::class);
    });

    // RBAC Management - hanya untuk Super Admin
    Route::middleware('role:Super Admin')->group(function () {
        Route::resource('roles', App\Http\Controllers\Management\RoleController::class);
        Route::get('/permissions', [App\Http\Controllers\Management\PermissionController::class, 'index'])->name('permissions.index');
    });
});
