@extends('layouts.app')

@section('title', 'Tambah Kategori Aset')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Kategori Aset Baru</h4>
                <p class="card-description">Isi form di bawah untuk menambah kategori aset baru</p>

                <form action="{{ route('asset-categories.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               placeholder="Contoh: Elektronik"
                               maxlength="100"
                               required
                               autofocus>
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
                                  placeholder="Deskripsi kategori (opsional)">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan
                        </button>
                        <a href="{{ route('asset-categories.index') }}" class="btn btn-light">
                            <i class="mdi mdi-cancel"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
