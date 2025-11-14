@extends('layouts.app')

@section('title', 'Jadwal Pemeliharaan')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Jadwal Pemeliharaan</h4>
                    @if(auth()->user()->hasPermission('create-maintenance-schedules'))
                    <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-primary btn-sm">
                        <i class="mdi mdi-plus"></i> Tambah Jadwal
                    </a>
                    @endif
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('maintenance-schedules.index') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-3">
                            <input type="text"
                                   name="search"
                                   class="form-control form-control-sm"
                                   placeholder="Cari aset, teknisi..."
                                   value="{{ $search ?? '' }}">
                        </div>

                        <div class="col-md-2">
                            <select name="asset_id" class="form-select form-select-sm">
                                <option value="">Semua Aset</option>
                                @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ ($assetId ?? '') == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Status -->
                        <div class="col-md-2">
                            <div class="dropdown" id="statusFilterDropdown">
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
                                    @foreach($statuses as $s)
                                    <div class="dropdown-item status-dropdown-item {{ in_array($s, $status ?? []) ? 'checked' : '' }}"
                                         style="padding: 0.5rem 1rem; cursor: pointer; transition: all 0.2s ease;">
                                        <div class="form-check" style="margin: 0; padding: 0;">
                                            <label class="form-check-label d-flex align-items-center" for="status{{ $loop->index }}" style="cursor: pointer; width: 100%; margin: 0;">
                                                <input class="form-check-input status-checkbox"
                                                       type="checkbox"
                                                       name="status[]"
                                                       value="{{ $s }}"
                                                       id="status{{ $loop->index }}"
                                                       {{ in_array($s, $status ?? []) ? 'checked' : '' }}
                                                       style="margin: 0 0.5rem 0 0; cursor: pointer;">
                                                <span>{{ ucfirst($s) }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Filter Frequency -->
                        <div class="col-md-2">
                            <div class="dropdown" id="frequencyFilterDropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle w-100 text-start d-flex justify-content-between align-items-center"
                                        type="button"
                                        data-bs-toggle="dropdown"
                                        aria-expanded="false"
                                        style="height: 31px; padding: 0.375rem 0.75rem; color: #000;">
                                    <span id="frequencyFilterLabel" class="text-truncate" style="color: #000;">
                                        @if(!empty($frequency))
                                            {{ count($frequency) }} Frekuensi
                                        @else
                                            Frekuensi
                                        @endif
                                    </span>
                                </button>
                                <div class="dropdown-menu" style="min-width: 100%; max-height: 300px; overflow-y: auto; padding: 0.5rem 0;">
                                    @foreach($frequencies as $freq)
                                    <div class="dropdown-item frequency-dropdown-item {{ in_array($freq, $frequency ?? []) ? 'checked' : '' }}"
                                         style="padding: 0.5rem 1rem; cursor: pointer; transition: all 0.2s ease;">
                                        <div class="form-check" style="margin: 0; padding: 0;">
                                            <label class="form-check-label d-flex align-items-center" for="frequency{{ $loop->index }}" style="cursor: pointer; width: 100%; margin: 0;">
                                                <input class="form-check-input frequency-checkbox"
                                                       type="checkbox"
                                                       name="frequency[]"
                                                       value="{{ $freq }}"
                                                       id="frequency{{ $loop->index }}"
                                                       {{ in_array($freq, $frequency ?? []) ? 'checked' : '' }}
                                                       style="margin: 0 0.5rem 0 0; cursor: pointer;">
                                                <span>{{ ucfirst($freq) }}</span>
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-md-1">
                            <input type="date"
                                   name="date_from"
                                   class="form-control form-control-sm"
                                   placeholder="Dari"
                                   value="{{ $dateFrom ?? '' }}">
                        </div>

                        <div class="col-md-1">
                            <input type="date"
                                   name="date_to"
                                   class="form-control form-control-sm"
                                   placeholder="Sampai"
                                   value="{{ $dateTo ?? '' }}">
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-primary btn-sm w-100" type="submit">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Aset</th>
                                <th width="12%">Tanggal</th>
                                <th width="10%">Frekuensi</th>
                                <th width="15%">Ditugaskan</th>
                                <th width="10%">Status</th>
                                <th width="15%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($schedules as $schedule)
                            <tr>
                                <td>{{ $schedules->firstItem() + $loop->index }}</td>
                                <td>
                                    <strong>{{ $schedule->asset->name }}</strong><br>
                                    <small class="text-muted">{{ $schedule->asset->asset_code }}</small>
                                </td>
                                <td>{{ $schedule->scheduled_date->format('d/m/Y') }}</td>
                                <td><span class="badge bg-primary text-white">{{ $schedule->frequency }}</span></td>
                                <td>{{ $schedule->assignedUser->name ?? '-' }}</td>
                                <td>
                                    @if($schedule->status === 'terjadwal')
                                        <span class="badge bg-info">Terjadwal</span>
                                    @elseif($schedule->status === 'dalam_perbaikan')
                                        <span class="badge bg-warning">Dalam Perbaikan</span>
                                    @elseif($schedule->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @endif
                                </td>
                                <td>
                                    @if(auth()->user()->hasPermission('view-maintenance-schedules'))
                                    <a href="{{ route('maintenance-schedules.show', $schedule) }}"
                                       class="btn btn-sm btn-info me-1"
                                       title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    @endif

                                    @if(auth()->user()->hasPermission('update-maintenance-schedules'))
                                    <a href="{{ route('maintenance-schedules.edit', $schedule) }}"
                                       class="btn btn-sm btn-warning me-1"
                                       title="Edit">
                                        <i class="mdi mdi-pencil"></i>
                                    </a>

                                    <!-- Tombol Assign Teknisi -->
                                    @if(!$schedule->assigned_to)
                                    <button type="button"
                                            class="btn btn-sm btn-success me-1"
                                            title="Assign Teknisi"
                                            onclick="showAssignModal({{ $schedule->id }}, '{{ addslashes($schedule->asset->name ?? '') }}')">
                                        <i class="mdi mdi-account-plus"></i>
                                    </button>
                                    @endif
                                    @endif

                                    @if(auth()->user()->hasPermission('delete-maintenance-schedules'))
                                    <form action="{{ route('maintenance-schedules.destroy', $schedule) }}"
                                          method="POST"
                                          class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus"
                                                onclick="confirmDelete(this, 'Yakin ingin menghapus jadwal ini?')">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <div class="py-4">
                                        <i class="mdi mdi-calendar-clock" style="font-size: 48px; color: #ccc;"></i>
                                        <p class="text-muted mb-0 mt-2">Tidak ada jadwal pemeliharaan.</p>
                                        @if(auth()->user()->hasPermission('create-maintenance-schedules'))
                                        <a href="{{ route('maintenance-schedules.create') }}" class="btn btn-sm btn-primary mt-2">
                                            <i class="mdi mdi-plus"></i> Tambah Jadwal
                                        </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($schedules->hasPages())
                <div class="mt-3">
                    {{ $schedules->links('vendor.pagination.custom') }}
                </div>
                @endif

                <div class="mt-2">
                    <small class="text-muted">
                        Menampilkan {{ $schedules->firstItem() ?? 0 }} - {{ $schedules->lastItem() ?? 0 }}
                        dari {{ $schedules->total() }} jadwal
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Assign Teknisi -->
<div class="modal fade" id="assignTeknisiModal" tabindex="-1" aria-labelledby="assignTeknisiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignTeknisiModalLabel">
                    <i class="mdi mdi-account-plus"></i> Assign Teknisi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="scheduleIdForAssign">
                <p class="mb-3">Pilih teknisi untuk jadwal maintenance: <strong id="assetNameForAssign"></strong></p>

                <div id="teknisiLoadingSpinner" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data teknisi...</p>
                </div>

                <div id="teknisiSelectContainer" style="display: none;">
                    <div class="mb-3">
                        <label for="teknisiSelect" class="form-label">Pilih Teknisi</label>
                        <select class="form-select" id="teknisiSelect">
                            <option value="">-- Pilih Teknisi --</option>
                        </select>
                    </div>
                </div>

                <div id="noTeknisiMessage" style="display: none;" class="text-center py-4">
                    <i class="mdi mdi-alert-circle-outline" style="font-size: 48px; color: #999;"></i>
                    <p class="text-muted mt-2">Tidak ada teknisi tersedia</p>
                </div>
            </div>
            <div class="modal-footer" id="modalFooter" style="display: none;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnAssignTeknisi">Assign Teknisi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Style for checked items */
    .status-dropdown-item.checked,
    .frequency-dropdown-item.checked {
        background-color: #e8f0fe;
        border-left: 3px solid #2196F3;
    }

    .status-dropdown-item:hover,
    .frequency-dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .status-dropdown-item.checked:hover,
    .frequency-dropdown-item.checked:hover {
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
        // Status Filter
        const statusCheckboxes = document.querySelectorAll('.status-checkbox');
        const statusFilterLabel = document.getElementById('statusFilterLabel');

        function updateStatusFilterLabel() {
            const checkedCount = document.querySelectorAll('.status-checkbox:checked').length;
            statusFilterLabel.textContent = checkedCount > 0 ? checkedCount + ' Status' : 'Status';
        }

        function updateDropdownItemState(checkbox, itemClass) {
            const dropdownItem = checkbox.closest(`.${itemClass}`);
            if (checkbox.checked) {
                dropdownItem.classList.add('checked');
            } else {
                dropdownItem.classList.remove('checked');
            }
        }

        statusCheckboxes.forEach(checkbox => {
            updateDropdownItemState(checkbox, 'status-dropdown-item');

            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                updateStatusFilterLabel();
                updateDropdownItemState(this, 'status-dropdown-item');
            });
        });

        document.querySelectorAll('.status-dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const checkbox = this.querySelector('.status-checkbox');
                if (checkbox && e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });

        // Frequency Filter
        const frequencyCheckboxes = document.querySelectorAll('.frequency-checkbox');
        const frequencyFilterLabel = document.getElementById('frequencyFilterLabel');

        function updateFrequencyFilterLabel() {
            const checkedCount = document.querySelectorAll('.frequency-checkbox:checked').length;
            frequencyFilterLabel.textContent = checkedCount > 0 ? checkedCount + ' Frekuensi' : 'Frekuensi';
        }

        frequencyCheckboxes.forEach(checkbox => {
            updateDropdownItemState(checkbox, 'frequency-dropdown-item');

            checkbox.addEventListener('change', function(e) {
                e.stopPropagation();
                updateFrequencyFilterLabel();
                updateDropdownItemState(this, 'frequency-dropdown-item');
            });
        });

        document.querySelectorAll('.frequency-dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const checkbox = this.querySelector('.frequency-checkbox');
                if (checkbox && e.target !== checkbox) {
                    checkbox.checked = !checkbox.checked;
                    checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });
        });

        // Prevent dropdown from closing when clicking inside
        const statusDropdownMenu = document.querySelector('#statusFilterDropdown .dropdown-menu');
        const frequencyDropdownMenu = document.querySelector('#frequencyFilterDropdown .dropdown-menu');

        if (statusDropdownMenu) {
            statusDropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }

        if (frequencyDropdownMenu) {
            frequencyDropdownMenu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });

    // Function to show assign modal
    function showAssignModal(scheduleId, assetName) {
        // Set schedule ID and asset name
        document.getElementById('scheduleIdForAssign').value = scheduleId;
        document.getElementById('assetNameForAssign').textContent = assetName;

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('assignTeknisiModal'));
        modal.show();

        // Show loading spinner and hide others
        document.getElementById('teknisiLoadingSpinner').style.display = 'block';
        document.getElementById('teknisiSelectContainer').style.display = 'none';
        document.getElementById('noTeknisiMessage').style.display = 'none';
        document.getElementById('modalFooter').style.display = 'none';

        // Fetch teknisi list
        fetch('/api/teknisi')
            .then(response => response.json())
            .then(data => {
                document.getElementById('teknisiLoadingSpinner').style.display = 'none';

                if (data.teknisi && data.teknisi.length > 0) {
                    document.getElementById('teknisiSelectContainer').style.display = 'block';
                    document.getElementById('modalFooter').style.display = 'flex';

                    const teknisiSelect = document.getElementById('teknisiSelect');
                    teknisiSelect.innerHTML = '<option value="">-- Pilih Teknisi --</option>';

                    data.teknisi.forEach(tek => {
                        const option = document.createElement('option');
                        option.value = tek.id;
                        option.textContent = `${tek.name} (${tek.email})`;
                        option.dataset.name = tek.name;
                        teknisiSelect.appendChild(option);
                    });
                } else {
                    document.getElementById('noTeknisiMessage').style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Error fetching teknisi:', error);
                document.getElementById('teknisiLoadingSpinner').style.display = 'none';
                document.getElementById('noTeknisiMessage').style.display = 'block';
            });
    }

    // Handle assign button click
    document.addEventListener('DOMContentLoaded', function() {
        const btnAssignTeknisi = document.getElementById('btnAssignTeknisi');
        if (btnAssignTeknisi) {
            btnAssignTeknisi.addEventListener('click', function() {
                const scheduleId = document.getElementById('scheduleIdForAssign').value;
                const teknisiSelect = document.getElementById('teknisiSelect');
                const teknisiId = teknisiSelect.value;
                const teknisiName = teknisiSelect.options[teknisiSelect.selectedIndex]?.dataset.name || '';

                if (!teknisiId) {
                    showToast('warning', 'Silakan pilih teknisi terlebih dahulu');
                    return;
                }

                // Show confirmation toast
                showConfirmToast(
                    `Assign ${teknisiName} ke jadwal maintenance ini?`,
                    function() {
                        // Perform assign
                        fetch(`/maintenance-schedules/${scheduleId}/assign`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                teknisi_id: teknisiId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Close modal
                                bootstrap.Modal.getInstance(document.getElementById('assignTeknisiModal')).hide();

                                // Show success message
                                showToast('success', data.message);

                                // Reload page after 1 second
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                showToast('error', 'Gagal assign teknisi: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error assigning teknisi:', error);
                            showToast('error', 'Terjadi kesalahan saat assign teknisi');
                        });
                    },
                    'Konfirmasi Assign',
                    'Ya, Assign'
                );
            });
        }
    });
</script>
@endpush
