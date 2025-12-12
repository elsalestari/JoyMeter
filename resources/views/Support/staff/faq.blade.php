{{-- ================================================================= --}}
{{-- FILE: resources/views/support/staff/faq.blade.php --}}
{{-- FAQ UNTUK STAFF/KARYAWAN --}}
{{-- ================================================================= --}}

@extends('layouts.app')

@section('title', 'FAQ')
@section('page-title', 'Frequently Asked Questions')

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
    <div class="bg-gradient-to-r from-[#F7AA4A] to-[#F6821F] rounded-lg shadow-lg p-8 mb-6 text-white">
        <h2 class="text-2xl font-bold mb-2">📚 Frequently Asked Questions</h2>
        <p class="opacity-90">Temukan jawaban untuk pertanyaan yang sering diajukan</p>
    </div>

    <!-- Search Box -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="relative">
            <input type="text" 
                   id="faqSearch"
                   placeholder="Cari pertanyaan..." 
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#F7AA4A]">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- FAQ Categories -->
    <div class="space-y-6">
        <!-- Umum -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-[#F7AA4A] mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Umum
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Apa itu JoyMeter?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        JoyMeter adalah sistem analisis kepuasan pelanggan berbasis AI yang menggunakan teknologi pengenalan ekspresi wajah untuk mengukur tingkat kepuasan pelanggan secara real-time melalui kamera.
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Siapa yang bisa menggunakan sistem ini?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Sistem ini digunakan oleh karyawan dan admin perusahaan. Karyawan dapat melihat data dan membuat laporan, sedangkan admin memiliki akses penuh untuk mengelola data, karyawan, dan pengaturan sistem.
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara kerja sistem ini?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Sistem menggunakan kamera untuk menangkap ekspresi wajah pelanggan, kemudian AI menganalisis ekspresi tersebut dan mengklasifikasikannya ke dalam kategori emosi (senang, sedih, marah, dll). Data ini kemudian ditampilkan dalam dashboard untuk analisis lebih lanjut.
                    </div>
                </details>
            </div>
        </div>

        <!-- Dashboard & Data -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                </svg>
                Dashboard & Data
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara membaca data di dashboard?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Dashboard menampilkan 3 kategori utama: Senang (≥70%), Netral (40-69%), dan Tidak Puas (<40%). Grafik tren menunjukkan perubahan kepuasan dari waktu ke waktu, dan tabel riwayat memberikan detail per hari/bulan.
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara filter data berdasarkan tanggal?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Gunakan form "Rentang Waktu" di bagian atas halaman. Pilih tanggal mulai dan tanggal akhir, lalu klik "Terapkan Filter". Untuk melihat semua data, klik "Tampilkan Semua".
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara export data ke PDF?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Buka menu "Kepuasan Pelanggan", pilih filter tanggal jika diperlukan, kemudian klik tombol "Export PDF" di bagian atas. File PDF akan otomatis terdownload.
                    </div>
                </details>
            </div>
        </div>

        <!-- Akun & Keamanan -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Akun & Keamanan
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara mengganti password?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Hubungi administrator untuk mengganti password Anda. Admin dapat mengubah password melalui menu Karyawan > Edit.
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Lupa password, bagaimana?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Hubungi administrator atau tim support untuk mereset password Anda. Buat tiket support dengan kategori "Masalah Teknis" untuk permintaan reset password.
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Apa perbedaan role Karyawan dan Admin?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <strong>Karyawan:</strong> Dapat melihat dashboard, data kepuasan pelanggan, daftar karyawan, dan membuat tiket support.<br>
                        <strong>Admin:</strong> Memiliki semua akses Karyawan plus dapat mengelola data karyawan (tambah, edit, hapus) dan menjawab tiket support.
                    </div>
                </details>
            </div>
        </div>

        <!-- Support & Tiket -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                Support & Tiket
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara membuat tiket support?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <ol class="list-decimal ml-5 space-y-1">
                            <li>Buka menu <strong>Support</strong> dari sidebar</li>
                            <li>Klik tombol <strong>"Laporkan Masalah"</strong> atau <strong>"Buat Tiket Baru"</strong></li>
                            <li>Pilih kategori masalah (Bug, Pertanyaan, Teknis, dll)</li>
                            <li>Pilih tingkat prioritas</li>
                            <li>Tulis subjek yang jelas dan deskripsi lengkap</li>
                            <li>Klik <strong>"Kirim Tiket"</strong></li>
                            <li>Tim support akan merespon dalam 1x24 jam</li>
                        </ol>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Berapa lama tiket saya akan direspon?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2">Waktu respon tergantung prioritas:</p>
                        <ul class="ml-5 space-y-1">
                            <li>• <strong>Mendesak:</strong> Maksimal 1 jam</li>
                            <li>• <strong>Tinggi:</strong> Maksimal 4 jam</li>
                            <li>• <strong>Sedang:</strong> Maksimal 24 jam</li>
                            <li>• <strong>Rendah:</strong> Maksimal 3 hari kerja</li>
                        </ul>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara melihat status tiket saya?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        Buka menu <strong>Support > Tiket Support Anda</strong>. Anda akan melihat daftar semua tiket Anda dengan status masing-masing (Terbuka, Dalam Proses, Terselesaikan, Ditutup). Klik pada tiket untuk melihat detail dan respon dari admin.
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- Contact Support -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h4 class="font-medium text-blue-900 mb-1">Tidak menemukan jawaban Anda?</h4>
                <p class="text-sm text-blue-700 mb-3">Hubungi tim support kami untuk mendapatkan bantuan lebih lanjut.</p>
                <a href="{{ route('support.tickets.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition-colors">
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
    // Simple FAQ Search
    document.getElementById('faqSearch').addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        const faqItems = document.querySelectorAll('.faq-item');
        
        faqItems.forEach(item => {
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