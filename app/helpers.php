<?php

use App\Order_item;

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

function average_stars($product_id)
{

   if(!App\Order_item::where('product_id', $product_id)->exists())
   {
     return 0;
   }

   if(App\Order_item::where('product_id', $product_id)->whereNull('stars')->exists())
   {
     return 0;
   }
    $average = (App\Order_item::where('product_id', $product_id)->whereNotNull('stars')->sum('stars'))/(App\Order_item::where('product_id', $product_id)->whereNotNull('stars')->count());

    return floor($average);

}
