@extends('layouts.app')

@section('title', 'Edit Jadwal Pemeliharaan')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Jadwal Pemeliharaan</h4>
                <p class="card-description">Perbarui informasi jadwal pemeliharaan</p>

                <form action="{{ route('maintenance-schedules.update', $maintenanceSchedule) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="asset_id">Aset <span class="text-danger">*</span></label>
                        <select class="form-select @error('asset_id') is-invalid @enderror"
                                id="asset_id"
                                name="asset_id"
                                required>
                            <option value="">Pilih Aset</option>
                            @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id', $maintenanceSchedule->asset_id) == $asset->id ? 'selected' : '' }}>
                                {{ $asset->asset_code }} - {{ $asset->name }}
                                @if($asset->room)
                                    ({{ $asset->room->name }})
                                @endif
                            </option>
                            @endforeach
                        </select>
                        @error('asset_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="scheduled_date">Tanggal Terjadwal <span class="text-danger">*</span></label>
                        <input type="date"
                               class="form-control @error('scheduled_date') is-invalid @enderror"
                               id="scheduled_date"
                               name="scheduled_date"
                               value="{{ old('scheduled_date', $maintenanceSchedule->scheduled_date->format('Y-m-d')) }}"
                               required>
                        @error('scheduled_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="frequency">Frekuensi <span class="text-danger">*</span></label>
                        <select class="form-select @error('frequency') is-invalid @enderror"
                                id="frequency"
                                name="frequency"
                                required>
                            <option value="">Pilih Frekuensi</option>
                            @foreach($frequencies as $freq)
                            <option value="{{ $freq }}" {{ old('frequency', $maintenanceSchedule->frequency) == $freq ? 'selected' : '' }}>
                                {{ ucfirst($freq) }}
                            </option>
                            @endforeach
                        </select>
                        @error('frequency')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="assigned_to">Ditugaskan Kepada</label>
                        <input type="text"
                               class="form-control @error('assigned_to') is-invalid @enderror"
                               id="assigned_to"
                               name="assigned_to"
                               value="{{ old('assigned_to', $maintenanceSchedule->assigned_to) }}"
                               placeholder="Nama teknisi/tim"
                               maxlength="100">
                        @error('assigned_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror"
                                id="status"
                                name="status"
                                required>
                            @foreach($statuses as $s)
                            <option value="{{ $s }}" {{ old('status', $maintenanceSchedule->status) == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="image_path">Foto Etiket/Jadwal</label>
                        @if($maintenanceSchedule->image_path)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $maintenanceSchedule->image_path) }}" alt="Foto Etiket" style="max-width: 200px; max-height: 200px;">
                        </div>
                        @endif
                        <input type="file"
                               class="form-control @error('image_path') is-invalid @enderror"
                               id="image_path"
                               name="image_path"
                               accept="image/*">
                        @error('image_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Format: JPG, PNG, maksimal 2MB. Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="4"
                                  placeholder="Detail pekerjaan pemeliharaan...">{{ old('description', $maintenanceSchedule->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Perbarui
                        </button>
                        <a href="{{ route('maintenance-schedules.index') }}" class="btn btn-light">
                            <i class="mdi mdi-cancel"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
