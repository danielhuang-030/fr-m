<?php

namespace App\Models;

class StateTax extends Model
{
    protected $table = 'state_taxes';
    protected $guarded = ['id'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

}
