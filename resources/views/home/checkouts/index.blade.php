@extends('layouts.home')

@section('main')

<form action="" method="POST">
{{ csrf_field() }}
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
                            <h3 class="h-title mb-30 t-uppercase">INFO</h3>

                            <div class="woocommerce-billing-fields">

                            @if (null === $user)
                            <p class="form-row form-row form-row-first validate-required validate-email" id="shipping_email_field"><label for="shipping_email" class="">Email <abbr class="required" title="required">*</abbr></label><input type="email" class="input-text " name="shipping_email" id="shipping_email" placeholder="" autocomplete="email" value=""></p>
                            @endif

                            <p class="form-row form-row form-row-first validate-required" id="shipping_first_name_field"><label for="shipping_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_first_name" id="shipping_first_name" placeholder="" autocomplete="given-name" value="{{ $address->first_name ?? '' }}"></p>

                            <p class="form-row form-row form-row-last validate-required" id="shipping_last_name_field"><label for="shipping_last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_last_name" id="shipping_last_name" placeholder="" autocomplete="family-name" value="{{ $address->last_name ?? '' }}"></p><div class="clear"></div>
                            <p class="form-row form-row form-row-last validate-required validate-phone" id="shipping_phone_field"><label for="shipping_phone" class="">Phone <abbr class="required" title="required">*</abbr></label><input type="tel" class="input-text " name="shipping_phone" id="shipping_phone" placeholder="" autocomplete="tel" value="{{ $address->phone ?? '' }}"></p><div class="clear"></div>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="shipping_address_1_field"><label for="shipping_address_1" class="">Address 1<abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_address_1" id="shipping_address_1" placeholder="Street address" autocomplete="address-line1" value="{{ $address->addr1 ?? '' }}"></p>

                            <p class="form-row form-row form-row-wide address-field" id="shipping_address_2_field"><label for="shipping_address_2" class="">Address 2</label><input type="text" class="input-text " name="shipping_address_2" id="shipping_address_2" placeholder="Apartment, suite, unit etc. (optional)" autocomplete="address-line2" value="{{ $address->addr2 ?? '' }}"></p>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="shipping_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required"><label for="shipping_city" class="">City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="shipping_city" id="shipping_city" placeholder="" autocomplete="address-level2" value="{{ $address->city ?? '' }}"></p>

		                    <p class="form-row form-row form-row-first address-field validate-state woocommerce-invalid woocommerce-invalid-required-field validate-required" id="shipping_state_field" data-o_class="form-row form-row form-row-first address-field validate-required validate-state woocommerce-invalid woocommerce-invalid-required-field"><label for="shipping_state" class="">State <abbr class="required" title="required">*</abbr></label>

                            <select name="state_id" id="billing_state" class="state_select" data-placeholder="" tabindex="-1" title="State *">
                              <option value="">Please Select</option>
                              @foreach ($states as $state)
                              <option value="{{ $state->id }}"@if (null !== $address && $address->state_id == $state->id) selected="selected" @endif>{{ $state->name }}</option>
                              @endforeach
                            </select>
                            </p>

                            <p class="form-row form-row form-row-last address-field validate-postcode validate-required" id="billing_postcode_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode"><label for="billing_postcode" class="">Zipcode <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_postcode" id="billing_postcode" placeholder="" autocomplete="postal-code" value="{{ $address->zipcode ?? '' }}"></p>

		                    <div class="clear"></div>
	                    </div>
                        </div>
                    </div>

                    <div class="container">
                        <h3 class="h-title mb-30 t-uppercase">CARD</h3>
                        <fieldset id="wc-stripe-cc-form" class="wc-credit-card-form wc-payment-form">
                            <p class="form-row form-row-wide">
                            <label for="stripe-card-number">Card Number <span class="required">*</span></label>
                            <input id="stripe-card-number" class="input-text wc-credit-card-form-card-number" inputmode="numeric" autocomplete="cc-number" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" placeholder="•••• •••• •••• ••••">
                            </p>

                            <p class="form-row form-row-first">
                            <label for="stripe-card-expiry">Expiry (MM/YY) <span class="required">*</span></label>
                            <input id="stripe-card-expiry" class="input-text wc-credit-card-form-card-expiry" inputmode="numeric" autocomplete="cc-exp" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" placeholder="MM / YY">
                            </p>

                            <p class="form-row form-row-last">
                            <label for="stripe-card-cvc">Card Code <span class="required">*</span></label>
                            <input id="stripe-card-cvc" class="input-text wc-credit-card-form-card-cvc" inputmode="numeric" autocomplete="off" autocorrect="no" autocapitalize="no" spellcheck="no" type="tel" maxlength="4" placeholder="CVC" style="width:100px">
                            </p>
                            <div class="clear"></div>
                        </fieldset>
                    </div>

                </div>
            </div>



        </div>


    </main>
</form>
@endsection

@section('script')
    <script type="text/javascript">

// refresh cart
function refreshCart() {
  console.log('refreshCart');
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
  console.log('getTax');
  $.ajax({
    url: "/fr-m/checkout/tax",
    type: "GET",
    data: { id: $("select[name=state_id]").val() },
    dataType: "json"
  }).done(function(json) {
    if (200 == json.code) {
        refreshCart();
    }
  });

};

$(function() {
  refreshCart();

  $("select[name=state_id]").on("change", function() {
      getTax();
  }).change();

});
    </script>
@endsection