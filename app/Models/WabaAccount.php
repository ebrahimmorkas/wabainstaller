<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WabaAccount extends Model
{
    protected $fillable = ['waba_id', 'access_token', 'name'];

    public function phoneNumbers() {
        return $this->hasMany(PhoneNumber::class, 'whatsapp_business_account_id', 'waba_id');
    }

    public function verification() {
        return $this->hasOne(BusinessVerification::class, 'whatsapp_business_account_id', 'waba_id');
    }

    public function templates() {
        return $this->hasMany(MessageTemplate::class, 'waba_id', 'waba_id');
    }
}

