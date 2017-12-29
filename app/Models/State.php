<?php

namespace App\Models;

class State extends Model
{
    protected $table = 'states';

    public function tax()
    {
        return $this->hasOne(StateTax::class);
    }

    public function orderShippings()
    {
        return $this->hasMany(Order::class, 'shipping_state_id');
    }

    public function orderBillings()
    {
        return $this->hasMany(Order::class, 'billing_state_id');
    }

}
