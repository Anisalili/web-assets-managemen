@extends('layouts.app')

@section('title', 'Detail Log Pemeliharaan')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Detail Log Pemeliharaan</h4>
                    <div>
                        <span class="badge badge-info mr-2">Auto-Generated Log</span>
                        <a href="{{ route('maintenance-logs.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <table class="table table-borderless">
                    @if($maintenanceLog->schedule)
                    <tr>
                        <th width="30%">Jadwal Terkait</th>
                        <td>
                            @if(auth()->user()->hasPermission('view-maintenance-schedules'))
                                <a href="{{ route('maintenance-schedules.show', $maintenanceLog->schedule) }}">
                                    Jadwal {{ $maintenanceLog->schedule->scheduled_date->format('d/m/Y') }}
                                </a>
                            @else
                                Jadwal {{ $maintenanceLog->schedule->scheduled_date->format('d/m/Y') }}
                            @endif
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <th width="30%">Aset</th>
                        <td>
                            <strong>{{ $maintenanceLog->asset->name }}</strong><br>
                            <small class="text-muted">{{ $maintenanceLog->asset->asset_code }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Kategori Aset</th>
                        <td>{{ $maintenanceLog->asset->category->name }}</td>
                    </tr>
                    <tr>
                        <th>Lokasi</th>
                        <td>
                            @if($maintenanceLog->asset->room)
                                {{ $maintenanceLog->asset->room->name }}
                                @if($maintenanceLog->asset->room->building)
                                    - {{ $maintenanceLog->asset->room->building->name }}
                                @endif
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dilakukan Oleh</th>
                        <td><strong>{{ $maintenanceLog->performedBy->name ?? '-' }}</strong></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pelaksanaan</th>
                        <td><strong>{{ $maintenanceLog->date_performed->format('d F Y, H:i') }} WIB</strong></td>
                    </tr>
                    <tr>
                        <th>Hasil Pemeliharaan</th>
                        <td>
                            @if($maintenanceLog->result)
                                <div class="p-2 bg-light rounded">
                                    {{ $maintenanceLog->result }}
                                </div>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Rekomendasi Berikutnya</th>
                        <td>
                            @if($maintenanceLog->next_recommendation_date)
                                <span class="badge bg-warning">
                                    {{ $maintenanceLog->next_recommendation_date->format('d F Y') }}
                                </span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $maintenanceLog->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $maintenanceLog->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
