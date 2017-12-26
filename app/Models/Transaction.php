<?php

namespace App\Models;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }

}
