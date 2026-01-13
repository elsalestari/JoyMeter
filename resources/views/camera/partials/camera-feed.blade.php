<div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
    {{-- Camera Header --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div id="recording-indicator" class="w-3 h-3 rounded-full bg-gray-300" style="display: none;"></div>
            <h3 class="text-lg font-semibold text-gray-900">Camera Feed</h3>
        </div>
        <div id="session-status" class="text-sm text-gray-500">
            Status: <span class="font-medium">Belum Dimulai</span>
        </div>
    </div>

    {{-- Video Container --}}
    <div id="video-container" class="mb-4 relative">
        <video id="video" autoplay muted playsinline 
               class="w-full h-auto rounded-lg shadow-md"></video>
        <canvas id="overlay" class="absolute top-0 left-0"></canvas>
    </div>

    {{-- Instructions --}}
    <div id="instructions" class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-medium mb-1">Panduan Penggunaan:</p>
                <ul class="list-disc list-inside space-y-1 text-xs">
                    <li>Klik "Mulai Sesi" untuk memulai deteksi ekspresi</li>
                    <li>Pastikan wajah pelanggan terlihat jelas dan pencahayaan cukup</li>
                    <li>Sistem akan otomatis mendeteksi dan merekam ekspresi</li>
                    <li>Biarkan merekam minimal 10-15 detik untuk hasil akurat</li>
                    <li>Klik "Selesai Sesi" untuk menyimpan data</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Control Buttons --}}
    <div class="flex gap-3">
        <button id="start-btn" 
                class="flex-1 px-6 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all font-medium shadow-md hover:shadow-lg">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Mulai Sesi</span>
            </div>
        </button>
        <button id="stop-btn" 
                disabled
                class="flex-1 px-6 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg hover:from-red-600 hover:to-red-700 transition-all font-medium shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                </svg>
                <span>Selesai Sesi</span>
            </div>
        </button>
    </div>

    {{-- Loading Status --}}
    <div id="loading-status" class="mt-4 text-center text-sm text-gray-600">
        <div class="flex items-center justify-center gap-2">
            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#F6821F]"></div>
            <span>Memuat model AI...</span>
        </div>
    </div>
</div>