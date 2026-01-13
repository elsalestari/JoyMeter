@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
    @php
        $ranges = config('satisfaction.ranges');
    @endphp

    <!-- Camera Session Button -->
    <div class="bg-gradient-to-r from-[#F7AA4A] via-[#F6821F] to-[#F7AA4A] rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="text-white">
                    <h3 class="text-xl font-bold mb-1">Deteksi Ekspresi Real-Time</h3>
                    <p class="text-sm text-white/90">Mulai sesi kamera untuk menangkap ekspresi pelanggan secara langsung</p>
                </div>
            </div>
            <a href="{{ route('camera.session') }}" 
               class="px-6 py-3 bg-white text-[#F6821F] rounded-lg hover:bg-gray-50 transition-all font-semibold shadow-lg hover:shadow-xl transform hover:scale-105 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Mulai Sesi Kamera
            </a>
        </div>
    </div>

    <!-- Filter Waktu -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <form method="GET" action="{{ route('dashboard') }}" class="flex items-end gap-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Rentang Waktu</label>
                <p class="text-xs text-gray-500 mb-3">Kosongkan untuk menampilkan semua data</p>
                <div class="grid grid-cols-2 gap-4">
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
            <div class="flex flex-col gap-2">
                <button type="submit" class="px-6 py-2 bg-[#F7AA4A] text-white rounded-md hover:bg-[#F6821F] transition-colors text-sm font-medium">
                    Terapkan Filter
                </button>
                @if($startDate || $endDate)
                <a href="{{ route('dashboard') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors text-sm font-medium text-center">
                    Tampilkan Semua
                </a>
                @endif
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

    <!-- Ringkasan Data Penting -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Pelanggan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total_customers']) }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Persentase Senang -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Tingkat Kepuasan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['senang_rate'], 1) }}%</p>
                    <p class="text-xs text-gray-500 mt-1">Pelanggan Senang</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pelanggan Hari Ini -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Pelanggan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['customers_today'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kategori Terbanyak -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Ekspresi Dominan</p>
                    <p class="text-xl font-bold text-gray-900">{{ $dominantExpression['emotion_label'] ?? '-' }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ $dominantExpression['percentage'] ?? 0 }}% ({{ $dominantExpression['count'] ?? 0 }} pelanggan)</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center text-2xl">
                    {{ $dominantExpression['emotion_emoji'] ?? '😐' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Kategori Kepuasan (HANYA 3 KATEGORI) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Senang -->
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow-sm border border-green-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-green-900">Senang</h3>
                <div class="text-3xl">😊</div>
            </div>
            <div class="space-y-2">
                <div class="flex justify-between items-center">
                    <span class="text-sm text-green-700">Total</span>
                    <span class="text-2xl font-bold text-green-900">{{ number_format($stats['senang_count']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-green-700">Persentase</span>
                    <span class="text-xl font-semibold text-green-900">{{ number_format($stats['senang_rate'], 1) }}%</span>
                </div>
            </div>
            <div class="mt-4 text-xs text-green-600 bg-green-50 rounded p-2">
                <div class="font-medium mb-1">📊 Satisfaction Score: ≥ {{ $ranges['senang']['min'] }}</div>
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
                    <span class="text-sm text-yellow-700">Total</span>
                    <span class="text-2xl font-bold text-yellow-900">{{ number_format($stats['netral_count']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-yellow-700">Persentase</span>
                    <span class="text-xl font-semibold text-yellow-900">{{ number_format($stats['netral_rate'], 1) }}%</span>
                </div>
            </div>
            <div class="mt-4 text-xs text-yellow-600 bg-yellow-50 rounded p-2">
                <div class="font-medium mb-1">📊 Satisfaction Score: {{ $ranges['netral']['min'] }} - {{ $ranges['netral']['max'] }}</div>
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
                    <span class="text-sm text-red-700">Total</span>
                    <span class="text-2xl font-bold text-red-900">{{ number_format($stats['tidak_puas_count']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-red-700">Persentase</span>
                    <span class="text-xl font-semibold text-red-900">{{ number_format($stats['tidak_puas_rate'], 1) }}%</span>
                </div>
            </div>
            <div class="mt-4 text-xs text-red-600 bg-red-50 rounded p-2">
                <div class="font-medium mb-1">📊 Satisfaction Score: < {{ $ranges['netral']['min'] }}</div>
            </div>
        </div>
    </div>

    <!-- Grafik -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Grafik Tren Kepuasan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-5">
            <h3 class="text-base font-semibold text-gray-900 mb-3">Tren Kepuasan</h3>
            @if(empty($satisfactionData['labels']))
            <div class="h-64 flex items-center justify-center text-gray-400">
                <div class="text-center">
                    <svg class="w-12 h-12 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    <p class="text-sm">Belum ada data untuk ditampilkan</p>
                    <a href="{{ route('camera.session') }}" class="text-xs text-[#F6821F] hover:underline mt-2 inline-block">
                        Mulai Sesi Kamera →
                    </a>
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
                    <a href="{{ route('camera.session') }}" class="text-xs text-[#F6821F] hover:underline mt-2 inline-block">
                        Mulai Sesi Kamera →
                    </a>
                </div>
            </div>
            @else
            <div class="h-64">
                <canvas id="categoryDistributionChart"></canvas>
            </div>
            @endif
        </div>
    </div>

    <!-- Tabel Riwayat Kepuasan Pelanggan per Bulan -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Riwayat Kepuasan Pelanggan per Bulan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pelanggan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Senang</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Netral</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tidak Puas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Kepuasan</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($monthlyHistory as $month)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-gray-900">{{ $month['month'] }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($month['total']) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ number_format($month['senang']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                {{ number_format($month['netral']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                {{ number_format($month['tidak_puas']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-sm font-bold text-gray-900">{{ number_format($month['senang_rate'], 1) }}%</span>
                                <span class="text-xs text-gray-500">Pelanggan Senang</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('customer-satisfaction.index', ['start_date' => $month['start_date'], 'end_date' => $month['end_date']]) }}"
                               class="inline-flex items-center px-3 py-1.5 border border-[#F7AA4A] text-xs font-medium rounded-full text-[#F7AA4A] bg-white hover:bg-[#FAEF9F]">
                                Lihat
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm mb-2">Belum ada riwayat kepuasan pelanggan</p>
                                <a href="{{ route('camera.session') }}" class="text-sm text-[#F6821F] hover:underline">
                                    Mulai Sesi Kamera untuk merekam data →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel Aktivitas Karyawan -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">Aktivitas Karyawan</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aktivitas Terakhir</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($staffActivities as $staff)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F7AA4A] to-[#F6821F] flex items-center justify-center text-white font-semibold mr-3">
                                    {{ strtoupper(substr($staff->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $staff->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $staff->email }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $staff->role_badge_classes }}">
                                {{ $staff->role_display_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $staff->updated_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada data karyawan
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