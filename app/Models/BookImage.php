<?php

namespace App\Models;

class BookImage extends Model
{
    protected $table = 'book_images';
    protected $guarded = ['id'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
