@extends('layouts.home')

@section('main')
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <h3 class="h-title mb-30 t-uppercase">My Cart</h3>
                            @if (0 === $items->count())
                            <table id="cart_list" class="cart-list mb-30">
                                <thead class="panel t-uppercase">
                                <tr>
                                  <th colspan="5">Cart is empty</th>
                                </tr>
                                </thead>
                            </table>
                            @else
                            <form action="" method="POST">
                            {{ csrf_field() }}
                            <table id="cart_list" class="cart-list mb-30">
                                <thead class="panel t-uppercase">
                                <tr>
                                    <th>Title</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                    <th>Delete</th>
                                </tr>
                                </thead>
                                <tfoot class="panel t-uppercase" style="background-color: #B9E9FA; ">
                                <tr>
                                  <th colspan="3" class="text-right">Total</th>
                                  <th style="padding: 15px; vertical-align: middle; color: #555; ">{{ \Cart::getSubTotal() }}</th>
                                  <th><a class="update-cart" href="#">[UPDATE]</a>&nbsp;<a class="clear-cart" href="#">[CLEAR]</a></th>
                                </tr>
                                </tfoot>
                                <tbody id="cars_data">
                                @foreach ($items as $item)
                                <tr class="panel alert">
                                    <td>
                                        <div class="media-body valign-middle">
                                            <h6 class="title mb-15 t-uppercase">
                                              <a href="{{ $item->attributes->url }}" target="_blank">{{ $item->name }}</a>
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="prices">{{ $item->price }}</td>
                                    <td>
                                      <div>
                                        <input type="button" class="decrement-qty" value="-" />
                                        <input type="text" name="qty[{{ $item->id }}]" class="qty" value="{{ $item->quantity }}" maxlength="2" max="{{ $item->attributes->stock }}" size="1" />
                                        <input type="button" class="increment-qty" value="+" />
                                      </div>
                                    </td>
                                    <td class="prices">{{ $item->price * $item->quantity }}</td>
                                    <td>
                                        <button data-id="{{ $item->id }}" class="close delete-item" type="button" >
                                            <i class="fa fa-trash-o"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                                <?php /*
                                @foreach (\Cart::getConditions() as $cartCondition)
                                <tr class="panel alert">
                                    <td>{{ $cartCondition->getName() }}</td>
                                    <td>{{ (float) $cartCondition->getValue() }}</td>
                                    <td>1</td>
                                    <td>{{ $cartCondition->getValue() * 1 }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                                */ ?>
                                </tbody>
                            </table>
                            </form>
                            <h3 class="h-title mb-30 t-uppercase text-right"><a href="{{ url('checkout') }}">CHECKOUT</a></h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection

@section('script')
    <script type="text/javascript">

$(function() {
  $(".delete-item").on("click", function() {
    if (confirm("Are you sure you want to delete this book?")) {
        $.post("/fr-m/cart/" + $(this).attr("data-id"), {
          _method: "DELETE"
        }).done(function(json) {
          // console.log(json);
          location.reload();
        });
    }
    return false;
  });

  $(".increment-qty").on("click", function() {
    var $quantity = $(this).parent("div").find("input.qty");
    var value = parseInt($quantity.val(), 10);
    value = isNaN(value) ? 0 : value;
    if (value < $quantity.prop("max")) {
        value++;
        $quantity.val(value);
    }
  });

  $(".decrement-qty").on("click", function() {
    var $quantity = $(this).parent("div").find("input.qty");
    var value = parseInt($quantity.val(), 10);
    value = isNaN(value) ? 0 : value;
    if (value > 1) {
        value--;
        $quantity.val(value);
    }
  });

  // update cart
  $(".update-cart").on("click", function() {
    console.log('uodate cart', $(this).parents("form").serialize());

    $.ajax({
      url: "/fr-m/cart/renew",
      type: "PUT",
      data: $(this).parents("form").serialize(),
      dataType: "json"
    }).done(function(json) {
      console.log(json);
      alert(json.message);
      if (200 == json.code) {
          location.reload();
      }
    });
    return false;
  });

  // clear-cart
  $(".clear-cart").on("click", function() {
    $.ajax({
      url: "/fr-m/cart/clear",
      type: "DELETE",
      dataType: "json"
    }).done(function(json) {
      alert(json.message);
      if (200 == json.code) {
          location.reload();
      }
    });
    return false;

  });

});
    </script>
@endsection