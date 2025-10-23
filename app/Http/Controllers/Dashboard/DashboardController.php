<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();
        $roles = $user->roles;
        $permissions = $user->getAllPermissions();

        return view('dashboard.index', compact('user', 'roles', 'permissions'));
    }
}
