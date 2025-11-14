<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav" id="sidebar-nav">
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
            <div class="collapse {{ request()->routeIs('assets.*') ? 'show' : '' }}" id="asset-menu" data-bs-parent="#sidebar-nav">
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

        @if(auth()->user()->hasPermission('view-maintenance-schedules') || auth()->user()->hasPermission('view-maintenance-logs'))
        <li class="nav-item {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#maintenance-menu" aria-expanded="{{ request()->routeIs('maintenance.*') ? 'true' : 'false' }}" aria-controls="maintenance-menu">
                <i class="menu-icon mdi mdi-wrench"></i>
                <span class="menu-title">Perawatan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('maintenance.*') ? 'show' : '' }}" id="maintenance-menu" data-bs-parent="#sidebar-nav">
                <ul class="nav flex-column sub-menu">
                    @if(auth()->user()->hasPermission('view-maintenance-schedules'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maintenance-schedules.index') }}">Jadwal Perawatan</a>
                    </li>
                    @endif
                    @if(auth()->user()->hasPermission('view-maintenance-logs'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('maintenance-logs.index') }}">Log Perawatan</a>
                    </li>
                    @endif
                </ul>
            </div>
        </li>
        @endif

        @if(auth()->user()->hasPermission('view-damage-reports') || auth()->user()->hasPermission('view-repairs'))
        <li class="nav-item {{ request()->routeIs('damage-reports.*') || request()->routeIs('repairs.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#damage-menu" aria-expanded="{{ request()->routeIs('damage-reports.*') || request()->routeIs('repairs.*') ? 'true' : 'false' }}" aria-controls="damage-menu">
                <i class="menu-icon mdi mdi-alert-circle"></i>
                <span class="menu-title">Kerusakan & Perbaikan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('damage-reports.*') || request()->routeIs('repairs.*') ? 'show' : '' }}" id="damage-menu" data-bs-parent="#sidebar-nav">
                <ul class="nav flex-column sub-menu">
                    @if(auth()->user()->hasPermission('view-damage-reports'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('damage-reports.index') }}">Laporan Kerusakan</a>
                    </li>
                    @endif
                    @if(auth()->user()->hasPermission('view-repairs'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('repairs.index') }}">Riwayat Perbaikan</a>
                    </li>
                    @endif
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
            <div class="collapse {{ request()->routeIs('reports.*') ? 'show' : '' }}" id="reports-menu" data-bs-parent="#sidebar-nav">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.assets') }}">Laporan Asset</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('reports.maintenance') }}">Laporan Perawatan</a>
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
        <li class="nav-item {{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') || request()->routeIs('building-layout.*') ? 'active' : '' }}">
            <a class="nav-link" data-bs-toggle="collapse" href="#location-menu" aria-expanded="{{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') || request()->routeIs('building-layout.*') ? 'true' : 'false' }}" aria-controls="location-menu">
                <i class="menu-icon mdi mdi-office-building"></i>
                <span class="menu-title">Gedung & Ruangan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse {{ request()->routeIs('buildings.*') || request()->routeIs('rooms.*') || request()->routeIs('building-layout.*') ? 'show' : '' }}" id="location-menu" data-bs-parent="#sidebar-nav">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('buildings.index') ? 'active' : '' }}" href="{{ route('buildings.index') }}">Daftar Gedung</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('rooms.index') ? 'active' : '' }}" href="{{ route('rooms.index') }}">Daftar Ruangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('building-layout.index') ? 'active' : '' }}" href="{{ route('building-layout.index') }}">Denah Gedung</a>
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
            <div class="collapse" id="rbac-menu" data-bs-parent="#sidebar-nav">
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
