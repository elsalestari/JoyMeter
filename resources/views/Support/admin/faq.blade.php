{{-- ================================================================= --}}
{{-- FILE: resources/views/support/admin/faq.blade.php --}}
{{-- FAQ UNTUK ADMIN --}}
{{-- ================================================================= --}}

@extends('layouts.app')

@section('title', 'FAQ Admin')
@section('page-title', 'FAQ - Admin Support')

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
        <h2 class="text-2xl font-bold mb-2">📚 FAQ untuk Admin Support</h2>
        <p class="opacity-90">Pertanyaan umum seputar pengelolaan tiket support dan sistem</p>
    </div>

    <!-- Search Box -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <div class="relative">
            <input type="text" 
                   id="faqSearch"
                   placeholder="Cari pertanyaan..." 
                   class="w-full px-4 py-3 pl-12 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            <svg class="w-5 h-5 text-gray-400 absolute left-4 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
    </div>

    <!-- FAQ Categories -->
    <div class="space-y-6">
        <!-- Pengelolaan Tiket -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Pengelolaan Tiket Support
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara memprioritaskan tiket yang harus ditangani?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2"><strong>Urutan prioritas:</strong></p>
                        <ol class="list-decimal ml-5 space-y-1">
                            <li><strong class="text-red-600">Urgent</strong> - Sistem down, error kritis yang menghambat operasional</li>
                            <li><strong class="text-orange-600">High</strong> - Bug yang mengganggu fungsi penting</li>
                            <li><strong class="text-yellow-600">Medium</strong> - Masalah yang perlu solusi tapi tidak mendesak</li>
                            <li><strong class="text-green-600">Low</strong> - Pertanyaan umum, saran fitur</li>
                        </ol>
                        <p class="mt-3">Selalu tangani tiket dengan status <span class="px-2 py-1 bg-orange-100 text-orange-800 rounded text-xs font-semibold">Terbuka</span> terlebih dahulu.</p>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Berapa lama SLA (Service Level Agreement) untuk merespon tiket?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2"><strong>Target waktu respon:</strong></p>
                        <ul class="ml-5 space-y-1">
                            <li>• <strong>Urgent:</strong> Maksimal 1 jam</li>
                            <li>• <strong>High:</strong> Maksimal 4 jam</li>
                            <li>• <strong>Medium:</strong> Maksimal 1 hari kerja (24 jam)</li>
                            <li>• <strong>Low:</strong> Maksimal 3 hari kerja (72 jam)</li>
                        </ul>
                        <p class="mt-3 text-blue-700">💡 <em>Tip: Kirim respon awal untuk acknowledge tiket, meskipun solusi penuh belum tersedia.</em></p>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Kapan saya harus mengubah status tiket?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2"><strong>Panduan status tiket:</strong></p>
                        <ul class="ml-5 space-y-2">
                            <li>• <strong>Terbuka:</strong> Tiket baru masuk, belum ada respon</li>
                            <li>• <strong>Dalam Proses:</strong> Setelah Anda memberikan respon/balasan pertama</li>
                            <li>• <strong>Terselesaikan:</strong> Masalah sudah solved, menunggu konfirmasi dari karyawan</li>
                            <li>• <strong>Ditutup:</strong> Karyawan confirm masalah selesai atau tidak ada follow-up setelah 7 hari</li>
                        </ul>
                    </div>
                </details>
            </div>
        </div>

        <!-- Best Practices -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Best Practices Support
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara memberikan respon yang baik?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2"><strong>Struktur respon yang efektif:</strong></p>
                        <ol class="list-decimal ml-5 space-y-2">
                            <li><strong>Greeting & Acknowledgment:</strong> Sapa dan terima kasih atas laporannya</li>
                            <li><strong>Pemahaman Masalah:</strong> Ringkas ulang masalah untuk konfirmasi</li>
                            <li><strong>Solusi/Langkah Selanjutnya:</strong> Berikan solusi konkret atau timeline investigasi</li>
                            <li><strong>Follow-up:</strong> Ajukan pertanyaan jika butuh info tambahan</li>
                            <li><strong>Closing:</strong> Tawarkan bantuan lebih lanjut jika diperlukan</li>
                        </ol>
                        <div class="mt-3 p-3 bg-blue-50 rounded">
                            <p class="text-xs text-blue-900"><strong>Contoh:</strong> "Halo [Nama], terima kasih atas laporannya. Saya memahami Anda mengalami error saat login. Saya sudah melakukan reset password untuk akun Anda. Silakan coba login dengan password baru: [xxx]. Jika masih ada kendala, jangan ragu untuk menghubungi kembali."</p>
                        </div>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Apa yang harus dilakukan jika saya tidak tahu solusinya?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2"><strong>Langkah-langkah:</strong></p>
                        <ol class="list-decimal ml-5 space-y-2">
                            <li>Jangan panik atau menunda respon</li>
                            <li>Kirim respon awal: acknowledge tiket dan inform sedang investigasi</li>
                            <li>Cari di Knowledge Base atau dokumentasi internal</li>
                            <li>Konsultasi dengan senior admin atau IT team</li>
                            <li>Beri update ke karyawan tentang progress (misal: "Sedang dikonsultasikan dengan IT team, estimasi 2 jam")</li>
                            <li>Jangan membuat janji yang tidak bisa ditepati</li>
                        </ol>
                        <p class="mt-3 text-green-700">✅ <strong>Better to be honest than give wrong solution!</strong></p>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana menangani karyawan yang komplain agresif?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p class="mb-2"><strong>Tetap profesional dan empati:</strong></p>
                        <ul class="ml-5 space-y-2">
                            <li>• Jangan ambil personally - mereka frustasi dengan masalah, bukan dengan Anda</li>
                            <li>• Acknowledge frustrasi mereka: "Saya memahami ini sangat mengganggu pekerjaan Anda"</li>
                            <li>• Fokus pada solusi, bukan siapa yang salah</li>
                            <li>• Set ekspektasi yang realistis tentang timeline</li>
                            <li>• Prioritaskan tiket mereka jika memang urgent</li>
                            <li>• Jika terlalu personal, escalate ke supervisor</li>
                        </ul>
                    </div>
                </details>
            </div>
        </div>

        <!-- Sistem & Teknis -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-6 h-6 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Sistem & Teknis
            </h3>
            <div class="space-y-4">
                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Bagaimana cara reset password karyawan?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <ol class="list-decimal ml-5 space-y-1">
                            <li>Buka menu <strong>Karyawan</strong></li>
                            <li>Cari karyawan yang bersangkutan</li>
                            <li>Klik tombol <strong>Edit</strong> (ikon pensil)</li>
                            <li>Isi password baru (minimal 6 karakter) dan konfirmasi</li>
                            <li>Klik <strong>Simpan Perubahan</strong></li>
                            <li>Informasikan password baru ke karyawan melalui tiket atau komunikasi pribadi</li>
                        </ol>
                    </div>
                </details>

                <details class="faq-item group">
                    <summary class="cursor-pointer list-none flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                        <span class="font-medium text-gray-900">Dimana saya bisa melihat log error sistem?</span>
                        <svg class="w-5 h-5 text-gray-500 transform group-open:rotate-180 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </summary>
                    <div class="mt-3 px-4 text-sm text-gray-600">
                        <p>Untuk error log sistem, hubungi IT Administrator atau Developer. Admin support fokus pada user support, bukan infrastruktur teknis.</p>
                        <p class="mt-2">Jika ada masalah teknis yang di luar kapasitas Anda, escalate ke IT team.</p>
                    </div>
                </details>
            </div>
        </div>
    </div>

    <!-- Contact IT -->
    <div class="mt-6 bg-purple-50 border border-purple-200 rounded-lg p-6">
        <div class="flex items-start">
            <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <div>
                <h4 class="font-medium text-purple-900 mb-1">Butuh Bantuan Teknis Lebih Lanjut?</h4>
                <p class="text-sm text-purple-700 mb-3">
                    Jika ada pertanyaan teknis yang tidak tercakup di sini atau memerlukan akses sistem yang lebih advance, hubungi IT Department.
                </p>
                <p class="text-xs text-purple-600">
                    Email: it-support@company.com | Ext: 1234
                </p>
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