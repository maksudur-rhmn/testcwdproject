<?php

namespace App\Http\Controllers;

use App\Faq;
use App\Product;
use App\Category;
use App\Order_item;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;


class FrontendController extends Controller
{
    function index()
    {
      return view('frontend.index', [
        'categories' => Category::all(),
        'products'   => Product::latest()->get(),
      ]);
    }
    function about()
    {
      return view('frontend.about');
    }
    function front_faq()
    {
      $faqs = Faq::all();
      return view('frontend.faq', compact('faqs'));
    }
    function contact()
    {
      return view('frontend.contact');
    }

    function shop ()
    {
      $products = Product::all();
      $categories = Category::all();
      return view('frontend.shop', compact('products', 'categories'));
    }

    function search()
    {

      // $searched = QueryBuilder::for(Product::class)
      //                ->allowedFilters(['product_name', 'category_id'])
      //                ->allowedSorts('product_name')
      //                ->get();

      //     return view('frontend.search.index', compact('searched'));

         $min = $_GET['min_price'];
         $max = $_GET['max_price'];
         $nam = $_GET['keyword'];
         $cat = $_GET['category_id'];

   
        if($nam && $min && $max && $cat)
        {
          
          
         
        $searched = Product::where('product_name', 'LIKE', '%'.$nam.'%')
                            ->whereBetween('product_price', [$min,$max])
                            ->orderBy('product_price', 'desc')
                            ->where('category_id', $cat)
                            ->get();

   
        return view('frontend.search.index', compact('searched'));

        }
         if($nam && $min && $max)
         {
           
          $searched = Product::where('product_name', 'LIKE', '%'.$nam.'%')
          ->whereBetween('product_price', [$min,$max])->get();
          return view('frontend.search.index', compact('searched'));
         }
         if($cat && $min && $max)
         {
           
          $searched = Product::where('category_id', 'LIKE', '%'.$cat.'%')
          ->whereBetween('product_price', [$min,$max])
          ->orderBy('product_price', 'asc')
          ->get();
          return view('frontend.search.index', compact('searched'));
         }

        if($nam && $cat)
         {
         
           $searched = Product::
           where('product_name', 'LIKE', '%'.$nam.'%')
           ->where('category_id', $cat)
           ->get();
           return view('frontend.search.index', compact('searched'));
         }
        if($nam)
        {

         $searched = Product::where('product_name', 'LIKE', '%'.$nam.'%')->get();
         return view('frontend.search.index', compact('searched'));
         
        }
        if($cat)
        {

         $searched = Product::where('category_id', 'LIKE', '%'.$cat.'%')->get();
         return view('frontend.search.index', compact('searched'));
         
        }
      

         
         
             
    }

    // END
}
