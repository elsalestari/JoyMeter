<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ticket_number',
        'category',
        'priority',
        'subject',
        'description',
        'status',
        'admin_reply',
        'admin_id',
        'replied_at',
        'closed_at',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    /**
     * Get the user who created the ticket
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the admin who replied to the ticket
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'open' => 'bg-blue-100 text-blue-800',
            'in_progress' => 'bg-yellow-100 text-yellow-800',
            'resolved' => 'bg-green-100 text-green-800',
            'closed' => 'bg-gray-100 text-gray-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get status label in Indonesian
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'open' => 'Terbuka',
            'in_progress' => 'Dalam Proses',
            'resolved' => 'Terselesaikan',
            'closed' => 'Ditutup',
            default => 'Unknown',
        };
    }

    /**
     * Get priority badge color
     */
    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => 'bg-green-100 text-green-800',
            'medium' => 'bg-yellow-100 text-yellow-800',
            'high' => 'bg-orange-100 text-orange-800',
            'urgent' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get priority label in Indonesian
     */
    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi',
            'urgent' => 'Mendesak',
            default => 'Unknown',
        };
    }

    /**
     * Get category label in Indonesian
     */
    public function getCategoryLabelAttribute(): string
    {
        return match($this->category) {
            'bug' => 'Bug/Error',
            'feature' => 'Permintaan Fitur',
            'question' => 'Pertanyaan',
            'technical' => 'Masalah Teknis',
            'other' => 'Lainnya',
            default => 'Unknown',
        };
    }

    /**
     * Generate unique ticket number
     */
    public static function generateTicketNumber(): string
    {
        $prefix = 'TKT';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
        
        return "{$prefix}-{$date}-{$random}";
    }
}