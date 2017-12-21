<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartService;

class CheckoutsController extends Controller
{
    protected $response = [
        'code' => 200,
        'message' => 'Success',
        'data' => '',
    ];

    /**
     * CartService
     *
     * @var CartService
     */
    protected $service;

    /**
     * construct
     *
     * @param AccountService $accountService
     */
    public function __construct(CartService $service)
    {
        $this->service = $service;
    }

    /**
     * cart list
     */
    public function index()
    {
        $items = $this->service->getItems();
        // dd($items);
        return view('home.checkouts.index', compact('items'));
    }

    private function guard()
    {
        return Auth::guard();
    }
}
