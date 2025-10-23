<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login - Sistem Manajemen Asset OMBÉ</title>

    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/typicons/typicons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/simple-line-icons/css/simple-line-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/css/vendor.bundle.base.css') }}">
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/css/vertical-layout-light/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/images/favicon.png') }}" />
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth px-0">
                <div class="row w-100 mx-0">
                    <div class="col-lg-4 mx-auto">
                        <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                            <div class="brand-logo text-center mb-4">
                                <h2 class="text-primary fw-bold">OMBÉ</h2>
                                <p class="text-muted">Sistem Manajemen Asset</p>
                            </div>

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

                            <h4>Selamat Datang!</h4>
                            <h6 class="fw-light">Silakan login untuk melanjutkan.</h6>

                            <form class="pt-3" method="POST" action="{{ route('login.post') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email"
                                           class="form-control form-control-lg @error('email') is-invalid @enderror"
                                           id="email"
                                           name="email"
                                           placeholder="Email"
                                           value="{{ old('email') }}"
                                           required
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <input type="password"
                                           class="form-control form-control-lg @error('password') is-invalid @enderror"
                                           id="password"
                                           name="password"
                                           placeholder="Password"
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input" name="remember">
                                            Ingat Saya
                                        </label>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                                        LOGIN
                                    </button>
                                </div>

                                <div class="text-center mt-4 fw-light">
                                    <a href="{{ route('home') }}" class="text-primary">Kembali ke Beranda</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/off-canvas.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/template.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/settings.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/todolist.js') }}"></script>
</body>
</html>
