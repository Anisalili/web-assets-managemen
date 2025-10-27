@extends('layouts.app')

@section('title', 'Tambah Ruangan')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Ruangan Baru</h4>
                <p class="card-description">Isi form di bawah untuk menambah ruangan baru</p>

                <form action="{{ route('rooms.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="room_code">Kode Ruangan <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('room_code') is-invalid @enderror"
                               id="room_code"
                               name="room_code"
                               value="{{ old('room_code') }}"
                               placeholder="Contoh: R-001"
                               maxlength="20"
                               required
                               autofocus>
                        @error('room_code')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Maksimal 20 karakter, harus unik</small>
                    </div>

                    <div class="form-group">
                        <label for="building_id">Gedung <span class="text-danger">*</span></label>
                        <select class="form-select @error('building_id') is-invalid @enderror"
                                id="building_id"
                                name="building_id"
                                required>
                            <option value="">Pilih Gedung</option>
                            @foreach($buildings as $building)
                            <option value="{{ $building->id }}" {{ old('building_id') == $building->id ? 'selected' : '' }}>
                                {{ $building->name }} ({{ $building->building_code }})
                            </option>
                            @endforeach
                        </select>
                        @error('building_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="name">Nama Ruangan <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Ruang Produksi 1"
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
                                  placeholder="Deskripsi ruangan (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan
                        </button>
                        <a href="{{ route('rooms.index') }}" class="btn btn-light">
                            <i class="mdi mdi-cancel"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
