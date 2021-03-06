<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Book extends Model
{
    use Sluggable;

    protected $table = 'books';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'book_authors');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'book_categories');
    }

    public function images()
    {
        return $this->hasMany(BookImage::class)->orderBy('sort');
    }

    public function conditions()
    {
        return $this->hasMany(BookCondition::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
