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

            <!-- Statistics Overview -->
            <div class="row mt-4">
                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $totalAssets }}</h3>
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
                                        <h3 class="mb-0">{{ $activeAssets }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-success">
                                        <span class="mdi mdi-check-circle icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Asset Aktif</h6>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-sm-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-9">
                                    <div class="d-flex align-items-center align-self-start">
                                        <h3 class="mb-0">{{ $maintenanceThisMonth }}</h3>
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
                                        <h3 class="mb-0">{{ $damageReports }}</h3>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="icon icon-box-danger">
                                        <span class="mdi mdi-alert-circle icon-item"></span>
                                    </div>
                                </div>
                            </div>
                            <h6 class="text-muted font-weight-normal">Laporan Kerusakan Aktif</h6>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row mt-4">
                <!-- Recent Damage Reports -->
                @if(auth()->user()->hasPermission('view-damage-reports'))
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Laporan Kerusakan Terbaru</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Asset</th>
                                            <th>Severity</th>
                                            <th>Status</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recentDamageReports as $report)
                                        <tr onclick="window.location='{{ route('damage-reports.show', $report) }}'" style="cursor: pointer;">
                                            <td>{{ $report->asset->name ?? '-' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $report->severity == 'berat' ? 'danger' : ($report->severity == 'sedang' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($report->severity) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $report->status == 'selesai' ? 'success' : ($report->status == 'dalam_proses' ? 'info' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $report->report_date->format('d/m/Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">Tidak ada laporan kerusakan</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($recentDamageReports->count() > 0)
                            <div class="mt-3">
                                <a href="{{ route('damage-reports.index') }}" class="btn btn-sm btn-outline-primary">
                                    Lihat Semua <i class="mdi mdi-arrow-right"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif

                <!-- Upcoming Maintenance -->
                @if(auth()->user()->hasPermission('view-maintenance-schedules'))
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Jadwal Maintenance Mendatang</h4>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Asset</th>
                                            <th>Teknisi</th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($upcomingMaintenance as $maintenance)
                                        <tr onclick="window.location='{{ route('maintenance-schedules.show', $maintenance) }}'" style="cursor: pointer;">
                                            <td>{{ $maintenance->asset->name ?? '-' }}</td>
                                            <td>{{ $maintenance->assignedUser->name ?? '-' }}</td>
                                            <td>{{ $maintenance->scheduled_date->format('d/m/Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">Tidak ada jadwal maintenance</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            @if($upcomingMaintenance->count() > 0)
                            <div class="mt-3">
                                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-sm btn-outline-warning">
                                    Lihat Semua <i class="mdi mdi-arrow-right"></i>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
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
                                <a href="{{ route('report.barang') }}" class="btn btn-info btn-fw">
                                    <i class="mdi mdi-file-document"></i> Lihat Laporan
                                </a>
                                @endif

                                @if(auth()->user()->hasPermission('view-maintenance-schedules'))
                                <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-warning btn-fw">
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
