<?php

namespace App\Http\Controllers\Home;

use DB;
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

        // check cart is empty, add fixed fee
        $this->middleware(function($request, $next) {
            if ($this->service->isEmpty()) {
                return redirect('/');
            }
            $this->service->clearConditions();
            $this->service->addConditionCarbonBalance();

            return $next($request);
        }, [
            'only' => [
                'index',
            ]
        ]);
    }

    /**
     * checkout
     */
    public function index()
    {
        $states = (new \App\Models\State())->get();
        return view('home.checkouts.index', compact('states'));
    }

    public function cart()
    {
        $items = $this->service->getItems();
        $conditions = $this->service->getConditions();
        $subTotal = $this->service->getSubTotal();
        $total = $this->service->getTotal();
        return view('home.checkouts.cart', compact('items', 'conditions', 'subTotal', 'total'));
    }

    public function tax(Request $request)
    {
        $stateId = (int) $request->input('id', 0);
        $this->service->addConditionTax($stateId);

        return response()->json([
            'code' => 200,
        ]);
    }

    private function guard()
    {
        return Auth::guard();
    }
}
