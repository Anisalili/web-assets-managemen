@extends('layouts.app')

@section('title', 'Detail Gedung')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Detail Gedung</h4>
                    <div>
                        @if(auth()->user()->hasPermission('update-buildings'))
                        <a href="{{ route('buildings.edit', $building) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('buildings.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Kode Gedung</th>
                        <td><strong class="text-primary">{{ $building->building_code }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nama Gedung</th>
                        <td><strong>{{ $building->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $building->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Jumlah Ruangan</th>
                        <td>
                            <span class="badge bg-info">{{ $building->rooms_count }} ruangan</span>
                        </td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $building->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $building->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

@if($building->rooms_count > 0)
<div class="row mt-3">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Ruangan ({{ $building->rooms_count }} ruangan)</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Kode Ruangan</th>
                                <th width="35%">Nama Ruangan</th>
                                <th width="40%">Deskripsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($building->rooms as $index => $room)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td><strong class="text-primary">{{ $room->room_code }}</strong></td>
                                <td>{{ $room->name }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ $room->description ? Str::limit($room->description, 50) : '-' }}
                                    </small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada ruangan</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($building->rooms_count > 10)
                <div class="mt-2">
                    <small class="text-muted">Menampilkan 10 ruangan pertama dari {{ $building->rooms_count }} ruangan</small>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
@endsection
