<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kerusakan - {{ $damageReport->asset->name }}</title>
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

        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
            font-weight: bold;
        }

        .badge-danger {
            background-color: #dc3545;
            color: white;
        }

        .badge-warning {
            background-color: #ffc107;
            color: black;
        }

        .badge-info {
            background-color: #17a2b8;
            color: white;
        }

        .badge-success {
            background-color: #28a745;
            color: white;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 10px;
            color: #666;
        }

        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN KERUSAKAN ASET</h1>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="info-section">
        <h2>Informasi Aset</h2>
        <table class="info-table">
            <tr>
                <td>Nama Aset</td>
                <td>{{ $damageReport->asset->name }}</td>
            </tr>
            <tr>
                <td>Kode Aset</td>
                <td>{{ $damageReport->asset->asset_code }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>{{ $damageReport->asset->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>{{ $damageReport->asset->room->building->name ?? '-' }} - {{ $damageReport->asset->room->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <h2>Detail Kerusakan</h2>
        <table class="info-table">
            <tr>
                <td>Tanggal Laporan</td>
                <td>{{ $damageReport->report_date->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Dilaporkan Oleh</td>
                <td>{{ $damageReport->reported_by ?? '-' }}</td>
            </tr>
            <tr>
                <td>Deskripsi Kerusakan</td>
                <td>{{ $damageReport->description }}</td>
            </tr>
            <tr>
                <td>Severity</td>
                <td>
                    <span class="badge badge-{{ $damageReport->severity == 'berat' ? 'danger' : ($damageReport->severity == 'sedang' ? 'warning' : 'info') }}">
                        {{ ucfirst($damageReport->severity) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Priority</td>
                <td>
                    <span class="badge badge-{{ $damageReport->priority == 'critical' ? 'danger' : ($damageReport->priority == 'high' ? 'warning' : 'info') }}">
                        {{ ucfirst($damageReport->priority) }}
                    </span>
                </td>
            </tr>
            <tr>
                <td>Status</td>
                <td>
                    <span class="badge badge-{{ $damageReport->status == 'selesai' ? 'success' : ($damageReport->status == 'dalam_proses' ? 'info' : 'warning') }}">
                        {{ ucfirst(str_replace('_', ' ', $damageReport->status)) }}
                    </span>
                </td>
            </tr>
            @if($damageReport->estimated_repair_cost)
            <tr>
                <td>Estimasi Biaya Perbaikan</td>
                <td>Rp {{ number_format($damageReport->estimated_repair_cost, 0, ',', '.') }}</td>
            </tr>
            @endif
            @if($damageReport->assigned_to)
            <tr>
                <td>Ditugaskan Ke</td>
                <td>{{ $damageReport->assignedUser->name ?? '-' }}</td>
            </tr>
            @endif
            @if($damageReport->resolution_notes)
            <tr>
                <td>Catatan Penyelesaian</td>
                <td>{{ $damageReport->resolution_notes }}</td>
            </tr>
            @endif
            @if($damageReport->resolved_at)
            <tr>
                <td>Tanggal Selesai</td>
                <td>{{ $damageReport->resolved_at->format('d F Y H:i') }}</td>
            </tr>
            @endif
            @if($damageReport->resolved_by)
            <tr>
                <td>Diselesaikan Oleh</td>
                <td>{{ $damageReport->resolvedBy->name ?? '-' }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Manajemen Aset</p>
        <p>&copy; {{ date('Y') }} - Semua hak dilindungi</p>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
