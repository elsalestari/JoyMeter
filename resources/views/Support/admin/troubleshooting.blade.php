{{-- ================================================================= --}}
{{-- FILE: resources/views/support/admin/troubleshooting.blade.php --}}
{{-- TROUBLESHOOTING UNTUK ADMIN --}}
{{-- ================================================================= --}}

@extends('layouts.app')

@section('title', 'Troubleshooting Admin')
@section('page-title', 'Troubleshooting & Solusi Teknis')

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
        <h2 class="text-2xl font-bold mb-2">🔧 Troubleshooting Admin</h2>
        <p class="opacity-90">Solusi untuk masalah teknis yang dilaporkan karyawan dan troubleshooting sistem</p>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="relative">
            <input type="text" 
                   id="troubleshootSearch"
                   placeholder="Cari solusi masalah..." 
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Common Issues -->
    <div class="space-y-6">
        <!-- Masalah Login Karyawan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">🔐 Masalah Login Karyawan</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-red-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Karyawan lupa password</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi Admin:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Buka menu <strong>Karyawan</strong></li>
                                <li>Cari karyawan berdasarkan nama atau email</li>
                                <li>Klik tombol <strong>Edit</strong> (ikon pensil)</li>
                                <li>Isi field "Password" dengan password sementara (min. 6 karakter)</li>
                                <li>Isi field "Konfirmasi Password" dengan password yang sama</li>
                                <li>Klik <strong>Simpan Perubahan</strong></li>
                                <li>Informasikan password baru ke karyawan via tiket atau chat</li>
                                <li>Minta karyawan untuk mengganti password setelah login</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-red-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Error "Akses ditolak"</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Role akun bukan staff/admin</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi Admin:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Buka menu <strong>Karyawan</strong></li>
                                <li>Edit data karyawan yang bersangkutan</li>
                                <li>Ubah field "Peran" menjadi <strong>Karyawan</strong> atau <strong>Admin</strong></li>
                                <li>Simpan perubahan</li>
                                <li>Minta karyawan untuk login kembali</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-red-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Session expired / Auto logout</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Session timeout atau cookies bermasalah</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi untuk Karyawan:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Clear cache dan cookies browser</li>
                                <li>Login kembali</li>
                                <li>Centang "Ingat saya" untuk stay logged in lebih lama</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masalah Dashboard & Data -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-blue-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📊 Masalah Dashboard & Data</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Data tidak muncul / kosong</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Diagnosis:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Cek apakah ada data di database (tabel <code>customer_expressions</code>)</li>
                                <li>Cek filter tanggal - mungkin terlalu sempit</li>
                                <li>Cek koneksi database</li>
                            </ol>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Solusi untuk Karyawan:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Klik "Tampilkan Semua" untuk reset filter</li>
                                <li>• Refresh halaman (F5)</li>
                                <li>• Coba browser lain</li>
                            </ul>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Jika masalah berlanjut:</strong></p>
                            <p class="text-sm text-gray-600 ml-4">Escalate ke IT team - kemungkinan masalah database atau server</p>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Grafik tidak tampil</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi untuk Karyawan:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Refresh halaman (F5)</li>
                                <li>Clear cache browser (Ctrl+Shift+Del)</li>
                                <li>Pastikan JavaScript aktif di browser</li>
                                <li>Coba browser modern (Chrome, Firefox, Edge)</li>
                                <li>Disable extensions yang mungkin memblokir script</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Data tidak sinkron / tidak update</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Caching atau delay sistem</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Refresh halaman untuk data terbaru</li>
                                <li>• Hard refresh: Ctrl+F5 (Windows) atau Cmd+Shift+R (Mac)</li>
                                <li>• Data akan ter-update setelah beberapa saat</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masalah Export & PDF -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-green-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📄 Masalah Export PDF</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ PDF tidak ter-download</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi untuk Karyawan:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Cek folder Downloads</li>
                                <li>Izinkan download di browser (lihat popup di address bar)</li>
                                <li>Disable popup blocker untuk domain ini</li>
                                <li>Coba browser lain</li>
                                <li>Cek space storage perangkat</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ PDF kosong atau error</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Diagnosis:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Tidak ada data dalam rentang tanggal yang dipilih</li>
                                <li>• Timeout jika data terlalu besar</li>
                                <li>• Error di library PDF generation</li>
                            </ul>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Pastikan ada data di rentang tanggal</li>
                                <li>Kurangi rentang tanggal jika data terlalu besar</li>
                                <li>Tunggu beberapa saat untuk processing</li>
                                <li>Refresh dan coba lagi</li>
                                <li>Jika error berlanjut, escalate ke IT team</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masalah Permission & Access -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-yellow-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">🚫 Masalah Akses & Permission</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-yellow-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Error 403: Access Denied</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> User tidak memiliki permission untuk halaman tersebut</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Diagnosis:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Cek role user - apakah staff atau admin?</li>
                                <li>Cek halaman yang diakses - apakah admin-only?</li>
                                <li>Pastikan user login dengan akun yang benar</li>
                            </ol>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Solusi Admin:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Fitur <strong>Tambah/Edit/Hapus Karyawan</strong> hanya untuk Admin</li>
                                <li>• Fitur <strong>Balas Tiket Support</strong> hanya untuk Admin</li>
                                <li>• Jika karyawan perlu akses, upgrade role ke Admin</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-yellow-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Tombol/Fitur tidak muncul</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Feature tersebut role-specific</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Contoh:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Tombol "Tambah Karyawan" hanya muncul untuk Admin</li>
                                <li>• Tombol "Buat Tiket" hanya muncul untuk Staff</li>
                                <li>• Form "Balas Tiket" hanya muncul untuk Admin</li>
                            </ul>
                            <p class="text-sm text-gray-700 mt-2"><strong>Ini adalah behavior normal.</strong> Tidak perlu troubleshooting.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Masalah Sistem -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">⚡ Masalah Performa & Sistem</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Website lambat / loading lama</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Quick Fix untuk Karyawan:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Cek koneksi internet</li>
                                <li>Tutup tab browser lain</li>
                                <li>Clear cache browser</li>
                                <li>Restart browser</li>
                                <li>Gunakan browser modern</li>
                            </ol>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Untuk Admin:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Cek server load dan resource usage</li>
                                <li>• Cek database query performance</li>
                                <li>• Monitor network latency</li>
                                <li>• Jika sistemik, escalate ke IT/DevOps team</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Halaman freeze / tidak merespon</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Tunggu beberapa saat (khususnya saat load data besar)</li>
                                <li>Refresh halaman (F5)</li>
                                <li>Close dan reopen browser</li>
                                <li>Restart komputer</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Error 500: Internal Server Error</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Error di server-side</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Action untuk Admin:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Catat langkah yang dilakukan user sebelum error</li>
                                <li>Screenshot error message</li>
                                <li>Cek log error di server (jika punya akses)</li>
                                <li><strong class="text-red-600">ESCALATE ke IT team immediately</strong></li>
                                <li>Informasikan ke user bahwa tim IT sedang menangani</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Escalation Guide -->
    <div class="mt-6 bg-orange-50 border border-orange-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-orange-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <div class="flex-1">
                <h4 class="font-medium text-orange-900 mb-2">📞 Kapan Harus Escalate ke IT Team?</h4>
                <p class="text-sm text-orange-700 mb-3">
                    Escalate masalah ke IT team jika:
                </p>
                <ul class="text-sm text-orange-700 space-y-1 ml-4">
                    <li>• Error 500 atau error server lainnya</li>
                    <li>• Bug sistemik yang mempengaruhi banyak user</li>
                    <li>• Masalah database atau koneksi</li>
                    <li>• Issue keamanan atau security breach</li>
                    <li>• Masalah yang di luar scope support (infrastruktur, deployment, dll)</li>
                </ul>
                <p class="text-xs text-orange-600 mt-3 font-medium">
                    Contact: it-support@company.com | Ext: 1234
                </p>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Simple Troubleshooting Search
    document.getElementById('troubleshootSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const items = document.querySelectorAll('.troubleshoot-item');
        
        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
</script>
@endpush