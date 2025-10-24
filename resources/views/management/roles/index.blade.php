@extends('layouts.app')

@section('title', 'Manajemen Role')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Role</h4>
                    @if(auth()->user()->hasRole('Super Admin'))
                    <a href="{{ route('roles.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Role
                    </a>
                    @endif
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Role</th>
                                <th>Deskripsi</th>
                                <th>Jumlah User</th>
                                <th>Jumlah Permission</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($roles as $index => $role)
                            <tr>
                                <td>{{ $roles->firstItem() + $index }}</td>
                                <td>
                                    <span class="badge badge-info">{{ $role->name }}</span>
                                </td>
                                <td>{{ $role->description ?? '-' }}</td>
                                <td>
                                    <span class="badge badge-primary">{{ $role->users_count }}</span>
                                </td>
                                <td>
                                    <span class="badge badge-success">{{ $role->permissions_count }}</span>
                                </td>
                                <td>
                                    @if(auth()->user()->hasRole('Super Admin'))
                                    <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    <form action="{{ route('roles.destroy', $role) }}" method="POST" class="d-inline delete-form" data-role-name="{{ $role->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete" title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @else
                                    <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada data role.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $roles->firstItem() ?? 0 }} sampai {{ $roles->lastItem() ?? 0 }} dari {{ $roles->total() }} data
                    </div>
                    <div>
                        {{ $roles->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle delete confirmation with toast
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                const roleName = form.dataset.roleName;

                showConfirmToast(
                    `Apakah Anda yakin ingin menghapus role <strong>${roleName}</strong>?`,
                    function() {
                        form.submit();
                    }
                );
            });
        });
    });
</script>
@endpush
