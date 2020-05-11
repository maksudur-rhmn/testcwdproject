@extends('layouts.frontend')

@section('title')
  Checkout
@endsection



@section('content')
  <!-- .breadcumb-area start -->
     <div class="breadcumb-area bg-img-4 ptb-100">
         <div class="container">
             <div class="row">
                 <div class="col-12">
                     <div class="breadcumb-wrap text-center">
                         <h2>Checkout</h2>
                         <ul>
                             <li><a href="index.html">Home</a></li>
                             <li><span>Checkout</span></li>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- .breadcumb-area end -->
     <!-- checkout-area start -->
     <div class="checkout-area ptb-100">
         <div class="container">
             <div class="row">
                 <div class="col-lg-8">
                     <div class="checkout-form form-style">
                         <h3>Billing Details</h3>
                         <form id="paypal_sub" action="{{ route('checkout.post') }}" method="post">
                           @csrf
                             <div class="row">
                                 <div class="col-12">
                                     <p>Full Name</p>
                                     <input type="text" name="full_name" value="{{ Auth::user()->name }}">
                                 </div>
                                 <div class="col-sm-6 col-12">
                                     <p>Email Address *</p>
                                     <input type="email" name="email_address" value="{{ Auth::user()->email }}">
                                 </div>
                                 <div class="col-sm-6 col-12">
                                     <p>Phone No. *</p>
                                     <input type="text" name="phone_number" value="{{ Auth::user()->phone_number }}">
                                 </div>
                                 <div class="col-12">
                                     <p>Country *</p>
                                    <select class="" name="country_id" id="country_list">
                                      <option value="">Select Your Country</option>
                                      @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                      @endforeach
                                    </select>
                                 </div>
                                 <div class="col-12">
                                     <p>City *</p>
                                    <select class="" name="city_id" id="city_list">
                                      <option value="">Select Your City</option>
                                    </select>
                                 </div>
                                 {{-- <div class="col-12">
                                     <p>City *</p>
                                    <select class="" name="city_id">
                                      <option value="1">DHaka</option>
                                      <option value="2">Delhi</option>
                                      <option value="3">Sydney</option>
                                    </select>
                                 </div> --}}
                                 <div class="col-12">
                                     <p>Your Address *</p>
                                     <input type="text" name="address" value="{{ Auth::user()->address }}">
                                 </div>
                                 <div class="col-12">
                                     <p>Order Notes </p>
                                     <textarea name="notes" placeholder="Notes about Your Order, e.g.Special Note for Delivery"></textarea>
                                 </div>
                             </div>

                     </div>
                 </div>
                 <div class="col-lg-4">
                     <div class="order-area">
                         <h3>Your Order</h3>

                         <ul class="total-cost">
                           @foreach ($cartItems as $cartItem)
                             <li>{{ $cartItem->relationBetweenProduct->product_name. "      Qt.   ". $cartItem->amount }}<span class="pull-right">${{ $cartItem->amount *  $cartItem->relationBetweenProduct->product_price }}</span></li>
                           @endforeach
                             <li>Subtotal <span class="pull-right"><strong>${{ $sub_total }}</strong></span></li>
                             <li>Coupon Name <span class="pull-right"><strong>{{ $coupon_name }}</strong></span></li>
                             <li>Shipping <span class="pull-right">Free</span></li>
                             <li>Total<span class="pull-right">${{ $total }}</span></li>
                         </ul>
                         <ul class="payment-method">
                             <li>
                                 <input id="card" type="radio" name="payment_status" value="2">
                                 <label for="card">Credit Card</label>
                             </li>
                             <li>
                                 <input id="paypal" type="radio" name="payment_status" value="3">
                                 <label for="paypal">PayPal</label>
                             </li>
                             <li>
                                 <input id="delivery" type="radio" name="payment_status" value="1" checked>
                                 <label for="delivery">Cash on Delivery</label>
                             </li>
                         </ul>
                         
                         <input type="hidden" name="sub_total" value="{{ $sub_total }}">
                         <input type="hidden" name="coupon_name" value="{{ $coupon_name }}">
                         <input type="hidden" name="total" value="{{ $total }}">
                         <button type="submit">Place Order</button>
                         <div class="mt-5" id="paypal-button-container"></div>
                         </form>
                         {{-- <div class="flex-center position-ref full-height">

                <div class="content">
                    <h1>Laravel 5.8 PayPal Integration Tutorial - ItSolutionStuff.com</h1>

                    <table border="0" cellpadding="10" cellspacing="0" align="center"><tr><td align="center"></td></tr><tr><td align="center"><a href="https://www.paypal.com/in/webapps/mpp/paypal-popup" title="How PayPal Works" onclick="javascript:window.open('https://www.paypal.com/in/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png" border="0" alt="PayPal Logo"></a></td></tr></table>

                    <a href="https://paypal.me/ekomalls" class="btn btn-success">Pay $100 from Paypal</a>

                </div>
            </div> --}}
                     </div>
                 </div>
             </div>
         </div>
     </div>
     <!-- checkout-area end -->
@endsection

@section('script')
  <script>
    $(document).ready(function(){
       $('#country_list').change(function(){
        var country_id = $(this).val();
        // Ajax Default Code
        $.ajaxSetup({
           headers: {
               'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               }
           });
      // Ajax Default Code Ends

     // Ajax Request Starts

           $.ajax({

             type: 'POST',
             url:  '/get/city/list',
             data: {country_id:country_id},
             success: function(data)
             {
               $('#city_list').html(data);
             }

           });

        });

        // Ajax Request 
    });


    $(document).ready(function(){
      $('#paypal').click(function(){
        var form  = document.getElementById('paypal_sub')
            form.action = "{{ route('create-payment') }}"
            // form.method = 'POST'
            console.log(form);
      });
      $("#delivery").unbind("click", process_click);
      $("#card").unbind("click", process_click);
   });
  </script>
@endsection


 