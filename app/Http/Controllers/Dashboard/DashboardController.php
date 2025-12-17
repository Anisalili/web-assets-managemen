<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetDamageReport;
use App\Models\MaintenanceSchedule;
use App\Models\MaintenanceLog;
use Illuminate\View\View;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        $roles = $user->roles;
        $permissions = $user->getAllPermissions();

        // Get statistics
        $totalAssets = Asset::count();
        $activeAssets = Asset::where("status", "aktif")->count();

        // Maintenance bulan ini
        $maintenanceThisMonth = MaintenanceSchedule::whereYear(
            "scheduled_date",
            Carbon::now()->year,
        )
            ->whereMonth("scheduled_date", Carbon::now()->month)
            ->count();

        // Laporan kerusakan yang belum selesai
        $damageReports = AssetDamageReport::where(
            "status",
            "!=",
            "selesai",
        )->count();

        // Asset berdasarkan status
        $assetsByStatus = Asset::selectRaw("status, COUNT(*) as count")
            ->groupBy("status")
            ->get();

        // Recent damage reports (5 terbaru)
        $recentDamageReports = AssetDamageReport::with(["asset"])
            ->orderBy("report_date", "desc")
            ->limit(5)
            ->get();

        // Upcoming maintenance (5 terdekat)
        $upcomingMaintenance = MaintenanceSchedule::with([
            "asset",
            "assignedUser",
        ])
            ->where("status", "terjadwal")
            ->where("scheduled_date", ">=", Carbon::now())
            ->orderBy("scheduled_date", "asc")
            ->limit(5)
            ->get();

        return view(
            "dashboard.index",
            compact(
                "user",
                "roles",
                "permissions",
                "totalAssets",
                "activeAssets",
                "maintenanceThisMonth",
                "damageReports",
                "assetsByStatus",
                "recentDamageReports",
                "upcomingMaintenance",
            ),
        );
    }
}
