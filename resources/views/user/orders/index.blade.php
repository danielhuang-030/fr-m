@extends('layouts.user')

@section('style')
    <style>
        th, td {
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px 10px;
        }
        td a.uuid {
            color: #00a0e9;
        }
    </style>
@endsection

@section('main')
    <div class="main-wrap">
        <div class="am-cf am-padding">
            <div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">Electronic&nbsp;bill</strong></div>
        </div>
        <hr>

        <table width="100%">

            <thead>
            <tr>
                <th class="time">order ID</th>
                <th class="name">create time</th>
                <th class="amount">total</th>
            </tr>
            </thead>

            <tbody>
                @foreach ($orders as $order)
                    <tr style="padding-left: 20px;">
                        <td class="time">
                            <p>
                                <a class="uuid" href="{{ url("/user/orders/{$order->id}") }}">{{ $order->id }}</a>
                            </p>
                        </td>
                        <td class="title name">
                            <p class="content">
                                {{ $order->created_at }}
                            </p>
                        </td>

                        <td class="amount">
                            <span class="amount-pay">{{ $order->total }}</span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
@endsection