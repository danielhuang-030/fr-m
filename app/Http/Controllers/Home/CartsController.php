<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CartService;

class CartsController extends Controller
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
        return view('home.carts.index', compact('items'));
    }

    /**
     * add cart
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        // data
        $id = $request->get('id', 0);
        $quantity = $request->get('qty', 1);

        // add cart
        try {
            $this->service->add($id, $quantity);
        } catch (\Exception $e) {
            $this->result['code'] = 403;
            $this->result['message'] = $e->getMessage();
            return response()->json($this->result);
        }

        $this->result['code'] = 200;
        $this->result['message'] = 'Add to Cart successfully';
        $this->result['data'] = $this->service->getItems();
        return response()->json($this->result);
    }

    /**
     * renew cart
     *
     * @param Request $request
     */
    public function renew(Request $request)
    {
        // data
        $quantityData = $request->get('qty', []);

        // renew cart
        try {
            $this->service->renew($quantityData);
        } catch (\Exception $e) {
            $this->result['code'] = 403;
            $this->result['message'] = $e->getMessage();
            return response()->json($this->result);
        }

        $this->result['code'] = 200;
        $this->result['message'] = 'Renew to Cart successfully';
        $this->result['data'] = $this->service->getItems();
        return response()->json($this->result);
    }

    /**
     * delete item from cart
     *
     * @param int $id
     */
    public function destroy(int $id)
    {
        $this->service->remove($id);
        $this->result['code'] = 200;
        $this->result['message'] = 'Deleted successfully';
        $this->result['data'] = $this->service->getItems();
        return response()->json($this->result);
    }

    public function checkout()
    {
        dd('checkout');
    }

    private function guard()
    {
        return Auth::guard();
    }
}
