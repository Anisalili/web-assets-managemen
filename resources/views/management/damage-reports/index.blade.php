@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Laporan Kerusakan Asset</h3>
                    <h6 class="font-weight-normal mb-0">Kelola laporan kerusakan asset perusahaan</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Daftar Laporan Kerusakan</h4>
                        @if(auth()->user()->hasPermission('create-damage-reports'))
                        <a href="{{ route('damage-reports.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah Laporan
                        </a>
                        @endif
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asset</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Dilaporkan Oleh</th>
                                    <th>Tingkat Kerusakan</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($damageReports as $index => $report)
                                <tr>
                                    <td>{{ $damageReports->firstItem() + $index }}</td>
                                    <td>{{ $report->asset->name }}</td>
                                    <td>{{ $report->report_date->format('d M Y H:i') }}</td>
                                    <td>{{ $report->reported_by }}</td>
                                    <td>
                                        <span class="badge badge-{{ $report->severity == 'berat' ? 'danger' : ($report->severity == 'sedang' ? 'warning' : 'info') }}">
                                            {{ ucfirst($report->severity) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $report->priority == 'critical' ? 'danger' : ($report->priority == 'high' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($report->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $report->status == 'selesai' ? 'success' : ($report->status == 'dalam_proses' ? 'info' : 'secondary') }}">
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('damage-reports.show', $report) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasPermission('update-damage-reports'))
                                        <a href="{{ route('damage-reports.edit', $report) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">Tidak ada data laporan kerusakan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $damageReports->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
