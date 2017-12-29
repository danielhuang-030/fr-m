<table id="cart_list" class="cart-list mb-30">
    <thead class="panel t-uppercase">
    <tr>
        <th>Title</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
    </tr>
    </thead>
    <tfoot class="panel t-uppercase" style="background-color: #B9E9FA; ">
    <tr>
      <th colspan="3" class="text-right">Total</th>
      <th style="padding: 15px; vertical-align: middle; color: #555; ">{{ \Cart::getTotal() }}</th>
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
        <td>{{ $item->quantity }}</td>
        <td class="prices">{{ $item->price * $item->quantity }}</td>
    </tr>
    @endforeach
    @foreach ($conditions as $condition)
    <tr class="panel alert">
        <td>{{ $condition->getAttributes()['name'] }}</td>
        <td>{{ $condition->getCalculatedValue($subTotal) }}</td>
        <td>-</td>
        <td>{{ \Darryldecode\Cart\Helpers\Helpers::formatValue($condition->getCalculatedValue($subTotal), env('SHOPPING_FORMAT_VALUES', false), ['format_numbers' => env('SHOPPING_FORMAT_VALUES', false), 'decimals' => env('SHOPPING_DECIMALS', 0), 'dec_point' => env('SHOPPING_DEC_POINT', '.'), 'thousands_sep' => env('SHOPPING_THOUSANDS_SEP', ',')]) }}</td>
    </tr>
    @endforeach
    </tbody>
</table>
