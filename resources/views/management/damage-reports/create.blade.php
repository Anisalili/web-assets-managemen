@extends('layouts.app')

@section('title', 'Tambah Laporan Kerusakan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Tambah Laporan Kerusakan</h3>
                    <h6 class="font-weight-normal mb-0">Buat laporan kerusakan asset baru</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Laporan Kerusakan</h4>

                    @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('damage-reports.store') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                        @csrf

                        <div class="row">
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

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reported_by">Dilaporkan Oleh <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="reported_by" name="reported_by"
                                           value="{{ old('reported_by', auth()->user()->name) }}" required>
                                    <small class="form-text text-muted">Bisa diubah untuk karyawan yang tidak memiliki akun</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="report_date">Tanggal Laporan <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" id="report_date" name="report_date"
                                           value="{{ old('report_date', now()->format('Y-m-d\TH:i')) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="severity">Tingkat Kerusakan <span class="text-danger">*</span></label>
                                    <select class="form-control" id="severity" name="severity" required>
                                        <option value="">-- Pilih Tingkat --</option>
                                        <option value="ringan" {{ old('severity') == 'ringan' ? 'selected' : '' }}>Ringan</option>
                                        <option value="sedang" {{ old('severity') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                        <option value="berat" {{ old('severity') == 'berat' ? 'selected' : '' }}>Berat</option>
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
                                        <option value="mechanical" {{ old('damage_type') == 'mechanical' ? 'selected' : '' }}>Mekanik</option>
                                        <option value="electrical" {{ old('damage_type') == 'electrical' ? 'selected' : '' }}>Elektrik</option>
                                        <option value="structural" {{ old('damage_type') == 'structural' ? 'selected' : '' }}>Struktur</option>
                                        <option value="software" {{ old('damage_type') == 'software' ? 'selected' : '' }}>Perangkat Lunak</option>
                                        <option value="hardware" {{ old('damage_type') == 'hardware' ? 'selected' : '' }}>Perangkat Keras</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="priority">Prioritas <span class="text-danger">*</span></label>
                                    <select class="form-control" id="priority" name="priority" required>
                                        <option value="">-- Pilih Prioritas --</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Rendah</option>
                                        <option value="medium" {{ old('priority', 'medium') == 'medium' ? 'selected' : '' }}>Sedang</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>Tinggi</option>
                                        <option value="critical" {{ old('priority') == 'critical' ? 'selected' : '' }}>Kritis</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Kerusakan <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="impact_on_operations">Dampak Pada Operasional</label>
                            <textarea class="form-control" id="impact_on_operations" name="impact_on_operations" rows="3">{{ old('impact_on_operations') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="estimated_repair_cost">Estimasi Biaya Perbaikan (Rp)</label>
                                    <input type="number" class="form-control" id="estimated_repair_cost" name="estimated_repair_cost"
                                           value="{{ old('estimated_repair_cost') }}" min="0" step="1000">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="image_path">Foto Kerusakan</label>
                                    <input type="file" class="form-control" id="image_path" name="image_path" accept="image/*">
                                    <small class="form-text text-muted">Format: JPG, PNG, maksimal 2MB</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="dilaporkan" {{ old('status', 'dilaporkan') == 'dilaporkan' ? 'selected' : '' }}>Dilaporkan</option>
                                <option value="dalam_proses" {{ old('status') == 'dalam_proses' ? 'selected' : '' }}>Dalam Proses</option>
                                <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary mr-2">
                                <i class="mdi mdi-content-save"></i> Simpan
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
