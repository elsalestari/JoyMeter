<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class CustomerExpression extends Model
{
    protected $fillable = [
        'session_id',
        'avg_scores',
        'dominant_emotion',
        'satisfaction',
        'started_at',
        'ended_at',
        'notes'
    ];

    protected $casts = [
        'avg_scores' => 'array',
        'satisfaction' => 'integer',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    /**
     * Scope untuk filter berdasarkan range tanggal
     */
    public function scopeDateRange(Builder $query, ?string $startDate, ?string $endDate): Builder
    {
        if ($startDate && $endDate) {
            return $query->whereBetween('ended_at', [
                Carbon::parse($startDate)->startOfDay(),
                Carbon::parse($endDate)->endOfDay(),
            ]);
        }
        
        return $query;
    }

    /**
     * Scope untuk kategori SENANG
     */
    public function scopeSenang(Builder $query): Builder
    {
        $min = config('satisfaction.ranges.senang.min');
        return $query->where('satisfaction', '>=', $min);
    }

    /**
     * Scope untuk kategori NETRAL
     */
    public function scopeNetral(Builder $query): Builder
    {
        $min = config('satisfaction.ranges.netral.min');
        $max = config('satisfaction.ranges.netral.max');
        return $query->whereBetween('satisfaction', [$min, $max]);
    }

    /**
     * Scope untuk kategori TIDAK PUAS
     */
    public function scopeTidakPuas(Builder $query): Builder
    {
        $max = config('satisfaction.ranges.tidak_puas.max');
        return $query->where('satisfaction', '<=', $max);
    }

    /**
     * Get kategori kepuasan berdasarkan score
     */
    public function getSatisfactionCategoryAttribute(): string
    {
        $ranges = config('satisfaction.ranges');
        
        if ($this->satisfaction >= $ranges['senang']['min']) {
            return 'Senang';
        } elseif ($this->satisfaction >= $ranges['netral']['min']) {
            return 'Netral';
        } else {
            return 'Tidak Puas';
        }
    }

    /**
     * Get emoji berdasarkan kategori
     */
    public function getCategoryEmojiAttribute(): string
    {
        $ranges = config('satisfaction.ranges');
        $emojis = config('satisfaction.emojis');
        
        if ($this->satisfaction >= $ranges['senang']['min']) {
            return $emojis['senang'];
        } elseif ($this->satisfaction >= $ranges['netral']['min']) {
            return $emojis['netral'];
        } else {
            return $emojis['tidak_puas'];
        }
    }

    /**
     * Get badge class berdasarkan kategori
     */
    public function getCategoryBadgeClassAttribute(): string
    {
        $ranges = config('satisfaction.ranges');
        $classes = config('satisfaction.badge_classes');
        
        if ($this->satisfaction >= $ranges['senang']['min']) {
            return $classes['senang'];
        } elseif ($this->satisfaction >= $ranges['netral']['min']) {
            return $classes['netral'];
        } else {
            return $classes['tidak_puas'];
        }
    }

    /**
     * Get label ekspresi dominan
     */
    public function getEmotionLabelAttribute(): string
    {
        $expressions = config('satisfaction.expressions');
        
        if (isset($expressions[$this->dominant_emotion])) {
            return $expressions[$this->dominant_emotion]['label'];
        }
        
        return ucfirst($this->dominant_emotion ?? 'Unknown');
    }

    /**
     * Get emoji ekspresi dominan
     */
    public function getEmotionEmojiAttribute(): string
    {
        $expressions = config('satisfaction.expressions');
        
        if (isset($expressions[$this->dominant_emotion])) {
            return $expressions[$this->dominant_emotion]['emoji'];
        }
        
        return '😐';
    }

    /**
     * Get sentiment dari ekspresi dominan
     */
    public function getEmotionSentimentAttribute(): string
    {
        $expressions = config('satisfaction.expressions');
        
        if (isset($expressions[$this->dominant_emotion])) {
            return $expressions[$this->dominant_emotion]['sentiment'];
        }
        
        return 'neutral';
    }
}