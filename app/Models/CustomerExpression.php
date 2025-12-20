<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerExpression extends Model
{
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
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Get satisfaction category based on dominant emotion
     * - Happy → Senang
     * - Neutral → Netral
     * - Others (Sad/Angry/Fearful/Disgusted/Surprised) → Tidak Puas
     */
    public function getSatisfactionCategoryAttribute(): string
    {
        return match($this->dominant_emotion) {
            'happy' => 'Senang',
            'neutral' => 'Netral',
            default => 'Tidak Puas', 
        };
    }

    /**
     * Get emoji for satisfaction category based on dominant emotion
     */
    public function getCategoryEmojiAttribute(): string
    {
        return match($this->dominant_emotion) {
            'happy' => '😊',
            'neutral' => '😐',
            default => '😞', 
        };
    }

    /**
     * Get human-readable emotion label
     */
    public function getEmotionLabelAttribute(): string
    {
        return match($this->dominant_emotion) {
            'happy' => 'Senang',
            'sad' => 'Sedih',
            'angry' => 'Marah',
            'surprised' => 'Terkejut',
            'neutral' => 'Netral',
            'fear' => 'Takut',
            'disgust' => 'Jijik',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Get emoji for emotion
     */
    public function getEmotionEmojiAttribute(): string
    {
        return match($this->dominant_emotion) {
            'happy' => '😊',
            'sad' => '😢',
            'angry' => '😠',
            'surprised' => '😲',
            'neutral' => '😐',
            'fear' => '😨',
            'disgust' => '🤢',
            default => '😐',
        };
    }
}