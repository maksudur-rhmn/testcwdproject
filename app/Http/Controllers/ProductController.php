<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Str;
use Carbon\Carbon;
use App\Category;
use App\ProductMultipleImages;
use Image;


class ProductController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth')->except(['show']);
    $this->middleware('verified')->except(['show']);
  }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('product.index', [
          'categories' => Category::all(),
          'products' => Product::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->product_name. '-' .Str::random(10));

        $product_id = Product::insertGetId([
          'category_id'                       => $request->category_id,
          'product_name'                      => $request->product_name,
          'product_price'                     => $request->product_price,
          'product_short_description'         => $request->product_short_description,
          'product_long_description'          => $request->product_long_description,
          'product_thumbnail_image'           =>  'hudai.jpg',
          'product_slug'                      => $slug,
          'created_at'                        => Carbon::now(),
         ]);
         $uploaded_image = $request->file('product_thumbnail_image');
         $filename = $product_id . "." . $uploaded_image->getClientOriginalExtension();
         $location = public_path('uploads/products/'.$filename);
         Image::make($uploaded_image)->resize(600,622)->save($location);

         Product::find($product_id)->update([
           'product_thumbnail_image' => $filename
         ]);


         $all_images = $request->file('product_multiple_images');
         $flag = 1;
          foreach($all_images as $single_image)
          {
           $filename = $product_id."-".$flag.".".$single_image->extension();
           $location = public_path('uploads/products_multiple_images/'.$filename);
           Image::make($single_image)->resize(600,672)->save($location);
           $flag++;
           ProductMultipleImages::insert([
              'product_id'              =>$product_id,
              'product_multiple_images' =>$filename,
              'created_at'              =>Carbon::now(),
           ]);
          }

         return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
       $single_products = Product::where('product_slug', $slug)->first();
       $related_products = Product::where('category_id', $single_products->category_id)->where('id', '!=', $single_products->id)->get();
       return view('frontend.product_details', compact('single_products', 'related_products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
       $categories = Category::all();
       return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
       if($request->hasFile('product_thumbnail_image'))
       {
         $uploaded_image = public_path('uploads/products/') .$product->product_thumbnail_image;
         unlink($uploaded_image);
         $new_image = $request->file('product_thumbnail_image');
         $filename = $product->id. "." .$new_image->getClientOriginalExtension('product_thumbnail_image');
         $location = public_path('uploads/products/' . $filename);
         Image::make($new_image)->resize(600, 622)->save($location);
     }
     $product_multiple = ProductMultipleImages::first();
     $all_images = $request->file('product_multiple_images');
       if($all_images)
       {
          $i = 1;
         foreach($all_images as $single_image)
         {
           $uploaded_image = public_path('uploads/products_multiple_images/' . $product_multiple->product_multiple_images);
           unlink($uploaded_image);
           $filename = $product->id. '-'. $i . '.' . $single_image->extension();
           $location = public_path('uploads/products_multiple_images/' . $filename);
           Image::make($single_image)->resize(600, 672)->save($location);
         }
       }

       $product->category_id  = $request->category_id;
       $product->product_name = $request->product_name;
       $product->product_price = $request->product_price;
       $product->product_price = $request->product_price;
       $product->product_short_description = $request->product_short_description;
       $product->product_long_description = $request->product_long_description;
       $product->save();
       return back()->withSuccess('Products Updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
