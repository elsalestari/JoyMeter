<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kepuasan Pelanggan</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111827; }
        h1, h2, h3 { margin: 0 0 8px 0; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th, td { border: 1px solid #E5E7EB; padding: 6px 8px; }
        th { background-color: #F3F4F6; font-weight: 600; font-size: 11px; }
    </style>
</head>
<body>
    <h1 class="text-center mb-2">Laporan Kepuasan Pelanggan</h1>
    <p class="text-center mb-4">JoyMeter - Sistem Analisis Ekspresi Pelanggan</p>

    <p class="mb-2"><strong>Periode:</strong>
        @if($startDate && $endDate)
            {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
        @else
            Semua data
        @endif
    </p>

    <p class="mb-4"><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y, H:i') }}</p>

    <h2 class="mb-2">Ringkasan Kategori Kepuasan</h2>
    <table>
        <thead>
            <tr>
                <th>Kategori</th>
                <th class="text-center">Total Pelanggan</th>
                <th class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Senang</td>
                <td class="text-center">{{ number_format($stats['senang_count']) }}</td>
                <td class="text-center">{{ number_format($stats['senang_rate'], 1) }}%</td>
            </tr>
            <tr>
                <td>Netral</td>
                <td class="text-center">{{ number_format($stats['netral_count']) }}</td>
                <td class="text-center">{{ number_format($stats['netral_rate'], 1) }}%</td>
            </tr>
            <tr>
                <td>Tidak Puas</td>
                <td class="text-center">{{ number_format($stats['tidak_puas_count']) }}</td>
                <td class="text-center">{{ number_format($stats['tidak_puas_rate'], 1) }}%</td>
            </tr>
        </tbody>
    </table>

    <h2 class="mb-2">Tren Kepuasan (Pelanggan Senang)</h2>
    @if(!empty($satisfactionData['labels']))
    <table>
        <thead>
            <tr>
                <th>Periode</th>
                <th class="text-center">Persentase Pelanggan Senang</th>
            </tr>
        </thead>
        <tbody>
            @foreach($satisfactionData['labels'] as $index => $label)
            <tr>
                <td>{{ $label }}</td>
                <td class="text-center">
                    {{ $satisfactionData['senang_rates'][$index] ?? 0 }}%
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="mb-4">Belum ada data tren kepuasan pelanggan untuk periode ini.</p>
    @endif

    <h2 class="mb-2">Riwayat Kepuasan per Hari (maksimal 20 hari terakhir)</h2>
    @if(!empty($dailyHistory))
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th class="text-center">Total Pelanggan</th>
                <th class="text-center">Senang</th>
                <th class="text-center">Netral</th>
                <th class="text-center">Tidak Puas</th>
                <th class="text-center">Tingkat Kepuasan (Senang)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dailyHistory as $day)
            <tr>
                <td>{{ $day['date'] }}</td>
                <td class="text-center">{{ number_format($day['total']) }}</td>
                <td class="text-center">{{ number_format($day['senang']) }}</td>
                <td class="text-center">{{ number_format($day['netral']) }}</td>
                <td class="text-center">{{ number_format($day['tidak_puas']) }}</td>
                <td class="text-center">{{ number_format($day['senang_rate'], 1) }}%</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>Belum ada data kepuasan pelanggan dari rekaman kamera.</p>
    @endif
</body>
</html>


