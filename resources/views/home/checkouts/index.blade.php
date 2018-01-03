@extends('layouts.home')

@section('main')

<form action="{{ route('checkout.pay') }}" method="POST">
{{ csrf_field() }}
<input name="order_id" type="hidden" />
    <main id="mainContent" class="main-content">
        <div class="page-container">
            <div class="container">
                <div class="cart-area ptb-60">
                    <div class="container">
                        <div class="cart-wrapper">
                            <h3 class="h-title mb-30 t-uppercase">Cart</h3>
                            <div class="cart-list-block"></div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="cart-wrapper">
                            <h3 class="h-title mb-30 t-uppercase">SHIPPING INFO</h3>

                            <div class="woocommerce-billing-fields">

                            @if (null === $user)
                            <p class="form-row form-row form-row-first validate-required validate-email" id="email_field"><label for="email" class="">Email <abbr class="required" title="required">*</abbr></label><input type="email" class="input-text " name="email" id="email" placeholder="" value=""></p>
                            @endif

                            <p class="form-row form-row form-row-first validate-required" id="shipping_first_name_field"><label for="shipping_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping[first_name]" id="shipping_first_name" placeholder="" value="{{ $address->first_name ?? '' }}"></p>

                            <p class="form-row form-row form-row-last validate-required" id="shipping_last_name_field"><label for="shipping_last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping[last_name]" id="shipping_last_name" placeholder="" value="{{ $address->last_name ?? '' }}"></p><div class="clear"></div>
                            <p class="form-row form-row form-row-last validate-required validate-phone" id="shipping_phone_field"><label for="shipping_phone" class="">Phone <abbr class="required" title="required">*</abbr></label><input type="tel" class="input-text phone-with-ddd" name="shipping[phone]" id="shipping_phone" placeholder="" value="{{ $address->phone ?? '' }}"></p><div class="clear"></div>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="shipping_address_1_field"><label for="shipping_address_1" class="">Address 1<abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping[addr1]" id="shipping_address_1" placeholder="" value="{{ $address->addr1 ?? '' }}"></p>

                            <p class="form-row form-row form-row-wide address-field" id="shipping_address_2_field"><label for="shipping_address_2" class="">Address 2</label><input type="text" class="input-text " name="shipping[addr2]" id="shipping_address_2" placeholder="" value="{{ $address->addr2 ?? '' }}"></p>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="shipping_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required"><label for="shipping_city" class="">City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping[city]" id="shipping_city" placeholder="" value="{{ $address->city ?? '' }}"></p>

		                    <p class="form-row form-row form-row-first address-field validate-state woocommerce-invalid woocommerce-invalid-required-field validate-required" id="shipping_state_field" data-o_class="form-row form-row form-row-first address-field validate-required validate-state woocommerce-invalid woocommerce-invalid-required-field"><label for="shipping_state" class="">State <abbr class="required" title="required">*</abbr></label>

                            <select name="shipping[state_id]" id="shipping_state" class="state_select" title="State *">
                              <option value="">Please Select</option>
                              @foreach ($states as $state)
                              <option value="{{ $state->id }}"@if (null !== $address && $address->state_id == $state->id) selected="selected" @endif>{{ $state->name }}</option>
                              @endforeach
                            </select>
                            </p>

                            <p class="form-row form-row form-row-last address-field validate-postcode validate-required" id="shipping_postcode_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode"><label for="shipping_postcode" class="">Zipcode <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping[zipcode]" id="shipping_postcode" placeholder="" value="{{ $address->zipcode ?? '' }}"></p>
                            <input type="hidden" name="shipping[country]" value="US" />

                            <p class="form-row form-row form-row-last address-field validate-postcode validate-required" id="order_memo_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode"><label for="order_memo" class="">Memo </label><textarea id="order_memo" rows="5" name="memo" placeholder=""></textarea></p>

		                    <div class="clear"></div>
	                    </div>
                        </div>
                    </div>

                    <div class="container">
                        <div class="cart-wrapper">
                            <h3 class="h-title mb-30 t-uppercase">BILLING INFO</h3>

                            <div class="woocommerce-billing-fields">

                              <p class="form-row form-row form-row-first validate-required" id="same_as_shipping_field"><label for="same_as_shipping" class="">Same As Shipping Info</label><input type="checkbox" class="input-text" id="same-as-shipping" placeholder="" value="1"></p>

                            <p class="form-row form-row form-row-first validate-required" id="billing_first_name_field"><label for="billing_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing[first_name]" id="billing_first_name" placeholder="" value=""></p>

                            <p class="form-row form-row form-row-last validate-required" id="billing_last_name_field"><label for="billing_last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing[last_name]" id="billing_last_name" placeholder="" value=""></p><div class="clear"></div>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field"><label for="billing_address_1" class="">Address 1<abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing[addr1]" id="billing_address_1" placeholder="" value=""></p>

                            <p class="form-row form-row form-row-wide address-field" id="billing_address_2_field"><label for="billing_address_2" class="">Address 2</label><input type="text" class="input-text " name="billing[addr2]" id="billing_address_2" placeholder="" value=""></p>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="billing_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required"><label for="billing_city" class="">City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing[city]" id="shipping_city" placeholder="" value=""></p>

		                    <p class="form-row form-row form-row-first address-field validate-state woocommerce-invalid woocommerce-invalid-required-field validate-required" id="billing_state_field" data-o_class="form-row form-row form-row-first address-field validate-required validate-state woocommerce-invalid woocommerce-invalid-required-field"><label for="billing_state" class="">State <abbr class="required" title="required">*</abbr></label>

                            <select name="billing[state_id]" id="billing_state" class="state_select" title="State *">
                              <option value="">Please Select</option>
                              @foreach ($states as $state)
                              <option value="{{ $state->id }}">{{ $state->name }}</option>
                              @endforeach
                            </select>
                            </p>

                            <p class="form-row form-row form-row-last address-field validate-postcode validate-required" id="billing_postcode_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode"><label for="billing_postcode" class="">Zipcode <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing[zipcode]" id="billing_postcode" placeholder="" value=""></p>
                            <input type="hidden" name="billing[country]" value="US" />
		                    <div class="clear"></div>
	                    </div>
                        </div>
                    </div>

                    <div class="container">
                        <h3 class="h-title mb-30 t-uppercase">CARD</h3>
                        <fieldset id="wc-stripe-cc-form" class="wc-credit-card-form wc-payment-form">
                            <p class="form-row form-row-wide">
                            <label for="card-number">Card Number <span class="required">*</span></label>
                            <input id="card-number" class="input-text card-number" name="card[number]" inputmode="numeric" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" placeholder="Card Number">
                            </p>

                            <p class="form-row form-row-first">
                            <label for="card-expiry">Expiry (MM/YY) <span class="required">*</span></label>
                            <input id="card-expiry" class="input-text card-expiry" name="card[expiry]" inputmode="numeric" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" placeholder="MM/YY">
                            </p>

                            <p class="form-row form-row-last">
                            <label for="card-cvc">Card Code <span class="required">*</span></label>
                            <input id="card-cvc" class="input-text card-cvc" name="card[cvc]" inputmode="numeric" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" maxlength="4" placeholder="CVC/CVV" style="width:100px">
                            </p>
                            <div class="clear"></div>
                        </fieldset>
                    </div>
                    <h3 class="h-title mb-30 t-uppercase text-right"><a id="place-order" href="#">PLACE ORDER</a></h3>
                </div>
            </div>



        </div>


    </main>
