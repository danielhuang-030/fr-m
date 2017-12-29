<?php

namespace App\Models;

class BookImage extends Model
{
    protected $table = 'book_images';

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * get directory
     *
     * @example when book_id = 1123, directory is 123
     * @return string
     */
    public function getDir()
    {
        return sprintf('%03d', $this->book_id % 1000);
    }

}
