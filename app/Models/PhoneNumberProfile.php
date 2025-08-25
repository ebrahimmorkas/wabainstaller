<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PhoneNumberProfile extends Model
{
    protected $fillable = [
        'phone_number_id','about','address','description',
        'email','profile_picture_url','websites','vertical'
    ];

    public function phoneNumber() {
        return $this->belongsTo(PhoneNumber::class, 'phone_number_id', 'phone_number_id');
    }
}


