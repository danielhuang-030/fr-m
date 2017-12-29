<?php

namespace App\Models;

class StateTax extends Model
{
    protected $table = 'state_taxes';

    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
