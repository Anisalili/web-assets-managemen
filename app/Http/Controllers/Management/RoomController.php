<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Room\StoreRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Building;
use App\Models\Room;
use App\Services\RoomService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function __construct(
        protected RoomService $roomService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'building_id' => $request->get('building_id'),
        ];

        // Check if any filter is applied
        $hasFilters = !empty($filters['search']) || !empty($filters['building_id']);

        $rooms = $hasFilters
            ? $this->roomService->advancedSearchRooms($filters, 25)
            : $this->roomService->getPaginatedRooms(25);

        $buildings = Building::orderBy('name')->get();

        // Extract for view compatibility
        $search = $filters['search'];
        $buildingId = $filters['building_id'];

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
            $this->roomService->createRoom($request->validated());

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
        $room = $this->roomService->findRoomById($room->id);
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
            $this->roomService->updateRoom($room, $request->validated());

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
            $this->roomService->deleteRoom($room);

            return redirect()
                ->route('rooms.index')
                ->with('success', 'Ruangan berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus ruangan: ' . $e->getMessage());
        }
    }
}
