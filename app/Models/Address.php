<?php

namespace App\Models;

class Address extends Model
{
    protected $table = 'addresses';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
