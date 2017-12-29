<?php

namespace App\Models;

class OrderTrack extends Model
{
    protected $table = 'order_tracks';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
