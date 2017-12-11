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

    public function bookImages()
    {
        return $this->hasMany(BookImage::class);
    }


    public function bookConditions()
    {
        return $this->hasMany(BookCondition::class);
    }

}
