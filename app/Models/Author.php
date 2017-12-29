<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class Author extends Model
{
    use Sluggable;

    protected $table = 'authors';

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_authors');
    }

}
