@extends('layouts.app')

@section('title', 'Manajemen Aset')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Daftar Aset</h4>
                    @if(auth()->user()->hasPermission('create-assets'))
                    <a href="{{ route('assets.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Aset
                    </a>
                    @endif
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('assets.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari kode/nama aset..."
                                   value="{{ $search ?? '' }}">
                        </div>

                        <!-- Filter Kategori -->
                        <div class="col-md-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="height: 31px; padding: 0.375rem 0.75rem; color: #000;">
                                    <span id="categoryFilterLabel" class="text-truncate" style="color: #000;">
                                        @if(!empty($categoryId))
                                            {{ count($categoryId) }} Kategori
                                        @else
                                            Kategori
                                        @endif
                                    </span>
                                </button>
                                <div class="dropdown-menu" style="min-width: 100%; max-height: 300px; overflow-y: auto; padding: 0.5rem 0;">
                                    @foreach($categories as $cat)
                                    <div class="dropdown-item filter-dropdown-item {{ in_array($cat->id, $categoryId) ? 'checked' : '' }}"
                                         style="padding: 0.5rem 1rem; cursor: pointer;">
                                        <div class="form-check" style="margin: 0;">
                                            <label class="form-check-label d-flex align-items-center" style="cursor: pointer; width: 100%; margin: 0;">
                                                <input class="form-check-input category-checkbox"
                                                       type="checkbox"
                                                       name="category_id[]"
                                                       value="{{ $cat->id }}"
                                                       {{ in_array($cat->id, $categoryId) ? 'checked' : '' }}
                                                       style="margin: 0 0.5rem 0 0; cursor: pointer;">
                                                <span>{{ $cat->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Filter Lokasi -->
                        <div class="col-md-3">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="height: 31px; padding: 0.375rem 0.75rem;">
                                    <span id="roomFilterLabel" class="text-truncate">
                                        @if(!empty($roomId))
                                            {{ count($roomId) }} Lokasi
                                        @else
                                            Lokasi
                                        @endif
                                    </span>
                                </button>
                                <div class="dropdown-menu" style="min-width: 100%; max-height: 300px; overflow-y: auto; padding: 0.5rem 0;">
                                    @foreach($rooms as $room)
                                    <div class="dropdown-item filter-dropdown-item {{ in_array($room->id, $roomId) ? 'checked' : '' }}"
                                         style="padding: 0.5rem 1rem; cursor: pointer;">
                                        <div class="form-check" style="margin: 0;">
                                            <label class="form-check-label d-flex align-items-center" style="cursor: pointer; width: 100%; margin: 0;">
                                                <input class="form-check-input room-checkbox"
                                                       type="checkbox"
                                                       name="room_id[]"
                                                       value="{{ $room->id }}"
                                                       {{ in_array($room->id, $roomId) ? 'checked' : '' }}
                                                       style="margin: 0 0.5rem 0 0; cursor: pointer;">
                                                <span>{{ $room->building->name }} - {{ $room->name }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div class="col-md-2">
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="height: 31px; padding: 0.375rem 0.75rem;">
                                    <span id="statusFilterLabel" class="text-truncate">
                                        @if(!empty($status))
                                            {{ count($status) }} Status
                                        @else
                                            Status
                                        @endif
                                    </span>
                                </button>
                                <div class="dropdown-menu" style="min-width: 100%; max-height: 300px; overflow-y: auto; padding: 0.5rem 0;">
                                    @foreach($statuses as $stat)
                                    <div class="dropdown-item filter-dropdown-item {{ in_array($stat, $status) ? 'checked' : '' }}"
                                         style="padding: 0.5rem 1rem; cursor: pointer;">
                                        <div class="form-check" style="margin: 0;">
                                            <label class="form-check-label d-flex align-items-center" style="cursor: pointer; width: 100%; margin: 0;">
                                                <input class="form-check-input status-checkbox"
                                                       type="checkbox"
                                                       name="status[]"
                                                       value="{{ $stat }}"
                                                       {{ in_array($stat, $status) ? 'checked' : '' }}
                                                       style="margin: 0 0.5rem 0 0; cursor: pointer;">
                                                <span>{{ ucfirst(str_replace('_', ' ', $stat)) }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm" type="submit">
                                <i class="mdi mdi-magnify"></i> Filter
                            </button>
                            @if(!empty($search) || !empty($categoryId) || !empty($roomId) || !empty($status))
                            <a href="{{ route('assets.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                            @endif
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Kode Aset</th>
                                <th width="15%">Nama Aset</th>
                                <th width="12%">Kategori</th>
                                <th width="15%">Lokasi</th>
                                <th width="10%">Status</th>
                                <th width="10%">Nilai</th>
                                <th width="12%">Pemilik</th>
                                <th width="11%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assets as $asset)
                            <tr>
                                <td>{{ $assets->firstItem() + $loop->index }}</td>
                                <td><strong class="text-primary">{{ $asset->asset_code }}</strong></td>
                                <td>{{ $asset->name }}</td>
                                <td>
                                    <span class="badge bg-light text-dark">{{ $asset->category->name }}</span>
                                </td>
                                <td>
                                    @if($asset->room)
                                        <small class="text-muted">
                                            @if($asset->room->building)
                                                {{ $asset->room->building->name }}<br>
                                            @endif
                                            {{ $asset->room->name }}
                                        </small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asset->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($asset->status == 'non-aktif')
                                        <span class="badge bg-secondary">Non-aktif</span>
                                    @elseif($asset->status == 'dalam_perbaikan')
                                        <span class="badge bg-warning">Dalam Perbaikan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asset->value)
                                        <small>Rp {{ number_format($asset->value, 0, ',', '.') }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <small>{{ $asset->owner ?? '-' }}</small>
                                </td>
                                <td>
                                    @if(auth()->user()->hasPermission('view-assets'))
                                    <a href="{{ route('assets.show', $asset) }}"
                                       class="btn btn-sm btn-info me-1"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('update-assets'))
                                    <a href="{{ route('assets.edit', $asset) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-assets'))
                                    <form action="{{ route('assets.destroy', $asset) }}"
                                          method="POST"
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                title="Stock Off"
                                                onclick="confirmDelete(this, 'Yakin ingin stock off aset ini?')">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="py-4">
                                        <i class="mdi mdi-package-variant" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mb-0 mt-2">Tidak ada data aset.</p>
                                        @if(auth()->user()->hasPermission('create-assets'))
                                        <a href="{{ route('assets.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="mdi mdi-plus"></i> Tambah Aset
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
                @if($assets->hasPages())
                <div class="mt-3">
                    {{ $assets->links('vendor.pagination.custom') }}
                </div>
                @endif

                <!-- Info -->
                <div class="mt-2">
                    <small class="text-muted">
                        Menampilkan {{ $assets->firstItem() ?? 0 }} - {{ $assets->lastItem() ?? 0 }}
                        dari {{ $assets->total() }} aset
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style for checked filter items */
    .filter-dropdown-item.checked {
        background-color: #e8f0fe;
        border-left: 3px solid #2196F3;
    }

    .filter-dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .filter-dropdown-item.checked:hover {
        background-color: #d3e3fd;
    }

    /* Force black text color for dropdown buttons and labels */
    .dropdown .btn-outline-secondary,
    .dropdown .btn-outline-secondary span,
    .dropdown-item label,
    .dropdown-item span {
        color: #000 !important;
    }
</style>
@endpush

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

    document.addEventListener('DOMContentLoaded', function() {
        // Category Filter
        const categoryCheckboxes = document.querySelectorAll('.category-checkbox');
        const categoryFilterLabel = document.getElementById('categoryFilterLabel');

        function updateCategoryFilterLabel() {
            const checkedCount = document.querySelectorAll('.category-checkbox:checked').length;
            categoryFilterLabel.textContent = checkedCount > 0 ? checkedCount + ' Kategori' : 'Kategori';
        }

        function updateDropdownItemState(checkbox) {
            const dropdownItem = checkbox.closest('.filter-dropdown-item');
            if (checkbox.checked) {
                dropdownItem.classList.add('checked');
            } else {
                dropdownItem.classList.remove('checked');
            }
        }

        // Initialize category checkboxes
        categoryCheckboxes.forEach(checkbox => {
            updateDropdownItemState(checkbox);
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                updateCategoryFilterLabel();
                updateDropdownItemState(this);
            });
        });

        // Room Filter
        const roomCheckboxes = document.querySelectorAll('.room-checkbox');
        const roomFilterLabel = document.getElementById('roomFilterLabel');

        function updateRoomFilterLabel() {
            const checkedCount = document.querySelectorAll('.room-checkbox:checked').length;
            roomFilterLabel.textContent = checkedCount > 0 ? checkedCount + ' Lokasi' : 'Lokasi';
        }

        roomCheckboxes.forEach(checkbox => {
            updateDropdownItemState(checkbox);
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                updateRoomFilterLabel();
                updateDropdownItemState(this);
            });
        });

        // Status Filter
        const statusCheckboxes = document.querySelectorAll('.status-checkbox');
        const statusFilterLabel = document.getElementById('statusFilterLabel');

        function updateStatusFilterLabel() {
            const checkedCount = document.querySelectorAll('.status-checkbox:checked').length;
            statusFilterLabel.textContent = checkedCount > 0 ? checkedCount + ' Status' : 'Status';
        }

        statusCheckboxes.forEach(checkbox => {
            updateDropdownItemState(checkbox);
            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                updateStatusFilterLabel();
                updateDropdownItemState(this);
            });
        });

        // Handle click on dropdown items to toggle checkbox
        const dropdownItems = document.querySelectorAll('.filter-dropdown-item');
        dropdownItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const checkbox = this.querySelector('input[type="checkbox"]');
                if (checkbox && e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;

                    const event = new Event('change', { bubbles: true });
                    checkbox.dispatchEvent(event);
                }
            });
        });

        // Prevent dropdown from closing when clicking inside
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        dropdownMenus.forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    });
</script>
@endpush
