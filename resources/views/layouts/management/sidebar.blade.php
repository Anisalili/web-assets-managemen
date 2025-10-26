<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-grid-large menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>

        @if(auth()->user()->hasPermission('view-assets'))
        <li class="nav-item nav-category">Manajemen Asset</li>
        <li class="nav-item {{ request()->routeIs('assets.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#asset-menu" aria-expanded="{{ request()->routeIs('assets.*') ? 'true' : 'false' }}" aria-controls="asset-menu">
                <i class="menu-icon mdi mdi-package-variant"></i>
                <span class="menu-title">Asset</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('assets.*') ? 'show' : '' }}" id="asset-menu">
                <ul class="nav flex-column sub-menu">
                    @if(auth()->user()->hasPermission('view-assets'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('assets.index') ? 'active' : '' }}" href="{{ route('assets.index') }}">Daftar Asset</a>
                    </li>
                    @endif
                    @if(auth()->user()->hasPermission('create-assets'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('assets.create') ? 'active' : '' }}" href="{{ route('assets.create') }}">Tambah Asset</a>
                    </li>
                    @endif
                    @if(auth()->user()->hasPermission('view-asset-categories'))
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('asset-categories.*') ? 'active' : '' }}" href="{{ route('asset-categories.index') }}">Kategori Asset</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if(auth()->user()->hasPermission('view-maintenance'))
        <li class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#maintenance-menu" aria-expanded="{{ request()->routeIs('maintenance.*') ? 'true' : 'false' }}" aria-controls="maintenance-menu">
                <i class="menu-icon mdi mdi-wrench"></i>
                <span class="menu-title">Pemeliharaan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('maintenance.*') ? 'show' : '' }}" id="maintenance-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maintenance.schedules') }}">Jadwal Maintenance</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maintenance.logs') }}">Log Maintenance</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        @if(auth()->user()->hasPermission('view-reports'))
        <li class="nav-item {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#reports-menu" aria-expanded="{{ request()->routeIs('reports.*') ? 'true' : 'false' }}" aria-controls="reports-menu">
                <i class="menu-icon mdi mdi-file-document"></i>
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reports-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.assets') }}">Laporan Asset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.damage') }}">Laporan Kerusakan</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        @if(auth()->user()->hasPermission('view-buildings'))
        <li class="nav-item nav-category">Lokasi</li>
        <li class="nav-item {{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#location-menu" aria-expanded="false" aria-controls="location-menu">
                <i class="menu-icon mdi mdi-office-building"></i>
                <span class="menu-title">Gedung & Ruangan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="location-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('buildings.index') }}">Daftar Gedung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('rooms.index') }}">Daftar Ruangan</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif

        @if(auth()->user()->hasPermission('view-users') || auth()->user()->hasRole('Super Admin'))
        <li class="nav-item nav-category">Manajemen Sistem</li>
        @endif

        @if(auth()->user()->hasPermission('view-users'))
        <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <i class="menu-icon mdi mdi-account-multiple"></i>
                <span class="menu-title">Pengguna</span>
            </a>
        </li>
        @endif

        @if(auth()->user()->hasRole('Super Admin'))
        <li class="nav-item {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#rbac-menu" aria-expanded="false" aria-controls="rbac-menu">
                <i class="menu-icon mdi mdi-shield-account"></i>
                <span class="menu-title">RBAC</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="rbac-menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('roles.index') }}">Role</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('permissions.index') }}">Permission</a>
                    </li>
                </ul>
            </div>
        </li>
        @endif
    </ul>
</nav>
