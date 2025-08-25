<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    protected $fillable = [
        'waba_id','name','category','language',
        'quality_score','status','components','component_data'
    ];

    protected $casts = [
        'components' => 'array',
        'component_data' => 'array',
    ];

    public function wabaAccount() {
        return $this->belongsTo(WabaAccount::class, 'waba_id', 'waba_id');
    }
}

