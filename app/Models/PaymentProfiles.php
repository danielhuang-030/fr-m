<?php

namespace App\Models;

class PaymentProfiles extends Model
{
    protected $table = 'payment_profiles';

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
