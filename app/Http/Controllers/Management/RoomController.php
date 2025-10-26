<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Building;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $buildingId = $request->get('building_id');

        $rooms = Room::query()
            ->with('building')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('room_code', 'like', "%{$search}%")
                      ->orWhere('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhereHas('building', function ($q) use ($search) {
                          $q->where('name', 'like', "%{$search}%");
                      });
                });
            })
            ->when($buildingId, function ($query, $buildingId) {
                $query->where('building_id', $buildingId);
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $buildings = Building::orderBy('name')->get();

        return view('management.rooms.index', compact('rooms', 'search', 'buildingId', 'buildings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $buildings = Building::orderBy('name')->get();
        return view('management.rooms.create', compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request): RedirectResponse
    {
        try {
            Room::create($request->validated());

            return redirect()
                ->route('rooms.index')
                ->with('success', 'Ruangan berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan ruangan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room): View
    {
        $room->load('building');
        return view('management.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room): View
    {
        $buildings = Building::orderBy('name')->get();
        return view('management.rooms.edit', compact('room', 'buildings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room): RedirectResponse
    {
        try {
            $room->update($request->validated());

            return redirect()
                ->route('rooms.index')
                ->with('success', 'Ruangan berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui ruangan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room): RedirectResponse
    {
        try {
            $room->delete();

            return redirect()
                ->route('rooms.index')
                ->with('success', 'Ruangan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }
}
