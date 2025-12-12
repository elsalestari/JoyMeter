@extends('layouts.app')

@section('title', 'Panduan Penggunaan')
@section('page-title', 'Panduan Penggunaan Sistem')

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
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-8 mb-6 text-white">
        <h2 class="text-2xl font-bold mb-2">📚 Panduan Lengkap JoyMeter</h2>
        <p class="opacity-90">Pelajari cara menggunakan sistem JoyMeter dengan panduan lengkap step-by-step</p>
    </div>

    <!-- Quick Links -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <a href="#login" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                </div>
                <span class="font-medium text-gray-900">Login & Akun</span>
            </div>
        </a>
        <a href="#dashboard" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-900">Menggunakan Dashboard</span>
            </div>
        </a>
        <a href="#karyawan" class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="font-medium text-gray-900">Mengelola Karyawan</span>
            </div>
        </a>
    </div>

    <!-- Guide 1: Login -->
    <div id="login" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-blue-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</span>
            Login & Mengakses Sistem
        </h3>
        
        <div class="space-y-4">
            <div class="pl-11">
                <h4 class="font-semibold text-gray-900 mb-2">Langkah-langkah Login:</h4>
                <ol class="list-decimal list-inside space-y-2 text-gray-700">
                    <li>Buka browser dan akses URL sistem JoyMeter</li>
                    <li>Masukkan email dan password yang telah diberikan oleh administrator</li>
                    <li>Centang "Ingat saya" jika ingin tetap login (opsional)</li>
                    <li>Klik tombol "Masuk ke Akun"</li>
                    <li>Anda akan diarahkan ke Dashboard utama</li>
                </ol>

                <div class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                    <div class="flex">
                        <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-yellow-800">Tips Keamanan:</p>
                            <ul class="text-sm text-yellow-700 mt-1 space-y-1">
                                <li>• Jangan bagikan password Anda kepada siapapun</li>
                                <li>• Selalu logout setelah selesai menggunakan sistem</li>
                                <li>• Hubungi admin jika lupa password</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 2: Dashboard -->
    <div id="dashboard" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</span>
            Menggunakan Dashboard
        </h3>
        
        <div class="space-y-6">
            <div class="pl-11">
                <h4 class="font-semibold text-gray-900 mb-3">Menu Dashboard</h4>
                
                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">📊 Statistik Ringkas</h5>
                        <p class="text-sm text-gray-700 mb-2">Di bagian atas dashboard, Anda akan melihat 4 kartu statistik:</p>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• <strong>Total Pelanggan:</strong> Jumlah keseluruhan data pelanggan</li>
                            <li>• <strong>Tingkat Kepuasan:</strong> Persentase pelanggan yang senang</li>
                            <li>• <strong>Pelanggan Hari Ini:</strong> Data pelanggan yang tercatat hari ini</li>
                            <li>• <strong>Ekspresi Dominan:</strong> Ekspresi yang paling banyak muncul</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">📈 Kategori Kepuasan</h5>
                        <p class="text-sm text-gray-700 mb-2">Sistem mengkategorikan kepuasan menjadi 3 tingkat:</p>
                        <ul class="text-sm text-gray-700 space-y-1 ml-4">
                            <li>• <strong>😊 Senang:</strong> Nilai ≥70% (Warna Hijau)</li>
                            <li>• <strong>😐 Netral:</strong> Nilai 40-69% (Warna Kuning)</li>
                            <li>• <strong>😞 Tidak Puas:</strong> Nilai <40% (Warna Merah)</li>
                        </ul>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg">
                        <h5 class="font-medium text-gray-900 mb-2">📅 Filter Berdasarkan Tanggal</h5>
                        <ol class="text-sm text-gray-700 space-y-1 ml-4 list-decimal">
                            <li>Klik form "Rentang Waktu" di bagian atas</li>
                            <li>Pilih tanggal mulai dan tanggal akhir</li>
                            <li>Klik "Terapkan Filter"</li>
                            <li>Data akan difilter sesuai rentang waktu yang dipilih</li>
                            <li>Klik "Tampilkan Semua" untuk melihat semua data</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 3: Kepuasan Pelanggan -->
    <div id="satisfaction" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-yellow-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">3</span>
            Menu Kepuasan Pelanggan
        </h3>
        
        <div class="space-y-4 pl-11">
            <p class="text-gray-700">Menu ini memberikan analisis detail tentang kepuasan pelanggan.</p>
            
            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">📊 Grafik Tren Kepuasan</h5>
                    <p class="text-sm text-gray-700">Menampilkan perubahan tingkat kepuasan dari waktu ke waktu. Grafik akan menampilkan data harian (jika rentang <30 hari) atau bulanan (jika rentang >30 hari).</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">🥧 Distribusi Kategori</h5>
                    <p class="text-sm text-gray-700">Grafik pie chart yang menunjukkan persentase masing-masing kategori (Senang, Netral, Tidak Puas).</p>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">📄 Export ke PDF</h5>
                    <ol class="text-sm text-gray-700 space-y-1 list-decimal ml-4">
                        <li>Pilih rentang tanggal yang ingin diekspor (opsional)</li>
                        <li>Klik tombol "Export PDF" berwarna merah</li>
                        <li>File PDF akan otomatis terdownload</li>
                        <li>Buka file PDF untuk melihat laporan lengkap</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 4: Karyawan Management -->
    <div id="karyawan" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-purple-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">4</span>
            Mengelola Karyawan (Admin Only)
        </h3>
        
        <div class="space-y-4 pl-11">
            <div class="p-4 bg-purple-50 border border-purple-200 rounded-lg">
                <p class="text-sm text-purple-800">
                    <strong>⚠️ Catatan:</strong> Fitur ini hanya tersedia untuk admin. Karyawan hanya dapat melihat daftar karyawan tanpa bisa menambah, edit, atau hapus.
                </p>
            </div>

            <div class="space-y-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">➕ Menambah Karyawan Baru</h5>
                    <ol class="text-sm text-gray-700 space-y-1 list-decimal ml-4">
                        <li>Buka menu "Karyawan" dari sidebar</li>
                        <li>Klik tombol "Tambah Karyawan" di kanan atas</li>
                        <li>Isi form dengan lengkap:
                            <ul class="ml-4 mt-1 space-y-0.5">
                                <li>- Nama lengkap karyawan</li>
                                <li>- Email (akan digunakan untuk login)</li>
                                <li>- Password (minimal 6 karakter)</li>
                                <li>- Peran (Karyawan atau Admin)</li>
                            </ul>
                        </li>
                        <li>Klik "Simpan Karyawan"</li>
                        <li>Karyawan baru berhasil ditambahkan</li>
                    </ol>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">✏️ Mengedit Data Karyawan</h5>
                    <ol class="text-sm text-gray-700 space-y-1 list-decimal ml-4">
                        <li>Cari karyawan yang ingin diedit</li>
                        <li>Klik ikon pensil (✏️) di kolom Aksi</li>
                        <li>Ubah data yang diperlukan</li>
                        <li>Password bersifat opsional (kosongkan jika tidak ingin mengubah)</li>
                        <li>Klik "Simpan Perubahan"</li>
                    </ol>
                </div>

                <div class="p-4 bg-gray-50 rounded-lg">
                    <h5 class="font-medium text-gray-900 mb-2">🗑️ Menghapus Karyawan</h5>
                    <ol class="text-sm text-gray-700 space-y-1 list-decimal ml-4">
                        <li>Cari karyawan yang ingin dihapus</li>
                        <li>Klik ikon tempat sampah (🗑️) di kolom Aksi</li>
                        <li>Konfirmasi penghapusan dengan klik "OK"</li>
                        <li>Karyawan akan dihapus dari sistem</li>
                    </ol>
                    <p class="text-sm text-red-600 mt-2">
                        <strong>⚠️ Perhatian:</strong> Anda tidak bisa menghapus akun Anda sendiri.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Guide 5: Support -->
    <div id="support" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
            <span class="w-8 h-8 bg-orange-500 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">5</span>
            Menggunakan Fitur Support
        </h3>
        
        <div class="space-y-4 pl-11">
            <div class="p-4 bg-gray-50 rounded-lg">
                <h5 class="font-medium text-gray-900 mb-2">🎫 Membuat Tiket Support</h5>
                <ol class="text-sm text-gray-700 space-y-1 list-decimal ml-4">
                    <li>Buka menu "Support" dari sidebar</li>
                    <li>Klik "Buat Tiket" atau tombol oranye di dashboard support</li>
                    <li>Isi form tiket:
                        <ul class="ml-4 mt-1 space-y-0.5">
                            <li>- Pilih kategori (Bug, Pertanyaan, Teknis, dll)</li>
                            <li>- Pilih prioritas (Rendah, Sedang, Tinggi, Mendesak)</li>
                            <li>- Tulis subjek yang jelas</li>
                            <li>- Jelaskan masalah secara detail</li>
                        </ul>
                    </li>
                    <li>Klik "Kirim Tiket"</li>
                    <li>Tim support akan merespon dalam 1x24 jam</li>
                </ol>
            </div>

            <div class="p-4 bg-gray-50 rounded-lg">
                <h5 class="font-medium text-gray-900 mb-2">📋 Melihat Status Tiket</h5>
                <ul class="text-sm text-gray-700 space-y-1 ml-4">
                    <li>• <strong>Terbuka:</strong> Tiket baru dibuat, menunggu respon admin</li>
                    <li>• <strong>Dalam Proses:</strong> Admin sedang menangani tiket</li>
                    <li>• <strong>Terselesaikan:</strong> Masalah sudah diselesaikan</li>
                    <li>• <strong>Ditutup:</strong> Tiket sudah selesai dan ditutup</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Video Tutorials (Optional) -->
    <div class="bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg border border-purple-200 p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">🎥 Video Tutorial</h3>
        <p class="text-gray-700 mb-4">Untuk panduan visual yang lebih detail, Anda dapat menonton video tutorial kami:</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                    </svg>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Pengenalan Dashboard</h4>
                <p class="text-sm text-gray-600">Durasi: 5 menit</p>
            </div>
            <div class="bg-white rounded-lg p-4 border border-gray-200">
                <div class="aspect-video bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z"/>
                    </svg>
                </div>
                <h4 class="font-medium text-gray-900 mb-1">Cara Export Laporan</h4>
                <p class="text-sm text-gray-600">Durasi: 3 menit</p>
            </div>
        </div>
    </div>
@endsection