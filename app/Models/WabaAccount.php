<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WabaAccount extends Model
{
    protected $fillable = [
        'user_id',
        'waba_id',
        'app_id',
        'app_secret',
        'phone_number_id',
        'access_token',
        'verify_token',
        'webhook_verified',
        'default_phone_number_id',
        'display_name',
        'category',
        'about',
        'website',
        'connected',
    ];

    protected $casts = [
        'access_token' => 'encrypted',
        'app_secret'   => 'encrypted',
        'webhook_verified' => 'boolean',
        'connected'    => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
