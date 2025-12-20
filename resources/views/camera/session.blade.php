@extends('layouts.app')

@section('title', 'Sesi Kamera - Deteksi Ekspresi')
@section('page-title', 'Deteksi Ekspresi Pelanggan')

@push('styles')
<style>
    #video-container {
        position: relative;
        width: 100%;
        max-width: 640px;
        margin: 0 auto;
    }
    
    #video {
        width: 100%;
        height: auto;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    canvas {
        position: absolute;
        top: 0;
        left: 0;
    }
    
    .expression-bar {
        height: 8px;
        border-radius: 4px;
        transition: width 0.3s ease;
    }
    
    .pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
    
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: .5; }
    }
    
    .recording-indicator {
        animation: recording-pulse 1.5s ease-in-out infinite;
    }
    
    @keyframes recording-pulse {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.1); opacity: 0.8; }
    }
</style>
@endpush

@section('content')
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-[#F6821F] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Camera Feed - Left Side -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
                <!-- Camera Controls -->
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div id="recording-indicator" class="w-3 h-3 rounded-full bg-gray-300" style="display: none;"></div>
                        <h3 class="text-lg font-semibold text-gray-900">Camera Feed</h3>
                    </div>
                    <div id="session-status" class="text-sm text-gray-500">
                        Status: <span class="font-medium">Belum Dimulai</span>
                    </div>
                </div>

                <!-- Video Container -->
                <div id="video-container" class="mb-4">
                    <video id="video" autoplay muted playsinline></video>
                    <canvas id="overlay"></canvas>
                </div>

                <!-- Camera Instructions -->
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

                <!-- Control Buttons -->
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

                <!-- Loading Status -->
                <div id="loading-status" class="mt-4 text-center text-sm text-gray-600">
                    <div class="flex items-center justify-center gap-2">
                        <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#F6821F]"></div>
                        <span>Memuat model AI...</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Data - Right Side -->
        <div class="lg:col-span-1">
            <!-- Current Expression -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Ekspresi Terdeteksi</h3>
                
                <!-- Expression Bars -->
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>😊 Happy</span>
                            <span id="happy-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="happy-bar" class="expression-bar bg-green-500" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>😐 Neutral</span>
                            <span id="neutral-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="neutral-bar" class="expression-bar bg-gray-500" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>😢 Sad</span>
                            <span id="sad-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="sad-bar" class="expression-bar bg-blue-500" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>😠 Angry</span>
                            <span id="angry-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="angry-bar" class="expression-bar bg-red-500" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>😲 Surprised</span>
                            <span id="surprised-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="surprised-bar" class="expression-bar bg-yellow-500" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>😨 Fearful</span>
                            <span id="fearful-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="fearful-bar" class="expression-bar bg-purple-500" style="width: 0%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs text-gray-600 mb-1">
                            <span>🤢 Disgusted</span>
                            <span id="disgusted-percent">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div id="disgusted-bar" class="expression-bar bg-pink-500" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Session Info -->
            <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Info Sesi</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Session ID:</span>
                        <span id="session-id-display" class="font-mono text-xs text-gray-900">-</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Durasi:</span>
                        <span id="duration-display" class="font-semibold text-gray-900">00:00</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Face Detected:</span>
                        <span id="face-status" class="font-semibold text-red-600">Tidak</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Operator:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<!-- Face-api.js Library -->
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', async () => {
    const video = document.getElementById('video');
    const canvas = document.getElementById('overlay');
    const startBtn = document.getElementById('start-btn');
    const stopBtn = document.getElementById('stop-btn');
    const loadingStatus = document.getElementById('loading-status');
    const recordingIndicator = document.getElementById('recording-indicator');
    const sessionStatus = document.getElementById('session-status');
    
    let sessionId = null;
    let sessionStartTime = null;
    let isRecording = false;
    let detectionInterval = null;
    let durationInterval = null;
    let accumulatedExpressions = {
        happy: [], sad: [], angry: [], surprised: [],
        neutral: [], fearful: [], disgusted: []
    };

    async function loadModels() {
        const MODEL_URL = 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model/';
        
        try {
            loadingStatus.innerHTML = '<div class="flex items-center justify-center gap-2"><div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#F6821F]"></div><span>Memuat model AI...</span></div>';
            
            await faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URL);
            await faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URL);
            
            loadingStatus.innerHTML = '<div class="text-green-600 font-medium">✓ Model AI siap digunakan</div>';
            setTimeout(() => loadingStatus.style.display = 'none', 2000);
            
            console.log('✓ Face-api.js models loaded');
        } catch (error) {
            console.error('Error loading models:', error);
            loadingStatus.innerHTML = '<div class="text-red-600">✗ Gagal memuat model AI</div>';
        }
    }

    async function startCamera() {
        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: { 
                    width: { ideal: 640 },
                    height: { ideal: 480 }
                } 
            });
            video.srcObject = stream;
            
            video.addEventListener('loadedmetadata', () => {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
            });
            
            console.log('✓ Camera started');
        } catch (error) {
            console.error('Error accessing camera:', error);
            alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
        }
    }

    function generateSessionId() {
        return 'SESSION_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
    }

    async function detectExpression() {
        if (!isRecording) return;

        const detections = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceExpressions();

        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        if (detections) {
            document.getElementById('face-status').textContent = 'Ya';
            document.getElementById('face-status').className = 'font-semibold text-green-600';
            
            const box = detections.detection.box;
            ctx.strokeStyle = '#10B981';
            ctx.lineWidth = 2;
            ctx.strokeRect(box.x, box.y, box.width, box.height);
            
            const expressions = detections.expressions;
            
            Object.keys(expressions).forEach(emotion => {
                accumulatedExpressions[emotion].push(expressions[emotion]);
            });
            
            updateExpressionBars(expressions);
            
        } else {
            document.getElementById('face-status').textContent = 'Tidak';
            document.getElementById('face-status').className = 'font-semibold text-red-600';
        }
    }

    function updateExpressionBars(expressions) {
        Object.keys(expressions).forEach(emotion => {
            const percent = Math.round(expressions[emotion] * 100);
            document.getElementById(`${emotion}-bar`).style.width = `${percent}%`;
            document.getElementById(`${emotion}-percent`).textContent = `${percent}%`;
        });
    }

    function calculateAverageExpressions() {
        const averages = {};
        Object.keys(accumulatedExpressions).forEach(emotion => {
            const values = accumulatedExpressions[emotion];
            const sum = values.reduce((a, b) => a + b, 0);
            averages[emotion] = values.length > 0 ? sum / values.length : 0;
        });
        return averages;
    }

    function updateDuration() {
        if (!sessionStartTime) return;
        
        const elapsed = Math.floor((Date.now() - sessionStartTime) / 1000);
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;
        document.getElementById('duration-display').textContent = 
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    startBtn.addEventListener('click', async () => {
        sessionId = generateSessionId();
        sessionStartTime = Date.now();
        isRecording = true;
        
        startBtn.disabled = true;
        stopBtn.disabled = false;
        recordingIndicator.style.display = 'block';
        recordingIndicator.className = 'w-3 h-3 rounded-full bg-red-500 recording-indicator';
        sessionStatus.innerHTML = 'Status: <span class="font-medium text-green-600">Merekam</span>';
        document.getElementById('session-id-display').textContent = sessionId;
        
        Object.keys(accumulatedExpressions).forEach(emotion => {
            accumulatedExpressions[emotion] = [];
        });
        
        detectionInterval = setInterval(detectExpression, 400);
        durationInterval = setInterval(updateDuration, 1000);
        
        console.log('✓ Session started:', sessionId);
    });

    stopBtn.addEventListener('click', async () => {
        isRecording = false;
        clearInterval(detectionInterval);
        clearInterval(durationInterval);
        
        const avgExpressions = calculateAverageExpressions();
        
        if (accumulatedExpressions.happy.length === 0) {
            alert('⚠️ Tidak ada data ekspresi yang tercatat. Pastikan wajah terdeteksi dengan baik.');
            
            startBtn.disabled = false;
            stopBtn.disabled = true;
            recordingIndicator.style.display = 'none';
            sessionStatus.innerHTML = 'Status: <span class="font-medium text-gray-500">Dibatalkan</span>';
            return;
        }
        
        try {
            const response = await fetch('{{ route('camera.save-expression') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    session_id: sessionId,
                    expressions: avgExpressions,
                    started_at: new Date(sessionStartTime).toISOString(),
                    ended_at: new Date().toISOString()
                })
            });
            
            const result = await response.json();
            
            if (result.success) {
                const finalScore = result.data.satisfaction_score;
                const category = result.data.satisfaction_category;
                const emoji = result.data.category_emoji;
                const sessionId = result.data.session_id;
                
                alert(`✓ Data Berhasil Disimpan!\n\n` +
                      `Session ID: ${sessionId}\n` +
                      `Kategori: ${emoji} ${category}\n` +
                      `Satisfaction Score: ${finalScore}\n\n` +
                      `Data ekspresi pelanggan telah tersimpan ke database.`);
                
                startBtn.disabled = false;
                stopBtn.disabled = true;
                recordingIndicator.style.display = 'none';
                sessionStatus.innerHTML = 'Status: <span class="font-medium text-gray-500">Selesai</span>';
                
                setTimeout(() => {
                    window.location.href = '{{ route('dashboard') }}';
                }, 2000);
            } else {
                alert('❌ Gagal menyimpan data: ' + result.message);
            }
        } catch (error) {
            console.error('Error saving data:', error);
            alert('❌ Terjadi kesalahan saat menyimpan data');
        }
    });

    await loadModels();
    await startCamera();
});
</script>
@endpush