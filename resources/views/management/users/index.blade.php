@extends('layouts.app')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Pengguna</h4>
                    @if(auth()->user()->hasPermission('create-users'))
                    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah User
                    </a>
                    @endif
                </div>

                <!-- Advanced Search Form -->
                <form method="GET" action="{{ route('users.index') }}" class="mb-3">
                    <div class="row g-2">
                        <!-- Search by Name/Email -->
                        <div class="col-md-4">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari nama atau email..."
                                   value="{{ $filters['search'] ?? '' }}">
                        </div>

                        <!-- Filter by Roles -->
                        <div class="col-md-3">
                            <div class="dropdown" id="roleFilterDropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="height: 31px; padding: 0.375rem 0.75rem;">
                                    <span id="roleFilterLabel" class="text-truncate">
                                        @if(!empty($filters['roles']))
                                            {{ count($filters['roles']) }} Role dipilih
                                        @else
                                            Filter Role
                                        @endif
                                    </span>
                                </button>
                                <div class="dropdown-menu" style="min-width: 100%; max-height: 300px; overflow-y: auto; padding: 0.5rem 0;">
                                    @foreach($roles as $role)
                                    <div class="dropdown-item role-dropdown-item {{ in_array($role->id, $filters['roles'] ?? []) ? 'checked' : '' }}"
                                         style="padding: 0.5rem 1rem; cursor: pointer; transition: all 0.2s ease;">
                                        <div class="form-check" style="margin: 0; padding: 0;">
                                            <label class="form-check-label d-flex align-items-center" for="role{{ $role->id }}" style="cursor: pointer; width: 100%; margin: 0;">
                                                <input class="form-check-input role-checkbox"
                                                       type="checkbox"
                                                       name="roles[]"
                                                       value="{{ $role->id }}"
                                                       id="role{{ $role->id }}"
                                                       {{ in_array($role->id, $filters['roles'] ?? []) ? 'checked' : '' }}
                                                       style="margin: 0 0.5rem 0 0; cursor: pointer;">
                                                <span>{{ $role->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-md-5">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-magnify"></i> Cari
                            </button>
                            @if(!empty($filters['search']) || !empty($filters['roles']))
                            <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="mdi mdi-refresh"></i> Reset Filter
                            </a>
                            @endif

                            <!-- Active Filters Display -->
                            @if(!empty($filters['search']))
                            <div class="d-inline-block ms-2">
                                <small class="text-muted">Pencarian:</small>
                                <span class="badge bg-info">"{{ $filters['search'] }}"</span>
                            </div>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $users->firstItem() + $loop->index }}</td>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    @if($user->id === auth()->id())
                                        <span class="badge bg-info">You</span>
                                    @endif
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @forelse($user->roles as $role)
                                        <span class="badge bg-primary">{{ $role->name }}</span>
                                    @empty
                                        <span class="text-muted">-</span>
                                    @endforelse
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('users.show', $user) }}"
                                       class="btn btn-sm btn-info me-1"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>

                                    @if(auth()->user()->hasPermission('edit-users'))
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-users') && $user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user) }}"
                                          method="POST"
                                          class="d-inline delete-form"
                                          data-user-name="{{ $user->name }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger btn-delete"
                                                title="Hapus">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">
                                    @if(!empty($filters['search']) || !empty($filters['roles']))
                                        Tidak ada data yang ditemukan dengan filter yang dipilih
                                    @else
                                        Belum ada data pengguna
                                    @endif
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="text-muted small">
                        Menampilkan {{ $users->firstItem() ?? 0 }} sampai {{ $users->lastItem() ?? 0 }} dari {{ $users->total() }} data
                    </div>
                    <div>
                        {{ $users->appends($filters)->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style for checked role items */
    .role-dropdown-item.checked {
        background-color: #e8f0fe;
        border-left: 3px solid #2196F3;
    }

    .role-dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .role-dropdown-item.checked:hover {
        background-color: #d3e3fd;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update role filter label when checkboxes change
        const roleCheckboxes = document.querySelectorAll('.role-checkbox');
        const roleFilterLabel = document.getElementById('roleFilterLabel');

        function updateRoleFilterLabel() {
            const checkedCount = document.querySelectorAll('.role-checkbox:checked').length;
            if (checkedCount > 0) {
                roleFilterLabel.textContent = checkedCount + ' Role dipilih';
            } else {
                roleFilterLabel.textContent = 'Filter Role';
            }
        }

        // Update visual state of dropdown items
        function updateDropdownItemState(checkbox) {
            const dropdownItem = checkbox.closest('.role-dropdown-item');
            if (checkbox.checked) {
                dropdownItem.classList.add('checked');
            } else {
                dropdownItem.classList.remove('checked');
            }
        }

        // Initialize state for all checkboxes
        roleCheckboxes.forEach(checkbox => {
            updateDropdownItemState(checkbox);

            checkbox.addEventListener('change', function(e) {
                // Stop immediate propagation to prevent conflicts
                e.stopPropagation();

                updateRoleFilterLabel();
                updateDropdownItemState(this);
            });
        });

        // Handle click on dropdown items to toggle checkbox
        const dropdownItems = document.querySelectorAll('.role-dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const checkbox = this.querySelector('.role-checkbox');
                if (checkbox && e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;

                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    checkbox.dispatchEvent(event);

                    updateRoleFilterLabel();
                    updateDropdownItemState(checkbox);
                }
            });
        });

        // Prevent dropdown from closing when clicking inside
        const dropdownMenu = document.querySelector('#roleFilterDropdown .dropdown-menu');
        if (dropdownMenu) {
            dropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        // Handle delete confirmation with toast
        const deleteButtons = document.querySelectorAll('.btn-delete');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const form = this.closest('.delete-form');
                const userName = form.dataset.userName;

                showConfirmToast(
                    `Apakah Anda yakin ingin menghapus user <strong>${userName}</strong>?`,
                    function() {
                        form.submit();
                    }
                );
            });
        });
    });
</script>
@endpush

