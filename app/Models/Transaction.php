<?php

namespace App\Models;

class Transaction extends Model
{
    protected $table = 'transactions';

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

}
