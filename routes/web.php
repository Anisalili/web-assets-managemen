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

    // Asset Management Routes - dengan permission checking
    Route::middleware('permission:view-assets')->group(function () {
        Route::get('/assets', function () {
            return 'Assets List';
        })->name('assets.index');
    });

    Route::middleware('permission:create-assets')->group(function () {
        Route::get('/assets/create', function () {
            return 'Create Asset';
        })->name('assets.create');
    });

    Route::middleware('permission:view-asset-categories')->group(function () {
        Route::get('/asset-categories', function () {
            return 'Asset Categories';
        })->name('asset-categories.index');
    });

    // Maintenance Routes
    Route::middleware('permission:view-maintenance')->group(function () {
        Route::get('/maintenance/schedules', function () {
            return 'Maintenance Schedules';
        })->name('maintenance.schedules');

        Route::get('/maintenance/logs', function () {
            return 'Maintenance Logs';
        })->name('maintenance.logs');
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
        Route::get('/buildings', function () {
            return 'Buildings List';
        })->name('buildings.index');

        Route::get('/rooms', function () {
            return 'Rooms List';
        })->name('rooms.index');
    });

    // User Management - hanya untuk Admin
    Route::middleware('role:Super Admin,Admin')->group(function () {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });

    // RBAC Management - hanya untuk Super Admin
    Route::middleware('role:Super Admin')->group(function () {
        Route::get('/roles', function () {
            return 'Roles Management';
        })->name('roles.index');

        Route::get('/permissions', function () {
            return 'Permissions Management';
        })->name('permissions.index');
    });
});
