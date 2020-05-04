<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Cart;
use App\Order;
use App\Order_item;
use App\Country;
use App\State;

class CheckoutController extends Controller
{
   public function __construct()
   {
     $this->middleware('auth');
   }

   public function index(Request $request)
   {
     $sub_total  = $request->sub_total;
     $total  = $request->total;
     $coupon_name = $request->coupon_name;
     $cartItems = cartItems();
     $countries = Country::all();
     return view('frontend.checkout', compact('sub_total', 'total', 'coupon_name', 'cartItems', 'countries'));
   }

   public function post(Request $request)
   {
      if($request->payment_status == 1)
      {
        $order_id = Order::insertGetId($request->except('_token') + [
          'order_number' => uniqid("Order-"),
          'user_id'      => Auth::id(),
          'created_at'   => Carbon::now(),
        ]);

        foreach(cartItems() as $item)
        {
          Order_item::insert([
            'order_id'   => $order_id,
            'user_id'    => Auth::id(),
            'product_id' => $item->product_id,
            'amount'     => $item->amount,
            'created_at' => Carbon::now()
          ]);

          // Product::find($item->product_id)->decrement('quantity', $item->amount)
          Cart::find($item->id)->delete();
        }
        return redirect('/')->withSuccess('Thank you for Shopping with ToHoney');
      }
      elseif($request->payment_status == 2)
      {
        return view('frontend.online_payment');
      }
      
   }

   public function getcitylist(Request $request)
   {
      $cities = State::where('country_id', $request->country_id)->get();
      $dropdown = "";
      foreach($cities as $city)
      {
        $dropdown .=  " <option value='". $city->id ."'>". $city->name ."</option>";
      }
      echo $dropdown;
   }



}
