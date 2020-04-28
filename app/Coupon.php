<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
      'coupon_name',
      'coupon_discount',
      'valid_till',
    ];
}
