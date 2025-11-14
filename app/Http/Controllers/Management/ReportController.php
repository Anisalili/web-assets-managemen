<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Building;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceSchedule;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display assets report
     */
    public function assets(Request $request): View
    {
        $query = Asset::with(["category", "room.building"]);

        // Apply filters
        if ($request->filled("category_id")) {
            $query->where("category_id", $request->category_id);
        }

        if ($request->filled("building_id")) {
            $query->whereHas("room", function ($q) use ($request) {
                $q->where("building_id", $request->building_id);
            });
        }

        if ($request->filled("room_id")) {
            $query->where("room_id", $request->room_id);
        }

        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        if ($request->filled("date_from")) {
            $query->whereDate("purchase_date", ">=", $request->date_from);
        }

        if ($request->filled("date_to")) {
            $query->whereDate("purchase_date", "<=", $request->date_to);
        }

        // Calculate statistics before pagination
        $totalAssets = $query->count();
        $totalValue = $query->sum("value");

        // Get all for statistics
        $allAssets = $query->get();
        $assetsByStatus = $allAssets->groupBy("status")->map->count();
        $assetsByCategory = $allAssets->groupBy("category.name")->map->count();

        // Get paginated results
        $assets = $query->orderBy("created_at", "desc")->paginate(25);

        // Get filter options
        $categories = AssetCategory::orderBy("name")->get();
        $buildings = Building::orderBy("name")->get();
        $rooms = Room::with("building")->orderBy("name")->get();
        $statuses = ["aktif", "non-aktif", "dalam_perbaikan", "rusak"];

        return view(
            "management.reports.assets",
            compact(
                "assets",
                "totalAssets",
                "totalValue",
                "assetsByStatus",
                "assetsByCategory",
                "categories",
                "buildings",
                "rooms",
                "statuses",
            ),
        );
    }

    /**
     * Display maintenance report
     */
    public function maintenance(Request $request): View
    {
        $query = MaintenanceLog::with([
            "asset.category",
            "asset.room.building",
            "schedule",
        ]);

        // Apply filters
        if ($request->filled("asset_id")) {
            $query->where("asset_id", $request->asset_id);
        }

        if ($request->filled("date_from")) {
            $query->whereDate("date_performed", ">=", $request->date_from);
        }

        if ($request->filled("date_to")) {
            $query->whereDate("date_performed", "<=", $request->date_to);
        }

        if ($request->filled("performed_by")) {
            $query->where(
                "performed_by",
                "like",
                "%" . $request->performed_by . "%",
            );
        }

        // Calculate statistics before pagination
        $totalMaintenance = $query->count();
        $totalCost = $query->sum("maintenance_cost");

        // Get all for statistics
        $allLogs = $query->get();
        $maintenanceByMonth = $allLogs
            ->groupBy(function ($log) {
                return $log->date_performed->format("Y-m");
            })
            ->map->count();

        // Get paginated results
        $maintenanceLogs = $query
            ->orderBy("date_performed", "desc")
            ->paginate(25);

        // Get filter options
        $assets = Asset::orderBy("name")->get();

        return view(
            "management.reports.maintenance",
            compact(
                "maintenanceLogs",
                "totalMaintenance",
                "totalCost",
                "maintenanceByMonth",
                "assets",
            ),
        );
    }

    /**
     * Display damage report
     */
    public function damage(Request $request): View
    {
        $query = Asset::with(["category", "room.building"])->whereIn("status", [
            "dalam_perbaikan",
            "rusak",
        ]);

        // Apply filters
        if ($request->filled("category_id")) {
            $query->where("category_id", $request->category_id);
        }

        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        // Calculate statistics before pagination
        $totalDamaged = $query->count();
        $totalValueDamaged = $query->sum("value");

        // Get all for statistics
        $allAssets = $query->get();
        $assetsByStatus = $allAssets->groupBy("status")->map->count();

        // Get paginated results
        $assets = $query->orderBy("updated_at", "desc")->paginate(25);

        // Get filter options
        $categories = AssetCategory::orderBy("name")->get();
        $statuses = ["dalam_perbaikan", "rusak"];

        return view(
            "management.reports.damage",
            compact(
                "assets",
                "totalDamaged",
                "totalValueDamaged",
                "assetsByStatus",
                "categories",
                "statuses",
            ),
        );
    }
}
