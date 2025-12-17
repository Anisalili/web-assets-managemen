<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetDamageReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetDamageReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = AssetDamageReport::with([
            "asset.category",
            "asset.room.building",
            "assignedUser",
            "resolvedBy",
        ]);

        // Filter untuk teknisi - hanya tampilkan yang di-assign ke mereka
        if (
            auth()->user()->hasRole("Teknisi") &&
            !auth()->user()->hasPermission("view-all-damage-reports")
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

        if ($request->filled("severity")) {
            $query->where("severity", $request->severity);
        }

        if ($request->filled("priority")) {
            $query->where("priority", $request->priority);
        }

        $damageReports = $query->orderBy("report_date", "desc")->paginate(15);
        $assets = Asset::orderBy("name")->get();

        return view(
            "management.damage-reports.index",
            compact("damageReports", "assets"),
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $assets = Asset::orderBy("name")->get();
        return view("management.damage-reports.create", compact("assets"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            "asset_id" => "required|exists:assets,id",
            "reported_by" => "required|string|max:100",
            "report_date" => "required|date",
            "severity" => "required|in:ringan,sedang,berat",
            "damage_type" => "nullable|string|max:50",
            "priority" => "required|in:low,medium,high,critical",
            "description" => "required|string",
            "impact_on_operations" => "nullable|string",
            "image_path" => "nullable|image|max:2048",
            "estimated_repair_cost" => "nullable|numeric|min:0",
            "status" => "required|in:dilaporkan,dalam_proses,selesai",
        ]);

        if ($request->hasFile("image_path")) {
            $validated["image_path"] = $request
                ->file("image_path")
                ->store("damage-reports", "public");
        }

        AssetDamageReport::create($validated);

        return redirect()
            ->route("damage-reports.index")
            ->with("success", "Laporan kerusakan berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetDamageReport $damageReport): View
    {
        $damageReport->load([
            "asset.category",
            "asset.room.building",
            "assignedUser",
            "resolvedBy",
            "repairs.repairedBy",
        ]);
        return view("management.damage-reports.show", compact("damageReport"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetDamageReport $damageReport): View
    {
        $assets = Asset::orderBy("name")->get();
        return view(
            "management.damage-reports.edit",
            compact("damageReport", "assets"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        AssetDamageReport $damageReport,
    ): RedirectResponse {
        $validated = $request->validate([
            "asset_id" => "required|exists:assets,id",
            "reported_by" => "required|string|max:100",
            "report_date" => "required|date",
            "severity" => "required|in:ringan,sedang,berat",
            "damage_type" => "nullable|string|max:50",
            "priority" => "required|in:low,medium,high,critical",
            "description" => "required|string",
            "impact_on_operations" => "nullable|string",
            "image_path" => "nullable|image|max:2048",
            "estimated_repair_cost" => "nullable|numeric|min:0",
            "status" => "required|in:dilaporkan,dalam_proses,selesai",
            "resolved_date" => "nullable|date",
            "resolved_by" => "nullable|exists:users,id",
        ]);

        if ($request->hasFile("image_path")) {
            $validated["image_path"] = $request
                ->file("image_path")
                ->store("damage-reports", "public");
        }

        $damageReport->update($validated);

        return redirect()
            ->route("damage-reports.index")
            ->with("success", "Laporan kerusakan berhasil diperbarui");
    }

    /**
     * Update only the status of damage report (for teknisi)
     */
    public function updateStatus(
        Request $request,
        AssetDamageReport $damageReport,
    ): RedirectResponse {
        // Validasi teknisi hanya bisa update data yang di-assign ke mereka
        if ($damageReport->assigned_to !== auth()->id()) {
            abort(
                403,
                "Anda tidak memiliki akses untuk mengupdate laporan ini",
            );
        }

        $validated = $request->validate([
            "status" => "required|in:dalam_proses,selesai",
        ]);

        $damageReport->update([
            "status" => $validated["status"],
            "resolved_date" =>
                $validated["status"] === "selesai"
                    ? now()
                    : $damageReport->resolved_date,
            "resolved_by" =>
                $validated["status"] === "selesai"
                    ? auth()->id() // User ID teknisi yang assigned
                    : $damageReport->resolved_by,
        ]);

        return redirect()
            ->route("damage-reports.show", $damageReport)
            ->with("success", "Status laporan kerusakan berhasil diperbarui");
    }

    /**
     * Assign teknisi to damage report
     */
    public function assign(Request $request, AssetDamageReport $damageReport)
    {
        $validated = $request->validate([
            "teknisi_id" => "required|exists:users,id",
        ]);

        $damageReport->update([
            "assigned_to" => $validated["teknisi_id"],
        ]);

        return response()->json([
            "success" => true,
            "message" => "Teknisi berhasil di-assign ke laporan kerusakan",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetDamageReport $damageReport): RedirectResponse
    {
        $damageReport->delete();

        return redirect()
            ->route("damage-reports.index")
            ->with("success", "Laporan kerusakan berhasil dihapus");
    }

    /**
     * Print the specified damage report.
     */
    public function print(AssetDamageReport $damageReport): View
    {
        $damageReport->load([
            "asset.category",
            "asset.room.building",
            "assignedUser",
            "resolvedBy",
        ]);

        return view("management.damage-reports.print", compact("damageReport"));
    }
}
