@extends('layouts.app')

@section('title', 'Admin Support Center')
@section('page-title', 'Pusat Manajemen Support')

@section('content')
    <!-- Welcome Banner Admin -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-700 rounded-lg shadow-lg p-8 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">👨‍💼 Admin Support Center</h2>
                <p class="text-sm opacity-90">Kelola semua tiket support dari karyawan dan pastikan masalah mereka terselesaikan dengan cepat</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-20 h-20 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 3.5a1.5 1.5 0 013 0V4a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-.5a1.5 1.5 0 000 3h.5a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-.5a1.5 1.5 0 00-3 0v.5a1 1 0 01-1 1H6a1 1 0 01-1-1v-3a1 1 0 00-1-1h-.5a1.5 1.5 0 010-3H4a1 1 0 001-1V6a1 1 0 011-1h3a1 1 0 001-1v-.5z"/>
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics - Admin View -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Tiket</p>
                    <p class="text-3xl font-bold text-gray-900">{{ $stats['total'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Dari semua karyawan</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Perlu Ditangani</p>
                    <p class="text-3xl font-bold text-orange-600">{{ $stats['open'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Status: Terbuka</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Dalam Proses</p>
                    <p class="text-3xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Sedang dikerjakan</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Terselesaikan</p>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
                    <p class="text-xs text-gray-500 mt-1">Masalah selesai</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Admin Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Tiket Terbuka (Priority Action) -->
        <a href="{{ route('support.tickets.index', ['status' => 'open']) }}" class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow text-white">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 rounded-lg bg-white bg-opacity-20 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Tiket Terbuka</h3>
                    <p class="text-2xl font-bold">{{ $stats['open'] }}</p>
                </div>
            </div>
            <p class="text-sm opacity-90">Tangani tiket yang perlu respon</p>
        </a>

        <!-- Semua Tiket -->
        <a href="{{ route('support.tickets.index') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Semua Tiket</h3>
                    <p class="text-sm text-gray-500">Kelola & Monitor</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Lihat riwayat lengkap tiket support</p>
        </a>

        <!-- Knowledge Base -->
        <a href="{{ route('support.guides') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Knowledge Base</h3>
                    <p class="text-sm text-gray-500">Panduan & FAQ</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Akses dokumentasi lengkap</p>
        </a>

        <!-- Troubleshooting -->
        <a href="{{ route('support.troubleshooting') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-3">
                <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Troubleshooting</h3>
                    <p class="text-sm text-gray-500">Solusi Masalah</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Referensi pemecahan masalah</p>
        </a>
    </div>

    <!-- Recent Tickets from Staff -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Tiket Terbaru dari Karyawan</h3>
                <p class="text-sm text-gray-500 mt-1">Monitor dan tanggapi laporan masalah</p>
            </div>
            <a href="{{ route('support.tickets.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua Tiket →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tiket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Karyawan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Masalah</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Waktu</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ $ticket->ticket_number }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white text-xs font-semibold mr-2">
                                    {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $ticket->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $ticket->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ Str::limit($ticket->subject, 40) }}</div>
                            <div class="text-xs text-gray-500">{{ $ticket->category_label }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->priority_badge }}">
                                {{ $ticket->priority_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status_badge }}">
                                {{ $ticket->status_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $ticket->created_at->format('d M Y') }}</div>
                            <div class="text-xs text-gray-500">{{ $ticket->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('support.tickets.show', $ticket) }}" 
                               class="inline-flex items-center px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-md hover:bg-blue-700 transition-colors">
                                Tangani
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
                                <p class="text-sm">Belum ada tiket dari karyawan</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection