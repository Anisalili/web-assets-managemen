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
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Total Aset Rusak</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($totalDamaged) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-warning text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Total Nilai Kerusakan</h6>
                                <h2 class="mt-2 mb-0">Rp {{ number_format($totalValueDamaged, 0, ',', '.') }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Dalam Perbaikan</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($assetsByStatus['dalam_perbaikan'] ?? 0) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('reports.damage') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
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
                            <button class="btn btn-primary btn-sm w-100" type="submit">
                                <i class="mdi mdi-magnify"></i> Filter
                            </button>
                        </div>

                        @if(request()->hasAny(['category_id', 'status']))
                        <div class="col-md-2">
                            <a href="{{ route('reports.damage') }}" class="btn btn-secondary btn-sm w-100">
                                <i class="mdi mdi-refresh"></i> Reset
                            </a>
                        </div>
                        @endif
                    </div>
                </form>

                <!-- Damaged Assets Table -->
                <div class="table-responsive" id="reportTable">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="12%">Kode Aset</th>
                                <th width="18%">Nama Aset</th>
                                <th width="15%">Kategori</th>
                                <th width="18%">Lokasi</th>
                                <th width="12%">Status</th>
                                <th width="15%">Nilai Aset</th>
                                <th width="15%">Terakhir Update</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assets as $index => $asset)
                            <tr>
                                <td>{{ $assets->firstItem() + $index }}</td>
                                <td><strong>{{ $asset->asset_code }}</strong></td>
                                <td>{{ $asset->name }}</td>
                                <td>{{ $asset->category->name }}</td>
                                <td>
                                    @if($asset->room)
                                        {{ $asset->room->building->name }} - {{ $asset->room->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asset->status == 'dalam_perbaikan')
                                        <span class="badge bg-warning">Dalam Perbaikan</span>
                                    @else
                                        <span class="badge bg-danger">Rusak</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asset->value)
                                        Rp {{ number_format($asset->value, 0, ',', '.') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $asset->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="mdi mdi-file-document-outline" style="font-size: 48px; color: #ccc;"></i>
                                    <p class="text-muted mb-0 mt-2">Tidak ada data kerusakan untuk ditampilkan</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        @if($assets->count() > 0)
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="6" class="text-end">Total:</th>
                                <th>Rp {{ number_format($totalValueDamaged, 0, ',', '.') }}</th>
                                <th>{{ number_format($totalDamaged) }} Aset</th>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                <!-- Pagination -->
                @if($assets->hasPages())
                <div class="mt-3">
                    {{ $assets->links('vendor.pagination.custom') }}
                </div>
                @endif

                <!-- Summary by Status -->
                @if($assetsByStatus->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-6">
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
                                    @foreach($assetsByStatus as $status => $count)
                                    <tr>
                                        <td>{{ ucfirst(str_replace('_', ' ', $status)) }}</td>
                                        <td class="text-end">{{ number_format($count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif

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
