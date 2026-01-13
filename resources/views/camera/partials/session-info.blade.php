<div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Info Sesi</h3>
    
    <div class="space-y-3 text-sm">
        {{-- Session ID --}}
        <div class="flex justify-between items-start">
            <span class="text-gray-600">Session ID:</span>
            <span id="session-id-display" 
                  class="font-mono text-xs text-gray-900 text-right ml-2 break-all">
                {{ $sessionId ?? '-' }}
            </span>
        </div>

        {{-- Duration --}}
        <div class="flex justify-between">
            <span class="text-gray-600">Durasi:</span>
            <span id="duration-display" class="font-semibold text-gray-900">00:00</span>
        </div>

        {{-- Face Detection Status --}}
        <div class="flex justify-between">
            <span class="text-gray-600">Face Detected:</span>
            <span id="face-status" class="font-semibold text-red-600">Tidak</span>
        </div>

        {{-- Operator Info --}}
        <div class="flex justify-between">
            <span class="text-gray-600">Operator:</span>
            <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
        </div>

        {{-- Department/Role --}}
        <div class="flex justify-between items-center">
            <span class="text-gray-600">Role:</span>
            <span class="px-2 py-0.5 text-xs rounded-full {{ auth()->user()->role_badge_classes }} flex items-center gap-1">
                <span>{{ auth()->user()->role_emoji }}</span>
                <span>{{ auth()->user()->role_display_name }}</span>
            </span>
        </div>

        {{-- Timestamp --}}
        <div class="flex justify-between">
            <span class="text-gray-600">Waktu:</span>
            <span class="text-xs text-gray-900">{{ now()->format('d M Y, H:i') }}</span>
        </div>
    </div>

    {{-- Session Statistics (Optional) --}}
    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="text-xs text-gray-500 space-y-1">
            <div class="flex justify-between">
                <span>Sesi Hari Ini:</span>
                <span id="sessions-today" class="font-medium text-gray-700">-</span>
            </div>
            <div class="flex justify-between">
                <span>Rata-rata Kepuasan:</span>
                <span id="avg-satisfaction" class="font-medium text-gray-700">-</span>
            </div>
        </div>
    </div>
</div>