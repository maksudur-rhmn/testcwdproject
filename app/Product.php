<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_thumbnail_image'];

    function relationBetweenCategory()
    {
       // return $this->hasOne('App\Category' , 'id', 'category_id');  // Category = id  and product = category_id
       return $this->belongsTo('App\Category', 'category_id', 'id');  //  product = category_id
    }

    function get_multiple_images()
    {
      return $this->hasMany('App\ProductMultipleImages', 'product_id', 'id');
    }




  // END
}
