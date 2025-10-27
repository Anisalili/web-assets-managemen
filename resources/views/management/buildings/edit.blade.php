@extends('layouts.app')

@section('title', 'Edit Gedung')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Gedung</h4>
                <p class="card-description">Edit data gedung <strong class="text-primary">{{ $building->name }}</strong></p>

                <form action="{{ route('buildings.update', $building) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="building_code">Kode Gedung <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('building_code') is-invalid @enderror"
                               id="building_code"
                               name="building_code"
                               value="{{ old('building_code', $building->building_code) }}"
                               placeholder="Contoh: GD-001"
                               maxlength="20"
                               required
                               autofocus>
                        @error('building_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Maksimal 20 karakter, harus unik</small>
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Gedung <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $building->name) }}"
                               placeholder="Contoh: Gedung Utama"
                               maxlength="100"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Maksimal 100 karakter</small>
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="4"
                                  placeholder="Deskripsi gedung (opsional)">{{ old('description', $building->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Update
                        </button>
                        <a href="{{ route('buildings.index') }}" class="btn btn-light">
                            <i class="mdi mdi-cancel"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
