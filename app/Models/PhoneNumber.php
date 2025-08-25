<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumber extends Model
{
    protected $fillable = [
        'phone_number_id', 'display_phone_number', 'whatsapp_business_account_id',
        'waba_name', 'verified_name', 'code_verification_status', 'quality_rating',
        'platform_type', 'throughput_level', 'last_onboarded_time',
        'webhook_configuration', 'is_official_business_account',
        'messaging_limit_tier', 'token', 'status'
    ];

    public function wabaAccount() {
        return $this->belongsTo(WabaAccount::class, 'whatsapp_business_account_id', 'waba_id');
    }

    public function profile() {
        return $this->hasOne(PhoneNumberProfile::class, 'phone_number_id', 'phone_number_id');
    }
}


