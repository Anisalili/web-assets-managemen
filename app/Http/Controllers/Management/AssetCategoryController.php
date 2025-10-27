<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Services\AssetCategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssetCategoryController extends Controller
{
    public function __construct(
        protected AssetCategoryService $categoryService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        $categories = !empty($search)
            ? $this->categoryService->searchCategories($search, 25)
            : $this->categoryService->getPaginatedCategories(25);

        return view('management.asset-categories.index', compact('categories', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('management.asset-categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        try {
            $this->categoryService->createCategory($validated);

            return redirect()
                ->route('asset-categories.index')
                ->with('success', 'Kategori aset berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetCategory $assetCategory): View
    {
        return view('management.asset-categories.edit', compact('assetCategory'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetCategory $assetCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        try {
            $this->categoryService->updateCategory($assetCategory, $validated);

            return redirect()
                ->route('asset-categories.index')
                ->with('success', 'Kategori aset berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetCategory $assetCategory): RedirectResponse
    {
        try {
            $this->categoryService->deleteCategory($assetCategory);

            return redirect()
                ->route('asset-categories.index')
                ->with('success', 'Kategori aset berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
