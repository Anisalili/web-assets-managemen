@extends('layouts.app')

@section('title', 'Laporan Kerusakan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Laporan Kerusakan Asset</h3>
                    <h6 class="font-weight-normal mb-0">Kelola laporan kerusakan asset perusahaan</h6>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Daftar Laporan Kerusakan</h4>
                        @if(auth()->user()->hasPermission('create-damage-reports'))
                        <a href="{{ route('damage-reports.create') }}" class="btn btn-primary btn-sm">
                            <i class="mdi mdi-plus"></i> Tambah Laporan
                        </a>
                        @endif
                    </div>

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asset</th>
                                    <th>Tanggal Laporan</th>
                                    <th>Dilaporkan Oleh</th>
                                    <th>Ditugaskan</th>
                                    <th>Tingkat Kerusakan</th>
                                    <th>Prioritas</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($damageReports as $index => $report)
                                <tr>
                                    <td>{{ $damageReports->firstItem() + $index }}</td>
                                    <td>{{ $report->asset->name }}</td>
                                    <td>{{ $report->report_date->format('d M Y H:i') }}</td>
                                    <td>{{ $report->reported_by ?? '-' }}</td>
                                    <td>{{ $report->assignedUser->name ?? '-' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $report->severity == 'berat' ? 'danger' : ($report->severity == 'sedang' ? 'warning' : 'info') }}">
                                            {{ ucfirst($report->severity) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $report->priority == 'critical' ? 'danger' : ($report->priority == 'high' ? 'warning' : 'success') }}">
                                            {{ ucfirst($report->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $report->status == 'selesai' ? 'success' : ($report->status == 'dalam_proses' ? 'info' : 'warning') }}">
                                            {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="{{ route('damage-reports.show', $report) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                        @if(auth()->user()->hasPermission('update-damage-reports'))
                                        <a href="{{ route('damage-reports.edit', $report) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="mdi mdi-pencil"></i>
                                        </a>

                                        @if(!$report->assigned_to)
                                        <button type="button" class="btn btn-sm btn-success" title="Assign Teknisi" onclick="showAssignModal({{ $report->id }}, '{{ addslashes($report->asset->name ?? '') }}')">
                                            <i class="mdi mdi-account-plus"></i>
                                        </button>
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data laporan kerusakan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        {{ $damageReports->links('vendor.pagination.custom') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Assign Teknisi -->
<div class="modal fade" id="assignTeknisiModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="mdi mdi-account-plus"></i> Assign Teknisi
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="reportIdForAssign">
                <p class="mb-3">Pilih teknisi untuk laporan kerusakan: <strong id="assetNameForAssign"></strong></p>

                <div id="teknisiLoadingSpinner" class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat data teknisi...</p>
                </div>

                <div id="teknisiSelectContainer" style="display: none;">
                    <div class="form-group">
                        <label for="teknisiSelect">Pilih Teknisi</label>
                        <select class="form-control" id="teknisiSelect">
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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnAssignTeknisi">Assign Teknisi</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showAssignModal(reportId, assetName) {
    document.getElementById('reportIdForAssign').value = reportId;
    document.getElementById('assetNameForAssign').textContent = assetName;

    $('#assignTeknisiModal').modal('show');

    document.getElementById('teknisiLoadingSpinner').style.display = 'block';
    document.getElementById('teknisiSelectContainer').style.display = 'none';
    document.getElementById('noTeknisiMessage').style.display = 'none';
    document.getElementById('modalFooter').style.display = 'none';

    fetch('/api/teknisi')
        .then(response => response.json())
        .then(data => {
            document.getElementById('teknisiLoadingSpinner').style.display = 'none';

            if (data.teknisi && data.teknisi.length > 0) {
                document.getElementById('teknisiSelectContainer').style.display = 'block';
                document.getElementById('modalFooter').style.display = 'flex';

                const select = document.getElementById('teknisiSelect');
                select.innerHTML = '<option value="">-- Pilih Teknisi --</option>';

                data.teknisi.forEach(tek => {
                    const option = document.createElement('option');
                    option.value = tek.id;
                    option.textContent = `${tek.name} (${tek.email})`;
                    option.dataset.name = tek.name;
                    select.appendChild(option);
                });
            } else {
                document.getElementById('noTeknisiMessage').style.display = 'block';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('teknisiLoadingSpinner').style.display = 'none';
            document.getElementById('noTeknisiMessage').style.display = 'block';
        });
}

document.addEventListener('DOMContentLoaded', function() {
    const btnAssign = document.getElementById('btnAssignTeknisi');
    if (btnAssign) {
        btnAssign.addEventListener('click', function() {
            const reportId = document.getElementById('reportIdForAssign').value;
            const select = document.getElementById('teknisiSelect');
            const teknisiId = select.value;
            const teknisiName = select.options[select.selectedIndex]?.dataset.name || '';

            if (!teknisiId) {
                showToast('warning', 'Silakan pilih teknisi terlebih dahulu');
                return;
            }

            showConfirmToast(
                `Assign ${teknisiName} ke laporan kerusakan ini?`,
                function() {
                    fetch(`/damage-reports/${reportId}/assign`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ teknisi_id: teknisiId })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            $('#assignTeknisiModal').modal('hide');
                            showToast('success', data.message);
                            setTimeout(() => window.location.reload(), 1000);
                        } else {
                            showToast('error', 'Gagal assign teknisi: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
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
