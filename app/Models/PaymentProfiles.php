<?php

namespace App\Models;

class PaymentProfiles extends Model
{
    protected $table = 'payment_profiles';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
