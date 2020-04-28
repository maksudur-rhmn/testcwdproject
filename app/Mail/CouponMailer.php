<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CouponMailer extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $coupon_name = "";
    public function __construct($coupon_name)
    {
       $this->coupon_name = $coupon_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $coupon_name = "";
        return $this->view('mails.couponMailer', compact('coupon_name'));
    }
}
