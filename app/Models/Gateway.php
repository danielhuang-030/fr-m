<?php

namespace App\Models;

class Gateway extends Model
{
    protected $table = 'gateways';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasOne(User::class);
    }

}
