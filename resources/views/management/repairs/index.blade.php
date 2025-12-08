@extends('layouts.app')

@section('title', 'Riwayat Perbaikan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Riwayat Perbaikan Asset</h3>
                    <h6 class="font-weight-normal mb-0">Kelola riwayat perbaikan asset perusahaan</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Daftar Perbaikan</h4>
                        @if(auth()->user()->hasPermission('create-repairs'))
                        <a href="{{ route('repairs.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah Perbaikan
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
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Diperbaiki Oleh</th>
                                    <th>Ditugaskan</th>
                                    <th>Biaya</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($repairs as $index => $repair)
                                <tr>
                                    <td>{{ $repairs->firstItem() + $index }}</td>
                                    <td>{{ $repair->asset->name }}</td>
                                    <td>{{ $repair->repair_start_date->format('d M Y') }}</td>
                                    <td>{{ $repair->repair_end_date ? $repair->repair_end_date->format('d M Y') : '-' }}</td>
                                    <td>{{ $repair->repairedBy->name ?? '-' }}</td>
                                    <td>{{ $repair->assignedUser->name ?? '-' }}</td>
                                    <td>Rp {{ number_format($repair->repair_cost, 0, ',', '.') }}</td>
                                    <td>
                                        <span class="badge badge-{{ $repair->status == 'completed' ? 'success' : ($repair->status == 'in_progress' ? 'info' : ($repair->status == 'failed' ? 'danger' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('repairs.show', $repair) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasPermission('update-repairs'))
                                        <a href="{{ route('repairs.edit', $repair) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data perbaikan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $repairs->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
