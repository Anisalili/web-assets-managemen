@extends('layouts.app')

@section('title', 'Tambah Perbaikan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Tambah Perbaikan</h3>
                    <h6 class="font-weight-normal mb-0">Buat riwayat perbaikan asset baru</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Perbaikan</h4>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('repairs.store') }}" method="POST" class="forms-sample">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="damage_report_id">Laporan Kerusakan <span class="text-danger">*</span></label>
                                    <select class="form-control" id="damage_report_id" name="damage_report_id" required>
                                        <option value="">-- Pilih Laporan Kerusakan --</option>
                                        @foreach($damageReports as $report)
                                        <option value="{{ $report->id }}"
                                                data-asset="{{ $report->asset_id }}"
                                                {{ old('damage_report_id', $selectedDamageReportId) == $report->id ? 'selected' : '' }}>
                                            {{ $report->asset->name }} - {{ $report->report_date->format('d M Y') }} ({{ ucfirst($report->severity) }})
                                        </option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Pilih laporan kerusakan yang akan diperbaiki</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asset_id">Asset <span class="text-danger">*</span></label>
                                    <select class="form-control" id="asset_id" name="asset_id" required>
                                        <option value="">-- Pilih Asset --</option>
                                        @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->name }} - {{ $asset->code }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repair_start_date">Tanggal Mulai Perbaikan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="repair_start_date" name="repair_start_date"
                                           value="{{ old('repair_start_date', now()->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repair_end_date">Tanggal Selesai Perbaikan</label>
                                    <input type="datetime-local" class="form-control" id="repair_end_date" name="repair_end_date"
                                           value="{{ old('repair_end_date') }}">
                                    <small class="form-text text-muted">Isi jika perbaikan sudah selesai</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repaired_by">Diperbaiki Oleh <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="repaired_by" name="repaired_by"
                                           value="{{ old('repaired_by', auth()->user()->name) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="repair_cost">Biaya Perbaikan (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="repair_cost" name="repair_cost"
                                           value="{{ old('repair_cost', 0) }}" min="0" step="1000" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="repair_description">Deskripsi Perbaikan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="repair_description" name="repair_description" rows="4" required>{{ old('repair_description') }}</textarea>
                            <small class="form-text text-muted">Jelaskan tindakan perbaikan yang dilakukan</small>
                        </div>

                        <div class="form-group">
                            <label for="spare_parts_used">Suku Cadang Yang Digunakan</label>
                            <textarea class="form-control" id="spare_parts_used" name="spare_parts_used" rows="3">{{ old('spare_parts_used') }}</textarea>
                            <small class="form-text text-muted">Sebutkan suku cadang yang digunakan (opsional)</small>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="failed" {{ old('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="notes">Catatan</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="mdi mdi-content-save"></i> Simpan
                            </button>
                            <a href="{{ route('repairs.index') }}" class="btn btn-light">
                                <i class="mdi mdi-cancel"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-fill asset when damage report is selected
document.getElementById('damage_report_id').addEventListener('change', function() {
    var selectedOption = this.options[this.selectedIndex];
    var assetId = selectedOption.getAttribute('data-asset');
    if (assetId) {
        document.getElementById('asset_id').value = assetId;
    }
});

// Trigger on page load if damage report is pre-selected
window.addEventListener('DOMContentLoaded', function() {
    var damageReportSelect = document.getElementById('damage_report_id');
    if (damageReportSelect.value) {
        var selectedOption = damageReportSelect.options[damageReportSelect.selectedIndex];
        var assetId = selectedOption.getAttribute('data-asset');
        if (assetId) {
            document.getElementById('asset_id').value = assetId;
        }
    }
});
</script>
@endpush
@endsection
