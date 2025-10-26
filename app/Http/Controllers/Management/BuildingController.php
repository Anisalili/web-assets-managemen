<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $buildings = Building::query()
            ->withCount('rooms')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('building_code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

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
            Building::create($request->validated());

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
        $building->loadCount('rooms');
        $building->load(['rooms' => function ($query) {
            $query->latest()->take(10);
        }]);

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
            $building->update($request->validated());

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
            $roomsCount = $building->rooms()->count();

            if ($roomsCount > 0) {
                return back()->with('error', "Gagal menghapus gedung. Masih ada {$roomsCount} ruangan yang terhubung.");
            }

            $building->delete();

            return redirect()
                ->route('buildings.index')
                ->with('success', 'Gedung berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus gedung: ' . $e->getMessage());
        }
    }
}
