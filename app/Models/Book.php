<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Book extends Model
{
    use Sluggable;

    protected $table = 'books';
    protected $guarded = ['id'];

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
        return $this->belongsToMany('App\Models\Author', 'book_authors');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'book_categories');
    }

    public function images()
    {
        return $this->hasMany(BookImage::class)->orderBy('sort');
    }


    public function conditions()
    {
        return $this->hasMany(BookCondition::class);
    }

}
