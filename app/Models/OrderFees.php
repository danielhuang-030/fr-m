<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFees extends Model
{
    protected $table = 'order_fees';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
