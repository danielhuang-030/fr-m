<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Book;

/**
 * Class BookRepository
 *
 * @package namespace App\Repositories;
 */
class BookRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Book::class;
    }

    public function getLatest(int $limit = 10)
    {
        $query = $this->model->query()->select('books.*');
        $query = $this->getQueryWithRelations($query);
        $query = $this->getQueryInStock($query);

        return $query->latest()->take($limit)->get();
    }

    public function getMostPopular(int $limit = 10)
    {
        $query = $this->model->query()->select('books.*');
        $query = $this->getQueryWithRelations($query);
        $query = $this->getQueryHasImages($query);
        $query = $this->getQueryInStock($query);

        return $query->inRandomOrder()->take($limit)->get();
    }

    protected function getQueryWithRelations(\Illuminate\Database\Eloquent\Builder &$query)
    {
        return $query->with([
            'authors',
            'categories',
            'conditions',
            'images',
        ]);
    }

    protected function getQueryInStock(\Illuminate\Database\Eloquent\Builder &$query)
    {
        return $query->join('book_conditions', 'book_conditions.book_id', '=', 'books.id')
            ->where('book_conditions.in_stock', 1)
            ->where('book_conditions.quantity', '>', 0);
    }

    protected function getQueryHasImages(\Illuminate\Database\Eloquent\Builder &$query)
    {
        return $query->join('book_images', 'book_images.book_id', '=', 'books.id')
            ->where('book_images.file', '!=', '');
    }

}
