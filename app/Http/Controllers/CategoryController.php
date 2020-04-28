<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Image;

class CategoryController extends Controller
{

    public  function __construct()
    {
      $this->middleware('auth');
      $this->middleware('verified');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $categories = Category::all();
      return view('category.index', compact('categories'));
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
      $request->validate([
        'category_name' => 'required|unique:categories',
      ]);

      $return_after_create = Category::create($request->except('_token') + ['added_by' => Auth::id(), 'created_at' => Carbon::now()]);

      if($request->hasFile('category_image'))
      {
        $uploaded_image = $request->file('category_image');
        $filename = $return_after_create->id. "."  .$uploaded_image->getClientOriginalExtension('category_image');
        $location = public_path('uploads/categories/' . $filename);
        Image::make($uploaded_image)->resize(600, 470)->save($location, 100);

        $return_after_create->category_image = $filename;
        $return_after_create->save();

      }

      return back()->withSuccess('Category Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
         return view('category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

      if($request->hasFile('category_image'))
      {
        if($category->category_image != 'category_default_image.jpg')
        {
          $uploaded_image = public_path('uploads/categories/' . $category->category_image);
          unlink($uploaded_image);
        }
        $uploaded_image = $request->file('category_image');
        $filename = $category->id. "." .$uploaded_image->getClientOriginalExtension('category_image');
        $location = public_path('uploads/categories/' . $filename);
        Image::make($uploaded_image)->resize(600,470)->save($location, 100);
        $category->category_image = $filename;
      }

       $category->category_name = $request->category_name;
       $category->save();
       return redirect('/category')->withSuccess('Category Edited Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category, Request $request)
    {
      if($category->product->count() < 0)
      {
        Category::findOrFail($request->category_id)->delete();
        return back()->withErrors('Category Deleted');
      }
      else
      {
        return back()->withErrors('Category is associated with a product. Please delete the product in order to proceed');
      }


    }

    public function delete($id)

{     Category::findOrFail($id)->delete();
    return back();
    }
}
