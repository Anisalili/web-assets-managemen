<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Repositories\PermissionRepository;
use Illuminate\View\View;

class PermissionController extends Controller
{
    public function __construct(
        protected PermissionRepository $permissionRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $permissions = $this->permissionRepository->getPaginated(25);
        return view('management.permissions.index', compact('permissions'));
    }
}
