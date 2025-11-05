@extends('layouts.app')

@section('title', 'Manajemen Ruangan')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Ruangan</h4>
                    @if(auth()->user()->hasPermission('create-rooms'))
                    <a href="{{ route('rooms.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Ruangan
                    </a>
                    @endif
                </div>

                <!-- Search & Filter Form -->
                <form method="GET" action="{{ route('rooms.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari kode, nama ruangan, atau gedung..."
                                   value="{{ $search ?? '' }}">
                        </div>
                        <div class="col-md-3">
                            <select name="building_id" class="form-select form-select-sm">
                                <option value="">Semua Gedung</option>
                                @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ $buildingId == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-5">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                            @if(!empty($search) || !empty($buildingId))
                            <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                            <div class="d-inline-block ms-2">
                                @if(!empty($search))
                                <small class="text-muted">Pencarian:</small>
                                <span class="badge bg-info">"{{ $search }}"</span>
                                @endif
                                @if(!empty($buildingId))
                                <small class="text-muted">Gedung:</small>
                                <span class="badge bg-success">{{ $buildings->find($buildingId)->name }}</span>
                                @endif
                            </div>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Kode Ruangan</th>
                                <th width="20%">Nama Ruangan</th>
                                <th width="20%">Gedung</th>
                                <th width="25%">Deskripsi</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rooms as $room)
                            <tr>
                                <td>{{ $rooms->firstItem() + $loop->index }}</td>
                                <td><strong class="text-primary">{{ $room->room_code }}</strong></td>
                                <td>{{ $room->name }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $room->building->name }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $room->description ? Str::limit($room->description, 50) : '-' }}
                                    </small>
                                </td>
                                <td>
                                    @if(auth()->user()->hasPermission('view-rooms'))
                                    <a href="{{ route('rooms.show', $room) }}"
                                       class="btn btn-sm btn-info me-1"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('update-rooms'))
                                    <a href="{{ route('rooms.edit', $room) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-rooms'))
                                    <form action="{{ route('rooms.destroy', $room) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="py-4">
                                        <i class="mdi mdi-door-closed" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mb-0 mt-2">Tidak ada data ruangan.</p>
                                        @if(auth()->user()->hasPermission('create-rooms'))
                                        <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="mdi mdi-plus"></i> Tambah Ruangan
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($rooms->hasPages())
                <div class="mt-3">
                    {{ $rooms->links('vendor.pagination.custom') }}
                </div>
                @endif

                <!-- Info -->
                <div class="mt-2">
                    <small class="text-muted">
                        Menampilkan {{ $rooms->firstItem() ?? 0 }} - {{ $rooms->lastItem() ?? 0 }}
                        dari {{ $rooms->total() }} ruangan
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
