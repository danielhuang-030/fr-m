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

    public function set($v)
    {
        session()->put('test-session', $v);
        \Session::put('test-session', $v);
    }

    public function get()
    {
        $v = session()->get('test-session');
        // dd(session()->all());
        dd(\Session::all());
    }

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

    public function index()
    {
        $items = \Cart::getContent();
        // dd($items);
        return view('home.carts.index', compact('items'));
    }

    public function store(Request $request)
    {
        // data
        $id = $request->get('id', 0);
        $quantity = $request->get('qty', 1);
        $condition = $request->get('cond', 'new');

        // add cart
        try {
            $this->service->add($id, $quantity, $condition);
        } catch (\Exception $e) {
            $this->result['code'] = 403;
            $this->result['message'] = $e->getMessage();
            return response()->json($this->result);
        }

        $this->result['code'] = 200;
        $this->result['message'] = 'Add to Cart successfully';
        $this->result['data'] = \Cart::getContent();
        return response()->json($this->result);
    }

    public function update(Request $request, int $id)
    {
        dd($request->json(), $id);
    }

    protected function isGreaterStock(array $data)
    {
        // buy numbers > count
        $product = Product::find($data['product_id']);

        if ($data['numbers'] > $product->productDetail->count) {
            return true;
        }

        return false;
    }

    public function destroy($id)
    {
        $this->service->remove($id);
        $this->result['code'] = 200;
        $this->result['message'] = 'Deleted successfully';
        $this->result['data'] = \Cart::getContent();
        return response()->json($this->result);
    }

    private function getFormData($request)
    {
        $form_data = $request->only('product_id');
        $form_data['user_id'] = $this->guard()->user()->id;
        $form_data['numbers'] = $request->input('numbers', 1);

        return $form_data;
    }

    private function guard()
    {
        return Auth::guard();
    }
}
