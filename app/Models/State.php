<?php

namespace App\Models;

class State extends Model
{
    protected $table = 'states';
    protected $guarded = ['id'];

    public function tax()
    {
        return $this->hasOne(StateTax::class);
    }

}
