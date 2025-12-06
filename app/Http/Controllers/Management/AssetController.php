<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\Asset\StoreAssetRequest;
use App\Http\Requests\Asset\UpdateAssetRequest;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Room;
use App\Services\AssetService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetController extends Controller
{
    public function __construct(protected AssetService $assetService) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $filters = [
            "search" => $request->get("search"),
            "category_id" => $request->get("category_id", []),
            "room_id" => $request->get("room_id", []),
            "status" => $request->get("status", []),
        ];

        // Ensure arrays
        $filters["category_id"] = is_array($filters["category_id"])
            ? $filters["category_id"]
            : [$filters["category_id"]];
        $filters["room_id"] = is_array($filters["room_id"])
            ? $filters["room_id"]
            : [$filters["room_id"]];
        $filters["status"] = is_array($filters["status"])
            ? $filters["status"]
            : [$filters["status"]];

        // Remove empty values
        $filters["category_id"] = array_filter($filters["category_id"]);
        $filters["room_id"] = array_filter($filters["room_id"]);
        $filters["status"] = array_filter($filters["status"]);

        // Check if any filter is applied
        $hasFilters =
            !empty($filters["search"]) ||
            !empty($filters["category_id"]) ||
            !empty($filters["room_id"]) ||
            !empty($filters["status"]);

        $assets = $hasFilters
            ? $this->assetService->advancedSearchAssets($filters, 25)
            : $this->assetService->getPaginatedAssets(25);

        $categories = AssetCategory::orderBy("name")->get();
        $rooms = Room::with("building")->orderBy("name")->get();
        $statuses = ["aktif", "non-aktif", "dalam_perbaikan", "rusak"];

        // Extract for view compatibility
        $search = $filters["search"];
        $categoryId = $filters["category_id"];
        $roomId = $filters["room_id"];
        $status = $filters["status"];

        return view(
            "management.assets.index",
            compact(
                "assets",
                "search",
                "categoryId",
                "roomId",
                "status",
                "categories",
                "rooms",
                "statuses",
            ),
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = AssetCategory::orderBy("name")->get();
        $rooms = Room::with("building")->orderBy("name")->get();
        $statuses = ["aktif", "non-aktif", "dalam_perbaikan", "rusak"];

        return view(
            "management.assets.create",
            compact("categories", "rooms", "statuses"),
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssetRequest $request): RedirectResponse
    {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile("image")) {
                $data["image_path"] = $request
                    ->file("image")
                    ->store("assets", "public");
            }

            $this->assetService->createAsset($data);

            return redirect()
                ->route("assets.index")
                ->with("success", "Aset berhasil ditambahkan.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with("error", "Gagal menambahkan aset: " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset): View
    {
        $asset->load([
            "category",
            "room.building",
            "statusHistory.previousRoom",
            "statusHistory.newRoom",
        ]);

        return view("management.assets.show", compact("asset"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset): View
    {
        $categories = AssetCategory::orderBy("name")->get();
        $rooms = Room::with("building")->orderBy("name")->get();
        $statuses = ["aktif", "non-aktif", "dalam_perbaikan", "rusak"];

        return view(
            "management.assets.edit",
            compact("asset", "categories", "rooms", "statuses"),
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        UpdateAssetRequest $request,
        Asset $asset,
    ): RedirectResponse {
        try {
            $data = $request->validated();

            // Handle image upload
            if ($request->hasFile("image")) {
                // Delete old image if exists
                if (
                    $asset->image_path &&
                    \Storage::disk("public")->exists($asset->image_path)
                ) {
                    \Storage::disk("public")->delete($asset->image_path);
                }

                $data["image_path"] = $request
                    ->file("image")
                    ->store("assets", "public");
            }

            $this->assetService->updateAsset($asset, $data);

            return redirect()
                ->route("assets.index")
                ->with("success", "Aset berhasil diperbarui.");
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with("error", "Gagal memperbarui aset: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage (Soft Delete for Stock Off).
     */
    public function destroy(Asset $asset): RedirectResponse
    {
        try {
            $this->assetService->deleteAsset($asset);

            return redirect()
                ->route("assets.index")
                ->with("success", "Aset berhasil di-stock off.");
        } catch (\Exception $e) {
            return back()->with(
                "error",
                "Gagal stock off aset: " . $e->getMessage(),
            );
        }
    }

    /**
     * Print asset detail report.
     */
    public function print(Asset $asset): View
    {
        $asset->load([
            "category",
            "room.building",
            "statusHistory.previousRoom",
            "statusHistory.newRoom",
        ]);

        return view("management.assets.print", compact("asset"));
    }
}
