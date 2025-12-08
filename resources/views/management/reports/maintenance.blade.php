@extends('layouts.app')

@section('title', 'Laporan Perawatan')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Laporan Perawatan</h3>
                    <h6 class="font-weight-normal mb-0">Laporan riwayat perawatan asset perusahaan</h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-md-12 stretch-card grid-margin">
            <div class="card bg-gradient-info card-img-holder text-white">
                <div class="card-body">
                    <h4 class="font-weight-normal mb-3">Total Perawatan
                        <i class="mdi mdi-wrench mdi-24px float-right"></i>
                    </h4>
                    <h2 class="mb-5">{{ $totalMaintenance }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="card-title mb-0">Riwayat Perawatan</h4>
                        <div>
                            <button type="button" class="btn btn-success btn-sm me-2" onclick="exportToExcel()">
                                <i class="mdi mdi-file-excel"></i> Export Excel
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="exportToPDF()">
                                <i class="mdi mdi-file-pdf"></i> Export PDF
                            </button>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('report.pemeliharaan') }}" class="mb-3">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <select name="asset_id" class="form-select form-select-sm">
                                    <option value="">Semua Asset</option>
                                    @foreach(\App\Models\Asset::all() as $asset)
                                    <option value="{{ $asset->id }}" {{ request('asset_id') == $asset->id ? 'selected' : '' }}>
                                        {{ $asset->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <button class="btn btn-primary btn-sm w-100" type="submit">
                                    <i class="mdi mdi-magnify"></i> Filter
                                </button>
                            </div>

                            @if(request('asset_id'))
                            <div class="col-md-2">
                                <a href="{{ route('report.pemeliharaan') }}" class="btn btn-secondary btn-sm w-100">
                                    <i class="mdi mdi-refresh"></i> Reset
                                </a>
                            </div>
                            @endif
                        </div>
                    </form>

                    <div class="table-responsive" id="maintenanceTable">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Asset</th>
                                    <th>Tanggal Perawatan</th>
                                    <th>Dilakukan Oleh</th>
                                    <th>Hasil</th>
                                    <th>Suku Cadang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($maintenanceLogs as $index => $log)
                                <tr>
                                    <td>{{ $maintenanceLogs->firstItem() + $index }}</td>
                                    <td>{{ $log->asset->name }}</td>
                                    <td>{{ $log->date_performed->format('d M Y') }}</td>
                                    <td>{{ $log->performedBy->name ?? '-' }}</td>
                                    <td>{{ Str::limit($log->result, 50) }}</td>
                                    <td>{{ $log->spare_parts_used ? Str::limit($log->spare_parts_used, 30) : '-' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary" onclick="printMaintenance({{ $log->id }})" title="Cetak">
                                            <i class="mdi mdi-printer"></i>
                                        </button>
                                        <a href="{{ route('maintenance-logs.show', $log) }}" class="btn btn-sm btn-info" title="Detail">
                                            <i class="mdi mdi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">Tidak ada data perawatan</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    @if($maintenanceLogs->hasPages())
                    <div class="mt-3">
                        {{ $maintenanceLogs->links('vendor.pagination.custom') }}
                    </div>
                    @endif
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
    function printMaintenance(maintenanceId) {
        window.open('/maintenance-logs/' + maintenanceId + '/print', '_blank');
    }

    function exportToExcel() {
        const table = document.querySelector('#maintenanceTable table');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Laporan Perawatan"});
        XLSX.writeFile(wb, 'Laporan_Perawatan_' + new Date().toISOString().slice(0,10) + '.xlsx');
        showToast('success', 'Laporan berhasil di-export ke Excel');
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4');

        doc.setFontSize(16);
        doc.text('Laporan Perawatan Aset', 14, 15);
        doc.setFontSize(10);
        doc.text('Tanggal: ' + new Date().toLocaleDateString('id-ID'), 14, 22);

        const tableData = [];
        const rows = document.querySelectorAll('#maintenanceTable tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length > 1) {
                const rowData = [];
                for(let i = 0; i < cells.length - 1; i++) {
                    rowData.push(cells[i].textContent.trim());
                }
                tableData.push(rowData);
            }
        });

        doc.autoTable({
            head: [['No', 'Asset', 'Tanggal Perawatan', 'Dilakukan Oleh', 'Hasil', 'Suku Cadang']],
            body: tableData,
            startY: 28,
            styles: { fontSize: 8 },
            headStyles: { fillColor: [23, 162, 184] }
        });

        doc.save('Laporan_Perawatan_' + new Date().toISOString().slice(0,10) + '.pdf');
        showToast('success', 'Laporan berhasil di-export ke PDF');
    }
</script>
@endpush
