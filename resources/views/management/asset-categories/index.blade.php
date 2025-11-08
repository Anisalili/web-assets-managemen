@extends('layouts.app')

@section('title', 'Kategori Aset')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Kategori Aset</h4>
                    @if(auth()->user()->hasPermission('create-asset-categories'))
                    <a href="{{ route('asset-categories.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Kategori
                    </a>
                    @endif
                </div>

                <!-- Search Form -->
                <form method="GET" action="{{ route('asset-categories.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama kategori..."
                                   value="{{ $search ?? '' }}">
                        </div>
                        <div class="col-md-8">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                            @if(!empty($search))
                            <a href="{{ route('asset-categories.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                <th width="30%">Nama Kategori</th>
                                <th width="45%">Deskripsi</th>
                                <th width="10%" class="text-center">Jumlah Aset</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td>{{ $categories->firstItem() + $loop->index }}</td>
                                <td><strong class="text-primary">{{ $category->name }}</strong></td>
                                <td>
                                    <small class="text-muted">
                                        {{ $category->description ? Str::limit($category->description, 80) : '-' }}
                                    </small>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-info">{{ $category->assets_count }} aset</span>
                                </td>
                                <td>
                                    @if(auth()->user()->hasPermission('update-asset-categories'))
                                    <a href="{{ route('asset-categories.edit', $category) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-asset-categories'))
                                    <form action="{{ route('asset-categories.destroy', $category) }}"
                                          method="POST"
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus"
                                                onclick="confirmDelete(this, 'Yakin ingin menghapus kategori ini?')">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">
                                    <div class="py-4">
                                        <i class="mdi mdi-tag-outline" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mb-0 mt-2">Tidak ada data kategori.</p>
                                        @if(auth()->user()->hasPermission('create-asset-categories'))
                                        <a href="{{ route('asset-categories.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="mdi mdi-plus"></i> Tambah Kategori
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
                @if($categories->hasPages())
                <div class="mt-3">
                    {{ $categories->links('vendor.pagination.custom') }}
                </div>
                @endif

                <!-- Info -->
                <div class="mt-2">
                    <small class="text-muted">
                        Menampilkan {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }}
                        dari {{ $categories->total() }} kategori
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Confirm delete function using toast
    function confirmDelete(button, message) {
        const form = button.closest('form');
        showConfirmToast(
            message,
            function() {
                form.submit();
            },
            'Konfirmasi Hapus',
            'Ya, Hapus'
        );
    }
</script>
@endpush
