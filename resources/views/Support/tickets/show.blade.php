@extends('layouts.app')

@section('title', 'Detail Tiket #' . $ticket->ticket_number)
@section('page-title', 'Detail Tiket Support')

@section('content')
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('support.tickets.index') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-[#F6821F] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Tiket
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Info -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $ticket->subject }}</h3>
                        <div class="flex items-center gap-3 text-sm text-gray-500">
                            <span class="font-mono">{{ $ticket->ticket_number }}</span>
                            <span>•</span>
                            <span>{{ $ticket->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                    </div>
                    <div class="flex flex-col gap-2 items-end">
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status_badge }}">
                            {{ $ticket->status_label }}
                        </span>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->priority_badge }}">
                            {{ $ticket->priority_label }}
                        </span>
                    </div>
                </div>

                <div class="prose max-w-none">
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F7AA4A] to-[#F6821F] flex items-center justify-center text-white font-semibold mr-3">
                                {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-medium text-gray-900">{{ $ticket->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $ticket->user->email }}</div>
                            </div>
                        </div>
                        <div class="text-gray-700 whitespace-pre-wrap">{{ $ticket->description }}</div>
                    </div>

                    @if($ticket->admin_reply)
                    <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                        <div class="flex items-start mb-4">
                            <div class="w-10 h-10 rounded-full bg-green-500 flex items-center justify-center text-white mr-3">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center justify-between mb-2">
                                    <div>
                                        <div class="font-medium text-green-900">
                                            {{ $ticket->admin->name ?? 'Admin' }}
                                            <span class="ml-2 px-2 py-0.5 text-xs bg-green-600 text-white rounded-full">Support Team</span>
                                        </div>
                                        <div class="text-sm text-green-700">{{ $ticket->replied_at->format('d M Y, H:i') }} WIB</div>
                                    </div>
                                </div>
                                <div class="text-gray-700 whitespace-pre-wrap">{{ $ticket->admin_reply }}</div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 text-center">
                        <svg class="w-12 h-12 text-yellow-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-sm text-yellow-800 font-medium">Menunggu Respon dari Tim Support</p>
                        <p class="text-xs text-yellow-700 mt-1">Tim kami akan segera merespon tiket Anda dalam 1x24 jam</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Admin Reply Form (Admin Only) -->
            @if(auth()->user()->role === 'admin' && !$ticket->admin_reply)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-lg font-semibold text-gray-900 mb-4">Balas Tiket</h4>
                <form method="POST" action="{{ route('support.tickets.reply', $ticket) }}">
                    @csrf
                    <div class="mb-4">
                        <textarea name="admin_reply" 
                                  rows="6"
                                  required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('admin_reply') border-red-300 @enderror"
                                  placeholder="Tulis balasan Anda untuk user...">{{ old('admin_reply') }}</textarea>
                        @error('admin_reply')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors font-medium">
                        Kirim Balasan
                    </button>
                </form>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Ticket Details -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase mb-4">Informasi Tiket</h4>
                <div class="space-y-4">
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Kategori</div>
                        <div class="text-sm font-medium text-gray-900">{{ $ticket->category_label }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Prioritas</div>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->priority_badge }}">
                            {{ $ticket->priority_label }}
                        </span>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $ticket->status_badge }}">
                            {{ $ticket->status_label }}
                        </span>
                    </div>
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Dibuat</div>
                        <div class="text-sm text-gray-900">{{ $ticket->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->created_at->format('H:i') }} WIB ({{ $ticket->created_at->diffForHumans() }})</div>
                    </div>
                    @if($ticket->replied_at)
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Direspon</div>
                        <div class="text-sm text-gray-900">{{ $ticket->replied_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->replied_at->format('H:i') }} WIB</div>
                    </div>
                    @endif
                    @if($ticket->closed_at)
                    <div>
                        <div class="text-xs text-gray-500 mb-1">Ditutup</div>
                        <div class="text-sm text-gray-900">{{ $ticket->closed_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $ticket->closed_at->format('H:i') }} WIB</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Change Status (Admin Only) -->
            @if(auth()->user()->role === 'admin')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase mb-4">Ubah Status</h4>
                <form method="POST" action="{{ route('support.tickets.update-status', $ticket) }}">
                    @csrf
                    @method('PATCH')
                    <select name="status" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] mb-3">
                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Terbuka</option>
                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Dalam Proses</option>
                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Terselesaikan</option>
                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Ditutup</option>
                    </select>
                    <button type="submit" 
                            class="w-full px-4 py-2 bg-[#F7AA4A] text-white rounded-md hover:bg-[#F6821F] transition-colors text-sm font-medium">
                        Update Status
                    </button>
                </form>
            </div>
            @endif

            <!-- User Info (Admin Only) -->
            @if(auth()->user()->role === 'admin')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h4 class="text-sm font-semibold text-gray-900 uppercase mb-4">Informasi Pengguna</h4>
                <div class="flex items-center mb-3">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-[#F7AA4A] to-[#F6821F] flex items-center justify-center text-white font-semibold mr-3">
                        {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">{{ $ticket->user->name }}</div>
                        <div class="text-xs text-gray-500 capitalize">{{ $ticket->user->role }}</div>
                    </div>
                </div>
                <div class="text-sm text-gray-600">
                    <div class="flex items-center mb-2">
                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $ticket->user->email }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Help Links -->
            <div class="bg-gradient-to-br from-blue-50 to-purple-50 rounded-lg border border-blue-200 p-6">
                <h4 class="text-sm font-semibold text-gray-900 mb-3">Butuh Bantuan Lain?</h4>
                <div class="space-y-2">
                    <a href="{{ route('support.faq') }}" class="block text-sm text-blue-600 hover:text-blue-800">
                        → Lihat FAQ
                    </a>
                    <a href="{{ route('support.guides') }}" class="block text-sm text-blue-600 hover:text-blue-800">
                        → Panduan Penggunaan
                    </a>
                    <a href="{{ route('support.troubleshooting') }}" class="block text-sm text-blue-600 hover:text-blue-800">
                        → Troubleshooting
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection