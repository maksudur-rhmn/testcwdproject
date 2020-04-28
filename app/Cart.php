<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
   protected $fillable = ['amount'];

   public function relationBetweenProduct()
   {
     return $this->belongsTo('App\Product', 'product_id', 'id');
   }
}
