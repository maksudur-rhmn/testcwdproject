<?php

namespace App\Http\Controllers;
use App\Cart;
use App\Order;
use Carbon\Carbon;
use App\Order_item;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\PaymentExecution;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class PaymentController extends Controller
{   
    public function create(Request $request)
    {
        $order = Order::create($request->except('_token') + [
                'order_number' => uniqid("Order-"),
                'user_id'      => Auth::id(),
                'created_at'   => Carbon::now(),
              ]);
              
      
              foreach(cartItems() as $item)
              {
                Order_item::insert([
                  'order_id'   => $order->id,
                  'user_id'    => Auth::id(),
                  'product_id' => $item->product_id,
                  'amount'     => $item->amount,
                  'created_at' => Carbon::now()
                ]);
              }

        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    'AXLaIqYuXOd2KPJ2669lHnCgbBy4QZjtz9aenIaEfurmktJCMlxlokqNbM2_CKktH5P2pjI3AcBUrCwE',     // ClientID
                    'EClvgXkRvTSBM_ddhlNu9QYH1Ej47E9G1NXjTIpmruKn4HdfS-dQRQal8afL4qxlT_8lAHNek5Prw_Ma'      // ClientSecret
                  )
              );

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');


        $item= new Item();
        $item->setName($order->order_number)
                   ->setCurrency('USD')
                   ->setQuantity(1)
                   ->setSku($order->id)
                   ->setPrice($request->total); 


                  // If you want to add more items use below code or do a foreach of the above item 
              
        // $item2 = new Item();
        // $item2->setName('Granola bars')
        //         ->setCurrency('USD')
        //         ->setQuantity(5)
        //         ->setSku('123123') // Similar to `item_number` in Classic API
        //         ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems([$item]);
  

        $details = new Details();
        $details->setShipping(0)
                ->setTax(0)
                ->setSubtotal($request->total);

        $amount = new Amount();
        $amount->setCurrency('USD')
                ->setTotal($request->total)
                ->setDetails($details);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
                ->setItemList($itemList)
                ->setDescription('Payment description')
                ->setInvoiceNumber(uniqid());

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://localhost:8000/execute-payment')
                        ->setCancelUrl('http://localhost:8000/cancel');

        $payment = new Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setRedirectUrls($redirectUrls)
                ->setTransactions([$transaction]);

        $payment->create($apiContext);


        return redirect($payment->getApprovalLink());
       
    }







   
    public function execute(Request $request)
    {

 
      $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AXLaIqYuXOd2KPJ2669lHnCgbBy4QZjtz9aenIaEfurmktJCMlxlokqNbM2_CKktH5P2pjI3AcBUrCwE',     // ClientID
            'EClvgXkRvTSBM_ddhlNu9QYH1Ej47E9G1NXjTIpmruKn4HdfS-dQRQal8afL4qxlT_8lAHNek5Prw_Ma'      // ClientSecret
          )
      );

      $paymentId = request('paymentId');
      $payment = Payment::get($paymentId, $apiContext);

     // Execution

      $execution = new PaymentExecution();
      $execution->setPayerId(request('PayerID'));
     
      // If you want to set a fixed amount use this code 

//       $transaction = new Transaction();
//       $amount = new Amount();
//       $details = new Details();

        // Set Shipping cost  if any         

//       $details->setShipping(0)
//                     ->setTax(0)
//                     ->setSubtotal(0);

       //  Set currency and total after shipping cost create() total and execute() total must be same otherwise response error 400 


//       $amount->setCurrency('USD');
//       $amount->setTotal(0);
//       $amount->setDetails($details);
//       $transaction->setAmount($amount);
//      //
//      //
//       $execution->addTransaction($transaction);
 


      $result = $payment->execute($execution, $apiContext);
      
      if ($result->getState() == 'approved')
      {
         foreach(cartItems() as $item)
         {
           Cart::find($item->id)->delete();
         }
        return redirect('/')->withSuccess('Thank you for Shopping with ToHoney');
     }
     else 
     {
        Order::where('order_number',  $result->transactions[0]->item_list->items[0]->name)->delete();
        Order_item::where('order_id', $result->transactions[0]->item_list->items[0]->sku)->delete();
        return redirect('/')->withSuccess('Payment was not processed please try again');    
     } 
     
    }

    // END
}

