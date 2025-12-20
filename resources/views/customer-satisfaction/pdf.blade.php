<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Laporan Kepuasan Pelanggan - JoyMeter</title>
    <style>
        @page {
            margin: 1.5cm;
        }
        
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #111827;
            line-height: 1.5;
        }
        
        h1 {
            font-size: 20px;
            font-weight: bold;
            margin: 0 0 8px 0;
            color: #1F2937;
        }
        
        h2 {
            font-size: 14px;
            font-weight: bold;
            margin: 16px 0 8px 0;
            color: #374151;
            border-bottom: 2px solid #F7AA4A;
            padding-bottom: 4px;
        }
        
        h3 {
            font-size: 12px;
            font-weight: bold;
            margin: 12px 0 6px 0;
            color: #4B5563;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        .mb-1 { margin-bottom: 4px; }
        .mb-2 { margin-bottom: 8px; }
        .mb-3 { margin-bottom: 12px; }
        .mb-4 { margin-bottom: 16px; }
        .mb-5 { margin-bottom: 20px; }
        
        .mt-4 { margin-top: 16px; }
        .mt-5 { margin-top: 20px; }
        
        /* Header Section */
        .header {
            border-bottom: 3px solid #F7AA4A;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        
        .logo-text {
            font-size: 24px;
            font-weight: bold;
            color: #F6821F;
            margin-bottom: 4px;
        }
        
        .subtitle {
            font-size: 10px;
            color: #6B7280;
        }
        
        /* Info Box */
        .info-box {
            background-color: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: 16px;
        }
        
        .info-row {
            display: table;
            width: 100%;
            margin-bottom: 6px;
        }
        
        .info-label {
            display: table-cell;
            width: 30%;
            font-weight: bold;
            color: #374151;
        }
        
        .info-value {
            display: table-cell;
            width: 70%;
            color: #1F2937;
        }
        
        /* Tables */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 10px;
        }
        
        th {
            background-color: #F3F4F6;
            border: 1px solid #D1D5DB;
            padding: 8px 6px;
            font-weight: 600;
            font-size: 9px;
            color: #374151;
            text-align: left;
        }
        
        td {
            border: 1px solid #E5E7EB;
            padding: 6px;
            font-size: 9px;
        }
        
        tr:nth-child(even) {
            background-color: #F9FAFB;
        }
        
        /* Summary Table */
        .summary-table {
            width: 100%;
            margin-bottom: 16px;
        }
        
        .summary-table td {
            padding: 10px;
            text-align: center;
            border: 1px solid #E5E7EB;
        }
        
        .summary-label {
            font-size: 11px;
            font-weight: bold;
            color: #374151;
            margin-bottom: 4px;
        }
        
        .summary-count {
            font-size: 18px;
            font-weight: bold;
            color: #1F2937;
            margin-bottom: 2px;
        }
        
        .summary-percent {
            font-size: 10px;
            color: #6B7280;
        }
        
        /* Footer */
        .footer {
            position: fixed;
            bottom: 0.8cm;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #9CA3AF;
            border-top: 1px solid #E5E7EB;
            padding-top: 8px;
        }
        
        /* No Data Message */
        .no-data {
            text-align: center;
            padding: 30px 20px;
            background-color: #F9FAFB;
            border: 1px dashed #D1D5DB;
            border-radius: 4px;
            color: #6B7280;
            font-size: 10px;
        }
        
        .page-break {
            page-break-after: always;
        }
        
        /* Compact table for large datasets */
        .compact-table td {
            padding: 4px;
            font-size: 8px;
        }
        
        .compact-table th {
            padding: 5px 4px;
            font-size: 8px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="text-center">
            <div class="logo-text">JoyMeter</div>
            <div class="subtitle">Sistem Monitoring Kepuasan Pelanggan</div>
        </div>
    </div>

    <h1 class="text-center mb-4">Laporan Kepuasan Pelanggan</h1>

    <!-- Info Box -->
    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Periode Laporan:</span>
            <span class="info-value">
                @if($startDate && $endDate)
                    {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}
                @else
                    Semua Data (Sejak Awal)
                @endif
            </span>
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Cetak:</span>
            <span class="info-value">{{ now()->translatedFormat('l, d F Y') }} pukul {{ now()->format('H:i') }} WIB</span>
        </div>
        <div class="info-row">
            <span class="info-label">Total Data:</span>
            <span class="info-value">{{ number_format($stats['total_customers']) }} Pelanggan</span>
        </div>
    </div>

    <!-- Summary Section -->
    <h2>Ringkasan Kategori Kepuasan</h2>
    
    @if($stats['total_customers'] > 0)
        <table class="summary-table">
            <tr>
                <td style="width: 33.33%;">
                    <div class="summary-label">Senang</div>
                    <div class="summary-count">{{ number_format($stats['senang_count']) }}</div>
                    <div class="summary-percent">{{ number_format($stats['senang_rate'], 1) }}%</div>
                </td>
                <td style="width: 33.33%;">
                    <div class="summary-label">Netral</div>
                    <div class="summary-count">{{ number_format($stats['netral_count']) }}</div>
                    <div class="summary-percent">{{ number_format($stats['netral_rate'], 1) }}%</div>
                </td>
                <td style="width: 33.33%;">
                    <div class="summary-label">Tidak Puas</div>
                    <div class="summary-count">{{ number_format($stats['tidak_puas_count']) }}</div>
                    <div class="summary-percent">{{ number_format($stats['tidak_puas_rate'], 1) }}%</div>
                </td>
            </tr>
        </table>

        <!-- Detailed Table -->
        <table>
            <thead>
                <tr>
                    <th style="width: 40%;">Kategori</th>
                    <th style="width: 30%; text-align: center;">Total Pelanggan</th>
                    <th style="width: 30%; text-align: center;">Persentase</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Senang</strong> (Score >= 80)</td>
                    <td style="text-align: center;">{{ number_format($stats['senang_count']) }}</td>
                    <td style="text-align: center;"><strong>{{ number_format($stats['senang_rate'], 1) }}%</strong></td>
                </tr>
                <tr>
                    <td><strong>Netral</strong> (Score 45-79)</td>
                    <td style="text-align: center;">{{ number_format($stats['netral_count']) }}</td>
                    <td style="text-align: center;"><strong>{{ number_format($stats['netral_rate'], 1) }}%</strong></td>
                </tr>
                <tr>
                    <td><strong>Tidak Puas</strong> (Score < 45)</td>
                    <td style="text-align: center;">{{ number_format($stats['tidak_puas_count']) }}</td>
                    <td style="text-align: center;"><strong>{{ number_format($stats['tidak_puas_rate'], 1) }}%</strong></td>
                </tr>
            </tbody>
        </table>
    @else
        <div class="no-data">
            <p><strong>Tidak ada data untuk periode ini</strong></p>
            <p>Silakan gunakan Sesi Kamera untuk mulai merekam data kepuasan pelanggan.</p>
        </div>
    @endif

    <!-- Trend Section -->
    @if(!empty($satisfactionData['labels']) && count($satisfactionData['labels']) > 0)
        <div class="page-break"></div>
        
        <h2>Tren Kepuasan Pelanggan per Periode</h2>
        <p class="mb-3" style="font-size: 10px; color: #6B7280;">Jumlah pelanggan berdasarkan kategori kepuasan</p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 35%;">Periode</th>
                    <th style="width: 15%; text-align: center;">Senang</th>
                    <th style="width: 15%; text-align: center;">Netral</th>
                    <th style="width: 20%; text-align: center;">Tidak Puas</th>
                    <th style="width: 15%; text-align: center;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($satisfactionData['labels'] as $index => $label)
                @php
                    $senang = $satisfactionData['senang_counts'][$index] ?? 0;
                    $netral = $satisfactionData['netral_counts'][$index] ?? 0;
                    $tidakPuas = ($satisfactionData['tidak_puas_counts'][$index] ?? 0);
                    $total = $senang + $netral + $tidakPuas;
                @endphp
                <tr>
                    <td>{{ $label }}</td>
                    <td style="text-align: center;"><strong>{{ $senang }}</strong></td>
                    <td style="text-align: center;"><strong>{{ $netral }}</strong></td>
                    <td style="text-align: center;"><strong>{{ $tidakPuas }}</strong></td>
                    <td style="text-align: center;"><strong>{{ $total }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Daily History Section -->
    @if(!empty($dailyHistory) && count($dailyHistory) > 0)
        <h2 class="mt-5">Riwayat Kepuasan per Hari</h2>
        <p class="mb-3" style="font-size: 10px; color: #6B7280;">Maksimal 20 hari terakhir</p>
        
        <table>
            <thead>
                <tr>
                    <th style="width: 20%;">Tanggal</th>
                    <th style="width: 13%; text-align: center;">Total</th>
                    <th style="width: 13%; text-align: center;">Senang</th>
                    <th style="width: 13%; text-align: center;">Netral</th>
                    <th style="width: 13%; text-align: center;">Tidak Puas</th>
                    <th style="width: 28%; text-align: center;">Tingkat Kepuasan</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dailyHistory as $day)
                <tr>
                    <td>{{ $day['date'] }}</td>
                    <td style="text-align: center;">{{ number_format($day['total']) }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ number_format($day['senang']) }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ number_format($day['netral']) }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ number_format($day['tidak_puas']) }}</td>
                    <td style="text-align: center;">
                        <strong>{{ number_format($day['senang_rate'], 1) }}%</strong> Pelanggan Senang
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Customer List Section -->
    @if(!empty($customerList) && count($customerList) > 0)
        <div class="page-break"></div>
        
        <h2>Data Kepuasan Pelanggan Individual</h2>
        <p class="mb-3" style="font-size: 10px; color: #6B7280;">Pelanggan 1 = data paling lama | Urutan tabel: Terbaru di atas, Terlama di bawah</p>
        
        <table class="compact-table">
            <thead>
                <tr>
                    <th style="width: 8%;">No</th>
                    <th style="width: 17%;">Tanggal</th>
                    <th style="width: 12%; text-align: center;">Waktu</th>
                    <th style="width: 12%; text-align: center;">Score</th>
                    <th style="width: 18%; text-align: center;">Kategori</th>
                    <th style="width: 18%;">Ekspresi</th>
                    <th style="width: 10%; text-align: center;">Durasi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customerList as $customer)
                <tr>
                    <td style="text-align: center;"><strong>{{ $customer['number'] }}</strong></td>
                    <td>{{ $customer['date'] }}</td>
                    <td style="text-align: center;">{{ $customer['time'] }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $customer['satisfaction_score'] }}</td>
                    <td style="text-align: center;"><strong>{{ $customer['category'] }}</strong></td>
                    <td>{{ $customer['emotion_label'] }}</td>
                    <td style="text-align: center;">{{ $customer['duration'] }}s</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @elseif($stats['total_customers'] > 0)
        <h2 class="mt-5">Data Kepuasan Pelanggan</h2>
        <div class="no-data">
            <p>Belum ada data pelanggan untuk periode ini.</p>
        </div>
    @endif

    <!-- Kesimpulan -->
    @if($stats['total_customers'] > 0)
        <div class="mt-5" style="background-color: #F0FDF4; border-left: 4px solid #10B981; padding: 12px; border-radius: 4px;">
            <h3 style="margin-top: 0; color: #047857;">Kesimpulan</h3>
            <p style="margin: 4px 0; font-size: 10px;">
                Dari total <strong>{{ number_format($stats['total_customers']) }} pelanggan</strong> yang tercatat:
            </p>
            <ul style="margin: 6px 0; padding-left: 20px; font-size: 10px;">
                <li><strong>{{ number_format($stats['senang_rate'], 1) }}%</strong> pelanggan merasa <strong>Senang</strong> ({{ number_format($stats['senang_count']) }} pelanggan)</li>
                <li><strong>{{ number_format($stats['netral_rate'], 1) }}%</strong> pelanggan merasa <strong>Netral</strong> ({{ number_format($stats['netral_count']) }} pelanggan)</li>
                <li><strong>{{ number_format($stats['tidak_puas_rate'], 1) }}%</strong> pelanggan merasa <strong>Tidak Puas</strong> ({{ number_format($stats['tidak_puas_count']) }} pelanggan)</li>
            </ul>
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis oleh sistem JoyMeter</p>
        <p>{{ now()->translatedFormat('l, d F Y') }} pukul {{ now()->format('H:i') }} WIB</p>
    </div>
</body>
</html>