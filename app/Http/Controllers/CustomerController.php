<?php

namespace App\Http\Controllers;

use PDF;
use App\Order;
use Carbon\Carbon;
use App\Order_item;
use Illuminate\Http\Request;
use Nexmo\Laravel\Facade\Nexmo;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
   function __construct()
   {
     $this->middleware('auth');
     $this->middleware('verified');
   }

   function index()
   {
     $orders = Order::where('user_id', Auth::id())->get();
     return view('customer_dashboard.index', compact('orders'));
   }

   function downloadPDF($order_id)
   {
      $order_details =  Order::findOrFail($order_id);

      $order_items =  Order_item::where('user_id', $order_details->user_id)->where('order_id', $order_details->id)->get();
      $pdf = PDF::loadView('orderpdf.invoice', compact('order_details', 'order_items'));
      $invoice = 'invoice_order_number_'. $order_id .'_'.Carbon::now()->format('Y-m-d'). '.pdf'; 
      return $pdf->download($invoice);   
   }

   function sendtxt($order_id)
   {
     $order_details =Order::findOrFail($order_id);

     $yes =  Nexmo::message()->send([
      'to'   => $order_details->phone_number,
      'from' => 'Ekomalls',
      'text' => 'Hello '. $order_details->full_name. 'Your Order number is ' . $order_id, 
    ]);
     
      return redirect('/home');

   }

   function addreview(Request $request)
   {
     Order_item::where('user_id', Auth::id())->where('product_id', $request->product_id)->whereNull('review')->first()->update([
      'stars'  => $request->stars,
      'review' => $request->review,
     ]);

     return back()->withSuccess('Review Added');
   }

   // END
}
