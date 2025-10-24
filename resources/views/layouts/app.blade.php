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

    <!-- Custom Pagination Style -->
    <style>
        .pagination-simple .page-item .page-link {
            border: none;
            background: transparent;
            color: #6c757d;
            padding: 0.25rem 0.5rem;
            margin: 0 0.25rem;
            font-size: 0.875rem;
        }

        .pagination-simple .page-item.active .page-link {
            color: #2196F3;
            font-weight: 600;
            background: transparent;
        }

        .pagination-simple .page-item .page-link:hover {
            color: #2196F3;
            background: transparent;
        }

        .pagination-simple .page-item.disabled .page-link {
            color: #dee2e6;
            background: transparent;
        }

        /* Toast Notification */
        .toast-container {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 99999;
            pointer-events: none;
        }

        .toast-notification {
            min-width: 300px;
            max-width: 400px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            margin-bottom: 10px;
            overflow: hidden;
            animation: slideIn 0.3s ease-out;
            pointer-events: auto;
        }

        @keyframes slideIn {
            from {
                transform: translateX(400px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .toast-notification.hiding {
            animation: slideOut 0.3s ease-out;
        }

        @keyframes slideOut {
            to {
                transform: translateX(400px);
                opacity: 0;
            }
        }

        .toast-header {
            display: flex;
            align-items: center;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }

        .toast-icon {
            width: 20px;
            height: 20px;
            margin-right: 10px;
            flex-shrink: 0;
        }

        .toast-title {
            flex: 1;
            font-weight: 600;
            font-size: 14px;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.5;
            padding: 0;
            margin-left: 10px;
            line-height: 1;
        }

        .toast-close:hover {
            opacity: 1;
        }

        .toast-body {
            padding: 12px 16px;
            font-size: 13px;
        }

        .toast-success .toast-header {
            background: #d4edda;
            color: #155724;
        }

        .toast-error .toast-header {
            background: #f8d7da;
            color: #721c24;
        }

        .toast-warning .toast-header {
            background: #fff3cd;
            color: #856404;
        }

        .toast-info .toast-header {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* Confirm Toast */
        .toast-confirm .toast-body {
            padding-bottom: 16px;
        }

        .toast-confirm-buttons {
            display: flex;
            gap: 8px;
            margin-top: 12px;
        }

        .toast-confirm-buttons button {
            flex: 1;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s;
        }

        .toast-btn-confirm {
            background: #dc3545;
            color: white;
        }

        .toast-btn-confirm:hover {
            background: #c82333;
        }

        .toast-btn-cancel {
            background: #6c757d;
            color: white;
        }

        .toast-btn-cancel:hover {
            background: #5a6268;
        }
    </style>

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
                    <!-- Content -->
                    @yield('content')
                </div>

                <!-- Footer -->
                @include('layouts.partials.footer')
            </div>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

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

    <!-- Toast Notification Script -->
    <script>
        function showToast(type, message, title = null) {
            const container = document.getElementById('toastContainer');

            const icons = {
                success: '<i class="mdi mdi-check-circle toast-icon"></i>',
                error: '<i class="mdi mdi-close-circle toast-icon"></i>',
                warning: '<i class="mdi mdi-alert toast-icon"></i>',
                info: '<i class="mdi mdi-information toast-icon"></i>'
            };

            const titles = {
                success: title || 'Berhasil',
                error: title || 'Gagal',
                warning: title || 'Peringatan',
                info: title || 'Informasi'
            };

            const toast = document.createElement('div');
            toast.className = `toast-notification toast-${type}`;
            toast.innerHTML = `
                <div class="toast-header">
                    ${icons[type]}
                    <span class="toast-title">${titles[type]}</span>
                    <button class="toast-close" onclick="closeToast(this)">&times;</button>
                </div>
                <div class="toast-body">${message}</div>
            `;

            container.appendChild(toast);

            setTimeout(() => {
                closeToast(toast.querySelector('.toast-close'));
            }, 4000);
        }

        function closeToast(button) {
            const toast = button.closest('.toast-notification');
            toast.classList.add('hiding');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }

        function showConfirmToast(message, onConfirm, title = 'Konfirmasi', confirmText = 'Ya, Hapus') {
            const container = document.getElementById('toastContainer');

            const toast = document.createElement('div');
            toast.className = 'toast-notification toast-warning toast-confirm';
            toast.innerHTML = `
                <div class="toast-header">
                    <i class="mdi mdi-help-circle toast-icon"></i>
                    <span class="toast-title">${title}</span>
                    <button class="toast-close" type="button">&times;</button>
                </div>
                <div class="toast-body">
                    ${message}
                    <div class="toast-confirm-buttons">
                        <button class="toast-btn-cancel" type="button">Batal</button>
                        <button class="toast-btn-confirm" type="button">${confirmText}</button>
                    </div>
                </div>
            `;

            container.appendChild(toast);

            // Add close button handler
            const closeBtn = toast.querySelector('.toast-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Close clicked');
                    toast.classList.add('hiding');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                });
            }

            // Add cancel button handler
            const cancelBtn = toast.querySelector('.toast-btn-cancel');
            if (cancelBtn) {
                cancelBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Cancel clicked');
                    toast.classList.add('hiding');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                });
            }

            // Add confirm button handler
            const confirmBtn = toast.querySelector('.toast-btn-confirm');
            if (confirmBtn) {
                confirmBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Confirm clicked');
                    toast.classList.add('hiding');
                    setTimeout(() => {
                        toast.remove();
                    }, 300);
                    if (onConfirm) onConfirm();
                });
            }

            return toast;
        }

        function confirmLogout() {
            showConfirmToast(
                'Apakah Anda yakin ingin keluar dari aplikasi?',
                function() {
                    document.getElementById('logoutForm').submit();
                },
                'Konfirmasi Logout',
                'Ya, Logout'
            );
        }

        // Show session messages as toast
        @if(session('success'))
            showToast('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if(session('warning'))
            showToast('warning', '{{ session('warning') }}');
        @endif

        @if(session('info'))
            showToast('info', '{{ session('info') }}');
        @endif

        @if($errors->any())
            @foreach($errors->all() as $error)
                showToast('error', '{{ $error }}');
            @endforeach
        @endif
    </script>

    @stack('scripts')
</body>
</html>
