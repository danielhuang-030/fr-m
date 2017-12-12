<?php

namespace App\Models;

class Book extends Model
{
    protected $table = 'books';
    protected $guarded = ['id'];

    public function authors()
    {
        return $this->belongsToMany('App\Models\Author', 'book_authors');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'book_categories');
    }

    public function images()
    {
        return $this->hasMany(BookImage::class);
    }


    public function conditions()
    {
        return $this->hasMany(BookCondition::class);
    }

}
