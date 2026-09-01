<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class MobileAccessToken extends Model
{
    protected $connection = 'mai1';

    protected $table = 'mobile_access_tokens';

    protected $fillable = [
        'nouid',
        'name',
        'token_hash',
        'ip_address',
        'user_agent',
        'last_used_at',
        'expires_at',
        'fcm_token',
    ];

    protected $hidden = [
        'token_hash',
    ];

    protected $casts = [
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
