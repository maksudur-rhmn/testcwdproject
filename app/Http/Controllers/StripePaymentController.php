<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Stripe;

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
                 "amount" => 1000 * 100,
                 "currency" => "usd",
                 "source" => $request->stripeToken,
                 "description" => "Test payment from Seven."
         ]);

         Session::flash('success', 'Payment successful!');
          echo "Payment has been made successfully";
     }
}
