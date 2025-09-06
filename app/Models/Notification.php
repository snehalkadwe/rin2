<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'short_text',
        'expiration',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'expiration' => 'datetime',
            'is_read' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('expiration', '>', now());
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
