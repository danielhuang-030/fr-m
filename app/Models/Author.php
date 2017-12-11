<?php

namespace App\Models;

use Kalnoy\Nestedset\NodeTrait;

class Author extends Model
{
    protected $table = 'authors';
    protected $guarded = ['id'];
}
