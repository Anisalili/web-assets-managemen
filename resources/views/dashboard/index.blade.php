@extends('layouts.app')

@section('title', 'Dashboard')

@push('plugin-styles')
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="home-tab">
            <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                <div>
                    <h2 class="mb-3">Dashboard</h2>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Informasi Pengguna</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                                    <p><strong>Email:</strong> {{ $user->email }}</p>

                                    <p><strong>Role:</strong></p>
                                    <div class="mb-3">
                                        @forelse($roles as $role)
                                            <span class="badge bg-primary me-1">{{ $role->name }}</span>
                                        @empty
                                            <span class="text-muted">Belum memiliki role</span>
                                        @endforelse
                                    </div>

                                    <p><strong>Permission:</strong></p>
                                    <div>
                                        @forelse($permissions as $permission)
                                            <span class="badge bg-success me-1 mb-1">{{ $permission->name }}</span>
                                        @empty
                                            <span class="text-muted">Belum memiliki permission</span>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Overview -->
            <div class="row mt-4">
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">-</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-primary">
                                        <span class="mdi mdi-package-variant icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Total Asset</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">-</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-check-circle icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Asset Baik</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">-</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-warning">
                                        <span class="mdi mdi-wrench icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Maintenance Bulan Ini</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">-</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-danger">
                                        <span class="mdi mdi-alert-circle icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Laporan Kerusakan</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            @if(auth()->user()->hasAnyRole(['Super Admin', 'Admin', 'Manager']))
            <div class="row mt-4">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Aksi Cepat</h4>
                            <p class="card-description">Menu akses cepat untuk operasi umum</p>
                            <div class="template-demo">
                                @if(auth()->user()->hasPermission('create-assets'))
                                <a href="{{ route('assets.create') }}" class="btn btn-primary btn-fw">
                                    <i class="mdi mdi-plus"></i> Tambah Asset Baru
                                </a>
                                @endif

                                @if(auth()->user()->hasPermission('view-reports'))
                                <a href="{{ route('reports.assets') }}" class="btn btn-info btn-fw">
                                    <i class="mdi mdi-file-document"></i> Lihat Laporan
                                </a>
                                @endif

                                @if(auth()->user()->hasPermission('view-maintenance'))
                                <a href="{{ route('maintenance.schedules') }}" class="btn btn-warning btn-fw">
                                    <i class="mdi mdi-calendar"></i> Jadwal Maintenance
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('plugin-scripts')
    <link rel="stylesheet" href="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/chart.js/Chart.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('star-admin2-free-admin-template-1.0.0/template/js/dashboard.js') }}"></script>
@endpush
