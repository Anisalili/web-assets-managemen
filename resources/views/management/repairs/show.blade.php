@extends('layouts.app')

@section('title', 'Detail Perbaikan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Detail Perbaikan</h3>
                    <h6 class="font-weight-normal mb-0">Informasi lengkap perbaikan asset</h6>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="justify-content-end d-flex">
                        <a href="{{ route('repairs.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>

                        {{-- Tombol Update Status untuk Teknisi yang di-assign --}}
                        @if($repair->assigned_to == auth()->id() && !in_array($repair->status, ['completed', 'failed']))
                        <button type="button" class="btn btn-sm btn-primary mr-2" data-toggle="modal" data-target="#updateStatusModal">
                            <i class="mdi mdi-sync"></i> Update Status
                        </button>
                        @endif

                        @if(auth()->user()->hasPermission('update-repairs'))
                        <a href="{{ route('repairs.edit', $repair) }}" class="btn btn-sm btn-warning">
                            <i class="mdi mdi-pencil"></i> Edit Full
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Perbaikan</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Asset:</label>
                                <p>{{ $repair->asset->name }} ({{ $repair->asset->code }})</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kategori Asset:</label>
                                <p>{{ $repair->asset->category->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Lokasi:</label>
                                <p>
                                    @if($repair->asset->room)
                                        @if($repair->asset->room->building)
                                            {{ $repair->asset->room->building->name }} - {{ $repair->asset->room->name }}
                                        @else
                                            {{ $repair->asset->room->name }}
                                        @endif
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status:</label>
                                <p>
                                    <span class="badge badge-{{ $repair->status == 'completed' ? 'success' : ($repair->status == 'in_progress' ? 'info' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Mulai Perbaikan:</label>
                                <p>{{ $repair->repair_start_date->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Selesai Perbaikan:</label>
                                <p>{{ $repair->repair_end_date ? $repair->repair_end_date->format('d F Y H:i') : '-' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($repair->repair_end_date)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Durasi Perbaikan:</label>
                                <p>{{ $repair->repair_start_date->diffForHumans($repair->repair_end_date, true) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Diperbaiki Oleh:</label>
                                <p>{{ $repair->repaired_by }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Biaya Perbaikan:</label>
                                <p class="text-primary font-weight-bold">Rp {{ number_format($repair->repair_cost, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi Perbaikan:</label>
                                <p class="text-justify">{{ $repair->repair_description }}</p>
                            </div>
                        </div>
                    </div>

                    @if($repair->spare_parts_used)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Suku Cadang Yang Digunakan:</label>
                                <p class="text-justify">{{ $repair->spare_parts_used }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($repair->notes)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Catatan:</label>
                                <p class="text-justify">{{ $repair->notes }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5 col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Laporan Kerusakan Terkait</h4>

                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge badge-{{ $repair->damageReport->severity == 'berat' ? 'danger' : ($repair->damageReport->severity == 'sedang' ? 'warning' : 'info') }}">
                                {{ ucfirst($repair->damageReport->severity) }}
                            </span>
                            <span class="badge badge-{{ $repair->damageReport->status == 'selesai' ? 'success' : 'secondary' }}">
                                {{ ucfirst(str_replace('_', ' ', $repair->damageReport->status)) }}
                            </span>
                        </div>
                        <p class="text-muted mb-1"><small>Dilaporkan: {{ $repair->damageReport->report_date->format('d M Y') }}</small></p>
                        <p class="mb-2"><strong>Dilaporkan Oleh:</strong> {{ $repair->damageReport->reportedBy->name ?? '-' }}</p>
                        <p class="mb-2">{{ Str::limit($repair->damageReport->description, 150) }}</p>
                        <a href="{{ route('damage-reports.show', $repair->damageReport) }}" class="btn btn-sm btn-outline-primary">
                            <i class="mdi mdi-eye"></i> Lihat Laporan Lengkap
                        </a>
                    </div>

                    @if($repair->damageReport->estimated_repair_cost)
                    <div class="mt-3">
                        <h6>Perbandingan Biaya</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Estimasi:</span>
                            <span class="text-muted">Rp {{ number_format($repair->damageReport->estimated_repair_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Aktual:</span>
                            <span class="text-primary font-weight-bold">Rp {{ number_format($repair->repair_cost, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span>Selisih:</span>
                            <span class="{{ $repair->repair_cost > $repair->damageReport->estimated_repair_cost ? 'text-danger' : 'text-success' }} font-weight-bold">
                                Rp {{ number_format(abs($repair->repair_cost - $repair->damageReport->estimated_repair_cost), 0, ',', '.') }}
                                @if($repair->repair_cost > $repair->damageReport->estimated_repair_cost)
                                    (lebih tinggi)
                                @else
                                    (lebih rendah)
                                @endif
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Section -->
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Timeline</h4>
                    <div class="mt-3">
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <i class="mdi mdi-alert-circle text-danger mdi-24px"></i>
                            </div>
                            <div>
                                <p class="mb-0"><strong>Kerusakan Dilaporkan</strong></p>
                                <small class="text-muted">{{ $repair->damageReport->report_date->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        <div class="d-flex mb-3">
                            <div class="mr-3">
                                <i class="mdi mdi-wrench text-warning mdi-24px"></i>
                            </div>
                            <div>
                                <p class="mb-0"><strong>Perbaikan Dimulai</strong></p>
                                <small class="text-muted">{{ $repair->repair_start_date->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        @if($repair->repair_end_date)
                        <div class="d-flex">
                            <div class="mr-3">
                                <i class="mdi mdi-check-circle text-success mdi-24px"></i>
                            </div>
                            <div>
                                <p class="mb-0"><strong>Perbaikan Selesai</strong></p>
                                <small class="text-muted">{{ $repair->repair_end_date->format('d M Y H:i') }}</small>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Status (for Teknisi yang di-assign) -->
@if($repair->assigned_to == auth()->id() && !in_array($repair->status, ['completed', 'failed']))
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('repairs.update-status', $repair) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">
                        <i class="mdi mdi-sync"></i> Update Status Perbaikan
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">-- Pilih Status --</option>
                            @if($repair->status == 'pending')
                            <option value="in_progress">In Progress (Sedang Dikerjakan)</option>
                            <option value="completed">Completed (Selesai)</option>
                            <option value="failed">Failed (Gagal)</option>
                            @elseif($repair->status == 'in_progress')
                            <option value="completed">Completed (Selesai)</option>
                            <option value="failed">Failed (Gagal)</option>
                            @endif
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i>
                        <small>
                            Status "Completed" akan otomatis:
                            <ul class="mb-0 mt-1">
                                <li>Mengisi tanggal selesai perbaikan</li>
                                <li>Update status laporan kerusakan menjadi "Selesai"</li>
                            </ul>
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="mdi mdi-check"></i> Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Pastikan modal bisa dibuka dengan jQuery
    $('[data-target="#updateStatusModal"]').on('click', function(e) {
        e.preventDefault();
        $('#updateStatusModal').modal('show');
    });
});
</script>
@endpush
