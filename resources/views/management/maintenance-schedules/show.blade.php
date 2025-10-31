@extends('layouts.app')

@section('title', 'Detail Jadwal Pemeliharaan')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Detail Jadwal Pemeliharaan</h4>
                    <div>
                        @if(auth()->user()->hasPermission('update-maintenance-schedules'))
                        <a href="{{ route('maintenance-schedules.edit', $maintenanceSchedule) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Aset</th>
                        <td>
                            <strong>{{ $maintenanceSchedule->asset->name }}</strong><br>
                            <small class="text-muted">{{ $maintenanceSchedule->asset->asset_code }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Kategori Aset</th>
                        <td>{{ $maintenanceSchedule->asset->category->name }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>
                            @if($maintenanceSchedule->asset->room)
                                {{ $maintenanceSchedule->asset->room->name }}
                                @if($maintenanceSchedule->asset->room->building)
                                    - {{ $maintenanceSchedule->asset->room->building->name }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Tanggal Terjadwal</th>
                        <td><strong>{{ $maintenanceSchedule->scheduled_date->format('d F Y') }}</strong></td>
                    </tr>
                    <tr>
                        <th>Frekuensi</th>
                        <td><span class="badge bg-secondary">{{ ucfirst($maintenanceSchedule->frequency) }}</span></td>
                    </tr>
                    <tr>
                        <th>Ditugaskan Kepada</th>
                        <td>{{ $maintenanceSchedule->assigned_to ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($maintenanceSchedule->status === 'terjadwal')
                                <span class="badge bg-info">Terjadwal</span>
                            @elseif($maintenanceSchedule->status === 'selesai')
                                <span class="badge bg-success">Selesai</span>
                            @else
                                <span class="badge bg-danger">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $maintenanceSchedule->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $maintenanceSchedule->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $maintenanceSchedule->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if($maintenanceSchedule->logs->count() > 0)
<div class="row mt-3">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Riwayat Pemeliharaan ({{ $maintenanceSchedule->logs->count() }} log)</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Tanggal Pelaksanaan</th>
                                <th width="20%">Dilakukan Oleh</th>
                                <th width="35%">Hasil</th>
                                <th width="20%">Rekomendasi Berikutnya</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenanceSchedule->logs as $index => $log)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $log->date_performed->format('d/m/Y H:i') }}</td>
                                <td>{{ $log->performed_by }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ $log->result ? Str::limit($log->result, 80) : '-' }}
                                    </small>
                                </td>
                                <td>
                                    @if($log->next_recommendation_date)
                                        {{ $log->next_recommendation_date->format('d/m/Y') }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
