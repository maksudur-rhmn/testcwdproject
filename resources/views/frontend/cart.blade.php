@extends('layouts.frontend')

@section('title')
  ToHoney - Cart Page
@endsection

@section('content')
  <!-- .breadcumb-area start -->
<div class="breadcumb-area bg-img-4 ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="breadcumb-wrap text-center">
                    <h2>Shopping Cart</h2>
                    <ul>
                        <li><a href="index.html">Home</a></li>
                        <li><span>Shopping Cart</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- .breadcumb-area end -->
<!-- cart-area start -->
<div class="cart-area ptb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
              @if (session('cartadded'))
                <div class="alert alert-success">
                  {{ session('cartadded') }}
                </div>
              @endif

              @if ($errors->all())
                <div class="alert alert-danger" role="alert">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </div>
              @endif
                <form action="{{ url('update/cart') }}" method="post">
                  @csrf
                    <table class="table-responsive cart-wrap">
                        <thead>
                            <tr>
                                <th class="images">Image</th>
                                <th class="product">Product</th>
                                <th class="ptice">Price</th>
                                <th class="quantity">Quantity</th>
                                <th class="total">Total</th>
                                <th class="remove">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                           @forelse (cartItems() as $item)
                             <tr>
                                 <td class="images"><img src="{{ asset('uploads/products') }}/{{ $item->relationBetweenProduct->product_thumbnail_image }}" alt=""></td>
                                 <td class="product"><a href="{{ route('product.show', $item->relationBetweenProduct->product_slug) }}">{{ $item->relationBetweenProduct->product_name }}</a></td>
                                 <td class="ptice">${{ $item->relationBetweenProduct->product_price }}</td>
                                  <input type="hidden" name="id[]" value="{{ $item->product_id }}">
                                 <td class="quantity cart-plus-minus">
                                     <input name="amount[]" type="text" value="{{ $item->amount }}" />
                                 </td>
                                 <td class="total">${{ $item->amount * $item->relationBetweenProduct->product_price }}</td>
                                 <td class="remove"> <a href="{{ route('delete.cart', $item->id) }}"> <i class="fa fa-times"></i></a></td>
                             </tr>
                           @empty
                                <td>You have no Products</td>
                           @endforelse
                        </tbody>
                    </table>
                    <div class="row mt-60">
                        <div class="col-xl-4 col-lg-5 col-md-6 ">
                            <div class="cartcupon-wrap">
                                <ul class="d-flex">
                                    <li>
                                        <button type="submit">Update Cart</button>
                                        </form>
                                    </li>
                                    <li><a href="{{ url('/') }}">Continue Shopping</a></li>
                                </ul>
                                <h3>Cupon</h3>
                                <p>Enter Your Cupon Code if You Have One</p>
                                <div class="cupon-wrap">
                                    <input type="text" id="couponName" placeholder="Cupon Code" value="{{ $coupon_discount->coupon_name ?? "" }}">
                                    <button type="button" id="applyCoupon">Apply Cupon</button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 offset-xl-5 col-lg-4 offset-lg-3 col-md-6">
                            <div class="cart-total text-right">
                                <h3>Cart Totals</h3>
                                <ul>
                                    <li><span class="pull-left">Subtotal </span>${{ subTotal() }}</li>
                                     @isset($coupon_discount)
                                         <li><span class="pull-left">Discount </span>{{ $coupon_discount->coupon_discount }}%</li>
                                         <li><span class="pull-left"> Total </span> ${{ $total = subTotal() - (($coupon_discount->coupon_discount / 100) * subTotal()) }}</li>
                                      @else
                                        <li><span class="pull-left"> Total </span> ${{ $total = subTotal() }}</li>
                                     @endisset

                                </ul>
                                  <form action="{{ route('checkout.index') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="sub_total" value="{{ subTotal() }}">
                                    <input type="hidden" name="total" value="{{ $total }}">
                                    <input type="hidden" name="coupon_name" value="{{ $coupon_discount->coupon_name ?? "" }}">
                                    <button type="submit" class="btn btn-danger btn-lg">Checkout</button>
                                  </form>

                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</div>

<!-- cart-area end -->
@endsection

@section('script')
  <script>
      $(document).ready(function(){
        $('#applyCoupon').click(function(){
          var couponName = $('#couponName').val()
          window.location.href = "{{ url('cart') }}" +'/' + couponName
        });
      });
  </script>
@endsection
