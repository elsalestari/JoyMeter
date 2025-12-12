@extends('layouts.app')

@section('title', 'Pusat Bantuan')
@section('page-title', 'Pusat Bantuan & Support')

@section('content')
    <!-- Welcome Banner Staff -->
    <div class="bg-gradient-to-r from-[#F7AA4A] to-[#F6821F] rounded-lg shadow-lg p-8 mb-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Selamat Datang di Pusat Support! 👋</h2>
                <p class="text-sm opacity-90">Laporkan masalah, dapatkan bantuan, atau temukan solusi dari panduan kami</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-24 h-24 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-2 0c0 .993-.241 1.929-.668 2.754l-1.524-1.525a3.997 3.997 0 00.078-2.183l1.562-1.562C17.802 8.249 18 9.1 18 10zm-5.165 3.913l1.58 1.58A5.98 5.98 0 0110 16a5.976 5.976 0 01-4.374-1.915l1.615-1.615a3.981 3.981 0 001.759.401 3.98 3.98 0 002.835-1.158zm-3.67-3.67a3.982 3.982 0 01-.9-1.905L5.737 5.81a5.98 5.98 0 00-.872 1.545l1.562 1.562c.236-.635.62-1.224 1.12-1.724z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics - Staff View -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Total Tiket Anda</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</p>
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
                    <p class="text-sm text-gray-500 mb-1">Menunggu Respon</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['open'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 mb-1">Dalam Proses</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['in_progress'] }}</p>
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
                    <p class="text-2xl font-bold text-green-600">{{ $stats['resolved'] }}</p>
                </div>
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions - Staff View -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Buat Tiket (Primary Action) -->
        <a href="{{ route('support.tickets.create') }}" class="bg-gradient-to-br from-[#F7AA4A] to-[#F6821F] rounded-lg shadow-sm p-6 hover:shadow-md transition-shadow text-white">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-white bg-opacity-20 flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold">Laporkan Masalah</h3>
                    <p class="text-sm opacity-90">Buat Tiket Baru</p>
                </div>
            </div>
            <p class="text-sm opacity-90">Laporkan bug, error, atau minta bantuan dari tim support</p>
        </a>

        <!-- FAQ -->
        <a href="{{ route('support.faq') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">FAQ</h3>
                    <p class="text-sm text-gray-500">Pertanyaan Umum</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
        </a>

        <!-- Panduan -->
        <a href="{{ route('support.guides') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Panduan</h3>
                    <p class="text-sm text-gray-500">Tutorial Lengkap</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Pelajari cara menggunakan sistem dengan panduan lengkap</p>
        </a>

        <!-- Troubleshooting -->
        <a href="{{ route('support.troubleshooting') }}" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center mb-4">
                <div class="w-12 h-12 rounded-lg bg-orange-100 flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900">Troubleshooting</h3>
                    <p class="text-sm text-gray-500">Pemecahan Masalah</p>
                </div>
            </div>
            <p class="text-sm text-gray-600">Solusi untuk masalah umum yang sering terjadi</p>
        </a>
    </div>

    <!-- My Recent Tickets -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Tiket Support Anda</h3>
                <p class="text-sm text-gray-500 mt-1">Pantau status laporan masalah Anda</p>
            </div>
            <a href="{{ route('support.tickets.index') }}" class="text-sm text-[#F7AA4A] hover:text-[#F6821F] font-medium">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No. Tiket</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subjek</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Prioritas</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Dibuat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-gray-900">{{ $ticket->ticket_number }}</span>
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
                            <div class="text-xs text-gray-500">{{ $ticket->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="{{ route('support.tickets.show', $ticket) }}" 
                               class="text-[#F7AA4A] hover:text-[#F6821F] transition-colors">
                                <svg class="w-5 h-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center text-gray-400">
                                <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="text-sm mb-3">Belum ada tiket support</p>
                                <a href="{{ route('support.tickets.create') }}" 
                                   class="text-[#F7AA4A] hover:text-[#F6821F] text-sm font-medium">
                                    Buat Tiket Pertama Anda →
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Help Resources Banner -->
    <div class="mt-6 bg-gradient-to-r from-blue-50 to-purple-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-8 h-8 text-blue-600 mr-4 flex-shrink-0 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
            </svg>
            <div>
                <h4 class="font-semibold text-gray-900 mb-2">💡 Tips: Coba Selesaikan Masalah Sendiri Dulu!</h4>
                <p class="text-sm text-gray-700 mb-3">
                    Sebelum membuat tiket, coba cek <a href="{{ route('support.faq') }}" class="text-blue-600 hover:text-blue-800 font-medium">FAQ</a> atau 
                    <a href="{{ route('support.troubleshooting') }}" class="text-blue-600 hover:text-blue-800 font-medium">Troubleshooting</a> terlebih dahulu. 
                    Mungkin solusinya sudah tersedia!
                </p>
                <p class="text-xs text-gray-600">
                    Jika masalah masih belum teratasi, jangan ragu untuk membuat tiket support. Tim kami siap membantu! 🚀
                </p>
            </div>
        </div>
    </div>
@endsection