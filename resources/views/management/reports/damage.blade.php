@extends('layouts.app')

@section('title', 'Laporan Kerusakan Aset')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Laporan Kerusakan Aset</h4>
                    <div>
                        <button type="button" class="btn btn-success btn-sm me-2" onclick="exportToExcel()">
                            <i class="mdi mdi-file-excel"></i> Export Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="exportToPDF()">
                            <i class="mdi mdi-file-pdf"></i> Export PDF
                        </button>
                    </div>
                </div>

                <!-- Statistics Cards -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Total Laporan</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($totalReports) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Estimasi Biaya</h6>
                                <h2 class="mt-2 mb-0">Rp {{ number_format($totalEstimatedCost, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Biaya Aktual</h6>
                                <h2 class="mt-2 mb-0">Rp {{ number_format($totalActualCost, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Dalam Proses</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($reportsByStatus['dalam_proses'] ?? 0) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('reports.damage') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <select name="asset_id" class="form-select form-select-sm">
                                <option value="">Semua Asset</option>
                                @foreach($assets as $asset)
                                <option value="{{ $asset->id }}" {{ request('asset_id') == $asset->id ? 'selected' : '' }}>
                                    {{ $asset->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                @foreach($statuses as $stat)
                                <option value="{{ $stat }}" {{ request('status') == $stat ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $stat)) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="severity" class="form-select form-select-sm">
                                <option value="">Semua Severity</option>
                                @foreach($severities as $sev)
                                <option value="{{ $sev }}" {{ request('severity') == $sev ? 'selected' : '' }}>
                                    {{ ucfirst($sev) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="priority" class="form-select form-select-sm">
                                <option value="">Semua Priority</option>
                                @foreach($priorities as $pri)
                                <option value="{{ $pri }}" {{ request('priority') == $pri ? 'selected' : '' }}>
                                    {{ ucfirst($pri) }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary btn-sm w-100" type="submit">
                                <i class="mdi mdi-magnify"></i> Filter
                            </button>
                        </div>

                        @if(request()->hasAny(['asset_id', 'status', 'severity', 'priority']))
                        <div class="col-md-2">
                            <a href="{{ route('reports.damage') }}" class="btn btn-secondary btn-sm w-100">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                        </div>
                        @endif
                    </div>
                </form>

                <!-- Damage Reports Table -->
                <div class="table-responsive" id="reportTable">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="15%">Asset</th>
                                <th width="12%">Tanggal Laporan</th>
                                <th width="10%">Severity</th>
                                <th width="10%">Priority</th>
                                <th width="10%">Status</th>
                                <th width="15%">Dilaporkan Oleh</th>
                                <th width="13%">Estimasi Biaya</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($damageReports as $index => $report)
                            <tr>
                                <td>{{ $damageReports->firstItem() + $index }}</td>
                                <td>{{ $report->asset->name ?? '-' }}</td>
                                <td>{{ $report->report_date->format('d/m/Y') }}</td>
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
                                <td>{{ $report->reportedBy->name ?? '-' }}</td>
                                <td>
                                    @if($report->estimated_repair_cost)
                                        Rp {{ number_format($report->estimated_repair_cost, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('damage-reports.show', $report) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <i class="mdi mdi-file-document-outline" style="font-size: 48px; color: #ccc;"></i>
                                    <p class="text-muted mb-0 mt-2">Tidak ada laporan kerusakan untuk ditampilkan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($damageReports->count() > 0)
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="7" class="text-end">Total Estimasi:</th>
                                <th colspan="2">Rp {{ number_format($totalEstimatedCost, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-end">Total Biaya Aktual:</th>
                                <th colspan="2">Rp {{ number_format($totalActualCost, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                <!-- Pagination -->
                @if($damageReports->hasPages())
                <div class="mt-3">
                    {{ $damageReports->links('vendor.pagination.custom') }}
                </div>
                @endif

                <!-- Summary Charts -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <h5>Ringkasan per Status</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Status</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportsByStatus as $status => $count)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                                        <td class="text-end">{{ number_format($count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Ringkasan per Severity</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Severity</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportsBySeverity as $severity => $count)
                                    <tr>
                                        <td>{{ ucfirst($severity) }}</td>
                                        <td class="text-end">{{ number_format($count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <h5>Ringkasan per Priority</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Priority</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reportsByPriority as $priority => $count)
                                    <tr>
                                        <td>{{ ucfirst($priority) }}</td>
                                        <td class="text-end">{{ number_format($count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js"></script>

<script>
    function exportToExcel() {
        const table = document.querySelector('#reportTable table');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Laporan Kerusakan"});
        XLSX.writeFile(wb, 'Laporan_Kerusakan_Aset_' + new Date().toISOString().slice(0,10) + '.xlsx');
        showToast('success', 'Laporan berhasil di-export ke Excel');
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4');

        // Title
        doc.setFontSize(16);
        doc.text('Laporan Kerusakan Aset', 14, 15);
        doc.setFontSize(10);
        doc.text('Tanggal: ' + new Date().toLocaleDateString('id-ID'), 14, 22);

        // Get table data
        const tableData = [];
        const rows = document.querySelectorAll('#reportTable tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) {
                const rowData = [];
                cells.forEach(cell => {
                    rowData.push(cell.textContent.trim());
                });
                tableData.push(rowData);
            }
        });

        // Add table
        doc.autoTable({
            head: [['#', 'Kode', 'Nama', 'Kategori', 'Lokasi', 'Status', 'Nilai', 'Update']],
            body: tableData,
            startY: 28,
            styles: { fontSize: 8 },
            headStyles: { fillColor: [220, 53, 69] }
        });

        doc.save('Laporan_Kerusakan_Aset_' + new Date().toISOString().slice(0,10) + '.pdf');
        showToast('success', 'Laporan berhasil di-export ke PDF');
    }
</script>
@endpush
