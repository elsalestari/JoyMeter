<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerExpression extends Model
{
    use HasFactory;

    protected $fillable = [
        'emotion',
        'confidence',
        'detected_at',
    ];

    protected $casts = [
        'confidence' => 'decimal:2',
        'detected_at' => 'datetime',
    ];

    /**
     * Get satisfaction category (3 levels: Senang, Netral, Tidak Puas)
     * Based directly on emotion
     */
    public function getSatisfactionCategoryAttribute(): string
    {
        $emotion = strtolower($this->emotion);
        
        // Senang: happy, surprised
        if (in_array($emotion, ['happy', 'surprised'])) {
            return 'Senang';
        }
        
        // Netral: neutral
        if ($emotion === 'neutral') {
            return 'Netral';
        }
        
        // Tidak Puas: sad, angry, fear, disgust
        return 'Tidak Puas';
    }

    /**
     * Get emoji for emotion
     */
    public function getEmotionEmojiAttribute(): string
    {
        $emotion = strtolower($this->emotion);
        
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
        $emotion = strtolower($this->emotion);
        
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

    /**
     * Static method to get all emotions that belong to a satisfaction category
     */
    public static function getEmotionsByCategory(string $category): array
    {
        return match(strtolower($category)) {
            'senang' => ['happy', 'surprised'],
            'netral' => ['neutral'],
            'tidak puas' => ['sad', 'angry', 'fear', 'disgust'],
            default => [],
        };
    }
}
