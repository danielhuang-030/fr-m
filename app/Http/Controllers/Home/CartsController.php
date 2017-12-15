<?php

namespace App\Http\Controllers\Home;

use Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartsController extends Controller
{
    protected $response = [
        'code' => 200,
        'message' => 'Success',
        'data' => '',
    ];

    public function index()
    {
        dd('cart list');
        /*
        $cars = [];
        if ($this->guard()->check()) {
            $cars = $this->guard()->user()->cars;
        }
        */
        return view('home.cars.index', compact('cars'));
    }

    public function store(Request $request)
    {
        // data
        $id = $request->get('id', 0);
        $quantity = $request->get('qty', 1);
        $condition = $request->get('cond', 'new');

        // check book exist and in stock
        $model = new \App\Models\Book();
        $book = $model->select('books.*')
            ->with('conditions')
            ->join('book_conditions', 'book_conditions.book_id', '=', 'books.id')
            ->where('books.id', $request->get('id', 0))
            ->where('book_conditions.condition', $request->get('cond', 'new'))
            ->where('book_conditions.in_stock', 1)
            ->where('book_conditions.quantity', '>', 0)
            ->first();
        if (!$book instanceof \App\Models\Book) {
            $this->result['code'] = 403;
            $this->result['message'] = 'Book does not exist or is not in stock';
            return response()->json($this->result);
        }

        // check stock quantity
        $bookCondition = $book->conditions()->first();
        if ($book->conditions()->first()->quantity < $request->get('qty', 1)) {
            $this->result['code'] = 403;
            $this->result['message'] = 'Not enough stock';
            return response()->json($this->result);
        }

        // get from cart
        dd(Cart::getContent());
        $item = Cart::get($id);


        if (null === $item) {
            $cartData = [
                'id' => $id,
                'name' => $book->title,
                'price' => $bookCondition->price,
                'quantity' => $quantity,
                'attributes' => [
                    'condition' => $condition,
                ],
            ];
            $r = Cart::add($cartData);
        }
        dd(Cart::getContent());





        // add cart




        if ($car = $this->guard()->user()->cars()->where('product_id', $form_data['product_id'])->first()) {
            $car->increment('numbers', $form_data['numbers']);
        } else {
            Car::create($form_data);
        }

        // Reduce inventory
        ProductDetail::where('product_id', $form_data['product_id'])
            ->lockForUpdate()
            ->first()
            ->decrement('count', $form_data['numbers']);

        return $this->response = ['code' => 0, 'msg' => '加入购物车成功'];
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
        dd($id);

        if ($car = Car::find($id)) {
            $car->delete();
        } else {
            return $this->response;
        }

        return $this->response = ['code' => 0, 'msg' => '删除成功'];
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
