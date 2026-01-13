<?php

namespace App\Traits;

trait HasRole
{
    /**
     * Check if user has specific role(s)
     * 
     * @param string|array $roles
     * @return bool
     */
    public function hasRole($roles): bool
    {
        if (is_string($roles)) {
            return $this->role === $roles;
        }

        if (is_array($roles)) {
            return in_array($this->role, $roles, true);
        }

        return false;
    }

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is staff/karyawan
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    /**
     * Check if user can access camera session
     */
    public function canAccessCamera(): bool
    {
        return $this->hasRole(['staff', 'admin']);
    }

    /**
     * Get role display name in Indonesian
     */
    public function getRoleDisplayNameAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'staff' => 'Karyawan',      
            default => ucfirst($this->role),
        };
    }

    /**
     * Get role display name in English (if needed)
     */
    public function getRoleDisplayNameEnAttribute(): string
    {
        return match($this->role) {
            'admin' => 'Administrator',
            'staff' => 'Staff',
            default => ucfirst($this->role),
        };
    }

    /**
     * Get role badge color for UI
     */
    public function getRoleBadgeColorAttribute(): string
    {
        return match($this->role) {
            'admin' => 'purple',
            'staff' => 'green',
            default => 'gray',
        };
    }

    /**
     * Get role badge classes for Tailwind
     */
    public function getRoleBadgeClassesAttribute(): string
    {
        return match($this->role) {
            'admin' => 'bg-purple-100 text-purple-800',
            'staff' => 'bg-green-100 text-green-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get role emoji
     */
    public function getRoleEmojiAttribute(): string
    {
        return match($this->role) {
            'admin' => '👑',
            'staff' => '👤',
            default => '❓',
        };
    }
}