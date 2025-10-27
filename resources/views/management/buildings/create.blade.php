@extends('layouts.app')

@section('title', 'Tambah Gedung')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Gedung Baru</h4>
                <p class="card-description">Isi form di bawah untuk menambah gedung baru</p>

                <form action="{{ route('buildings.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="building_code">Kode Gedung <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('building_code') is-invalid @enderror"
                               id="building_code"
                               name="building_code"
                               value="{{ old('building_code') }}"
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
                               value="{{ old('name') }}"
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
                                  placeholder="Deskripsi gedung (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan
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
