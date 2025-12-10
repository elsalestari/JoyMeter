@extends('layouts.app')

@section('title', 'Edit Karyawan')
@section('page-title', 'Edit Karyawan')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('staff.index') }}" 
               class="inline-flex items-center text-sm text-gray-600 hover:text-[#F6821F] transition-colors">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali ke Daftar Karyawan
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <div class="mb-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Edit Informasi Karyawan</h3>
                <p class="text-sm text-gray-500">Perbarui data karyawan {{ $staff->name }}</p>
            </div>

            <form method="POST" action="{{ route('staff.update', $staff) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', $staff->name) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('name') border-red-300 @enderror"
                           placeholder="Masukkan nama lengkap">
                    @error('name')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $staff->email) }}"
                           required
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('email') border-red-300 @enderror"
                           placeholder="nama@email.com">
                    @error('email')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                        Peran <span class="text-red-500">*</span>
                    </label>
                    <select id="role" 
                            name="role" 
                            required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('role') border-red-300 @enderror">
                        <option value="">Pilih Peran</option>
                        <option value="staff" {{ old('role', $staff->role) == 'staff' ? 'selected' : '' }}>Karyawan</option>
                        <option value="admin" {{ old('role', $staff->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                    <p class="mt-2 text-xs text-gray-500">
                        <span class="font-medium">Karyawan:</span> Dapat melihat data<br>
                        <span class="font-medium">Admin:</span> Dapat melihat dan mengelola semua data
                    </p>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-200 pt-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-2">Ubah Password (Opsional)</h4>
                    <p class="text-xs text-gray-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password" 
                               name="password" 
                               class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A] @error('password') border-red-300 @enderror"
                               placeholder="Minimal 6 karakter (opsional)">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="button"
                                    class="text-gray-400 hover:text-gray-600 focus:outline-none"
                                    data-toggle-password="password">
                                <svg class="h-5 w-5 hidden" data-password-icon="show" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="h-5 w-5" data-password-icon="hide" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @error('password')
                        <p class="mt-2 text-sm text-red-600 flex items-center">
                            <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        Konfirmasi Password Baru
                    </label>
                    <div class="relative">
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="w-full px-4 py-2 pr-12 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#F7AA4A]"
                               placeholder="Ketik ulang password baru (opsional)">
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <button type="button"
                                    class="text-gray-400 hover:text-gray-600 focus:outline-none"
                                    data-toggle-password="password_confirmation">
                                <svg class="h-5 w-5 hidden" data-password-icon="show" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg class="h-5 w-5" data-password-icon="hide" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end gap-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('staff.index') }}" 
                       class="px-6 py-2 border border-gray-300 text-gray-700 rounded-md hover:bg-gray-50 transition-colors text-sm font-medium">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-gradient-to-r from-[#F7AA4A] to-[#F6821F] text-white rounded-md hover:shadow-lg transition-all text-sm font-medium">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <svg class="w-5 h-5 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div>
                    <p class="text-sm text-blue-800 font-medium mb-1">Informasi</p>
                    <ul class="text-xs text-blue-700 space-y-1">
                        <li>• Data karyawan dibuat pada: {{ $staff->created_at->format('d M Y, H:i') }} WIB</li>
                        <li>• Aktivitas terakhir: {{ $staff->updated_at->format('d M Y, H:i') }} WIB</li>
                        @if($staff->id === auth()->id())
                        <li class="text-[#F6821F] font-medium">• Ini adalah akun Anda sendiri</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Toggle password visibility
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            const targetId = button.dataset.togglePassword;
            const input = document.getElementById(targetId);
            if (!input) return;

            const showIcon = button.querySelector('[data-password-icon="show"]');
            const hideIcon = button.querySelector('[data-password-icon="hide"]');

            button.addEventListener('click', () => {
                const showing = input.type === 'text';
                input.type = showing ? 'password' : 'text';
                
                if (showIcon && hideIcon) {
                    showIcon.classList.toggle('hidden', showing);
                    hideIcon.classList.toggle('hidden', !showing);
                }
            });
        });
    });
</script>
@endpush