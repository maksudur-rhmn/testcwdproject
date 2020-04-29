<?php

namespace App\Http\Controllers;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use PayPal\Api\PaymentExecution;
use App\Http\Controllers\Controller;



class PaymentController extends Controller
{   

    public function create(Request $request)
    {
        session(['request' => request()->all()]);
        $apiContext = new \PayPal\Rest\ApiContext(
                new \PayPal\Auth\OAuthTokenCredential(
                    'AXLaIqYuXOd2KPJ2669lHnCgbBy4QZjtz9aenIaEfurmktJCMlxlokqNbM2_CKktH5P2pjI3AcBUrCwE',     // ClientID
                    'EClvgXkRvTSBM_ddhlNu9QYH1Ej47E9G1NXjTIpmruKn4HdfS-dQRQal8afL4qxlT_8lAHNek5Prw_Ma'      // ClientSecret
                  )
              );

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $item1 = new Item();
        $item1->setName('Products')
                ->setCurrency('USD')
                ->setQuantity(1)
                ->setSku('123123') // Similar to `item_number` in Classic API
                ->setPrice($request->total);
        // $item2 = new Item();
        // $item2->setName('Granola bars')
        //         ->setCurrency('USD')
        //         ->setQuantity(5)
        //         ->setSku('123123') // Similar to `item_number` in Classic API
        //         ->setPrice(2);

        $itemList = new ItemList();
        $itemList->setItems([$item1]);

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







   
    public function execute()
    {
 
      $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            'AXLaIqYuXOd2KPJ2669lHnCgbBy4QZjtz9aenIaEfurmktJCMlxlokqNbM2_CKktH5P2pjI3AcBUrCwE',     // ClientID
            'EClvgXkRvTSBM_ddhlNu9QYH1Ej47E9G1NXjTIpmruKn4HdfS-dQRQal8afL4qxlT_8lAHNek5Prw_Ma'      // ClientSecret
          )
      );

      $paymentId = request('paymentId');
      $payment = Payment::get($paymentId, $apiContext);
     //
      $execution = new PaymentExecution();
      $execution->setPayerId(request('PayerID'));
     //
      $transaction = new Transaction();
      $amount = new Amount();
      $details = new Details();
     //
      $details->setShipping(0)
                    ->setTax(0)
                    ->setSubtotal(session('request.total'));
     //
      $amount->setCurrency('USD');
      $amount->setTotal(session('request.total'));
      $amount->setDetails($details);
      $transaction->setAmount($amount);
     //
     //
      $execution->addTransaction($transaction);
     //
      $result = $payment->execute($execution, $apiContext);

      return $result;


    }
}
