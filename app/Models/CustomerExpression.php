<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerExpression extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'avg_scores',
        'dominant_emotion',
        'satisfaction',
        'started_at',
        'ended_at',
        'notes',
    ];

    protected $casts = [
        'avg_scores' => 'array',
        'satisfaction' => 'integer',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Get satisfaction category (3 levels: Senang, Netral, Tidak Puas)
     * Based on numeric satisfaction (0 - 100)
     */
    public function getSatisfactionCategoryAttribute(): string
    {
        $score = (int) $this->satisfaction;

        if ($score >= 70) {
            return 'Senang';
        }

        if ($score >= 40) {
            return 'Netral';
        }

        return 'Tidak Puas';
    }

    /**
     * Get emoji for emotion
     */
    public function getEmotionEmojiAttribute(): string
    {
        $emotion = strtolower($this->dominant_emotion ?? '');
        
        $emojiMap = [
            'happy' => '😊',
            'sad' => '😢',
            'angry' => '😠',
            'surprised' => '😲',
            'neutral' => '😐',
            'fear' => '😨',
            'disgust' => '🤢',
        ];
        
        return $emojiMap[$emotion] ?? '😐';
    }

    /**
     * Get emoji for satisfaction category
     */
    public function getCategoryEmojiAttribute(): string
    {
        $category = $this->satisfaction_category;
        
        $emojiMap = [
            'Senang' => '😊',
            'Netral' => '😐',
            'Tidak Puas' => '😞',
        ];
        
        return $emojiMap[$category] ?? '😐';
    }

    /**
     * Get Indonesian label for emotion
     */
    public function getEmotionLabelAttribute(): string
    {
        $emotion = strtolower($this->dominant_emotion ?? '');
        
        $labelMap = [
            'happy' => 'Senang',
            'sad' => 'Sedih',
            'angry' => 'Marah',
            'surprised' => 'Terkejut',
            'neutral' => 'Netral',
            'fear' => 'Takut',
            'disgust' => 'Jijik',
        ];
        
        return $labelMap[$emotion] ?? ucfirst($emotion);
    }

}
