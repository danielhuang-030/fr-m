<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Services\HomeService;

class HomeController extends Controller
{
    /**
     * HomeService
     *
     * @var HomeService
     */
    protected $service;

    /**
     * construct
     *
     * @param HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
        $this->service = $homeService;
    }

    public function index()
    {
        $categories = $this->service->getCategoriesTopBySort(9);
        $hotProducts = $this->service->getBooksMostPopular(3);
        $latestProducts = $this->service->getBooksLatest(9);

        return view('home.homes.index', compact('categories', 'hotProducts', 'latestProducts'));
    }
}
