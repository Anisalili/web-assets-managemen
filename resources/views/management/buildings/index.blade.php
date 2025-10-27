@extends('layouts.app')

@section('title', 'Manajemen Gedung')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Gedung</h4>
                    @if(auth()->user()->hasPermission('create-buildings'))
                    <a href="{{ route('buildings.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Gedung
                    </a>
                    @endif
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('buildings.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari kode atau nama gedung..."
                                   value="{{ $search ?? '' }}">
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                            @if(!empty($search))
                            <a href="{{ route('buildings.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                            <div class="d-inline-block ms-2">
                                <small class="text-muted">Pencarian:</small>
                                <span class="badge bg-info">"{{ $search }}"</span>
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
                                <th width="15%">Kode Gedung</th>
                                <th width="25%">Nama Gedung</th>
                                <th width="30%">Deskripsi</th>
                                <th width="10%" class="text-center">Jumlah Ruangan</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($buildings as $building)
                            <tr>
                                <td>{{ $buildings->firstItem() + $loop->index }}</td>
                                <td><strong class="text-primary">{{ $building->building_code }}</strong></td>
                                <td>{{ $building->name }}</td>
                                <td>
                                    <small class="text-muted">
                                        {{ $building->description ? Str::limit($building->description, 50) : '-' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $building->rooms_count }} ruangan</span>
                                </td>
                                <td>
                                    @if(auth()->user()->hasPermission('view-buildings'))
                                    <a href="{{ route('buildings.show', $building) }}"
                                       class="btn btn-sm btn-info me-1"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('edit-buildings'))
                                    <a href="{{ route('buildings.edit', $building) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-buildings'))
                                    <form action="{{ route('buildings.destroy', $building) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus gedung ini?')">
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
                                        <i class="mdi mdi-office-building-outline" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mb-0 mt-2">Tidak ada data gedung.</p>
                                        @if(auth()->user()->hasPermission('create-buildings'))
                                        <a href="{{ route('buildings.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="mdi mdi-plus"></i> Tambah Gedung
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
                @if($buildings->hasPages())
                <div class="mt-3">
                    {{ $buildings->links('vendor.pagination.custom') }}
                </div>
                @endif

                <!-- Info -->
                <div class="mt-2">
                    <small class="text-muted">
                        Menampilkan {{ $buildings->firstItem() ?? 0 }} - {{ $buildings->lastItem() ?? 0 }}
                        dari {{ $buildings->total() }} gedung
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
