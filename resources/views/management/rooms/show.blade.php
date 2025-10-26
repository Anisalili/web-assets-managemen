@extends('layouts.app')

@section('title', 'Detail Ruangan')

@section('content')
<div class="row">
    <div class="col-md-8 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Detail Ruangan</h4>
                    <div>
                        @if(auth()->user()->hasPermission('edit-rooms'))
                        <a href="{{ route('rooms.edit', $room) }}" class="btn btn-warning btn-sm">
                            <i class="mdi mdi-pencil"></i> Edit
                        </a>
                        @endif
                        <a href="{{ route('rooms.index') }}" class="btn btn-light btn-sm">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <table class="table table-borderless">
                    <tr>
                        <th width="30%">Kode Ruangan</th>
                        <td><strong class="text-primary">{{ $room->room_code }}</strong></td>
                    </tr>
                    <tr>
                        <th>Nama Ruangan</th>
                        <td><strong>{{ $room->name }}</strong></td>
                    </tr>
                    <tr>
                        <th>Gedung</th>
                        <td>
                            <a href="{{ route('buildings.show', $room->building) }}" class="text-decoration-none">
                                <span class="badge bg-info">{{ $room->building->name }}</span>
                            </a>
                            <br>
                            <small class="text-muted">Kode: {{ $room->building->building_code }}</small>
                        </td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $room->description ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Dibuat Pada</th>
                        <td>{{ $room->created_at->format('d M Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Terakhir Diupdate</th>
                        <td>{{ $room->updated_at->format('d M Y H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
