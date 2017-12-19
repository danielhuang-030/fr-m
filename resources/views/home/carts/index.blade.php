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
                                  <th colspan="3" style="padding: 15px; vertical-align: middle; color: #555; ">{{ \Cart::getTotal() }}</th>
                                </tr>
                                </tfoot>
                                <tbody id="cars_data">
                                @inject('productPresenter', 'App\Presenters\ProductPresenter')
                                @foreach ($items as $item)
                                <tr class="panel alert">
                                    <td>
                                        <div class="media-body valign-middle">
                                            <h6 class="title mb-15 t-uppercase">
                                                <a href="{{ url("/home/books/{$item->id}") }}">
                                                    {{ $item->name }}
                                                </a>
                                            </h6>
                                        </div>
                                    </td>
                                    <td class="prices">{{ $item->price }}</td>
                                    <td>
                                      <div>
                                        <input type="button" onclick="decrementValue()" value="-" />
                                        <input type="text" name="quantity" value="{{ $item->quantity }}" maxlength="2" max="99" size="1" id="number" />
                                        <input type="button" onclick="incrementValue()" value="+" />
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
                                @foreach (\Cart::getConditions() as $cartCondition)
                                <tr class="panel alert">
                                    <td>{{ $cartCondition->getName() }}</td>
                                    <td>{{ (float) $cartCondition->getValue() }}</td>
                                    <td>1</td>
                                    <td>{{ $cartCondition->getValue() * 1 }}</td>
                                    <td></td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
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
function incrementValue()
{
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    if(value<10){
        value++;
            document.getElementById('number').value = value;
    }
}
function decrementValue()
{
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    if(value>1){
        value--;
            document.getElementById('number').value = value;
    }

}

$(function() {
  $(".delete-item").on("click", function() {
    $.post("/fr-m/cart/" + $(this).attr("data-id"), {
      _method: "DELETE"
    }).done(function(json) {
      console.log(json);
      alert(json.message);
    });

    return false;
  });
});
    </script>
@endsection