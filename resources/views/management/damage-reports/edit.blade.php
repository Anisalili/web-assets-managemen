@extends('layouts.app')

@section('title', 'Edit Laporan Kerusakan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Edit Laporan Kerusakan</h3>
                    <h6 class="font-weight-normal mb-0">Perbarui informasi laporan kerusakan</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Edit Laporan Kerusakan</h4>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('damage-reports.update', $damageReport) }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="asset_id">Asset <span class="text-danger">*</span></label>
                                    <select class="form-control" id="asset_id" name="asset_id" required>
                                        <option value="">-- Pilih Asset --</option>
                                        @foreach($assets as $asset)
                                        <option value="{{ $asset->id }}" {{ old('asset_id', $damageReport->asset_id) == $asset->id ? 'selected' : '' }}>
                                            {{ $asset->name }} - {{ $asset->code }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reported_by">Dilaporkan Oleh <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reported_by" name="reported_by"
                                           value="{{ old('reported_by', $damageReport->reported_by) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="report_date">Tanggal Laporan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="report_date" name="report_date"
                                           value="{{ old('report_date', $damageReport->report_date->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="severity">Tingkat Kerusakan <span class="text-danger">*</span></label>
                                    <select class="form-control" id="severity" name="severity" required>
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="ringan" {{ old('severity', $damageReport->severity) == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                        <option value="sedang" {{ old('severity', $damageReport->severity) == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="berat" {{ old('severity', $damageReport->severity) == 'berat' ? 'selected' : '' }}>Berat</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="damage_type">Jenis Kerusakan</label>
                                    <select class="form-control" id="damage_type" name="damage_type">
                                        <option value="">-- Pilih Jenis --</option>
                                        <option value="mechanical" {{ old('damage_type', $damageReport->damage_type) == 'mechanical' ? 'selected' : '' }}>Mechanical</option>
                                        <option value="electrical" {{ old('damage_type', $damageReport->damage_type) == 'electrical' ? 'selected' : '' }}>Electrical</option>
                                        <option value="structural" {{ old('damage_type', $damageReport->damage_type) == 'structural' ? 'selected' : '' }}>Structural</option>
                                        <option value="software" {{ old('damage_type', $damageReport->damage_type) == 'software' ? 'selected' : '' }}>Software</option>
                                        <option value="hardware" {{ old('damage_type', $damageReport->damage_type) == 'hardware' ? 'selected' : '' }}>Hardware</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-control" id="priority" name="priority" required>
                                        <option value="">-- Pilih Prioritas --</option>
                                        <option value="low" {{ old('priority', $damageReport->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $damageReport->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $damageReport->priority) == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="critical" {{ old('priority', $damageReport->priority) == 'critical' ? 'selected' : '' }}>Critical</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $damageReport->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="impact_on_operations">Dampak Pada Operasional</label>
                            <textarea class="form-control" id="impact_on_operations" name="impact_on_operations" rows="3">{{ old('impact_on_operations', $damageReport->impact_on_operations) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estimated_repair_cost">Estimasi Biaya Perbaikan (Rp)</label>
                                    <input type="number" class="form-control" id="estimated_repair_cost" name="estimated_repair_cost"
                                           value="{{ old('estimated_repair_cost', $damageReport->estimated_repair_cost) }}" min="0" step="1000">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image_path">Foto Kerusakan</label>
                                    @if($damageReport->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $damageReport->image_path) }}" alt="Foto Kerusakan" style="max-width: 200px; max-height: 200px;">
                                    </div>
                                    @endif
                                    <input type="file" class="form-control" id="image_path" name="image_path" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG, maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-control" id="status" name="status" required>
                                        <option value="dilaporkan" {{ old('status', $damageReport->status) == 'dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                                        <option value="dalam_proses" {{ old('status', $damageReport->status) == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                                        <option value="selesai" {{ old('status', $damageReport->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="resolved_by">Diselesaikan Oleh</label>
                                    <input type="text" class="form-control" id="resolved_by" name="resolved_by"
                                           value="{{ old('resolved_by', $damageReport->resolved_by) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="resolved_date">Tanggal Diselesaikan</label>
                            <input type="datetime-local" class="form-control" id="resolved_date" name="resolved_date"
                                   value="{{ old('resolved_date', $damageReport->resolved_date ? $damageReport->resolved_date->format('Y-m-d\TH:i') : '') }}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="mdi mdi-content-save"></i> Update
                            </button>
                            <a href="{{ route('damage-reports.index') }}" class="btn btn-light">
                                <i class="mdi mdi-cancel"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
