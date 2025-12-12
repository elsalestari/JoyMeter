{{-- ================================================================= --}}
{{-- FILE: resources/views/support/admin/guides.blade.php --}}
{{-- PANDUAN UNTUK ADMIN SUPPORT --}}
{{-- ================================================================= --}}

@extends('layouts.app')

@section('title', 'Panduan Admin Support')
@section('page-title', 'Panduan Pengelolaan Support')

@section('content')
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('support.index') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-blue-600 transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Support Center
        </a>
    </div>

    <!-- Intro -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-8 mb-6 text-white">
        <h2 class="text-2xl font-bold mb-2">📖 Panduan Admin Support</h2>
        <p class="opacity-90">Pelajari cara mengelola tiket support dan memberikan layanan terbaik kepada karyawan</p>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <a href="#dashboard" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-900">Dashboard Admin</span>
            </div>
        </a>
        <a href="#ticket-management" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <span class="font-medium text-gray-900">Mengelola Tiket</span>
            </div>
        </a>
        <a href="#best-practices" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-900">Best Practices</span>
            </div>
        </a>
    </div>

    <!-- Guide 1: Dashboard Admin -->
    <div id="dashboard" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
            Menggunakan Dashboard Admin
        </h3>
        
        <div class="space-y-4">
            <div class="pl-11">
                <h4 class="font-semibold text-gray-900 mb-2">Komponen Dashboard</h4>
                
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">📊 Statistik Tiket</h5>
                        <p class="text-sm text-gray-700 mb-2">Dashboard menampilkan 4 metrik penting:</p>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• <strong>Total Tiket:</strong> Semua tiket dari karyawan</li>
                            <li>• <strong>Perlu Ditangani:</strong> Tiket dengan status "Terbuka" - <span class="text-orange-600 font-semibold">prioritas utama!</span></li>
                            <li>• <strong>Dalam Proses:</strong> Tiket yang sedang Anda tangani</li>
                            <li>• <strong>Terselesaikan:</strong> Tiket yang sudah solved</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">⚡ Quick Actions</h5>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• <strong>Tiket Terbuka:</strong> Akses cepat ke tiket yang perlu respon</li>
                            <li>• <strong>Semua Tiket:</strong> Lihat dan filter semua tiket</li>
                            <li>• <strong>Knowledge Base:</strong> Akses panduan dan FAQ</li>
                            <li>• <strong>Troubleshooting:</strong> Referensi solusi masalah</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">📋 Tabel Tiket Terbaru</h5>
                        <p class="text-sm text-gray-700 mb-2">Menampilkan 10 tiket terbaru dengan informasi:</p>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• <strong>Nomor Tiket:</strong> ID unik untuk tracking</li>
                            <li>• <strong>Karyawan:</strong> Siapa yang melaporkan</li>
                            <li>• <strong>Masalah:</strong> Subjek dan kategori</li>
                            <li>• <strong>Prioritas:</strong> Rendah, Sedang, Tinggi, Mendesak</li>
                            <li>• <strong>Status:</strong> Terbuka, Dalam Proses, Terselesaikan</li>
                            <li>• <strong>Waktu:</strong> Kapan tiket dibuat</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 2: Mengelola Tiket -->
    <div id="ticket-management" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
            Mengelola Tiket Support
        </h3>
        
        <div class="space-y-6">
            <div class="pl-11">
                <h4 class="font-semibold text-gray-900 mb-3">Workflow Penanganan Tiket</h4>
                
                <div class="space-y-4">
                    <div class="p-4 bg-blue-50 rounded-lg border-l-4 border-blue-500">
                        <h5 class="font-medium text-blue-900 mb-2">Step 1️⃣: Review Tiket Baru</h5>
                        <ol class="text-sm text-gray-700 space-y-1 ml-4 list-decimal">
                            <li>Buka dashboard admin atau menu "Tiket Terbuka"</li>
                            <li>Baca subjek dan deskripsi tiket dengan teliti</li>
                            <li>Perhatikan prioritas dan kategori</li>
                            <li>Identifikasi apakah Anda bisa menangani atau perlu escalate</li>
                        </ol>
                    </div>

                    <div class="p-4 bg-green-50 rounded-lg border-l-4 border-green-500">
                        <h5 class="font-medium text-green-900 mb-2">Step 2️⃣: Kirim Respon/Balasan</h5>
                        <ol class="text-sm text-gray-700 space-y-1 ml-4 list-decimal">
                            <li>Klik tombol "Tangani" atau masuk ke detail tiket</li>
                            <li>Scroll ke form "Balas Tiket" di bagian bawah</li>
                            <li>Tulis respon yang jelas dan solutif (minimal 10 karakter)</li>
                            <li>Klik "Kirim Balasan"</li>
                            <li>Status otomatis berubah menjadi "Dalam Proses"</li>
                        </ol>
                        <div class="mt-3 p-3 bg-white rounded border border-green-200">
                            <p class="text-xs text-green-900"><strong>💡 Tip:</strong> Gunakan template respon untuk efisiensi, tapi personalisasi sesuai konteks masalah.</p>
                        </div>
                    </div>

                    <div class="p-4 bg-yellow-50 rounded-lg border-l-4 border-yellow-500">
                        <h5 class="font-medium text-yellow-900 mb-2">Step 3️⃣: Update Status Tiket</h5>
                        <p class="text-sm text-gray-700 mb-2">Gunakan form "Ubah Status" di sidebar detail tiket:</p>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• <strong>Terbuka →</strong> Tiket baru, belum direspon</li>
                            <li>• <strong>Dalam Proses →</strong> Setelah kirim respon pertama</li>
                            <li>• <strong>Terselesaikan →</strong> Masalah sudah solved, menunggu konfirmasi</li>
                            <li>• <strong>Ditutup →</strong> Karyawan confirm atau tidak ada follow-up</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-purple-50 rounded-lg border-l-4 border-purple-500">
                        <h5 class="font-medium text-purple-900 mb-2">Step 4️⃣: Follow-up & Monitoring</h5>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• Cek tiket "Dalam Proses" secara berkala</li>
                            <li>• Kirim update progress jika penyelesaian memakan waktu</li>
                            <li>• Tanyakan apakah solusi berhasil setelah 1-2 hari</li>
                            <li>• Tutup tiket jika tidak ada respon setelah 7 hari</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 3: Best Practices -->
    <div id="best-practices" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
            Best Practices Support
        </h3>
        
        <div class="space-y-4 pl-11">
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">✅ Template Respon yang Baik</h5>
                    <div class="bg-white p-3 rounded border border-gray-200 text-sm">
                        <p class="text-gray-700 mb-2"><strong>Subject: Login Error</strong></p>
                        <p class="text-gray-600 italic mb-3">
                            "Halo [Nama Karyawan],<br><br>
                            Terima kasih telah melaporkan masalah ini. Saya memahami Anda mengalami error saat login ke sistem.<br><br>
                            <strong>Solusi:</strong><br>
                            Saya sudah melakukan reset password untuk akun Anda. Silakan gunakan password baru berikut: <code>TempPass123</code><br><br>
                            Setelah login, Anda akan diminta mengganti password. Pastikan password baru minimal 6 karakter.<br><br>
                            Jika masih ada kendala, jangan ragu untuk menghubungi kembali.<br><br>
                            Salam,<br>
                            [Nama Admin]"
                        </p>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">⚠️ Hal yang Harus Dihindari</h5>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li>❌ <strong>Respon terlalu singkat:</strong> "Sudah diperbaiki" - tidak informatif</li>
                        <li>❌ <strong>Bahasa teknis berlebihan:</strong> Karyawan mungkin tidak mengerti jargon IT</li>
                        <li>❌ <strong>Menyalahkan user:</strong> "Kenapa tidak baca panduan dulu?" - tidak profesional</li>
                        <li>❌ <strong>Janji berlebihan:</strong> "Akan selesai dalam 5 menit" padahal butuh investigasi</li>
                        <li>❌ <strong>Mengabaikan tiket urgent:</strong> Selalu prioritaskan berdasarkan urgensi</li>
                    </ul>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">🎯 Tips Efisiensi</h5>
                    <ul class="text-sm text-gray-700 space-y-1 ml-4">
                        <li>• Gunakan filter untuk fokus pada prioritas tertentu</li>
                        <li>• Tangani tiket sejenis secara batch (misal: semua reset password)</li>
                        <li>• Buat dokumentasi untuk masalah yang sering muncul</li>
                        <li>• Update Knowledge Base jika ada solusi baru</li>
                        <li>• Komunikasikan dengan tim jika ada bug sistemik</li>
                    </ul>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">🤝 Komunikasi Efektif</h5>
                    <ol class="text-sm text-gray-700 space-y-2 ml-4 list-decimal">
                        <li><strong>Empati:</strong> Pahami frustasi karyawan, acknowledge perasaan mereka</li>
                        <li><strong>Clarity:</strong> Jelaskan solusi dengan langkah-langkah yang jelas</li>
                        <li><strong>Proaktif:</strong> Tawarkan bantuan lebih lanjut jika diperlukan</li>
                        <li><strong>Profesional:</strong> Tetap sopan meskipun karyawan komplain keras</li>
                        <li><strong>Responsif:</strong> Respon cepat membuat karyawan merasa dihargai</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 4: Fitur Khusus Admin -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
            Fitur Khusus Admin
        </h3>
        
        <div class="space-y-4 pl-11">
            <div class="p-4 bg-gray-50 rounded-lg">
                <h5 class="font-medium text-gray-900 mb-2">👤 Reset Password Karyawan</h5>
                <ol class="text-sm text-gray-700 space-y-1 ml-4 list-decimal">
                    <li>Buka menu <strong>Karyawan</strong> dari sidebar</li>
                    <li>Cari karyawan yang perlu direset password</li>
                    <li>Klik tombol <strong>Edit</strong> (ikon pensil)</li>
                    <li>Isi field "Password" dan "Konfirmasi Password"</li>
                    <li>Klik <strong>Simpan Perubahan</strong></li>
                    <li>Informasikan password baru via tiket atau komunikasi pribadi</li>
                </ol>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <h5 class="font-medium text-gray-900 mb-2">🔍 Filter & Search Tiket</h5>
                <ul class="text-sm text-gray-700 space-y-1 ml-4">
                    <li>• <strong>Filter Status:</strong> Terbuka, Dalam Proses, Terselesaikan, Ditutup</li>
                    <li>• <strong>Filter Prioritas:</strong> Rendah, Sedang, Tinggi, Mendesak</li>
                    <li>• <strong>Search:</strong> Cari berdasarkan nomor tiket, subjek, atau deskripsi</li>
                    <li>• <strong>Kombinasi Filter:</strong> Gunakan multiple filter untuk hasil spesifik</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Additional Resources -->
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg border border-blue-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">📚 Sumber Daya Tambahan</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('support.faq') }}" class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium text-gray-900">FAQ Admin</span>
                </div>
                <p class="text-xs text-gray-600">Pertanyaan umum pengelolaan support</p>
            </a>

            <a href="{{ route('support.troubleshooting') }}" class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="font-medium text-gray-900">Troubleshooting</span>
                </div>
                <p class="text-xs text-gray-600">Solusi masalah teknis</p>
            </a>

            <a href="{{ route('support.tickets.index') }}" class="bg-white rounded-lg p-4 border border-gray-200 hover:shadow-md transition">
                <div class="flex items-center mb-2">
                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <span class="font-medium text-gray-900">Semua Tiket</span>
                </div>
                <p class="text-xs text-gray-600">Lihat dan kelola tiket</p>
            </a>
        </div>
    </div>
@endsection