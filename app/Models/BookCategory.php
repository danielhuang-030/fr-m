<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;

class BookCategory extends Model
{
    protected $table = 'book_categories';
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
                'source' => 'name'
            ]
        ];
    }
    
}
