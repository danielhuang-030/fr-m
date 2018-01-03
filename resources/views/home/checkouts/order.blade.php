@extends('layouts.home')

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
          <div class="container">

<div style="margin-top: 20px; "><h3 class="h-title mb-30 t-uppercase">ORDER PAYMENT SUCCESSFUL</h3></div>
<p>
<h5>[Shipping Address]</h5>
<div style="display: table; width: 100%; ">
    <div style="display: table-row-group; ">
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->shipping_first_name }} {{ $order->shipping_last_name }}  {{ $order->shipping_phone }}</div>
        </div>
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->shipping_addr2 }}</div>
        </div>
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->shipping_addr1 }}</div>
        </div>
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->shipping_city }} {{ $order->shippingState->name }} {{ $order->shipping_zipcode }}</div>
        </div>
    </div>
</div>
</p>

<p>
<h5>[Billing Address]</h5>
<div style="display: table; width: 100%; ">
    <div style="display: table-row-group; ">
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->billing_first_name }} {{ $order->billing_last_name }}</div>
        </div>
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->billing_addr2 }}</div>
        </div>
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->billing_addr1 }}</div>
        </div>
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $order->billing_city }} {{ $order->billingState->name }} {{ $order->billing_zipcode }}</div>
        </div>
    </div>
</div>
</p>

<p>
<h5>[Order]</h5>
<div style="display: table; width: 100%; ">
    <div style="display: table-header-group; ">
        <div style="display: table-row; ">
            <div style="display: table-cell; ">Name</div>
            <div style="display: table-cell; ">Price</div>
            <div style="display: table-cell; ">Quantity</div>
            <div style="display: table-cell; " class="text-right">Subtotal</div>
        </div>
    </div>
    @foreach ($order->details as $orderDetail)
    <div style="display: table-row-group; ">
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $orderDetail->title }}</div>
            <div style="display: table-cell; ">{{ $orderDetail->price }}</div>
            <div style="display: table-cell; ">{{ $orderDetail->quantity }}</div>
            <div style="display: table-cell; " class="text-right">{{ $orderDetail->price * $orderDetail->quantity }}</div>
        </div>
    </div>
    @endforeach
    @foreach ($order->fees as $orderFee)
    <div style="display: table-row-group; ">
        <div style="display: table-row; ">
            <div style="display: table-cell; ">{{ $orderFee->name }}</div>
            <div style="display: table-cell; ">{{ $orderFee->total }}</div>
            <div style="display: table-cell; ">-</div>
            <div style="display: table-cell; " class="text-right">{{ $orderFee->total }}</div>
        </div>
    </div>
    @endforeach
    <div style="display: table-row-group;">
        <div style="display: table-row; ">
          <div style="display: table-cell; ">&nbsp;</div>
          <div style="display: table-cell; ">&nbsp;</div>
          <div style="display: table-cell; ">Total</div>
          <div style="display: table-cell; " class="text-right">{{ $order->total }}</div>
        </div>
    </div>
</div>
</p>
<h3 class="h-title mb-30 t-uppercase text-right"><a href="{{ url('user/orders') }}">ORDER LIST</a></h3>
</div></div></main>
@endsection

@section('script')
    <script type="text/javascript">
$(function() {
});
    </script>
@endsection