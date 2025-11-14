<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDamageReport;
use App\Models\AssetRepair;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = AssetRepair::with([
            "asset.category",
            "damageReport",
            "repairedBy",
            "assignedUser",
        ]);

        // Filter untuk teknisi - hanya tampilkan yang di-assign ke mereka
        if (
            auth()->user()->hasRole("Teknisi") &&
            !auth()->user()->hasPermission("view-all-repairs")
        ) {
            $query->where("assigned_to", auth()->id());
        }

        // Apply filters
        if ($request->filled("asset_id")) {
            $query->where("asset_id", $request->asset_id);
        }

        if ($request->filled("status")) {
            $query->where("status", $request->status);
        }

        if ($request->filled("date_from")) {
            $query->whereDate("repair_start_date", ">=", $request->date_from);
        }

        if ($request->filled("date_to")) {
            $query->whereDate("repair_start_date", "<=", $request->date_to);
        }

        $repairs = $query->orderBy("repair_start_date", "desc")->paginate(15);
        $assets = Asset::orderBy("name")->get();

        return view("management.repairs.index", compact("repairs", "assets"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $assets = Asset::orderBy("name")->get();
        $damageReports = AssetDamageReport::where("status", "!=", "selesai")
            ->with("asset")
            ->orderBy("report_date", "desc")
            ->get();

        $selectedDamageReportId = $request->query("damage_report_id");

        return view(
            "management.repairs.create",
            compact("assets", "damageReports", "selectedDamageReportId"),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "damage_report_id" => "required|exists:asset_damage_reports,id",
            "asset_id" => "required|exists:assets,id",
            "repair_start_date" => "required|date",
            "repair_end_date" =>
                "nullable|date|after_or_equal:repair_start_date",
            "repair_description" => "required|string",
            "spare_parts_used" => "nullable|string",
            "repair_cost" => "required|numeric|min:0",
            "status" => "required|in:pending,in_progress,completed,failed",
            "notes" => "nullable|string",
        ]);

        // Get damage report untuk ambil assigned_to
        $damageReport = AssetDamageReport::findOrFail(
            $validated["damage_report_id"],
        );

        // Auto-fill repaired_by dan assigned_to dari damage report atau auth user
        $validated["repaired_by"] = $damageReport->assigned_to ?? auth()->id();
        $validated["assigned_to"] = $damageReport->assigned_to;

        AssetRepair::create($validated);

        // Update damage report status if repair is completed
        if ($validated["status"] === "completed") {
            $damageReport->update([
                "status" => "selesai",
                "resolved_date" => now(),
                "resolved_by" => $validated["repaired_by"],
            ]);
        }

        return redirect()
            ->route("repairs.index")
            ->with("success", "Perbaikan berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetRepair $repair): View
    {
        $repair->load([
            "asset.category",
            "asset.room.building",
            "damageReport",
        ]);
        return view("management.repairs.show", compact("repair"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetRepair $repair): View
    {
        $assets = Asset::orderBy("name")->get();
        $damageReports = AssetDamageReport::with("asset")
            ->orderBy("report_date", "desc")
            ->get();

        return view(
            "management.repairs.edit",
            compact("repair", "assets", "damageReports"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        AssetRepair $repair,
    ): RedirectResponse {
        $validated = $request->validate([
            "damage_report_id" => "required|exists:asset_damage_reports,id",
            "asset_id" => "required|exists:assets,id",
            "repair_start_date" => "required|date",
            "repair_end_date" =>
                "nullable|date|after_or_equal:repair_start_date",
            "repaired_by" => "required|string|max:100",
            "repair_description" => "required|string",
            "spare_parts_used" => "nullable|string",
            "repair_cost" => "required|numeric|min:0",
            "status" => "required|in:pending,in_progress,completed,failed",
            "notes" => "nullable|string",
        ]);

        $repair->update($validated);

        // Update damage report status if repair is completed
        if ($validated["status"] === "completed") {
            $damageReport = AssetDamageReport::find(
                $validated["damage_report_id"],
            );
            $damageReport->update([
                "status" => "selesai",
                "resolved_date" => now(),
                "resolved_by" => $validated["repaired_by"],
            ]);
        }

        return redirect()
            ->route("repairs.index")
            ->with("success", "Perbaikan berhasil diperbarui");
    }

    /**
     * Update only the status of repair (for teknisi)
     */
    public function updateStatus(
        Request $request,
        AssetRepair $repair,
    ): RedirectResponse {
        // Validasi teknisi hanya bisa update data yang di-assign ke mereka
        if (
            auth()->user()->hasRole("Teknisi") &&
            $repair->assigned_to !== auth()->id()
        ) {
            abort(
                403,
                "Anda tidak memiliki akses untuk mengupdate perbaikan ini",
            );
        }

        $validated = $request->validate([
            "status" => "required|in:pending,in_progress,completed,failed",
        ]);

        $repair->update([
            "status" => $validated["status"],
            "repair_end_date" =>
                $validated["status"] === "completed"
                    ? now()
                    : $repair->repair_end_date,
        ]);

        // Update damage report status if repair is completed
        if ($validated["status"] === "completed") {
            $repair->damageReport->update([
                "status" => "selesai",
                "resolved_date" => now(),
                "resolved_by" => auth()->user()->name,
            ]);
        }

        return redirect()
            ->route("repairs.show", $repair)
            ->with("success", "Status perbaikan berhasil diperbarui");
    }

    /**
     * Assign teknisi to repair
     */
    public function assign(Request $request, AssetRepair $repair)
    {
        $validated = $request->validate([
            "teknisi_id" => "required|exists:users,id",
        ]);

        $repair->update([
            "assigned_to" => $validated["teknisi_id"],
        ]);

        return response()->json([
            "success" => true,
            "message" => "Teknisi berhasil di-assign ke perbaikan",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetRepair $repair): RedirectResponse
    {
        $repair->delete();

        return redirect()
            ->route("repairs.index")
            ->with("success", "Perbaikan berhasil dihapus");
    }
}
