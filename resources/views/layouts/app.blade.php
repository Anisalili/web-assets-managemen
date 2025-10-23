<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Dashboard') - Sistem Manajemen Asset OMBÉ</title>

    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/css/vendor.bundle.base.css') }}">

    <!-- Plugin css for this page -->
    @stack('plugin-styles')

    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/css/vertical-layout-light/style.css') }}">

    <link rel="shortcut icon" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/images/favicon.png') }}" />

    @stack('styles')
</head>
<body>
    <div class="container-scroller">
        <!-- Navbar -->
        @include('layouts.partials.navbar')

        <div class="container-fluid page-body-wrapper">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Alert Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Content -->
                    @yield('content')
                </div>

                <!-- Footer -->
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

    <!-- plugins:js -->
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/js/vendor.bundle.base.js') }}"></script>

    <!-- Plugin js for this page -->
    @stack('plugin-scripts')

    <!-- inject:js -->
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/template.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/settings.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/todolist.js') }}"></script>

    @stack('scripts')
</body>
</html>
