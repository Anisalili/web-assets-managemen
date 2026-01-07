@extends('layouts.app')

@section('title', 'Pindah Aset')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Pindah Aset</h4>
                <p class="card-description">Pindahkan aset ke lokasi/ruangan baru</p>

                <!-- Asset Info Card -->
                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-3 text-muted">Informasi Aset</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Kode Aset:</strong>
                                    <span class="text-primary">{{ $asset->asset_code }}</span>
                                </p>
                                <p class="mb-2">
                                    <strong>Nama:</strong>
                                    {{ $asset->name }}
                                </p>
                                <p class="mb-2">
                                    <strong>Kategori:</strong>
                                    <span class="badge bg-secondary">{{ $asset->category->name }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <strong>Lokasi Saat Ini:</strong>
                                    @if($asset->room)
                                        {{ $asset->room->building->name }} - {{ $asset->room->name }}
                                    @else
                                        <span class="text-muted">Belum ditentukan</span>
                                    @endif
                                </p>
                                <p class="mb-2">
                                    <strong>Pengguna Saat Ini:</strong>
                                    @if($asset->private_owner)
                                        {{ $asset->private_owner }}
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </p>
                                <p class="mb-0">
                                    <strong>Status:</strong>
                                    @if($asset->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($asset->status == 'non-aktif')
                                        <span class="badge bg-dark">Non-aktif</span>
                                    @elseif($asset->status == 'dalam_perbaikan')
                                        <span class="badge bg-warning">Dalam Perbaikan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('assets.transfer.post', $asset) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="room_id">Lokasi Baru <span class="text-danger">*</span></label>
                        <select class="form-select @error('room_id') is-invalid @enderror"
                                id="room_id"
                                name="room_id"
                                required>
                            <option value="">Pilih Ruangan Tujuan</option>
                            @foreach($rooms as $room)
                            <option value="{{ $room->id }}" {{ old('room_id') == $room->id ? 'selected' : '' }}>
                                {{ $room->building->name }} - {{ $room->name }}
                            </option>
                            @endforeach
                        </select>
                        @error('room_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pilih ruangan tujuan untuk aset ini</small>
                    </div>

                    <div class="form-group">
                        <label for="private_owner">Pengguna Baru</label>
                        <input type="text"
                               class="form-control @error('private_owner') is-invalid @enderror"
                               id="private_owner"
                               name="private_owner"
                               value="{{ old('private_owner', $asset->private_owner) }}"
                               placeholder="Contoh: Budi Santoso"
                               maxlength="100">
                        @error('private_owner')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Kosongkan jika milik ruangan/institusi</small>
                    </div>

                    <div class="form-group">
                        <label for="notes">Catatan Perpindahan</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror"
                                  id="notes"
                                  name="notes"
                                  rows="3"
                                  placeholder="Alasan perpindahan (opsional)"
                                  maxlength="500">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Catatan ini akan disimpan ke riwayat perpindahan</small>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-swap-horizontal"></i> Pindahkan Aset
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
