<?php

namespace App\Services;

use App\Repositories\BookRepository;
use App\Repositories\CategoryRepository;

class HomeService
{
    /**
     * BookRepository
     *
     * @var BookRepository
     */
    protected $bookRepository;

    /**
     * CategoryRepository
     * @var CategoryRepository
     */
    protected $categoryRepository;

    /**
     * construct
     *
     * @param BookRepository $bookRepository
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(BookRepository $bookRepository, CategoryRepository $categoryRepository)
    {
        $this->bookRepository = $bookRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getCategoriesTopBySort(int $limit = 9)
    {
        return $this->categoryRepository->getTopBySort(9);
    }

    public function getBooksMostPopular(int $limit = 9)
    {
        return $this->bookRepository->getMostPopular($limit);
    }

    public function getBooksLatest(int $limit = 9)
    {
        return $this->bookRepository->getLatest($limit);
    }

}