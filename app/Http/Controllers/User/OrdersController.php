<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders;

        return view('user.orders.index', compact('orders'));
    }

    public function show(\App\Models\Order $order)
    {
        if ($order->user_id != auth()->id()) {
            return redirect(action(sprintf('\%s@index', __CLASS__)));
        }
        return view('user.orders.show', compact('order'));
    }

}
