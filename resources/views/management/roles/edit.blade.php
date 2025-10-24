@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Edit Role</h4>
                <p class="card-description">Ubah informasi role</p>

                <form action="{{ route('roles.update', $role) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nama Role <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name"
                               name="name"
                               value="{{ old('name', $role->name) }}"
                               placeholder="Masukkan nama role"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description"
                                  name="description"
                                  rows="3"
                                  placeholder="Masukkan deskripsi role">{{ old('description', $role->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Permission</label>
                        <div class="border rounded" style="max-height: 450px; overflow-y: auto; padding: 0.5rem 0;">
                            @forelse($permissions as $category => $categoryPermissions)
                            <!-- Category Header -->
                            <div class="permission-category-header" style="padding: 0.5rem 1rem; background-color: #f8f9fa; border-bottom: 2px solid #dee2e6; position: sticky; top: 0; z-index: 1;">
                                <strong class="text-uppercase" style="font-size: 0.75rem; color: #6c757d; letter-spacing: 0.5px;">
                                    {{ ucfirst($category) }}
                                </strong>
                            </div>

                            <!-- Permissions in Category -->
                            @foreach($categoryPermissions as $permission)
                            <div class="permission-item {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}" data-permission-id="{{ $permission->id }}"
                                 style="cursor: pointer; transition: all 0.2s ease; border-bottom: 1px solid #f0f0f0;">
                                <label class="d-flex align-items-start w-100" for="permission-{{ $permission->id }}" style="cursor: pointer; margin: 0; padding: 0.75rem 1rem;">
                                    <input class="form-check-input permission-checkbox"
                                           type="checkbox"
                                           name="permissions[]"
                                           value="{{ $permission->id }}"
                                           id="permission-{{ $permission->id }}"
                                           {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}
                                           style="margin: 0.25rem 0.75rem 0 0; cursor: pointer; flex-shrink: 0;">
                                    <div style="flex: 1;">
                                        <strong>{{ $permission->name }}</strong>
                                        @if($permission->description)
                                        <br><small class="text-muted">{{ $permission->description }}</small>
                                        @endif
                                    </div>
                                </label>
                            </div>
                            @endforeach
                            @empty
                            <div style="padding: 1rem;">
                                <p class="text-muted mb-0">Tidak ada permission tersedia.</p>
                            </div>
                            @endforelse
                        </div>
                        @error('permissions')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            <span id="selectedPermissionsCount">{{ count(old('permissions', $role->permissions->pluck('id')->toArray())) }}</span> permission dipilih
                        </small>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save"></i> Update
                        </button>
                        <a href="{{ route('roles.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style for permission items */
    .permission-item {
        position: relative;
    }

    .permission-item.checked {
        background-color: #e8f0fe;
        border-left: 3px solid #2196F3;
    }

    .permission-item:hover {
        background-color: #f5f5f5;
    }

    .permission-item.checked:hover {
        background-color: #d3e3fd;
    }

    .permission-item label {
        user-select: none;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const permissionCheckboxes = document.querySelectorAll('.permission-checkbox');
        const selectedCountSpan = document.getElementById('selectedPermissionsCount');

        function updateSelectedCount() {
            const checkedCount = document.querySelectorAll('.permission-checkbox:checked').length;
            selectedCountSpan.textContent = checkedCount;
        }

        function updatePermissionItemState(checkbox) {
            const permissionItem = checkbox.closest('.permission-item');
            if (checkbox.checked) {
                permissionItem.classList.add('checked');
            } else {
                permissionItem.classList.remove('checked');
            }
        }

        // Initialize state for all checkboxes
        permissionCheckboxes.forEach(checkbox => {
            updatePermissionItemState(checkbox);

            checkbox.addEventListener('change', function() {
                updatePermissionItemState(this);
                updateSelectedCount();
            });
        });
    });
</script>
@endpush
