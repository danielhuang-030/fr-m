<?php

namespace App\Http\Controllers\User;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ProductDetail;
use Auth;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;

class OrdersController extends Controller
{

    public function index()
    {
        $orders = auth()->user()->orders;

        return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id != Auth::user()->id) {
            abort(404, '你没有权限');
        }

//        $detail = $order->details->first();
//        dd($detail, $detail->book);

        return view('user.orders.show', compact('order'));
    }

}
