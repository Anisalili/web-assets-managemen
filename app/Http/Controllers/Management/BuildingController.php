<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Models\Building;
use App\Services\BuildingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuildingController extends Controller
{
    public function __construct(
        protected BuildingService $buildingService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $buildings = !empty($search)
            ? $this->buildingService->searchBuildings($search, 25)
            : $this->buildingService->getPaginatedBuildings(25);

        return view('management.buildings.index', compact('buildings', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('management.buildings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBuildingRequest $request): RedirectResponse
    {
        try {
            $this->buildingService->createBuilding($request->validated());

            return redirect()
                ->route('buildings.index')
                ->with('success', 'Gedung berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan gedung: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Building $building): View
    {
        $building = $this->buildingService->findBuildingById($building->id);

        return view('management.buildings.show', compact('building'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Building $building): View
    {
        return view('management.buildings.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBuildingRequest $request, Building $building): RedirectResponse
    {
        try {
            $this->buildingService->updateBuilding($building, $request->validated());

            return redirect()
                ->route('buildings.index')
                ->with('success', 'Gedung berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui gedung: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Building $building): RedirectResponse
    {
        try {
            $this->buildingService->deleteBuilding($building);

            return redirect()
                ->route('buildings.index')
                ->with('success', 'Gedung berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
