<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Auth;
use App\Order;
use App\Order_item;
use Carbon\Carbon;
use App\Cart;

class StripePaymentController extends Controller
{
  /**
      * success response method.
      *
      * @return \Illuminate\Http\Response
      */
     public function stripe()
     {
         return view('stripe');
     }

     /**
      * success response method.
      *
      * @return \Illuminate\Http\Response
      */
     public function stripePost(Request $request)
     {
         Stripe\Stripe::setApiKey('sk_test_firDb2BrvwKsLBZBcsv70lWJ00e8vefitV');
         Stripe\Charge::create ([
                 "amount" => $request->total  * 100,
                 "currency" => "usd",
                 "source" => $request->stripeToken,
                 "description" => "Test payment from Seven."
         ]);

         $order_id = Order::insertGetId([
            'order_number'        =>uniqid('Order-'),
            'full_name'           =>$request->full_name,
            'email_address'       =>$request->email_address,
            'phone_number'        =>$request->phone_number,
            'country_id'          =>$request->country_id,
            'city_id'             =>$request->city_id,
            'address'             =>$request->address,
            'notes'               =>$request->notes,
            'total'               =>$request->total,
            'sub_total'           =>$request->sub_total,
            'created_at'          =>Carbon::now(),
            'user_id'             =>Auth::id(),
            'payment_status'      =>2,
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

             Cart::find($item->id)->delete();
         }
         return redirect('/')->withSuccess('Thank you for Shopping with ToHoney');
     }
}
