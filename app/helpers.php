<?php

function cartTotal()
{
  return App\Cart::where('ip_address', request()->ip())->count();
}

function cartItems()
{
  return App\Cart::where('ip_address', request()->ip())->get();
}

function subTotal()
{
  $sub_total = 0;
  foreach (cartItems() as $item)
  {
    $sub_total = $sub_total + ($item->amount * App\Product::findOrFail($item->product_id)->product_price);
  }
  return $sub_total;
}
