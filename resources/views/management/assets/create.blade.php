@extends('layouts.app')

@section('title', 'Tambah Aset')

@section('content')
<div class="row">
    <div class="col-md-10 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Aset Baru</h4>
                <p class="card-description">Isi form di bawah untuk menambah aset baru</p>

                <form action="{{ route('assets.store') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asset_code">Kode Aset <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('asset_code') is-invalid @enderror"
                                       id="asset_code"
                                       name="asset_code"
                                       value="{{ old('asset_code') }}"
                                       placeholder="Contoh: AST-001"
                                       maxlength="50"
                                       required
                                       autofocus>
                                @error('asset_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maksimal 50 karakter, harus unik</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nama Aset <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Contoh: Laptop HP Pavilion"
                                       maxlength="150"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Maksimal 150 karakter</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="category_id">Kategori <span class="text-danger">*</span></label>
                                <select class="form-select @error('category_id') is-invalid @enderror"
                                        id="category_id"
                                        name="category_id"
                                        required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="room_id">Lokasi (Ruangan)</label>
                                <select class="form-select @error('room_id') is-invalid @enderror"
                                        id="room_id"
                                        name="room_id">
                                    <option value="">Pilih Ruangan (Opsional)</option>
                                    @foreach($rooms as $room)
                                    <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                        {{ $room->building->name }} - {{ $room->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('room_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="">Pilih Status</option>
                                    @foreach($statuses as $stat)
                                    <option value="{{ $stat }}" {{ old('status') == $stat ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('_', ' ', $stat)) }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="owner">Pemilik/Penanggung Jawab</label>
                                <input type="text"
                                       class="form-control @error('owner') is-invalid @enderror"
                                       id="owner"
                                       name="owner"
                                       value="{{ old('owner') }}"
                                       placeholder="Contoh: Bagian IT"
                                       maxlength="100">
                                @error('owner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Pemilik institusi/bagian</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="private_owner">Pengguna Pribadi</label>
                                <input type="text"
                                       class="form-control @error('private_owner') is-invalid @enderror"
                                       id="private_owner"
                                       name="private_owner"
                                       value="{{ old('private_owner') }}"
                                       placeholder="Contoh: Budi Santoso"
                                       maxlength="100">
                                @error('private_owner')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika milik ruangan/institusi</small>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Foto Aset</label>
                                <input type="file"
                                       class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image"
                                       accept="image/jpeg,image/png,image/jpg">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Format: JPG, PNG, maksimal 2MB</small>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchase_date">Tanggal Pembelian</label>
                                <input type="date"
                                       class="form-control @error('purchase_date') is-invalid @enderror"
                                       id="purchase_date"
                                       name="purchase_date"
                                       value="{{ old('purchase_date') }}">
                                @error('purchase_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Nilai Beli (Rp)</label>
                                <input type="text"
                                       class="form-control @error('value') is-invalid @enderror"
                                       id="value"
                                       name="value"
                                       value="{{ old('value') }}"
                                       placeholder="Belum ada harga">
                                @error('value')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Kosongkan jika belum ada harga. Aktiva: > 500, Pasif: ≤ 500</small>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  id="notes"
                                  name="notes"
                                  rows="4"
                                  placeholder="Catatan tambahan (opsional)">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan
                        </button>
                        <a href="{{ route('assets.index') }}" class="btn btn-light">
                            <i class="mdi mdi-cancel"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
