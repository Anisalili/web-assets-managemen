<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
    <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
        <div class="me-3">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
                <span class="icon-menu"></span>
            </button>
        </div>
        <div>
            <a class="navbar-brand brand-logo" href="{{ route('dashboard') }}">
                <h3 class="text-primary mb-0">OMBÉ</h3>
            </a>
            <a class="navbar-brand brand-logo-mini" href="{{ route('dashboard') }}">
                <h3 class="text-primary mb-0">O</h3>
            </a>
        </div>
    </div>
    <div class="navbar-menu-wrapper d-flex align-items-top">
        <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
                <h1 class="welcome-text">Selamat Datang, <span class="text-black fw-bold">{{ auth()->user()->name }}</span></h1>
                <h3 class="welcome-sub-text">Sistem Manajemen Asset OMBÉ</h3>
            </li>
        </ul>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown d-none d-lg-block user-dropdown">
                <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <span class="mdi mdi-account-circle text-primary" style="font-size: 2rem;"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                    <div class="dropdown-header text-center">
                        <span class="mdi mdi-account-circle text-primary" style="font-size: 4rem;"></span>
                        <p class="mb-1 mt-3 font-weight-semibold">{{ auth()->user()->name }}</p>
                        <p class="fw-light text-muted mb-0">{{ auth()->user()->email }}</p>
                        <div class="mt-2">
                            @foreach(auth()->user()->roles as $role)
                                <span class="badge bg-primary">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <a class="dropdown-item" href="{{ route('profile') }}">
                        <i class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> Profil Saya
                    </a>
                    <form method="POST" action="{{ route('logout') }}" id="logoutForm" class="d-inline">
                        @csrf
                        <button type="button" class="dropdown-item" onclick="confirmLogout()">
                            <i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-bs-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
        </button>
    </div>
</nav>
