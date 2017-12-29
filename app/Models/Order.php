<?php

namespace App\Models;

use DB;
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

    public function orderTracks()
    {
        return $this->hasMany(OrderTrack::class);
    }

    public function shippingState()
    {
        return $this->belongsTo(State::class);
    }

    public function billingState()
    {
        return $this->belongsTo(State::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateStatus(string $status, string $memo = '')
    {
        DB::beginTransaction();
        try {
            // update order status
            $order->status = $status;
            $order->save();

            // update order status
            $orderStatus = new \App\Models\OrderStatus();
            $orderStatus->order_id = $this->id;
            $orderStatus->status = $status;
            if (!empty($memo)) {
               $orderStatus->memo = $memo;
            }
            $orderStatus->save();

        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
        DB::commit();

        return true;
    }

}
