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
                        {{-- Tombol Update Status untuk Teknisi yang di-assign --}}
                        @if($maintenanceSchedule->assigned_to == auth()->id() && in_array($maintenanceSchedule->status, ['terjadwal', 'dalam_perbaikan']))
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#updateStatusModal">
                            <i class="mdi mdi-sync"></i> Update Status
                        </button>
                        @endif

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
                        <td>{{ $maintenanceSchedule->assignedUser->name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            @if($maintenanceSchedule->status === 'terjadwal')
                                <span class="badge bg-info">Terjadwal</span>
                            @elseif($maintenanceSchedule->status === 'dalam_perbaikan')
                                <span class="badge bg-warning">Dalam Perbaikan</span>
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
                                <td>{{ $log->performedBy->name ?? '-' }}</td>
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

{{-- Modal Update Status --}}
@if($maintenanceSchedule->assigned_to == auth()->id() && in_array($maintenanceSchedule->status, ['terjadwal', 'dalam_perbaikan']))
<div class="modal fade" id="updateStatusModal" tabindex="-1" role="dialog" aria-labelledby="updateStatusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('maintenance-schedules.update-status', $maintenanceSchedule) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="updateStatusModalLabel">
                        <i class="mdi mdi-sync"></i> Update Status Maintenance
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
                            @if($maintenanceSchedule->status == 'terjadwal')
                            <option value="dalam_perbaikan">Dalam Perbaikan (Sedang Dikerjakan)</option>
                            <option value="selesai">Selesai</option>
                            @elseif($maintenanceSchedule->status == 'dalam_perbaikan')
                            <option value="selesai">Selesai</option>
                            @endif
                        </select>
                    </div>

                    <div id="selesaiFields" style="display: none;">
                        <hr>
                        <h6 class="mb-3">Detail Penyelesaian Maintenance</h6>

                        <div class="form-group">
                            <label for="result">Hasil Perawatan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="result" name="result" rows="4"
                                placeholder="Jelaskan hasil perawatan yang telah dilakukan..."></textarea>
                            <small class="form-text text-muted">Wajib diisi jika status selesai</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="maintenance_cost">Biaya Perawatan (Rp)</label>
                                    <input type="number" class="form-control" id="maintenance_cost"
                                        name="maintenance_cost" min="0" step="1000"
                                        placeholder="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="next_recommendation_date">Rekomendasi Perawatan Berikutnya</label>
                                    <input type="date" class="form-control" id="next_recommendation_date"
                                        name="next_recommendation_date"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="spare_parts_used">Spare Parts yang Digunakan</label>
                            <textarea class="form-control" id="spare_parts_used" name="spare_parts_used" rows="2"
                                placeholder="Daftar spare parts yang digunakan..."></textarea>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan Tambahan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="2"
                                placeholder="Catatan atau informasi tambahan..."></textarea>
                        </div>
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

    // Handle status change untuk show/hide selesai fields
    const statusSelect = document.getElementById('status');
    const selesaiFields = document.getElementById('selesaiFields');
    const resultField = document.getElementById('result');

    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            if (this.value === 'selesai') {
                selesaiFields.style.display = 'block';
                resultField.setAttribute('required', 'required');
            } else {
                selesaiFields.style.display = 'none';
                resultField.removeAttribute('required');
            }
        });
    }
});
</script>
@endpush
