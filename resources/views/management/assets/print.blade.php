<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Detail Aset - {{ $asset->asset_code }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            padding: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 11px;
            color: #666;
        }

        .info-section {
            margin-bottom: 20px;
        }

        .info-section h2 {
            font-size: 14px;
            margin-bottom: 10px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        table.info-table td:first-child {
            width: 35%;
            font-weight: bold;
            background-color: #f5f5f5;
        }

        table.history-table {
            font-size: 10px;
        }

        table.history-table th,
        table.history-table td {
            padding: 6px;
            border: 1px solid #ddd;
            text-align: left;
        }

        table.history-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-success { background-color: #28a745; color: white; }
        .badge-dark { background-color: #343a40; color: white; }
        .badge-warning { background-color: #ffc107; color: #000; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-info { background-color: #17a2b8; color: white; }
        .badge-primary { background-color: #007bff; color: white; }

        .footer {
            margin-top: 40px;
            text-align: right;
            font-size: 11px;
        }

        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }

        .signature-box {
            width: 45%;
            text-align: center;
        }

        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #000;
            padding-top: 5px;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .print-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <button onclick="window.print()" class="print-button no-print">Cetak Laporan</button>

    <div class="header">
        <h1>LAPORAN DETAIL ASET</h1>
        <p>Tanggal Cetak: {{ now()->format('d F Y, H:i') }} WIB</p>
    </div>

    <div class="info-section">
        <h2>Informasi Aset</h2>
        <table class="info-table">
            <tr>
                <td>Kode Aset</td>
                <td><strong>{{ $asset->asset_code }}</strong></td>
            </tr>
            <tr>
                <td>Nama Aset</td>
                <td><strong>{{ $asset->name }}</strong></td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td><span class="badge badge-primary">{{ $asset->category->name }}</span></td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>
                    @if($asset->room)
                        @if($asset->room->building)
                            {{ $asset->room->building->name }} - {{ $asset->room->name }}
                        @else
                            {{ $asset->room->name }}
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    @if($asset->status == 'aktif')
                        <span class="badge badge-success">Aktif</span>
                    @elseif($asset->status == 'non-aktif')
                        <span class="badge badge-dark">Non-aktif</span>
                    @elseif($asset->status == 'dalam_perbaikan')
                        <span class="badge badge-warning">Dalam Perbaikan</span>
                    @else
                        <span class="badge badge-danger">Rusak</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td>Pemilik/Penanggung Jawab</td>
                <td>{{ $asset->owner ?? '-' }}</td>
            </tr>
            <tr>
                <td>Pengguna Pribadi</td>
                <td>{{ $asset->private_owner ?? '-' }}</td>
            </tr>
            <tr>
                <td>Tanggal Pembelian</td>
                <td>{{ $asset->purchase_date ? $asset->purchase_date->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td>Nilai Beli</td>
                <td>
                    @if($asset->value)
                        Rp {{ number_format($asset->value, 0, ',', '.') }}
                        @if($asset->value > 500)
                            <span class="badge badge-success">Aktiva</span>
                        @else
                            <span class="badge badge-info">Pasif</span>
                        @endif
                    @else
                        -
                    @endif
                </td>
            </tr>
            @if($asset->notes)
            <tr>
                <td>Catatan</td>
                <td>{{ $asset->notes }}</td>
            </tr>
            @endif
            <tr>
                <td>Dibuat Pada</td>
                <td>{{ $asset->created_at->format('d F Y, H:i') }} WIB</td>
            </tr>
            <tr>
                <td>Terakhir Diupdate</td>
                <td>{{ $asset->updated_at->format('d F Y, H:i') }} WIB</td>
            </tr>
        </table>
    </div>

    @if($asset->statusHistory->count() > 0)
    <div class="info-section">
        <h2>Riwayat Status & Lokasi ({{ $asset->statusHistory->count() }} record)</h2>
        <table class="history-table">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="15%">Tanggal</th>
                    <th width="15%">Status Lama</th>
                    <th width="15%">Status Baru</th>
                    <th width="15%">Lokasi Lama</th>
                    <th width="15%">Lokasi Baru</th>
                    <th width="10%">Diubah Oleh</th>
                    <th width="10%">Catatan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($asset->statusHistory->sortByDesc('change_date') as $index => $history)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $history->change_date->format('d/m/Y H:i') }}</td>
                    <td>
                        @if($history->previous_status)
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $history->previous_status)) }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-primary">{{ ucfirst(str_replace('_', ' ', $history->new_status)) }}</span>
                    </td>
                    <td>
                        @if($history->previousRoom)
                            {{ $history->previousRoom->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($history->newRoom)
                            {{ $history->newRoom->name }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $history->changedBy->name ?? '-' }}</td>
                    <td>{{ $history->notes ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh Sistem Manajemen Aset</p>
    </div>

    <div class="signature-section">
        <div class="signature-box">
            <p>Penanggung Jawab Aset</p>
            <div class="signature-line">
                <p>(...........................)</p>
            </div>
        </div>
        <div class="signature-box">
            <p>Kepala Bagian</p>
            <div class="signature-line">
                <p>(...........................)</p>
            </div>
        </div>
    </div>
</body>
</html>
