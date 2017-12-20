<?php

namespace App\Models;


class BookCondition extends Model
{
    protected $table = 'book_conditions';
    protected $guarded = ['id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function scopeInStock($query)
    {
        return $query->where('in_stock', 1)->where('quantity', '>', 0);
    }

}
