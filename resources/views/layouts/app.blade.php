<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | JoyMeter</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-6 border-b border-gray-200">
                <h1 class="text-2xl font-bold text-[#F7AA4A]">JoyMeter</h1>
                <p class="text-sm text-gray-500 mt-1">Customer Satisfaction</p>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#FAEF9F] hover:text-[#F7AA4A] transition-colors {{ request()->routeIs('dashboard') ? 'bg-[#FAEF9F] text-[#F7AA4A] font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('customer-satisfaction.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#FAEF9F] hover:text-[#F7AA4A] transition-colors {{ request()->routeIs('customer-satisfaction.*') ? 'bg-[#FAEF9F] text-[#F7AA4A] font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Kepuasan Pelanggan
                </a>
                <a href="{{ route('staff.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#FAEF9F] hover:text-[#F7AA4A] transition-colors {{ request()->routeIs('staff.*') ? 'bg-[#FAEF9F] text-[#F7AA4A] font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Karyawan
                </a>
                <a href="{{ route('support.index') }}" class="flex items-center px-4 py-3 text-gray-700 rounded-lg hover:bg-[#FAEF9F] hover:text-[#F7AA4A] transition-colors {{ request()->routeIs('support.*') ? 'bg-[#FAEF9F] text-[#F7AA4A] font-medium' : '' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Support
                    @php
                        $userTickets = \App\Models\SupportTicket::where('user_id', auth()->id())
                            ->where('status', 'open')
                            ->count();
                    @endphp
                    @if($userTickets > 0)
                    <span class="ml-auto px-2 py-0.5 text-xs bg-red-500 text-white rounded-full">{{ $userTickets }}</span>
                    @endif
                </a>
            </nav>

            <!-- User Info -->
            <div class="p-4 border-t border-gray-200">
                <div class="flex items-center mb-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#F7AA4A] to-[#F6821F] flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-xs text-gray-500 capitalize">{{ auth()->user()->role }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full px-4 py-2 text-sm text-gray-700 rounded-lg hover:bg-gray-100 transition-colors flex items-center justify-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white border-b border-gray-200 px-6 py-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-semibold text-gray-900">@yield('page-title', 'Dashboard')</h2>
                    <div class="text-sm text-gray-500">
                        {{ now()->translatedFormat('l, d F Y - H:i') }} WIB
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start animate-fade-in">
                    <svg class="w-5 h-5 text-green-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-green-600 hover:text-green-800 ml-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg flex items-start animate-fade-in">
                    <svg class="w-5 h-5 text-red-600 mr-3 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                    <button onclick="this.parentElement.remove()" class="text-red-600 hover:text-red-800 ml-3">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
    
    <script>
        // Auto-hide flash messages after 5 seconds
        document.addEventListener('DOMContentLoaded', () => {
            const messages = document.querySelectorAll('.animate-fade-in');
            messages.forEach(msg => {
                setTimeout(() => {
                    msg.style.transition = 'opacity 0.5s ease-out';
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }, 5000);
            });
        });
    </script>
</body>
</html>