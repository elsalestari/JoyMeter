@extends('layouts.app')

@section('title', 'Kepuasan Pelanggan')
@section('page-title', 'Kepuasan Pelanggan')

@section('content')
    <!-- Filter Waktu & Export -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('customer-satisfaction.index') }}" class="flex flex-col md:flex-row md:items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Waktu</label>
                <p class="text-xs text-gray-500 mb-3">Kosongkan untuk menampilkan semua data</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ $startDate ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#F7AA4A]">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Tanggal Akhir</label>
                        <input type="date" name="end_date" value="{{ $endDate ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#F7AA4A]">
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-2 md:w-56">
                <button type="submit" class="px-6 py-2 bg-[#F7AA4A] text-white rounded-md hover:bg-[#F6821F] transition-colors text-sm font-medium w-full">
                    Terapkan Filter
                </button>
                @if($startDate || $endDate)
                <a href="{{ route('customer-satisfaction.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium text-center">
                    Tampilkan Semua
                </a>
                @endif
                <a href="{{ route('customer-satisfaction.export-pdf', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="px-6 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition-colors text-sm font-medium text-center">
                    Export PDF
                </a>
            </div>
        </form>

        @if(!$startDate && !$endDate)
        <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
            <p class="text-sm text-blue-800">
                <span class="font-medium">Menampilkan semua data</span> - Gunakan filter di atas untuk membatasi rentang waktu
            </p>
        </div>
        @endif
    </div>

    <!-- Ringkasan Kategori Kepuasan -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Senang -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-sm border border-green-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-green-900">Senang</h3>
                <div class="text-3xl">😊</div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-green-700">Total Pelanggan</span>
                    <span class="text-2xl font-bold text-green-900">{{ number_format($stats['senang_count']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-green-700">Persentase</span>
                    <span class="text-xl font-semibold text-green-900">{{ number_format($stats['senang_rate'], 1) }}%</span>
                </div>
            </div>
        </div>

        <!-- Netral -->
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg shadow-sm border border-yellow-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-yellow-900">Netral</h3>
                <div class="text-3xl">😐</div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-yellow-700">Total Pelanggan</span>
                    <span class="text-2xl font-bold text-yellow-900">{{ number_format($stats['netral_count']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-yellow-700">Persentase</span>
                    <span class="text-xl font-semibold text-yellow-900">{{ number_format($stats['netral_rate'], 1) }}%</span>
                </div>
            </div>
        </div>

        <!-- Tidak Puas -->
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-lg shadow-sm border border-red-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-red-900">Tidak Puas</h3>
                <div class="text-3xl">😞</div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-red-700">Total Pelanggan</span>
                    <span class="text-2xl font-bold text-red-900">{{ number_format($stats['tidak_puas_count']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-red-700">Persentase</span>
                    <span class="text-xl font-semibold text-red-900">{{ number_format($stats['tidak_puas_rate'], 1) }}%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Grafik Kepuasan -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Grafik Tren Kepuasan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Tren Kepuasan Pelanggan</h3>
            @if(empty($satisfactionData['labels']))
            <div class="h-64 flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-sm">Belum ada data untuk ditampilkan</p>
                </div>
            </div>
            @else
            <div class="h-64">
                <canvas id="satisfactionTrendChart"></canvas>
            </div>
            @endif
        </div>

        <!-- Grafik Distribusi Kategori -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Distribusi Kategori Kepuasan</h3>
            @if($stats['total_customers'] == 0)
            <div class="h-64 flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
                    <p class="text-sm">Belum ada data untuk ditampilkan</p>
                </div>
            </div>
            @else
            <div class="h-64">
                <canvas id="categoryDistributionChart"></canvas>
            </div>
            @endif
        </div>
    </div>

    <!-- Tabel Riwayat Kepuasan per Hari (maksimal 20 hari terakhir) -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Kepuasan Pelanggan per Hari</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pelanggan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Senang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Netral</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Puas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Kepuasan</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($dailyHistory as $day)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $day['date'] }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($day['total']) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ number_format($day['senang']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ number_format($day['netral']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                {{ number_format($day['tidak_puas']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-bold text-gray-900">{{ number_format($day['senang_rate'], 1) }}%</span>
                                <span class="text-xs text-gray-500">Pelanggan Senang</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm">Belum ada data kepuasan pelanggan dari rekaman kamera</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    @if(!empty($satisfactionData['labels']))
    // Grafik Tren Kepuasan (Persentase Senang)
    const trendCtx = document.getElementById('satisfactionTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: @json($satisfactionData['labels']),
            datasets: [{
                label: 'Persentase Pelanggan Senang',
                data: @json($satisfactionData['senang_rates']),
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    padding: 12,
                    titleFont: { size: 14 },
                    bodyFont: { size: 13 },
                    callbacks: {
                        label: function(context) {
                            return 'Pelanggan Senang: ' + context.parsed.y + '%';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        stepSize: 10,
                        font: { size: 11 },
                        callback: function(value) { return value + '%'; }
                    },
                    grid: { color: 'rgba(0, 0, 0, 0.05)' }
                },
                x: {
                    ticks: { font: { size: 11 } },
                    grid: { display: false }
                }
            }
        }
    });
    @endif

    @if($stats['total_customers'] > 0)
    // Grafik Distribusi Kategori
    const categoryCtx = document.getElementById('categoryDistributionChart').getContext('2d');
    new Chart(categoryCtx, {
        type: 'doughnut',
        data: {
            labels: @json($categoryDistribution['labels']),
            datasets: [{
                data: @json($categoryDistribution['data']),
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 15,
                        usePointStyle: true,
                        font: { size: 12 }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) { return context.label + ': ' + context.parsed + '%'; }
                    }
                }
            }
        }
    });
    @endif
</script>
@endpush