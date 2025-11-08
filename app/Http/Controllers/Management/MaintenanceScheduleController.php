<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceSchedule\StoreMaintenanceScheduleRequest;
use App\Http\Requests\MaintenanceSchedule\UpdateMaintenanceScheduleRequest;
use App\Models\Asset;
use App\Models\MaintenanceSchedule;
use App\Services\MaintenanceScheduleService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceScheduleController extends Controller
{
    public function __construct(
        protected MaintenanceScheduleService $scheduleService,
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            "search" => $request->get("search"),
            "asset_id" => $request->get("asset_id"),
            "status" => $request->get("status", []),
            "frequency" => $request->get("frequency", []),
            "date_from" => $request->get("date_from"),
            "date_to" => $request->get("date_to"),
        ];

        // Ensure arrays
        $filters["status"] = is_array($filters["status"])
            ? $filters["status"]
            : [$filters["status"]];
        $filters["frequency"] = is_array($filters["frequency"])
            ? $filters["frequency"]
            : [$filters["frequency"]];

        // Remove empty values
        $filters["status"] = array_filter($filters["status"]);
        $filters["frequency"] = array_filter($filters["frequency"]);

        // Check if any filter is applied
        $hasFilters =
            !empty($filters["search"]) ||
            !empty($filters["asset_id"]) ||
            !empty($filters["status"]) ||
            !empty($filters["frequency"]) ||
            !empty($filters["date_from"]) ||
            !empty($filters["date_to"]);

        $schedules = $hasFilters
            ? $this->scheduleService->advancedSearchSchedules($filters, 25)
            : $this->scheduleService->getPaginatedSchedules(25);

        // Load assigned user relationship
        $schedules->load("assignedUser");

        $assets = Asset::orderBy("name")->get();
        $statuses = ["terjadwal", "selesai", "dibatalkan"];
        $frequencies = [
            "harian",
            "mingguan",
            "bulanan",
            "triwulan",
            "semesteran",
            "tahunan",
        ];

        // Extract for view compatibility
        $search = $filters["search"];
        $assetId = $filters["asset_id"];
        $status = $filters["status"];
        $frequency = $filters["frequency"];
        $dateFrom = $filters["date_from"];
        $dateTo = $filters["date_to"];

        return view(
            "management.maintenance-schedules.index",
            compact(
                "schedules",
                "search",
                "assetId",
                "status",
                "frequency",
                "dateFrom",
                "dateTo",
                "assets",
                "statuses",
                "frequencies",
            ),
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $assets = Asset::with(["category", "room.building"])
            ->orderBy("name")
            ->get();
        $statuses = ["terjadwal", "selesai", "dibatalkan"];
        $frequencies = [
            "harian",
            "mingguan",
            "bulanan",
            "triwulan",
            "semesteran",
            "tahunan",
        ];

        return view(
            "management.maintenance-schedules.create",
            compact("assets", "statuses", "frequencies"),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        StoreMaintenanceScheduleRequest $request,
    ): RedirectResponse {
        try {
            $this->scheduleService->createSchedule($request->validated());

            return redirect()
                ->route("maintenance-schedules.index")
                ->with("success", "Jadwal pemeliharaan berhasil ditambahkan.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Gagal menambahkan jadwal pemeliharaan: " .
                        $e->getMessage(),
                );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceSchedule $maintenanceSchedule): View
    {
        $maintenanceSchedule->load([
            "asset.category",
            "asset.room.building",
            "logs",
        ]);

        return view(
            "management.maintenance-schedules.show",
            compact("maintenanceSchedule"),
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceSchedule $maintenanceSchedule): View
    {
        $assets = Asset::with(["category", "room.building"])
            ->orderBy("name")
            ->get();
        $statuses = ["terjadwal", "selesai", "dibatalkan"];
        $frequencies = [
            "harian",
            "mingguan",
            "bulanan",
            "triwulan",
            "semesteran",
            "tahunan",
        ];

        return view(
            "management.maintenance-schedules.edit",
            compact("maintenanceSchedule", "assets", "statuses", "frequencies"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateMaintenanceScheduleRequest $request,
        MaintenanceSchedule $maintenanceSchedule,
    ): RedirectResponse {
        try {
            $this->scheduleService->updateSchedule(
                $maintenanceSchedule,
                $request->validated(),
            );

            return redirect()
                ->route("maintenance-schedules.index")
                ->with("success", "Jadwal pemeliharaan berhasil diperbarui.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with(
                    "error",
                    "Gagal memperbarui jadwal pemeliharaan: " .
                        $e->getMessage(),
                );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        MaintenanceSchedule $maintenanceSchedule,
    ): RedirectResponse {
        try {
            $this->scheduleService->deleteSchedule($maintenanceSchedule);

            return redirect()
                ->route("maintenance-schedules.index")
                ->with("success", "Jadwal pemeliharaan berhasil dihapus.");
        } catch (\Exception $e) {
            return back()->with(
                "error",
                "Gagal menghapus jadwal pemeliharaan: " . $e->getMessage(),
            );
        }
    }

    /**
     * Get list of teknisi users
     */
    public function getTeknis()
    {
        $teknisi = \App\Models\User::whereHas("roles", function ($query) {
            $query->where("name", "Teknisi");
        })
            ->select("id", "name", "email")
            ->get();

        return response()->json([
            "success" => true,
            "teknisi" => $teknisi,
        ]);
    }

    /**
     * Assign teknisi to maintenance schedule
     */
    public function assign(Request $request, MaintenanceSchedule $schedule)
    {
        $request->validate([
            "teknisi_id" => "required|exists:users,id",
        ]);

        try {
            $schedule->assigned_to = $request->teknisi_id;
            $schedule->save();

            return response()->json([
                "success" => true,
                "message" =>
                    "Teknisi berhasil di-assign ke jadwal pemeliharaan",
                "schedule" => $schedule->load("assignedUser"),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Gagal assign teknisi: " . $e->getMessage(),
                ],
                500,
            );
        }
    }
}
