<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cart;
use Carbon\Carbon;
use App\Coupon;
use App\Order;
use Auth;

class CartController extends Controller
{
   public function addCart(Request $request)
   {
    if(Cart::where('ip_address', $request->ip())->where('product_id', $request->product_id)->exists())
    {
      Cart::where('ip_address', $request->ip())->where('product_id', $request->product_id)->increment('amount', $request->amount);
    }
    else
    {
      Cart::insert([
        'ip_address'  => $request->ip(),
        'product_id'  => $request->product_id,
        'amount'      => $request->amount,
        'created_at'  => Carbon::now(),
      ]);
    }

     return back()->withCartadded('Products Added to Cart');
   }

   function deleteCart($cart_id)
   {
     Cart::findOrFail($cart_id)->delete();
     return back();
   }

   function cart($coupon_name = "")
   {
     if($coupon_name != "")
     {
       if(Coupon::where('coupon_name', $coupon_name)->exists())
       {
         if(Coupon::where('coupon_name', $coupon_name)->first()->valid_till >= Carbon::now())
         {
           if(!Order::where('coupon_name', $coupon_name)->where('user_id', Auth::id())->exists())
           {
             $coupon_discount = Coupon::where('coupon_name', $coupon_name)->first();
             return view('frontend.cart', compact('coupon_discount'));
           }
           else
           {
             return redirect('/cart')->withErrors('You have already made a purchase with this coupon code');
           }
         }
         else
         {
           return redirect('/cart')->withErrors('Coupon Code Already Expired');
         }
       }
       else
       {
         return redirect('/cart')->withErrors('Invalid Coupon Code');
       }
     }
     else
     {
       return view('frontend.cart');
     }
   }

   function updateCart(Request $request)
   {
     foreach ($request->id as $key => $id) {

     Cart::where('product_id', $id)->update([
         'amount' => $request->amount[$key]
       ]);

     }
      return back()->withCartadded('Cart Updated Successfully');
   }
}
