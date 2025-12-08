@extends('layouts.app')

@section('title', 'Laporan Aset')

@section('content')
<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">Laporan Aset</h4>
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
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Total Aset</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($totalAssets) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Aset Aktif</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($assetsByStatus['aktif'] ?? 0) }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h6 class="card-title mb-0">Aset Rusak</h6>
                                <h2 class="mt-2 mb-0">{{ number_format($assetsByStatus['rusak'] ?? 0) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('report.barang') }}" class="mb-3">
                    <div class="row g-2">
                        <div class="col-md-2">
                            <select name="category_id" class="form-select form-select-sm">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="building_id" class="form-select form-select-sm" id="buildingFilter">
                                <option value="">Semua Gedung</option>
                                @foreach($buildings as $building)
                                <option value="{{ $building->id }}" {{ request('building_id') == $building->id ? 'selected' : '' }}>
                                    {{ $building->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="room_id" class="form-select form-select-sm">
                                <option value="">Semua Ruangan</option>
                                @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ request('room_id') == $room->id ? 'selected' : '' }}>
                                    {{ $room->building->name }} - {{ $room->name }}
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
                            <input type="date" name="date_from" class="form-control form-control-sm"
                                   placeholder="Dari" value="{{ request('date_from') }}">
                        </div>

                        <div class="col-md-1">
                            <input type="date" name="date_to" class="form-control form-control-sm"
                                   placeholder="Sampai" value="{{ request('date_to') }}">
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-primary btn-sm w-100" type="submit">
                                <i class="mdi mdi-magnify"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Assets Table -->
                <div class="table-responsive" id="reportTable">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">#</th>
                                <th width="10%">Kode Aset</th>
                                <th width="15%">Nama Aset</th>
                                <th width="12%">Kategori</th>
                                <th width="15%">Lokasi</th>
                                <th width="10%">Status</th>
                                <th width="12%">Nilai Beli</th>
                                <th width="10%">Tgl Pembelian</th>
                                <th width="11%">Pemilik</th>
                                <th width="10%">Aksi</th>
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
                                        @if($asset->room->building)
                                            {{ $asset->room->building->name }} - {{ $asset->room->name }}
                                        @else
                                            {{ $asset->room->name }}
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($asset->status == 'aktif')
                                        <span class="badge bg-success">Aktif</span>
                                    @elseif($asset->status == 'non-aktif')
                                        <span class="badge bg-dark">Non-aktif</span>
                                    @elseif($asset->status == 'dalam_perbaikan')
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
                                <td>
                                    @if($asset->purchase_date)
                                        {{ $asset->purchase_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $asset->owner ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('assets.show', $asset) }}" class="btn btn-sm btn-info" title="Detail">
                                        <i class="mdi mdi-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="printAsset({{ $asset->id }})" title="Cetak">
                                        <i class="mdi mdi-printer"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    <i class="mdi mdi-file-document-outline" style="font-size: 48px; color: #ccc;"></i>
                                    <p class="text-muted mb-0 mt-2">Tidak ada data untuk ditampilkan</p>
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

                <!-- Summary by Category -->
                @if($assetsByCategory->count() > 0)
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>Ringkasan per Kategori</h5>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kategori</th>
                                        <th class="text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($assetsByCategory as $category => $count)
                                    <tr>
                                        <td>{{ $category }}</td>
                                        <td class="text-end">{{ number_format($count) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

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
    function printAsset(assetId) {
        window.open('/assets/' + assetId + '/print', '_blank');
    }

    function exportToExcel() {
        const table = document.querySelector('#reportTable table');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Laporan Aset"});
        XLSX.writeFile(wb, 'Laporan_Aset_' + new Date().toISOString().slice(0,10) + '.xlsx');
        showToast('success', 'Laporan berhasil di-export ke Excel');
    }

    function exportToPDF() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4');

        doc.setFontSize(16);
        doc.text('Laporan Aset', 14, 15);
        doc.setFontSize(10);
        doc.text('Tanggal: ' + new Date().toLocaleDateString('id-ID'), 14, 22);

        const tableData = [];
        const rows = document.querySelectorAll('#reportTable tbody tr');

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
            head: [['#', 'Kode', 'Nama', 'Kategori', 'Lokasi', 'Status', 'Nilai', 'Update']],
            body: tableData,
            startY: 28,
            styles: { fontSize: 8 },
            headStyles: { fillColor: [0, 123, 255] }
        });

        doc.save('Laporan_Aset_' + new Date().toISOString().slice(0,10) + '.pdf');
        showToast('success', 'Laporan berhasil di-export ke PDF');
    }
</script>
@endpush
