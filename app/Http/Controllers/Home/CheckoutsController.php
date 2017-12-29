<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartService;
use App\Services\CheckoutService;

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
    protected $cartService;

    protected $checkoutService;

    /**
     * construct
     *
     * @param CartService $cartService
     */
    public function __construct(CartService $cartService, CheckoutService $checkoutService)
    {
        $this->cartService = $cartService;
        $this->checkoutService = $checkoutService;

        // check cart is empty, add fixed fee
        $this->middleware(function($request, $next) {
            if ($this->cartService->isEmpty()) {
                return redirect('/');
            }
            $this->cartService->clearConditions();
            $this->cartService->addConditionShipping();
            $this->cartService->addConditionCarbonBalance();

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
        $user = auth()->user();
        $address = null;
        if (null !== $user) {
            $addresses = $user->addresses;
            $addresses instanceof \Illuminate\Support\Collection;
            if (!$addresses->isEmpty()) {
                $address = $addresses->first();
            }
        }
        $states = (new \App\Models\State())->get();

        return view('home.checkouts.index', compact('user', 'address', 'states'));
    }

    public function cart()
    {
        $items = $this->cartService->getItems();
        $conditions = $this->cartService->getConditions();
        $subTotal = $this->cartService->getSubTotal();
        $total = $this->cartService->getTotal();
        return view('home.checkouts.cart', compact('items', 'conditions', 'subTotal', 'total'));
    }

    public function tax(Request $request)
    {
        $stateId = (int) $request->input('id', 0);
        $this->cartService->addConditionTax($stateId);

        return response()->json([
            'code' => 200,
        ]);
    }

    public function order(Request $request)
    {
        /*
        $email = 'danielsimplybridel@gmail.com';
        // $email = 'daniel.huang@simplybridal.com';
        $r = $this->checkoutService->createUserByEmail($email);
        dd($r);
        return;*/

        $r = $this->checkoutService->order($request->all(), auth()->id());
        dd($r);
    }

}
