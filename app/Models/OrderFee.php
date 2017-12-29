<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFee extends Model
{
    protected $table = 'order_fees';
    protected $guarded = ['id'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
