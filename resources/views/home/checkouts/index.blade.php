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
                            <h3 class="h-title mb-30 t-uppercase">Info</h3>

                            <div class="woocommerce-billing-fields">
                            <p class="form-row form-row form-row-first validate-required" id="billing_first_name_field"><label for="billing_first_name" class="">First Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_first_name" id="billing_first_name" placeholder="" autocomplete="given-name" value=""></p>

                            <p class="form-row form-row form-row-last validate-required" id="billing_last_name_field"><label for="billing_last_name" class="">Last Name <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_last_name" id="billing_last_name" placeholder="" autocomplete="family-name" value=""></p><div class="clear"></div>

                            <p class="form-row form-row form-row-first validate-required validate-email" id="billing_email_field"><label for="billing_email" class="">Email Address <abbr class="required" title="required">*</abbr></label><input type="email" class="input-text " name="billing_email" id="billing_email" placeholder="" autocomplete="email" value=""></p>

                            <p class="form-row form-row form-row-last validate-required validate-phone" id="billing_phone_field"><label for="billing_phone" class="">Phone <abbr class="required" title="required">*</abbr></label><input type="tel" class="input-text " name="billing_phone" id="billing_phone" placeholder="" autocomplete="tel" value=""></p><div class="clear"></div>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="billing_address_1_field"><label for="billing_address_1" class="">Address <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_address_1" id="billing_address_1" placeholder="Street address" autocomplete="address-line1" value=""></p>

                            <p class="form-row form-row form-row-wide address-field" id="billing_address_2_field"><input type="text" class="input-text " name="billing_address_2" id="billing_address_2" placeholder="Apartment, suite, unit etc. (optional)" autocomplete="address-line2" value=""></p>

                            <p class="form-row form-row form-row-wide address-field validate-required" id="billing_city_field" data-o_class="form-row form-row form-row-wide address-field validate-required"><label for="billing_city" class="">Town / City <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_city" id="billing_city" placeholder="" autocomplete="address-level2" value=""></p>

		                    <p class="form-row form-row form-row-first address-field validate-state woocommerce-invalid woocommerce-invalid-required-field validate-required" id="billing_state_field" data-o_class="form-row form-row form-row-first address-field validate-required validate-state woocommerce-invalid woocommerce-invalid-required-field"><label for="billing_state" class="">State <abbr class="required" title="required">*</abbr></label>

                            <select name="state_id" id="billing_state" class="state_select" data-placeholder="" tabindex="-1" title="State *">
                              <option value="">Please Select</option>
                              @foreach ($states as $state)
                              <option value="{{ $state->id }}">{{ $state->name }}</option>
                              @endforeach
                            </select>
                            </p>

                            <p class="form-row form-row form-row-last address-field validate-postcode validate-required" id="billing_postcode_field" data-o_class="form-row form-row form-row-last address-field validate-required validate-postcode"><label for="billing_postcode" class="">ZIP <abbr class="required" title="required">*</abbr></label><input type="text" class="input-text " name="billing_postcode" id="billing_postcode" placeholder="" autocomplete="postal-code" value=""></p>

		                    <div class="clear"></div>
	                    </div>
                        </div>
                    </div>

                    <div class="container">
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