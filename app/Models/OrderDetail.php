<?php

namespace App\Models;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

}
