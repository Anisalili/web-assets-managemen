<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceLog\StoreMaintenanceLogRequest;
use App\Http\Requests\MaintenanceLog\UpdateMaintenanceLogRequest;
use App\Models\Asset;
use App\Models\MaintenanceLog;
use App\Models\MaintenanceSchedule;
use App\Services\MaintenanceLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MaintenanceLogController extends Controller
{
    public function __construct(
        protected MaintenanceLogService $logService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'asset_id' => $request->get('asset_id'),
            'schedule_id' => $request->get('schedule_id'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        // Check if any filter is applied
        $hasFilters = !empty($filters['search']) || !empty($filters['asset_id']) || !empty($filters['schedule_id']) || !empty($filters['date_from']) || !empty($filters['date_to']);

        $logs = $hasFilters
            ? $this->logService->advancedSearchLogs($filters, 25)
            : $this->logService->getPaginatedLogs(25);

        $assets = Asset::orderBy('name')->get();
        $schedules = MaintenanceSchedule::with('asset')->orderBy('scheduled_date', 'desc')->get();

        // Extract for view compatibility
        $search = $filters['search'];
        $assetId = $filters['asset_id'];
        $scheduleId = $filters['schedule_id'];
        $dateFrom = $filters['date_from'];
        $dateTo = $filters['date_to'];

        return view('management.maintenance-logs.index', compact('logs', 'search', 'assetId', 'scheduleId', 'dateFrom', 'dateTo', 'assets', 'schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $assets = Asset::with(['category', 'room.building'])->orderBy('name')->get();
        $schedules = MaintenanceSchedule::with('asset')->where('status', 'terjadwal')->orderBy('scheduled_date')->get();

        return view('management.maintenance-logs.create', compact('assets', 'schedules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMaintenanceLogRequest $request): RedirectResponse
    {
        try {
            $this->logService->createLog($request->validated());

            return redirect()
                ->route('maintenance-logs.index')
                ->with('success', 'Log pemeliharaan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan log pemeliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(MaintenanceLog $maintenanceLog): View
    {
        $maintenanceLog->load(['asset.category', 'asset.room.building', 'schedule']);

        return view('management.maintenance-logs.show', compact('maintenanceLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MaintenanceLog $maintenanceLog): View
    {
        $assets = Asset::with(['category', 'room.building'])->orderBy('name')->get();
        $schedules = MaintenanceSchedule::with('asset')->orderBy('scheduled_date', 'desc')->get();

        return view('management.maintenance-logs.edit', compact('maintenanceLog', 'assets', 'schedules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMaintenanceLogRequest $request, MaintenanceLog $maintenanceLog): RedirectResponse
    {
        try {
            $this->logService->updateLog($maintenanceLog, $request->validated());

            return redirect()
                ->route('maintenance-logs.index')
                ->with('success', 'Log pemeliharaan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui log pemeliharaan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MaintenanceLog $maintenanceLog): RedirectResponse
    {
        try {
            $this->logService->deleteLog($maintenanceLog);

            return redirect()
                ->route('maintenance-logs.index')
                ->with('success', 'Log pemeliharaan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus log pemeliharaan: ' . $e->getMessage());
        }
    }
}
