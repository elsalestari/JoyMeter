@extends('layouts.app')

@section('title', 'Profil Saya')
@section('page-title', 'Profil Saya')

@section('content')
    <div class="max-w-4xl mx-auto">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-[#F7AA4A] to-[#F6821F] rounded-lg shadow-sm p-8 mb-6 text-white">
            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white font-bold text-3xl border-4 border-white/30">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <h2 class="text-2xl font-bold mb-2">{{ $user->name }}</h2>
                    <p class="text-white/90 mb-3">{{ $user->email }}</p>
                    <div class="flex items-center gap-3">
                        <span class="px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm font-medium flex items-center gap-1">
                            <span>{{ $user->role_emoji }}</span>
                            <span>{{ $user->role_display_name }}</span>
                        </span>
                        <span class="text-sm text-white/80">
                            Bergabung {{ $user->created_at->diffForHumans() }}
                        </span>
                    </div>
                </div>
                <div>
                    <a href="{{ route('profile.edit') }}" 
                       class="inline-flex items-center px-4 py-2 bg-white text-[#F6821F] rounded-lg hover:bg-white/90 transition-colors font-medium">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Profil
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Aktivitas Terakhir -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Aktivitas Terakhir</h3>
                    <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-bold text-gray-900">{{ $stats['last_login']->diffForHumans() }}</p>
                <p class="text-sm text-gray-500 mt-1">{{ $stats['last_login']->format('d M Y, H:i') }}</p>
            </div>

            <!-- Tiket Support atau Status Akun -->
            @if($user->isStaff())
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Tiket Terbuka</h3>
                    <div class="w-10 h-10 rounded-lg bg-orange-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $stats['open_tickets'] ?? 0 }}</p>
                <a href="{{ route('support.tickets.index') }}" class="text-sm text-[#F6821F] hover:underline mt-1 inline-block">Lihat Tiket →</a>
            </div>
            @else
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-gray-500">Status Akun</h3>
                    <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                </div>
                <p class="text-lg font-bold text-green-600">Aktif</p>
                <p class="text-sm text-gray-500 mt-1">Administrator</p>
            </div>
            @endif
        </div>

        <!-- Informasi Detail -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Akun -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Informasi Akun
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama Lengkap</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Peran</label>
                        <p class="text-base text-gray-900 mt-1">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->role_badge_classes }} gap-1">
                                <span>{{ $user->role_emoji }}</span>
                                <span>{{ $user->role_display_name }}</span>
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Riwayat Akun -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Riwayat Akun
                </h3>
                <div class="space-y-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Akun Dibuat</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Terakhir Diperbarui</label>
                        <p class="text-base text-gray-900 mt-1">{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                        <p class="text-xs text-gray-500 mt-1">{{ $user->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">ID Pengguna</label>
                        <p class="text-base text-gray-900 mt-1 font-mono">#{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('profile.edit') }}" 
                   class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#F7AA4A] hover:bg-[#FAEF9F]/20 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-[#FAEF9F] flex items-center justify-center group-hover:bg-[#F7AA4A] transition-colors">
                        <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Edit Profil</p>
                        <p class="text-xs text-gray-500">Ubah informasi akun</p>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}#change-password" 
                   class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#F7AA4A] hover:bg-[#FAEF9F]/20 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-[#FAEF9F] flex items-center justify-center group-hover:bg-[#F7AA4A] transition-colors">
                        <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Ubah Password</p>
                        <p class="text-xs text-gray-500">Perbarui kata sandi</p>
                    </div>
                </a>

                <a href="{{ route('dashboard') }}" 
                   class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:border-[#F7AA4A] hover:bg-[#FAEF9F]/20 transition-all group">
                    <div class="w-10 h-10 rounded-lg bg-[#FAEF9F] flex items-center justify-center group-hover:bg-[#F7AA4A] transition-colors">
                        <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">Ke Dashboard</p>
                        <p class="text-xs text-gray-500">Kembali ke halaman utama</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection