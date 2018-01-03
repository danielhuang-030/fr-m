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

    /**
     * CheckoutService
     *
     * @var CheckoutService
     */
    protected $checkoutService;

    /**
     *
     * @var type
     */
    protected $order;

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

        // check order exist, owner
        $this->middleware(function($request, $next) {
            $orderId = (int) $request->route('id');
            $userId = (int) auth()->id();
            $this->order = $this->checkoutService->getOrder($orderId);
            if (null === $this->order || (int) $this->order->user_id !== $userId) {
                return redirect(url('/'));
            }
            return $next($request);
        }, [
            'only' => [
                'order',
            ]
        ]);

    }

    /**
     * index
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

    /**
     * cart (AJAX)
     */
    public function cart()
    {
        $items = $this->cartService->getItems();
        $conditions = $this->cartService->getConditions();
        $subTotal = $this->cartService->getSubTotal();
        $total = $this->cartService->getTotal();
        return view('home.checkouts.cart', compact('items', 'conditions', 'subTotal', 'total'));
    }

    /**
     * tax (AJAX)
     */
    public function tax(Request $request)
    {
        $stateId = (int) $request->input('id', 0);
        $this->cartService->addConditionTax($stateId);

        return response()->json($this->response);
    }

    /**
     * pay (AJAX)
     *
     * @param Request $request
     */
    public function pay(Request $request)
    {
        $orderId = $this->checkoutService->pay($request->all(), (int) auth()->id());
        $errorMessage = $this->checkoutService->getErrorMessage();
        if (0 === $orderId || !empty($errorMessage)) {
            $this->response['code'] = 403;
            $this->response['message'] = $errorMessage;
            $this->response['data'] = $orderId;
            return response()->json($this->response);
        }
        $this->response['data'] = $orderId;
        return response()->json($this->response);
    }

    /**
     * order
     *
     * @param Request $request
     */
    public function order(Request $request)
    {
        $order = $this->order;
        return view('home.checkouts.order', compact('order'));
    }

}
