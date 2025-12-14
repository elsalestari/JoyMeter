@extends('layouts.app')

@section('title', 'FAQ - Bantuan')
@section('page-title', 'Pertanyaan yang Sering Diajukan')

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

    <!-- FAQ Header -->
    <div class="bg-gradient-to-r from-[#F7AA4A] to-[#F6821F] rounded-lg shadow-sm p-8 mb-6 text-white">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold mb-2">Pertanyaan yang Sering Diajukan</h2>
                <p class="text-white/90">Temukan jawaban untuk pertanyaan umum seputar JoyMeter</p>
            </div>
        </div>
    </div>

    <!-- FAQ Accordion -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
                <!-- FAQ 1: Akun & Login -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
                            onclick="toggleFaq('faq1')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FAEF9F] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900">Bagaimana cara login ke sistem JoyMeter?</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" id="faq1-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq1" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Untuk login ke sistem JoyMeter, ikuti langkah berikut:</p>
                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                            <li>Buka halaman login JoyMeter di browser Anda</li>
                            <li>Masukkan email dan password yang telah diberikan oleh administrator</li>
                            <li>Klik tombol "Masuk ke Akun"</li>
                            <li>Anda akan diarahkan ke dashboard utama</li>
                        </ol>
                        <p class="text-sm text-gray-600 mt-3">
                            <strong>Catatan:</strong> Pastikan Anda menggunakan akun dengan role Karyawan atau Admin. 
                            Jika mengalami kesulitan login, hubungi administrator sistem.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2: Lupa Password -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
                            onclick="toggleFaq('faq2')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FAEF9F] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900">Bagaimana jika saya lupa password?</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" id="faq2-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq2" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Jika Anda lupa password, Anda dapat mengubahnya sendiri setelah login:</p>
                        <ol class="list-decimal list-inside space-y-2 text-gray-700 mb-4">
                            <li>Klik foto profil Anda di pojok kanan atas</li>
                            <li>Pilih menu "Pengaturan" atau "Profil Saya"</li>
                            <li>Scroll ke bagian "Ubah Password"</li>
                            <li>Masukkan password lama dan password baru Anda</li>
                            <li>Klik tombol "Ubah Password"</li>
                        </ol>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <p class="text-sm text-blue-800">
                                <strong>💡 Tips Keamanan:</strong><br>
                                • Gunakan password minimal 6 karakter<br>
                                • Kombinasikan huruf, angka, dan simbol<br>
                                • Jangan gunakan password yang mudah ditebak<br>
                                • Ubah password secara berkala untuk keamanan akun Anda
                            </p>
                        </div>
                        <p class="text-sm text-gray-600 mt-3">
                            <strong>Jika tidak bisa login sama sekali:</strong> Hubungi administrator untuk reset password atau buat tiket support.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3: Mengubah Profil -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
                            onclick="toggleFaq('faq3')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FAEF9F] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900">Bagaimana cara mengubah informasi profil saya?</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" id="faq3-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq3" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Anda dapat mengubah informasi profil Anda dengan cara:</p>
                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                            <li>Klik foto profil Anda di pojok kanan atas</li>
                            <li>Pilih menu "Profil Saya"</li>
                            <li>Klik tombol "Edit Profil"</li>
                            <li>Ubah nama atau email Anda</li>
                            <li>Klik "Simpan Perubahan"</li>
                        </ol>
                        <p class="text-sm text-gray-600 mt-3">
                            <strong>Catatan:</strong> Role/peran akun Anda tidak dapat diubah sendiri. Hubungi administrator jika perlu mengubah role.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4: Membuat Tiket Support -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
                            onclick="toggleFaq('faq4')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FAEF9F] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900">Bagaimana cara membuat tiket support?</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" id="faq4-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq4" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Untuk membuat tiket support baru:</p>
                        <ol class="list-decimal list-inside space-y-2 text-gray-700">
                            <li>Buka menu "Support" dari sidebar</li>
                            <li>Klik tombol "Laporkan Masalah" atau "Buat Tiket Baru"</li>
                            <li>Pilih kategori masalah (Bug, Feature Request, Question, Technical, Other)</li>
                            <li>Pilih tingkat prioritas (Low, Medium, High, Urgent)</li>
                            <li>Isi subjek dan deskripsi masalah secara detail</li>
                            <li>Klik "Submit Tiket"</li>
                        </ol>
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                            <p class="text-sm text-blue-800">
                                <strong>💡 Tips:</strong> Berikan deskripsi yang jelas dan detail agar tim support dapat membantu Anda dengan lebih cepat.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- FAQ 5: Status Tiket -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
                            onclick="toggleFaq('faq5')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FAEF9F] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900">Apa arti dari status tiket support?</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" id="faq5-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq5" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Status tiket menunjukkan progress penanganan masalah Anda:</p>
                        <div class="space-y-3">
                            <div class="flex items-start gap-3">
                                <span class="px-3 py-1 bg-orange-100 text-orange-800 rounded-full text-sm font-medium">Open</span>
                                <p class="text-gray-700 flex-1">Tiket baru yang belum ditangani oleh admin. Menunggu respons dari tim support.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">In Progress</span>
                                <p class="text-gray-700 flex-1">Tiket sedang dalam proses penanganan. Admin telah merespons dan sedang mengerjakan solusi.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">Resolved</span>
                                <p class="text-gray-700 flex-1">Masalah telah diselesaikan oleh admin. Anda dapat memeriksa solusi yang diberikan.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">Closed</span>
                                <p class="text-gray-700 flex-1">Tiket telah ditutup. Tidak ada tindakan lebih lanjut yang diperlukan.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ 6: Keamanan Akun -->
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="w-full px-6 py-4 text-left bg-gray-50 hover:bg-gray-100 transition-colors flex items-center justify-between"
                            onclick="toggleFaq('faq6')">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-[#FAEF9F] flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F6821F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900">Bagaimana cara menjaga keamanan akun saya?</h3>
                        </div>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" id="faq6-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="faq6" class="hidden px-6 py-4 bg-white border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Tips menjaga keamanan akun JoyMeter Anda:</p>
                        <ul class="space-y-2 text-gray-700">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Gunakan password yang kuat dan unik (minimal 6 karakter, kombinasi huruf, angka, simbol)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Ubah password secara berkala (setiap 3-6 bulan)</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Jangan bagikan password Anda kepada siapapun</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Selalu logout setelah selesai menggunakan sistem, terutama di komputer publik</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Jangan simpan password di browser jika menggunakan komputer bersama</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <span>Laporkan segera ke administrator jika mencurigai ada aktivitas tidak wajar di akun Anda</span>
                            </li>
                        </ul>
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                            <p class="text-sm text-yellow-800">
                                <strong>⚠️ Penting:</strong> Jangan pernah memberikan password Anda kepada siapapun, termasuk yang mengaku sebagai admin atau technical support.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bantuan Tambahan -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mt-6">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-blue-900 mb-2">Tidak Menemukan Jawaban?</h3>
                <p class="text-blue-800 mb-4">Jika pertanyaan Anda tidak terjawab di FAQ ini, jangan ragu untuk menghubungi kami.</p>
                <a href="{{ route('support.tickets.create') }}" 
                   class="inline-flex items-center px-4 py-2 bg-[#F6821F] text-white rounded-lg hover:bg-[#d96f1a] transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
    function toggleFaq(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById(id + '-icon');
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.style.transform = 'rotate(180deg)';
        } else {
            content.classList.add('hidden');
            icon.style.transform = 'rotate(0deg)';
        }
    }
</script>
@endpush