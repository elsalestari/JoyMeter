class CameraSessionManager {
    constructor(config = {}) {
        this.config = {
            modelUrl: 'https://cdn.jsdelivr.net/npm/@vladmandic/face-api/model/',
            detectionInterval: 500, 
            minSessionDuration: 10,
            csrfToken: config.csrfToken,
            saveUrl: config.saveUrl,
            ...config
        };

        this.elements = this.initializeElements();
        this.state = this.initializeState();
        
        this.init();
    }

    initializeElements() {
        return {
            video: document.getElementById('video'),
            canvas: document.getElementById('overlay'),
            startBtn: document.getElementById('start-btn'),
            stopBtn: document.getElementById('stop-btn'),
            loadingStatus: document.getElementById('loading-status'),
            recordingIndicator: document.getElementById('recording-indicator'),
            sessionStatus: document.getElementById('session-status'),
            sessionIdDisplay: document.getElementById('session-id-display'),
            durationDisplay: document.getElementById('duration-display'),
            faceStatus: document.getElementById('face-status'),
        };
    }

    initializeState() {
        return {
            sessionId: null,
            sessionStartTime: null,
            isRecording: false,
            detectionInterval: null,
            durationInterval: null,
            accumulatedExpressions: {
                happy: [], sad: [], angry: [], surprised: [],
                neutral: [], fearful: [], disgusted: []
            },
            modelsLoaded: false,
            cameraReady: false,
            lastDetectionTime: 0
        };
    }

    async init() {
        this.elements.startBtn.disabled = true;
        this.elements.startBtn.innerHTML = '<span class="flex items-center justify-center gap-2"><div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div><span>Memuat...</span></span>';
        
        try {
            await Promise.all([
                this.startCamera(),
                this.loadModels()
            ]);
            
            this.enableStartButton();
            
        } catch (error) {
            console.error('Initialization error:', error);
            this.updateLoadingStatus('error', '✗ Gagal menginisialisasi sistem');
            this.showNotification('Gagal menginisialisasi sistem. Periksa izin kamera atau koneksi model.', 'error');
            try {
                this.resetSession();
            } catch (err) {
                console.error('Error resetting UI after init failure:', err);
            }
        }
    }

    async loadModels() {
        try {
            this.updateLoadingStatus('loading', 'Memuat model AI...');
            
            await Promise.all([
                faceapi.nets.tinyFaceDetector.loadFromUri(this.config.modelUrl),
                faceapi.nets.faceExpressionNet.loadFromUri(this.config.modelUrl)
            ]);
            
            this.state.modelsLoaded = true;
            this.updateLoadingStatus('success', '✓ Model AI siap');
            
            console.log('✓ Face-api.js models loaded successfully');
            
        } catch (error) {
            console.error('Error loading models:', error);
            this.updateLoadingStatus('error', '✗ Gagal memuat model AI');
            throw error;
        }
    }

    async startCamera() {
        try {
            this.updateLoadingStatus('loading', 'Mengaktifkan kamera...');
            
            const stream = await navigator.mediaDevices.getUserMedia({
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    facingMode: 'user'
                }
            });
            
            this.elements.video.srcObject = stream;
            
            await new Promise((resolve) => {
                this.elements.video.onloadedmetadata = () => {
                    this.elements.video.play();
                    resolve();
                };
            });
            
            this.elements.canvas.width = this.elements.video.videoWidth;
            this.elements.canvas.height = this.elements.video.videoHeight;
            
            this.state.cameraReady = true;
            this.updateLoadingStatus('success', '✓ Kamera aktif');
            
            console.log('✓ Camera started successfully');
            
        } catch (error) {
            console.error('Error accessing camera:', error);
            this.updateLoadingStatus('error', '✗ Gagal mengakses kamera');
            this.showNotification('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.', 'error');
            throw error;
        }
    }

    enableStartButton() {
        if (this.state.modelsLoaded && this.state.cameraReady) {
            this.elements.startBtn.disabled = false;
            this.elements.startBtn.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Mulai Sesi</span>
                </div>
            `;
            this.attachEventListeners();
            
            setTimeout(() => {
                this.elements.loadingStatus.style.display = 'none';
            }, 1500);
        }
    }

    attachEventListeners() {
        this.elements.startBtn.addEventListener('click', () => this.startSession());
        this.elements.stopBtn.addEventListener('click', () => this.stopSession());
    }

    startSession() {
        if (!this.state.modelsLoaded || !this.state.cameraReady) {
            this.showNotification('Sistem belum siap. Tunggu sebentar...', 'warning');
            return;
        }

        this.state.sessionId = this.generateSessionId();
        this.state.sessionStartTime = Date.now();
        this.state.isRecording = true;

        this.elements.startBtn.disabled = true;
        this.elements.stopBtn.disabled = false;
        this.elements.recordingIndicator.style.display = 'block';
        this.elements.recordingIndicator.className = 'w-3 h-3 rounded-full bg-red-500 recording-indicator';
        this.updateSessionStatus('Merekam', 'green');
        this.elements.sessionIdDisplay.textContent = this.state.sessionId;

        Object.keys(this.state.accumulatedExpressions).forEach(emotion => {
            this.state.accumulatedExpressions[emotion] = [];
        });

        this.startDetectionLoop();
        this.state.durationInterval = setInterval(() => this.updateDuration(), 1000);

        console.log('✓ Session started:', this.state.sessionId);
        this.showNotification('Sesi dimulai. Arahkan wajah pelanggan ke kamera.', 'success');
    }

    startDetectionLoop() {
        const detect = async () => {
            if (!this.state.isRecording) return;

            const now = Date.now();
            if (now - this.state.lastDetectionTime >= this.config.detectionInterval) {
                await this.detectExpression();
                this.state.lastDetectionTime = now;
            }

            requestAnimationFrame(detect);
        };

        requestAnimationFrame(detect);
    }

    async stopSession() {
        this.state.isRecording = false;
        clearInterval(this.state.durationInterval);

        const sessionDuration = Math.floor((Date.now() - this.state.sessionStartTime) / 1000);

        this.elements.stopBtn.disabled = true;
        this.elements.stopBtn.innerHTML = `
            <div class="flex items-center justify-center gap-2">
                <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white"></div>
                <span>Menyimpan...</span>
            </div>
        `;

        if (sessionDuration < this.config.minSessionDuration) {
            this.showNotification(
                `⚠️ Sesi terlalu singkat. Minimal ${this.config.minSessionDuration} detik untuk hasil akurat.`, 
                'warning'
            );
            this.resetSession();
            return;
        }

        if (this.state.accumulatedExpressions.happy.length === 0) {
            this.showNotification(
                '⚠️ Tidak ada data ekspresi yang tercatat. Pastikan wajah terdeteksi dengan baik.', 
                'warning'
            );
            this.resetSession();
            return;
        }

        const avgExpressions = this.calculateAverageExpressions();
        await this.saveExpressionData(avgExpressions);
    }

    async detectExpression() {
        if (!this.state.isRecording) return;

        try {
            const detections = await faceapi
                .detectSingleFace(this.elements.video, new faceapi.TinyFaceDetectorOptions({
                    inputSize: 224,
                    scoreThreshold: 0.5
                }))
                .withFaceExpressions();

            const ctx = this.elements.canvas.getContext('2d');
            ctx.clearRect(0, 0, this.elements.canvas.width, this.elements.canvas.height);

            if (detections) {
                this.updateFaceStatus(true);
                this.drawFaceBox(ctx, detections.detection.box);
                
                const expressions = detections.expressions;
                this.accumulateExpressions(expressions);
                this.updateExpressionBars(expressions);
            } else {
                this.updateFaceStatus(false);
            }
        } catch (error) {
            console.error('Detection error:', error);
        }
    }

    accumulateExpressions(expressions) {
        const expressionMap = {
            'happy': 'happy',
            'sad': 'sad',
            'angry': 'angry',
            'surprised': 'surprised',
            'neutral': 'neutral',
            'fearful': 'fearful',
            'disgusted': 'disgusted'
        };

        Object.keys(expressionMap).forEach(apiName => {
            const ourName = expressionMap[apiName];
            if (this.state.accumulatedExpressions[ourName] !== undefined && expressions[apiName] !== undefined) {
                this.state.accumulatedExpressions[ourName].push(expressions[apiName]);
            }
        });
    }

    calculateAverageExpressions() {
        const averages = {};
        Object.keys(this.state.accumulatedExpressions).forEach(emotion => {
            const values = this.state.accumulatedExpressions[emotion];
            const sum = values.reduce((a, b) => a + b, 0);
            averages[emotion] = values.length > 0 ? sum / values.length : 0;
        });
        
        console.log('Calculated averages:', averages);
        return averages;
    }

    async saveExpressionData(expressions) {
        try {
            const payload = {
                session_id: this.state.sessionId,
                expressions: {
                    happy: expressions.happy || 0,
                    sad: expressions.sad || 0,
                    angry: expressions.angry || 0,
                    surprised: expressions.surprised || 0,
                    neutral: expressions.neutral || 0,
                    fearful: expressions.fearful || 0,
                    disgusted: expressions.disgusted || 0
                },
                started_at: new Date(this.state.sessionStartTime).toISOString(),
                ended_at: new Date().toISOString()
            };

            console.log('Sending payload:', JSON.stringify(payload, null, 2));

            const response = await fetch(this.config.saveUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': this.config.csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const result = await response.json();
            console.log('Server response:', result);

            if (result.success) {
                this.showSuccessModal(result.data);
                setTimeout(() => {
                    window.location.href = '/dashboard';
                }, 3000);
            } else {
                console.error('Save failed:', result);
                this.showNotification('✗ Gagal menyimpan data: ' + (result.message || 'Unknown error'), 'error');
                
                if (result.errors) {
                    console.error('Validation errors:', result.errors);
                    const errorMessages = Object.values(result.errors).flat().join(', ');
                    this.showNotification('Kesalahan validasi: ' + errorMessages, 'error');
                }
                
                this.resetSession();
            }
        } catch (error) {
            console.error('Save error:', error);
            this.showNotification('✗ Terjadi kesalahan saat menyimpan data: ' + error.message, 'error');
            this.resetSession();
        }
    }

    drawFaceBox(ctx, box) {
        ctx.strokeStyle = '#10B981';
        ctx.lineWidth = 3;
        ctx.strokeRect(box.x, box.y, box.width, box.height);
        
        const cornerLength = 20;
        ctx.lineWidth = 4;
        
        // Top-left corner
        ctx.beginPath();
        ctx.moveTo(box.x, box.y + cornerLength);
        ctx.lineTo(box.x, box.y);
        ctx.lineTo(box.x + cornerLength, box.y);
        ctx.stroke();
        
        // Top-right corner
        ctx.beginPath();
        ctx.moveTo(box.x + box.width - cornerLength, box.y);
        ctx.lineTo(box.x + box.width, box.y);
        ctx.lineTo(box.x + box.width, box.y + cornerLength);
        ctx.stroke();
        
        // Bottom-left corner
        ctx.beginPath();
        ctx.moveTo(box.x, box.y + box.height - cornerLength);
        ctx.lineTo(box.x, box.y + box.height);
        ctx.lineTo(box.x + cornerLength, box.y + box.height);
        ctx.stroke();
        
        // Bottom-right corner
        ctx.beginPath();
        ctx.moveTo(box.x + box.width - cornerLength, box.y + box.height);
        ctx.lineTo(box.x + box.width, box.y + box.height);
        ctx.lineTo(box.x + box.width, box.y + box.height - cornerLength);
        ctx.stroke();
    }

    updateExpressionBars(expressions) {
        const expressionMap = {
            'happy': 'happy',
            'sad': 'sad',
            'angry': 'angry',
            'surprised': 'surprised',
            'neutral': 'neutral',
            'fearful': 'fearful',
            'disgusted': 'disgusted'
        };

        Object.keys(expressionMap).forEach(apiName => {
            const ourName = expressionMap[apiName];
            const value = expressions[apiName] || 0;
            const percent = Math.round(value * 100);
            
            const barElement = document.getElementById(`${ourName}-bar`);
            const percentElement = document.getElementById(`${ourName}-percent`);
            
            if (barElement) barElement.style.width = `${percent}%`;
            if (percentElement) percentElement.textContent = `${percent}%`;
        });
    }

    updateDuration() {
        if (!this.state.sessionStartTime) return;

        const elapsed = Math.floor((Date.now() - this.state.sessionStartTime) / 1000);
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;
        
        this.elements.durationDisplay.textContent = 
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }

    updateFaceStatus(detected) {
        if (detected) {
            this.elements.faceStatus.textContent = 'Ya';
            this.elements.faceStatus.className = 'font-semibold text-green-600';
        } else {
            this.elements.faceStatus.textContent = 'Tidak';
            this.elements.faceStatus.className = 'font-semibold text-red-600';
        }
    }

    updateSessionStatus(status, color) {
        const colorClass = {
            'green': 'text-green-600',
            'red': 'text-red-600',
            'gray': 'text-gray-500'
        }[color] || 'text-gray-500';

        this.elements.sessionStatus.innerHTML = 
            `Status: <span class="font-medium ${colorClass}">${status}</span>`;
    }

    updateLoadingStatus(status, message) {
        const icons = {
            loading: '<div class="animate-spin rounded-full h-4 w-4 border-b-2 border-[#F6821F]"></div>',
            success: '<svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>',
            error: '<svg class="w-4 h-4 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'
        };

        const colorClass = {
            loading: 'text-gray-600',
            success: 'text-green-600',
            error: 'text-red-600'
        }[status] || 'text-gray-600';

        this.elements.loadingStatus.innerHTML = `
            <div class="flex items-center justify-center gap-2 ${colorClass}">
                ${icons[status]}
                <span class="text-sm font-medium">${message}</span>
            </div>
        `;
        
        this.elements.loadingStatus.style.display = 'block';
    }

    resetSession() {
        this.elements.startBtn.disabled = false;
        this.elements.startBtn.innerHTML = `
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Mulai Sesi</span>
            </div>
        `;
        
        this.elements.stopBtn.disabled = true;
        this.elements.stopBtn.innerHTML = `
            <div class="flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                </svg>
                <span>Selesai Sesi</span>
            </div>
        `;
        
        this.elements.recordingIndicator.style.display = 'none';
        this.updateSessionStatus('Siap', 'gray');
    }

    generateSessionId() {
        const now = new Date();
        
        // Format: YYYYMMDD
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const dateStr = `${year}${month}${day}`;
        
        // Format: HHMMSS
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const timeStr = `${hours}${minutes}${seconds}`;
        
        // Random 8 character hex string
        const random = Math.floor(Math.random() * 0xffffffff).toString(16).padStart(8, '0');
        
        const sessionId = `SESSION_${dateStr}_${timeStr}_${random}`;
        
        console.log('Generated Session ID:', sessionId);
        return sessionId;
    }

    showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => notification.remove(), 300);
        }, 4000);
    }

    showSuccessModal(data) {
        const modal = document.createElement('div');
        modal.className = 'modal-overlay';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Data Berhasil Disimpan!</h3>
                    <div class="space-y-2 text-sm text-gray-600 mb-4">
                        <p><strong>Session ID:</strong> ${data.session_id}</p>
                        <p class="text-2xl">${data.category_emoji}</p>
                        <p><strong>Kategori:</strong> ${data.satisfaction_category}</p>
                        <p><strong>Satisfaction Score:</strong> ${data.satisfaction_score}</p>
                    </div>
                    <p class="text-xs text-gray-500">Mengarahkan ke dashboard...</p>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const config = window.CAMERA_CONFIG || {};
    
    new CameraSessionManager({
        csrfToken: config.csrfToken || document.querySelector('meta[name="csrf-token"]')?.content,
        saveUrl: config.saveUrl || '/camera/save-expression',
        sessionId: config.sessionId
    });
});