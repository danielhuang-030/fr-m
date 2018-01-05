<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Category;

/**
 * Class CategoryRepository
 *
 * @package namespace App\Repositories;
 */
class CategoryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Category::class;
    }

    public function getTopBySort(int $limit = 10)
    {
        return $this->model->where('parent_id', null)->orderBy('sort')->take($limit)->get();
    }

}
