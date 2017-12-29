<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $guarded = ['id'];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function orderFees()
    {
        return $this->hasMany(OrderFee::class);
    }

    public function orderStatuses()
    {
        return $this->hasMany(orderStatus::class);
    }

    public function OrderTracks()
    {
        return $this->hasMany(OrderTrack::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
