<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Satisfaction Score Ranges
    |--------------------------------------------------------------------------
    | 
    */
    'ranges' => [
        'senang' => ['min' => 80, 'max' => 100],
        'netral' => ['min' => 45, 'max' => 79],
        'tidak_puas' => ['min' => 0, 'max' => 44],
    ],

    // Labels untuk kategori
    'labels' => [
        'senang' => 'Senang',
        'netral' => 'Netral',
        'tidak_puas' => 'Tidak Puas',
    ],

    // Emojis untuk kategori
    'emojis' => [
        'senang' => '😊',
        'netral' => '😐',
        'tidak_puas' => '😞',
    ],

    // Badge Classes
    'badge_classes' => [
        'senang' => 'bg-green-100 text-green-800',
        'netral' => 'bg-yellow-100 text-yellow-800',
        'tidak_puas' => 'bg-red-100 text-red-800',
    ],

    /*
    |--------------------------------------------------------------------------
    | Expression Weights untuk Satisfaction Score
    |--------------------------------------------------------------------------
    */
    'weights' => [
        'happy'     => 100,
        'surprised' => 30,
        'neutral'   => 50,
        'sad'       => 20,
        'fear'      => 15,
        'angry'     => 10,
        'disgust'   => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Expression Display Information
    |--------------------------------------------------------------------------
    */
    'expressions' => [
        'happy' => [
            'label' => 'Senang',
            'emoji' => '😊',
            'sentiment' => 'positive',
            'description' => 'Pelanggan menunjukkan kebahagiaan'
        ],
        'surprised' => [
            'label' => 'Terkejut',
            'emoji' => '😲',
            'sentiment' => 'neutral-positive',
            'description' => 'Pelanggan terkejut (bisa positif/negatif)'
        ],
        'neutral' => [
            'label' => 'Netral',
            'emoji' => '😐',
            'sentiment' => 'neutral',
            'description' => 'Pelanggan tidak menunjukkan emosi kuat'
        ],
        'sad' => [
            'label' => 'Sedih',
            'emoji' => '😢',
            'sentiment' => 'negative',
            'description' => 'Pelanggan menunjukkan kesedihan'
        ],
        'fear' => [
            'label' => 'Takut',
            'emoji' => '😨',
            'sentiment' => 'negative',
            'description' => 'Pelanggan menunjukkan ketakutan'
        ],
        'angry' => [
            'label' => 'Marah',
            'emoji' => '😠',
            'sentiment' => 'negative',
            'description' => 'Pelanggan menunjukkan kemarahan'
        ],
        'disgust' => [
            'label' => 'Jijik',
            'emoji' => '🤢',
            'sentiment' => 'negative',
            'description' => 'Pelanggan menunjukkan ketidaksukaan'
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Validation Rules
    |--------------------------------------------------------------------------
    */
    'validation' => [
        'min_session_duration' => 10,
        'min_detections' => 5,
        'expression_threshold' => 0.3,
    ],

    /*
    |--------------------------------------------------------------------------
    | Score Interpretation Guidelines
    |--------------------------------------------------------------------------
    */
    'interpretation' => [
        'excellent' => [
            'min' => 85,
            'max' => 100,
            'label' => 'Sangat Puas',
            'color' => 'green',
            'action' => 'Pertahankan kualitas layanan'
        ],
        'good' => [
            'min' => 70,
            'max' => 84,
            'label' => 'Puas',
            'color' => 'green',
            'action' => 'Tingkatkan aspek tertentu'
        ],
        'fair' => [
            'min' => 50,
            'max' => 69,
            'label' => 'Cukup',
            'color' => 'yellow',
            'action' => 'Perlu perbaikan signifikan'
        ],
        'poor' => [
            'min' => 30,
            'max' => 49,
            'label' => 'Kurang',
            'color' => 'orange',
            'action' => 'Evaluasi menyeluruh diperlukan'
        ],
        'critical' => [
            'min' => 0,
            'max' => 29,
            'label' => 'Sangat Tidak Puas',
            'color' => 'red',
            'action' => 'Tindakan darurat diperlukan'
        ],
    ],
];