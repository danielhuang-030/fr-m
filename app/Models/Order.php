<?php

namespace App\Models;

use DB;

class Order extends Model
{
    protected $table = 'orders';

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function fees()
    {
        return $this->hasMany(OrderFee::class);
    }

    public function statuses()
    {
        return $this->hasMany(OrderStatus::class);
    }

    public function tracks()
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

    /**
     * update status
     *
     * @param string $status
     * @param string $memo
     * @return boolean
     */
    public function updateStatus(string $status, string $memo = '')
    {
        DB::beginTransaction();
        try {
            // update order status
            $this->status = $status;
            $this->save();

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
