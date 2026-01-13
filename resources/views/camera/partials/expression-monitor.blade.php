<div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6 mb-6">
    <h3 class="text-lg font-semibold text-gray-900 mb-4">Ekspresi Terdeteksi</h3>
    
    {{-- Expression Bars --}}
    <div class="space-y-3">
        @php
        $expressions = [
            ['id' => 'happy', 'emoji' => '😊', 'label' => 'Happy', 'color' => 'green'],
            ['id' => 'neutral', 'emoji' => '😐', 'label' => 'Neutral', 'color' => 'gray'],
            ['id' => 'sad', 'emoji' => '😢', 'label' => 'Sad', 'color' => 'blue'],
            ['id' => 'angry', 'emoji' => '😠', 'label' => 'Angry', 'color' => 'red'],
            ['id' => 'surprised', 'emoji' => '😲', 'label' => 'Surprised', 'color' => 'yellow'],
            ['id' => 'fearful', 'emoji' => '😨', 'label' => 'Fearful', 'color' => 'purple'],
            ['id' => 'disgusted', 'emoji' => '🤢', 'label' => 'Disgusted', 'color' => 'pink'],
        ];
        @endphp

        @foreach($expressions as $expression)
        <div>
            <div class="flex justify-between text-xs text-gray-600 mb-1">
                <span>{{ $expression['emoji'] }} {{ $expression['label'] }}</span>
                <span id="{{ $expression['id'] }}-percent">0%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div id="{{ $expression['id'] }}-bar" 
                     class="expression-bar bg-{{ $expression['color'] }}-500 h-2 rounded-full transition-all duration-300" 
                     style="width: 0%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>