<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Web\HomeController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get("/", [HomeController::class, "index"])->name("home");

// Auth Routes
Route::middleware("guest")->group(function () {
    Route::get("/login", [LoginController::class, "showLoginForm"])->name(
        "login",
    );
    Route::post("/login", [LoginController::class, "login"])->name(
        "login.post",
    );
});

Route::middleware("auth")->group(function () {
    Route::post("/logout", [LogoutController::class, "logout"])->name("logout");

    // Dashboard
    Route::get("/dashboard", [DashboardController::class, "index"])->name(
        "dashboard",
    );

    // Profile
    Route::get("/profile", function () {
        return view("profile.index");
    })->name("profile");

    // Asset Management Routes
    Route::middleware("permission:view-assets")->group(function () {
        Route::resource(
            "assets",
            App\Http\Controllers\Management\AssetController::class,
        );
        Route::get("assets/{asset}/print", [
            App\Http\Controllers\Management\AssetController::class,
            "print",
        ])->name("assets.print");
    });

    Route::middleware("permission:view-asset-categories")->group(function () {
        Route::resource(
            "asset-categories",
            App\Http\Controllers\Management\AssetCategoryController::class,
        )->except(["show"]);
    });

    // Maintenance Routes
    Route::middleware("permission:view-maintenance-schedules")->group(
        function () {
            Route::resource(
                "maintenance-schedules",
                App\Http\Controllers\Management\MaintenanceScheduleController::class,
            );
        },
    );

    // API untuk get list teknisi (outside permission middleware to allow ajax call)
    Route::middleware("auth")
        ->get("api/teknisi", [
            App\Http\Controllers\Management\MaintenanceScheduleController::class,
            "getTeknis",
        ])
        ->name("api.teknisi");

    // Assign teknisi ke jadwal maintenance
    Route::middleware("permission:update-maintenance-schedules")
        ->post("maintenance-schedules/{schedule}/assign", [
            App\Http\Controllers\Management\MaintenanceScheduleController::class,
            "assign",
        ])
        ->name("maintenance-schedules.assign");

    // Update status maintenance (untuk teknisi)
    Route::middleware("auth")
        ->post("maintenance-schedules/{schedule}/update-status", [
            App\Http\Controllers\Management\MaintenanceScheduleController::class,
            "updateStatus",
        ])
        ->name("maintenance-schedules.update-status");

    Route::middleware("permission:view-maintenance-logs")->group(function () {
        Route::resource(
            "maintenance-logs",
            App\Http\Controllers\Management\MaintenanceLogController::class,
        )->only(["index", "show"]); // Disable create, edit, update, delete - logs are auto-generated
        Route::get("maintenance-logs/{maintenanceLog}/print", [
            App\Http\Controllers\Management\MaintenanceLogController::class,
            "print",
        ])->name("maintenance-logs.print");
    });

    // Damage Reports & Repairs Routes
    Route::middleware("permission:view-damage-reports")->group(function () {
        Route::resource(
            "damage-reports",
            App\Http\Controllers\AssetDamageReportController::class,
        )->parameters([
            "damage-reports" => "damageReport",
        ]);
        Route::get("damage-reports/{damageReport}/print", [
            App\Http\Controllers\AssetDamageReportController::class,
            "print",
        ])->name("damage-reports.print");
    });

    // Assign teknisi ke damage report
    Route::middleware("permission:update-damage-reports")
        ->post("damage-reports/{damageReport}/assign", [
            App\Http\Controllers\AssetDamageReportController::class,
            "assign",
        ])
        ->name("damage-reports.assign");

    // Update status damage report (for teknisi)
    Route::middleware("auth")
        ->post("damage-reports/{damageReport}/update-status", [
            App\Http\Controllers\AssetDamageReportController::class,
            "updateStatus",
        ])
        ->name("damage-reports.update-status");

    Route::middleware("permission:view-repairs")->group(function () {
        Route::resource(
            "repairs",
            App\Http\Controllers\AssetRepairController::class,
        )->parameters([
            "repairs" => "repair",
        ]);
    });

    // Assign teknisi ke repair
    Route::middleware("permission:update-repairs")
        ->post("repairs/{repair}/assign", [
            App\Http\Controllers\AssetRepairController::class,
            "assign",
        ])
        ->name("repairs.assign");

    // Update status repair (for teknisi)
    Route::middleware("auth")
        ->post("repairs/{repair}/update-status", [
            App\Http\Controllers\AssetRepairController::class,
            "updateStatus",
        ])
        ->name("repairs.update-status");

    // Reports Routes
    Route::middleware("permission:view-reports")->group(function () {
        Route::get("/reports/assets", [
            App\Http\Controllers\Management\ReportController::class,
            "assets",
        ])->name("report.barang");
        Route::get("/reports/maintenance", [
            App\Http\Controllers\Management\ReportController::class,
            "maintenance",
        ])->name("report.pemeliharaan");
        Route::get("/reports/damage", [
            App\Http\Controllers\Management\ReportController::class,
            "damage",
        ])->name("report.kerusakan");
    });

    // Buildings & Rooms Routes
    Route::middleware("permission:view-buildings")->group(function () {
        Route::resource(
            "buildings",
            App\Http\Controllers\Management\BuildingController::class,
        );
        Route::resource(
            "rooms",
            App\Http\Controllers\Management\RoomController::class,
        );
        Route::get("building-layout", [
            App\Http\Controllers\Management\BuildingLayoutController::class,
            "index",
        ])->name("building-layout.index");

        // API endpoint for room assets
        Route::get("api/rooms/{room}/assets", [
            App\Http\Controllers\Management\BuildingLayoutController::class,
            "getRoomAssets",
        ])->name("api.rooms.assets");
    });

    // User Management - berbasis permission
    Route::middleware("permission:view-users")->group(function () {
        Route::resource(
            "users",
            App\Http\Controllers\Management\UserController::class,
        );
    });

    // RBAC Management - hanya untuk Super Admin
    Route::middleware("role:Super Admin")->group(function () {
        Route::resource(
            "roles",
            App\Http\Controllers\Management\RoleController::class,
        );
        Route::get("/permissions", [
            App\Http\Controllers\Management\PermissionController::class,
            "index",
        ])->name("permissions.index");
    });
});
