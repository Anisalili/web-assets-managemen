@extends('layouts.app')

@section('title', 'Laporan Perawatan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Laporan Perawatan</h3>
                    <h6 class="font-weight-normal mb-0">Laporan riwayat perawatan asset perusahaan</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-12 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total Perawatan
                        <i class="mdi mdi-wrench mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $totalMaintenance }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Riwayat Perawatan</h4>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asset</th>
                                    <th>Tanggal Perawatan</th>
                                    <th>Dilakukan Oleh</th>
                                    <th>Hasil</th>
                                    <th>Suku Cadang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenanceLogs as $index => $log)
                                <tr>
                                    <td>{{ $maintenanceLogs->firstItem() + $index }}</td>
                                    <td>{{ $log->asset->name }}</td>
                                    <td>{{ $log->date_performed->format('d M Y') }}</td>
                                    <td>{{ $log->performedBy->name ?? '-' }}</td>
                                    <td>{{ Str::limit($log->result, 50) }}</td>
                                    <td>{{ $log->spare_parts_used ? Str::limit($log->spare_parts_used, 30) : '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data perawatan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($maintenanceLogs->hasPages())
                    <div class="mt-3">
                        {{ $maintenanceLogs->links('vendor.pagination.custom') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
