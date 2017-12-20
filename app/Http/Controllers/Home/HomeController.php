<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $model = new \App\Models\Category();
        $categories = $model->where('parent_id', null)->orderBy('sort')->take(9)->get();

        $model = new \App\Models\Book();
        $hotProducts = $model->with(['conditions', 'images'])
            ->join('book_conditions', 'book_conditions.book_id', '=', 'books.id')
            ->where('book_conditions.in_stock', 1)
            ->where('book_conditions.quantity', '>', 0)
            ->orderBy('book_conditions.quantity')
            ->take(3)->get();

        $model = new \App\Models\Book();
        $latestProducts = $model->with(['conditions', 'images'])->latest()->take(9)->get();

        return view('home.homes.index', compact('categories', 'hotProducts', 'latestProducts'));
    }
}
