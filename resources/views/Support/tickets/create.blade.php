@extends('layouts.app')

@section('title', 'Buat Tiket Support')
@section('page-title', 'Buat Tiket Support Baru')

@section('content')
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('support.tickets.index') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-[#F6821F] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Tiket
        </a>
    </div>

    <div class="max-w-3xl mx-auto">
        <!-- Info Card -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
            <div class="flex">
                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-medium text-blue-900 mb-1">Tips Membuat Tiket Support</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• Gunakan subjek yang jelas dan deskriptif</li>
                        <li>• Jelaskan masalah secara detail dan spesifik</li>
                        <li>• Sertakan langkah-langkah yang sudah Anda coba</li>
                        <li>• Prioritas akan otomatis disesuaikan berdasarkan kategori</li>
                        <li>• Tim support akan merespon dalam 1x24 jam</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="{{ route('support.tickets.store') }}" class="space-y-6">
                @csrf

                <!-- Kategori -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori <span class="text-red-500">*</span>
                    </label>
                    <select id="category" 
                            name="category" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('category') border-red-300 @enderror">
                        <option value="">Pilih Kategori</option>
                        <option value="bug" {{ old('category') == 'bug' ? 'selected' : '' }}>Bug/Error</option>
                        <option value="feature" {{ old('category') == 'feature' ? 'selected' : '' }}>Permintaan Fitur</option>
                        <option value="question" {{ old('category') == 'question' ? 'selected' : '' }}>Pertanyaan</option>
                        <option value="technical" {{ old('category') == 'technical' ? 'selected' : '' }}>Masalah Teknis</option>
                        <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <!-- Auto Priority Info -->
                    <p id="priorityInfo" class="mt-2 text-sm text-gray-600 italic">
                        💡 Prioritas otomatis: <span id="priorityText">Pilih kategori untuk melihat prioritas</span>
                    </p>
                </div>

                <!-- Prioritas - AUTO SELECTED (Hidden from user but can be changed) -->
                <div id="prioritySection">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Prioritas <span class="text-xs text-gray-500">(Otomatis disesuaikan)</span>
                    </label>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                        <!-- Low Priority -->
                        <label id="priority-low" class="priority-option relative flex cursor-pointer rounded-lg border p-4 shadow-sm transition-all border-gray-300 hover:bg-gray-50">
                            <input type="radio" 
                                   name="priority" 
                                   value="low" 
                                   class="sr-only" 
                                   {{ old('priority') == 'low' ? 'checked' : '' }} 
                                   required>
                            <span class="flex flex-1 flex-col">
                                <span class="block text-sm font-medium text-gray-900">Rendah</span>
                                <span class="mt-1 flex items-center text-xs text-gray-500">Tidak mendesak</span>
                            </span>
                            <svg class="checkmark h-5 w-5 text-green-600 absolute top-3 right-3 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        <!-- Medium Priority -->
                        <label id="priority-medium" class="priority-option relative flex cursor-pointer rounded-lg border p-4 shadow-sm transition-all border-gray-300 hover:bg-gray-50">
                            <input type="radio" 
                                   name="priority" 
                                   value="medium" 
                                   class="sr-only" 
                                   {{ old('priority') == 'medium' ? 'checked' : '' }} 
                                   required>
                            <span class="flex flex-1 flex-col">
                                <span class="block text-sm font-medium text-gray-900">Sedang</span>
                                <span class="mt-1 flex items-center text-xs text-gray-500">Cukup penting</span>
                            </span>
                            <svg class="checkmark h-5 w-5 text-yellow-600 absolute top-3 right-3 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        <!-- High Priority -->
                        <label id="priority-high" class="priority-option relative flex cursor-pointer rounded-lg border p-4 shadow-sm transition-all border-gray-300 hover:bg-gray-50">
                            <input type="radio" 
                                   name="priority" 
                                   value="high" 
                                   class="sr-only" 
                                   {{ old('priority') == 'high' ? 'checked' : '' }} 
                                   required>
                            <span class="flex flex-1 flex-col">
                                <span class="block text-sm font-medium text-gray-900">Tinggi</span>
                                <span class="mt-1 flex items-center text-xs text-gray-500">Perlu cepat</span>
                            </span>
                            <svg class="checkmark h-5 w-5 text-orange-600 absolute top-3 right-3 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>

                        <!-- Urgent Priority -->
                        <label id="priority-urgent" class="priority-option relative flex cursor-pointer rounded-lg border p-4 shadow-sm transition-all border-gray-300 hover:bg-gray-50">
                            <input type="radio" 
                                   name="priority" 
                                   value="urgent" 
                                   class="sr-only" 
                                   {{ old('priority') == 'urgent' ? 'checked' : '' }} 
                                   required>
                            <span class="flex flex-1 flex-col">
                                <span class="block text-sm font-medium text-gray-900">Mendesak</span>
                                <span class="mt-1 flex items-center text-xs text-gray-500">Sangat urgent</span>
                            </span>
                            <svg class="checkmark h-5 w-5 text-red-600 absolute top-3 right-3 hidden" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </label>
                    </div>
                    @error('priority')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">💡 Anda bisa mengubah prioritas jika diperlukan</p>
                </div>

                <!-- Subjek -->
                <div>
                    <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                        Subjek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="subject" 
                           name="subject" 
                           value="{{ old('subject') }}"
                           required
                           maxlength="255"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('subject') border-red-300 @enderror"
                           placeholder="Contoh: Tidak bisa login ke sistem">
                    @error('subject')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Maksimal 255 karakter</p>
                </div>

                <!-- Deskripsi -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi Masalah <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="8"
                              required
                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('description') border-red-300 @enderror"
                              placeholder="Jelaskan masalah Anda secara detail:
- Apa yang terjadi?
- Kapan masalah mulai muncul?
- Langkah-langkah apa yang sudah Anda coba?
- Apakah ada pesan error? (jika ada, sertakan)">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Minimal 10 karakter. Semakin detail, semakin cepat kami bisa membantu.</p>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('support.tickets.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-[#F7AA4A] to-[#F6821F] text-white rounded-md hover:shadow-lg transition-all text-sm font-medium">
                        Kirim Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Auto-set priority based on category
    const categoryPriorityMap = {
        'bug': 'high',           
        'feature': 'low',        
        'question': 'low',       
        'technical': 'high',     
        'other': 'medium'        
    };

    const priorityLabels = {
        'low': 'Rendah (Tidak mendesak)',
        'medium': 'Sedang (Cukup penting)',
        'high': 'Tinggi (Perlu cepat ditangani)',
        'urgent': 'Mendesak (Sangat urgent)'
    };

    const categorySelect = document.getElementById('category');
    const priorityText = document.getElementById('priorityText');

    // Function to set priority
    function setPriority(priority) {
        document.querySelectorAll('.priority-option').forEach(label => {
            label.classList.remove('border-green-500', 'ring-2', 'ring-green-500', 'bg-green-50');
            label.classList.remove('border-yellow-500', 'ring-yellow-500', 'bg-yellow-50');
            label.classList.remove('border-orange-500', 'ring-orange-500', 'bg-orange-50');
            label.classList.remove('border-red-500', 'ring-red-500', 'bg-red-50');
            label.classList.add('border-gray-300');
            label.querySelector('.checkmark')?.classList.add('hidden');
        });

        const selectedLabel = document.getElementById(`priority-${priority}`);
        const selectedRadio = selectedLabel.querySelector('input[type="radio"]');
        selectedRadio.checked = true;

        if (priority === 'low') {
            selectedLabel.classList.remove('border-gray-300');
            selectedLabel.classList.add('border-green-500', 'ring-2', 'ring-green-500', 'bg-green-50');
        } else if (priority === 'medium') {
            selectedLabel.classList.remove('border-gray-300');
            selectedLabel.classList.add('border-yellow-500', 'ring-2', 'ring-yellow-500', 'bg-yellow-50');
        } else if (priority === 'high') {
            selectedLabel.classList.remove('border-gray-300');
            selectedLabel.classList.add('border-orange-500', 'ring-2', 'ring-orange-500', 'bg-orange-50');
        } else if (priority === 'urgent') {
            selectedLabel.classList.remove('border-gray-300');
            selectedLabel.classList.add('border-red-500', 'ring-2', 'ring-red-500', 'bg-red-50');
        }
        
        selectedLabel.querySelector('.checkmark')?.classList.remove('hidden');

        priorityText.textContent = priorityLabels[priority];
        priorityText.parentElement.classList.add('text-blue-700', 'font-medium');
    }

    categorySelect.addEventListener('change', function() {
        const category = this.value;
        if (category && categoryPriorityMap[category]) {
            const priority = categoryPriorityMap[category];
            setPriority(priority);
        } else {
            priorityText.textContent = 'Pilih kategori untuk melihat prioritas';
            priorityText.parentElement.classList.remove('text-blue-700', 'font-medium');
        }
    });

    document.querySelectorAll('input[type="radio"][name="priority"]').forEach(radio => {
        radio.addEventListener('change', function() {
            setPriority(this.value);
        });
    });

    const subjectInput = document.getElementById('subject');
    if (subjectInput) {
        subjectInput.addEventListener('input', function() {
            const remaining = 255 - this.value.length;
            const helper = this.parentElement.querySelector('.text-xs');
            if (helper) {
                helper.textContent = `${remaining} karakter tersisa`;
                if (remaining < 50) {
                    helper.classList.add('text-orange-500');
                } else {
                    helper.classList.remove('text-orange-500');
                }
            }
        });
    }

    // Character counter for description
    const descInput = document.getElementById('description');
    if (descInput) {
        descInput.addEventListener('input', function() {
            const length = this.value.length;
            const helper = this.parentElement.querySelector('.text-xs');
            if (helper) {
                if (length < 10) {
                    helper.textContent = `Minimal 10 karakter (${10 - length} lagi)`;
                    helper.classList.add('text-red-500');
                } else {
                    helper.textContent = `${length} karakter. Semakin detail, semakin cepat kami bisa membantu.`;
                    helper.classList.remove('text-red-500');
                }
            }
        });
    }

    @if(old('category'))
    document.addEventListener('DOMContentLoaded', function() {
        const category = categorySelect.value;
        if (category && categoryPriorityMap[category]) {
            const priority = categoryPriorityMap[category];
            setPriority(priority);
        }
    });
    @endif
</script>
@endpush