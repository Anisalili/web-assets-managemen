@extends('layouts.app')

@section('title', 'Detail Laporan Kerusakan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Detail Laporan Kerusakan</h3>
                    <h6 class="font-weight-normal mb-0">Informasi lengkap laporan kerusakan asset</h6>
                </div>
                <div class="col-12 col-xl-4">
                    <div class="justify-content-end d-flex">
                        <a href="{{ route('damage-reports.index') }}" class="btn btn-sm btn-light mr-2">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                        @if(auth()->user()->hasPermission('update-damage-reports'))
                        <a href="{{ route('damage-reports.edit', $damageReport) }}" class="btn btn-sm btn-primary mr-2">
                            <i class="mdi mdi-pencil"></i> Edit Full
                        </a>
                        @elseif(auth()->user()->hasPermission('update-damage-status'))
                        <button type="button" class="btn btn-sm btn-warning mr-2" data-toggle="modal" data-target="#updateStatusModal">
                            <i class="mdi mdi-sync"></i> Update Status
                        </button>
                        @endif
                        @if(auth()->user()->hasPermission('create-repairs') && $damageReport->status != 'selesai')
                        <a href="{{ route('repairs.create', ['damage_report_id' => $damageReport->id]) }}" class="btn btn-sm btn-success">
                            <i class="mdi mdi-wrench"></i> Buat Perbaikan
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
                    <h4 class="card-title">Informasi Kerusakan</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Asset:</label>
                                <p>{{ $damageReport->asset->name }} ({{ $damageReport->asset->code }})</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Kategori Asset:</label>
                                <p>{{ $damageReport->asset->category->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Lokasi:</label>
                                <p>{{ $damageReport->asset->room->building->name }} - {{ $damageReport->asset->room->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Dilaporkan Oleh:</label>
                                <p>{{ $damageReport->reported_by }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Laporan:</label>
                                <p>{{ $damageReport->report_date->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Status:</label>
                                <p>
                                    <span class="badge badge-{{ $damageReport->status == 'selesai' ? 'success' : ($damageReport->status == 'dalam_proses' ? 'info' : 'secondary') }}">
                                        {{ ucfirst(str_replace('_', ' ', $damageReport->status)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tingkat Kerusakan:</label>
                                <p>
                                    <span class="badge badge-{{ $damageReport->severity == 'berat' ? 'danger' : ($damageReport->severity == 'sedang' ? 'warning' : 'info') }}">
                                        {{ ucfirst($damageReport->severity) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Prioritas:</label>
                                <p>
                                    <span class="badge badge-{{ $damageReport->priority == 'critical' ? 'danger' : ($damageReport->priority == 'high' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($damageReport->priority) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    @if($damageReport->damage_type)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Jenis Kerusakan:</label>
                                <p>{{ ucfirst($damageReport->damage_type) }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Deskripsi Kerusakan:</label>
                                <p class="text-justify">{{ $damageReport->description }}</p>
                            </div>
                        </div>
                    </div>

                    @if($damageReport->impact_on_operations)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Dampak Pada Operasional:</label>
                                <p class="text-justify">{{ $damageReport->impact_on_operations }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($damageReport->estimated_repair_cost)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Estimasi Biaya Perbaikan:</label>
                                <p class="text-primary font-weight-bold">Rp {{ number_format($damageReport->estimated_repair_cost, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($damageReport->image_path)
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="font-weight-bold">Foto Kerusakan:</label>
                                <div>
                                    <img src="{{ asset('storage/' . $damageReport->image_path) }}" alt="Foto Kerusakan" class="img-fluid" style="max-width: 500px;">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($damageReport->status == 'selesai')
                    <hr>
                    <h5 class="mt-4 mb-3">Informasi Penyelesaian</h5>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Diselesaikan Oleh:</label>
                                <p>{{ $damageReport->resolved_by }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="font-weight-bold">Tanggal Diselesaikan:</label>
                                <p>{{ $damageReport->resolved_date->format('d F Y H:i') }}</p>
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
                    <h4 class="card-title">Riwayat Perbaikan</h4>

                    @if($damageReport->repairs->count() > 0)
                        @foreach($damageReport->repairs as $repair)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Perbaikan #{{ $loop->iteration }}</h6>
                                <span class="badge badge-{{ $repair->status == 'completed' ? 'success' : ($repair->status == 'in_progress' ? 'info' : 'secondary') }}">
                                    {{ ucfirst(str_replace('_', ' ', $repair->status)) }}
                                </span>
                            </div>
                            <p class="text-muted mb-1"><small>{{ $repair->repair_start_date->format('d M Y') }}</small></p>
                            <p class="mb-1">{{ Str::limit($repair->repair_description, 80) }}</p>
                            <p class="text-primary mb-1"><strong>Biaya: Rp {{ number_format($repair->repair_cost, 0, ',', '.') }}</strong></p>
                            <a href="{{ route('repairs.show', $repair) }}" class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-eye"></i> Detail
                            </a>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">Belum ada riwayat perbaikan untuk laporan ini.</p>
                        @if(auth()->user()->hasPermission('create-repairs'))
                        <a href="{{ route('repairs.create', ['damage_report_id' => $damageReport->id]) }}" class="btn btn-sm btn-primary">
                            <i class="mdi mdi-plus"></i> Tambah Perbaikan
                        </a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Update Status (for Teknisi) -->
@if(auth()->user()->hasPermission('update-damage-status'))
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('damage-reports.update-status', $damageReport) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">Update Status Laporan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="dilaporkan" {{ $damageReport->status == 'dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                            <option value="dalam_proses" {{ $damageReport->status == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                            <option value="selesai" {{ $damageReport->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="mdi mdi-information"></i> Jika status diubah menjadi "Selesai", tanggal dan user penyelesaian akan otomatis terisi.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection
