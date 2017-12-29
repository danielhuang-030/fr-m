<?php

namespace App\Models;

class OrderStatus extends Model
{
    protected $table = 'order_statuses';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
