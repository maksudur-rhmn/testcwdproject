<?php

namespace App\Http\Controllers;
use PayPal\Api\Item;
use PayPal\Api\Payer;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Payment;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use App\Paypal\CreatePayment;
use App\Paypal\ExecutePayment;
use PayPal\Api\PaymentExecution;
use App\Http\Controllers\Controller;
use PayPal\Auth\OAuthTokenCredential;



class PaymentController extends Controller
{
    public function execute()
    {

      cartTotal();
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
      $details->setShipping(10.2)
                    ->setTax(10.3)
                    ->setSubtotal(79.50);
     //
      $amount->setCurrency('USD');
      $amount->setTotal(100);
      $amount->setDetails($details);
      $transaction->setAmount($amount);
     //
     //
      $execution->addTransaction($transaction);
     //
      $result = $payment->execute($execution, $apiContext);


      if($result->state == 'approved')
      {
        return redirect('/')->withSuccess('Payment has been charged Products will soon be delivered');
      }
      else
      {
        echo "no";
      }


    }
}
