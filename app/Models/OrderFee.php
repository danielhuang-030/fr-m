<?php

namespace App\Models;

class OrderFee extends Model
{
    protected $table = 'order_fees';

    protected $casts = [
        'meta' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