</form>
@endsection

@section('script')
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.13/jquery.mask.min.js"></script>
    <script type="text/javascript">

// refresh cart
function refreshCart() {
  // console.log('refreshCart');
  $.ajax({
    url: "/fr-m/checkout/cart",
    type: "GET",
    dataType: "html"
  }).done(function(html) {
    $(".cart-list-block").html(html).fadeIn();
  });

};

// get tax
function getTax() {
  // console.log('getTax');
  $.ajax({
    url: "/fr-m/checkout/tax",
    type: "GET",
    data: { id: $("select[name=shipping\\[state_id\\]]").val() },
    dataType: "json"
  }).done(function(json) {
    if (200 == json.code) {
        refreshCart();
    }
  });

};

function validateCardNumber(number) {
  var regex = new RegExp("^[0-9]{16}$");
  if (!regex.test(number)) {
    return false;
  }
  return luhnCheck(number);
};

function luhnCheck(val) {
  var sum = 0;
  for (var i = 0; i < val.length; i++) {
    var intVal = parseInt(val.substr(i, 1));
    if (i % 2 == 0) {
      intVal *= 2;
      if (intVal > 9) {
        intVal = 1 + (intVal % 10);
      }
    }
    sum += intVal;
  }
  return (sum % 10) == 0;
};

$(function() {
  // mask
  $(".phone-with-ddd").mask("(00) 0000-0000");
  $("input[name*=zipcode]").mask("00000");
  $(".card-number").mask("0000000000000000");
  $(".card-expiry").mask("00/00");
  $(".card-cvc").mask("0000");

  // refresh cart
  refreshCart();

  // change state tax
  $("select[name=shipping\\[state_id\\]]").on("change", function() {
    getTax();
  }).change();

  // same as shipping
  $("#same-as-shipping").on("change", function() {
    if ($(this).prop("checked")) {
      $("input[name^=shipping], select[name^=shipping]").each(function() {
        var name = String($(this).prop("name")).replace(/^shipping/i, "billing").replace(/(:|\.|\[|\]|,|=|@)/g, "\\$1");
        // console.log(name, $(this).prop("name"));
        switch ($(this).prop('nodeName')) {
          case "SELECT":
            $("select[name=" + name + "]").val($(this).val());
            break;
          case "INPUT":
          default:
            $("input[name=" + name + "]").val($(this).val());
            break;
        }
      });
    }

  });

  // check card number
//  $(".card-number").on("blur", function() {
//    if (!validateCardNumber(String($(this).val()).replace(/\s/g, ""))) {
//      console.log("Credit card has a valid format!");
//    }
//  });

  // place order
  $("#place-order").on("click", function() {
    var $form = $(this).parents("form");
    $.ajax({
      url: $form.prop("action"),
      type: $form.prop("method"),
      data: $form.serialize(),
      dataType: "json"
    }).done(function(json) {
      alert(json.message);
      $("input[name=order_id]").val(json.data);
      if (200 == json.code) {
        // location.href = '/fr-m';
      }
    });
    return false;
  });

});
    </script>
@endsection