@extends('layouts.app')

@section('title', 'Tambah Log Pemeliharaan')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Tambah Log Pemeliharaan</h4>
                <p class="card-description">Isi form di bawah untuk mencatat pemeliharaan yang telah dilakukan</p>

                <form action="{{ route('maintenance-logs.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="schedule_id">Jadwal Pemeliharaan (Opsional)</label>
                        <select class="form-select @error('schedule_id') is-invalid @enderror"
                                id="schedule_id"
                                name="schedule_id">
                            <option value="">Tidak terkait jadwal</option>
                            @foreach($schedules as $schedule)
                            <option value="{{ $schedule->id }}" {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}>
                                {{ $schedule->asset->asset_code }} - {{ $schedule->asset->name }}
                                ({{ $schedule->scheduled_date->format('d/m/Y') }})
                            </option>
                            @endforeach
                        </select>
                        @error('schedule_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pilih jika log ini terkait dengan jadwal pemeliharaan</small>
                    </div>

                    <div class="form-group">
                        <label for="asset_id">Aset <span class="text-danger">*</span></label>
                        <select class="form-select @error('asset_id') is-invalid @enderror"
                                id="asset_id"
                                name="asset_id"
                                required>
                            <option value="">Pilih Aset</option>
                            @foreach($assets as $asset)
                            <option value="{{ $asset->id }}" {{ old('asset_id') == $asset->id ? 'selected' : '' }}>
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
                        <label for="performed_by">Dilakukan Oleh <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('performed_by') is-invalid @enderror"
                               id="performed_by"
                               name="performed_by"
                               value="{{ old('performed_by', auth()->user()->name) }}"
                               placeholder="Nama teknisi/tim"
                               maxlength="100"
                               required>
                        @error('performed_by')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_performed">Tanggal Pelaksanaan <span class="text-danger">*</span></label>
                        <input type="datetime-local"
                               class="form-control @error('date_performed') is-invalid @enderror"
                               id="date_performed"
                               name="date_performed"
                               value="{{ old('date_performed', now()->format('Y-m-d\TH:i')) }}"
                               max="{{ now()->format('Y-m-d\TH:i') }}"
                               required>
                        @error('date_performed')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="result">Hasil Pemeliharaan</label>
                        <textarea class="form-control @error('result') is-invalid @enderror"
                                  id="result"
                                  name="result"
                                  rows="4"
                                  placeholder="Jelaskan hasil pemeliharaan, kondisi aset, dan tindakan yang dilakukan...">{{ old('result') }}</textarea>
                        @error('result')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="next_recommendation_date">Rekomendasi Pemeliharaan Berikutnya</label>
                        <input type="date"
                               class="form-control @error('next_recommendation_date') is-invalid @enderror"
                               id="next_recommendation_date"
                               name="next_recommendation_date"
                               value="{{ old('next_recommendation_date') }}">
                        @error('next_recommendation_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Simpan
                        </button>
                        <a href="{{ route('maintenance-logs.index') }}" class="btn btn-light">
                            <i class="mdi mdi-cancel"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
