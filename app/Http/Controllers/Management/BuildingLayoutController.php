<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Room;
use Illuminate\View\View;

class BuildingLayoutController extends Controller
{
    /**
     * Display the building layout page.
     */
    public function index(): View
    {
        // Get the main building
        $building = Building::where('building_code', 'GD-UTAMA')->first();

        // Get rooms grouped by floor with asset count
        $lantai1Rooms = Room::where('building_id', $building->id)
            ->where('room_code', 'LIKE', 'LT1-%')
            ->withCount('assets')
            ->orderBy('room_code')
            ->get();

        $lantai2Rooms = Room::where('building_id', $building->id)
            ->where('room_code', 'LIKE', 'LT2-%')
            ->withCount('assets')
            ->orderBy('room_code')
            ->get();

        return view('management.building-layout.index', compact('lantai1Rooms', 'lantai2Rooms'));
    }

    /**
     * Get assets for a specific room.
     */
    public function getRoomAssets(Room $room)
    {
        $assets = $room->assets()
            ->with('category')
            ->get();

        return response()->json([
            'success' => true,
            'room' => [
                'id' => $room->id,
                'name' => $room->name,
                'room_code' => $room->room_code,
            ],
            'assets' => $assets,
        ]);
    }
}
