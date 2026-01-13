@extends('layouts.app')

@section('title', 'Sesi Kamera - Deteksi Ekspresi')
@section('page-title', 'Deteksi Ekspresi Pelanggan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/camera-session.css') }}">
@endpush

@section('content')
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center text-sm text-gray-600 hover:text-[#F6821F] transition-colors">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Camera Feed Section --}}
        <div class="lg:col-span-2">
            @include('camera.partials.camera-feed')
        </div>

        {{-- Live Data Section --}}
        <div class="lg:col-span-1">
            @include('camera.partials.expression-monitor')
            @include('camera.partials.session-info')
        </div>
    </div>
@endsection

@push('scripts')
{{-- Face-api.js Library --}}
<script defer src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

{{-- Camera Session Manager --}}
<script src="{{ asset('js/camera-session.js') }}"></script>

{{-- Initialize with config --}}
<script>
    window.CAMERA_CONFIG = {
        csrfToken: '{{ csrf_token() }}',
        saveUrl: '{{ route('camera.save-expression') }}',
        sessionId: '{{ $sessionId }}',
        userName: '{{ auth()->user()->name }}'
    };
</script>
@endpush