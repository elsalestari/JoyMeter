@extends('layouts.app')

@section('title', 'Troubleshooting')
@section('page-title', 'Troubleshooting & Pemecahan Masalah')

@section('content')
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('support.index') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-[#F6821F] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Support
        </a>
    </div>

    <!-- Intro -->
    <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg p-8 mb-6 text-white">
        <h2 class="text-2xl font-bold mb-2">🔧 Troubleshooting</h2>
        <p class="opacity-90">Solusi untuk masalah umum yang mungkin Anda temui</p>
    </div>

    <!-- Search -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="relative">
            <input type="text" 
                   id="troubleshootSearch"
                   placeholder="Cari solusi masalah..." 
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F7AA4A]">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- Common Issues -->
    <div class="space-y-6">
        <!-- Login Issues -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-red-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">🔒 Masalah Login</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-red-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Error: "Email atau password yang Anda masukkan salah"</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Email atau password salah</li>
                                <li>• Caps Lock aktif saat mengetik password</li>
                                <li>• Spasi di awal atau akhir email/password</li>
                            </ul>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Periksa kembali email dan password Anda</li>
                                <li>Pastikan Caps Lock tidak aktif</li>
                                <li>Hapus spasi di awal atau akhir</li>
                                <li>Gunakan fitur "Tampilkan Password" untuk memverifikasi</li>
                                <li>Jika tetap gagal, hubungi admin untuk reset password</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-red-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Error: "Akses ditolak"</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Akun Anda bukan karyawan atau admin</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Hubungi administrator untuk mengubah role akun Anda</li>
                                <li>Pastikan Anda menggunakan akun yang benar</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Dashboard Issues -->
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
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Belum ada data pelanggan yang tercatat</li>
                                <li>• Filter tanggal terlalu sempit</li>
                                <li>• Masalah koneksi database</li>
                            </ul>
                            <p class="text-sm text-gray-700 mb-2 mt-3"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Klik "Tampilkan Semua" untuk melihat seluruh data</li>
                                <li>Ubah rentang tanggal filter menjadi lebih luas</li>
                                <li>Refresh halaman (F5 atau Ctrl+R)</li>
                                <li>Cek koneksi internet Anda</li>
                                <li>Jika masih kosong, hubungi admin</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Grafik tidak tampil</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Refresh halaman (F5)</li>
                                <li>Bersihkan cache browser (Ctrl+Shift+Del)</li>
                                <li>Coba browser lain (Chrome, Firefox, Edge)</li>
                                <li>Pastikan JavaScript diaktifkan di browser</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-blue-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Data tidak terupdate real-time</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Halaman perlu di-refresh untuk melihat data terbaru</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong> Refresh halaman secara berkala atau klik tombol filter</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Export Issues -->
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
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Periksa folder Downloads Anda</li>
                                <li>Izinkan download di browser (biasanya ada popup di address bar)</li>
                                <li>Nonaktifkan popup blocker</li>
                                <li>Coba browser lain</li>
                                <li>Periksa space penyimpanan perangkat Anda</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-green-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ PDF kosong atau error</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Pastikan ada data dalam rentang tanggal yang dipilih</li>
                                <li>Tunggu beberapa saat (untuk data besar memerlukan waktu)</li>
                                <li>Refresh halaman dan coba lagi</li>
                                <li>Hubungi admin jika masalah berlanjut</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Issues -->
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
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Anda tidak memiliki izin untuk mengakses halaman tersebut</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ul class="text-sm text-gray-600 space-y-1 ml-4">
                                <li>• Pastikan Anda sudah login dengan akun yang benar</li>
                                <li>• Cek role akun Anda (Staff atau Admin)</li>
                                <li>• Beberapa fitur hanya tersedia untuk Admin</li>
                                <li>• Hubungi admin jika Anda merasa seharusnya memiliki akses</li>
                            </ul>
                        </div>

                        <div class="border-l-4 border-yellow-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Tombol "Tambah Karyawan" tidak muncul</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Penyebab:</strong> Fitur ini hanya untuk Admin</p>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong> Jika Anda adalah karyawan, ini adalah behavior normal. Hubungi admin jika Anda seharusnya Admin.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Performance Issues -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 troubleshoot-item">
            <div class="flex items-start">
                <div class="w-12 h-12 rounded-lg bg-purple-100 flex items-center justify-center mr-4 flex-shrink-0">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">⚡ Masalah Performa & Kecepatan</h3>
                    
                    <div class="space-y-4">
                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Website lambat / loading lama</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Periksa koneksi internet Anda</li>
                                <li>Tutup tab browser lain yang tidak digunakan</li>
                                <li>Bersihkan cache browser (Ctrl+Shift+Del)</li>
                                <li>Restart browser Anda</li>
                                <li>Gunakan browser terbaru (Chrome, Firefox, Edge)</li>
                                <li>Hindari memuat data terlalu banyak sekaligus</li>
                            </ol>
                        </div>

                        <div class="border-l-4 border-purple-500 pl-4">
                            <h4 class="font-medium text-gray-900 mb-2">❌ Halaman freeze / tidak merespon</h4>
                            <p class="text-sm text-gray-700 mb-2"><strong>Solusi:</strong></p>
                            <ol class="text-sm text-gray-600 space-y-1 ml-4 list-decimal">
                                <li>Tunggu beberapa saat (terutama saat load data besar)</li>
                                <li>Refresh halaman (F5)</li>
                                <li>Tutup dan buka kembali browser</li>
                                <li>Restart komputer jika masalah berlanjut</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Still Need Help -->
    <div class="mt-6 bg-orange-50 border border-orange-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-orange-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <div class="flex-1">
                <h4 class="font-medium text-orange-900 mb-1">Masalah Tidak Terpecahkan?</h4>
                <p class="text-sm text-orange-700 mb-3">
                    Jika masalah Anda masih belum terselesaikan setelah mengikuti panduan di atas, silakan hubungi tim support kami.
                </p>
                <a href="{{ route('support.tickets.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded-md hover:bg-orange-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Buat Tiket Support
                </a>
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