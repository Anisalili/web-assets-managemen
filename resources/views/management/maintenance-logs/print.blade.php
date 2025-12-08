<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perawatan - {{ $maintenanceLog->asset->name }}</title>
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
        <h1>LAPORAN PERAWATAN ASET</h1>
        <p>Tanggal Cetak: {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="info-section">
        <h2>Informasi Aset</h2>
        <table class="info-table">
            <tr>
                <td>Nama Aset</td>
                <td>{{ $maintenanceLog->asset->name }}</td>
            </tr>
            <tr>
                <td>Kode Aset</td>
                <td>{{ $maintenanceLog->asset->asset_code }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>{{ $maintenanceLog->asset->category->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Lokasi</td>
                <td>{{ $maintenanceLog->asset->room->building->name ?? '-' }} - {{ $maintenanceLog->asset->room->name ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="info-section">
        <h2>Detail Perawatan</h2>
        <table class="info-table">
            <tr>
                <td>Tanggal Perawatan</td>
                <td>{{ $maintenanceLog->date_performed->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Dilakukan Oleh</td>
                <td>{{ $maintenanceLog->performedBy->name ?? '-' }}</td>
            </tr>
            @if($maintenanceLog->schedule)
            <tr>
                <td>Jadwal Terkait</td>
                <td>{{ $maintenanceLog->schedule->scheduled_date->format('d F Y') }} - {{ $maintenanceLog->schedule->maintenance_type }}</td>
            </tr>
            @endif
            <tr>
                <td>Hasil Perawatan</td>
                <td>{{ $maintenanceLog->result }}</td>
            </tr>
            @if($maintenanceLog->spare_parts_used)
            <tr>
                <td>Suku Cadang yang Digunakan</td>
                <td>{{ $maintenanceLog->spare_parts_used }}</td>
            </tr>
            @endif
            @if($maintenanceLog->notes)
            <tr>
                <td>Catatan</td>
                <td>{{ $maintenanceLog->notes }}</td>
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
