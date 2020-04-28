<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Faq;
use App\Product;

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

    // END
}
