@extends('layouts.app')

@section('title', 'Manajemen Permission')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Permission</h4>
                </div>

                <p class="card-description">
                    Berikut adalah daftar semua permission yang tersedia dalam sistem.
                </p>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Permission</th>
                                <th>Deskripsi</th>
                                <th>Digunakan oleh Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $index => $permission)
                            <tr>
                                <td>{{ $permissions->firstItem() + $index }}</td>
                                <td>
                                    <code class="text-primary">{{ $permission->name }}</code>
                                </td>
                                <td>{{ $permission->description ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $permission->roles_count }} Role</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data permission.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $permissions->firstItem() ?? 0 }} sampai {{ $permissions->lastItem() ?? 0 }} dari {{ $permissions->total() }} data
                    </div>
                    <div>
                        {{ $permissions->links('vendor.pagination.custom') }}
                    </div>
                </div>

                <div class="mt-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-light">
                        <i class="mdi mdi-arrow-left"></i> Kembali ke Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
