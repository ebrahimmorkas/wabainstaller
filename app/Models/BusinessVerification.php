<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessVerification extends Model
{
    public $timestamps = false; // only updated_at present

    protected $fillable = ['whatsapp_business_account_id','name','verification_status'];

    public function wabaAccount() {
        return $this->belongsTo(WabaAccount::class, 'whatsapp_business_account_id', 'waba_id');
    }
}

