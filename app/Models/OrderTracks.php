<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTracks extends Model
{
    protected $table = 'order_tracks';
    protected $guarded = ['id'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
