<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Building;
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

        // Get results
        $assets = $query->orderBy("created_at", "desc")->get();

        // Calculate statistics
        $totalAssets = $assets->count();
        $totalValue = $assets->sum("value");
        $assetsByStatus = $assets->groupBy("status")->map->count();
        $assetsByCategory = $assets->groupBy("category.name")->map->count();

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

        // Get results
        $assets = $query->orderBy("updated_at", "desc")->get();

        // Calculate statistics
        $totalDamaged = $assets->count();
        $totalValueDamaged = $assets->sum("value");
        $assetsByStatus = $assets->groupBy("status")->map->count();

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
