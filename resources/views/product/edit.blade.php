
@extends('layouts.dashboard')

@section('title')
  Products
@endsection

@section('product')
  active
@endsection

@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    <span class="breadcrumb-item active">Products</span>
  </nav>
@endsection

@section('content')
  <div class="container">
  <div class="row">
      <div class="col-lg-8 m-auto">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        <div class="card">
          <div class="card-header">
            <h5 class="text-center">Add Products</h5>
          </div>
          <div class="card-body">
            <form class="form-group" action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
              {{ method_field('PUT') }}
              @csrf
              <div class="py-3">
                 <select class="form-control" name="category_id">
                  <option value="{{ $product->relationBetweenCategory->category_id }}">{{ $product->relationBetweenCategory->category_name }}</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                  @endforeach
                 </select>
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_name" value="{{ $product->product_name }}">
                @error ('product_name')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_price" value="{{ $product->product_price }}">
                @error ('product_price')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_short_description" value="{{ $product->product_short_description }}">
                @error ('product_short_description')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_long_description" value="{{ $product->product_long_description }}">
                @error ('product_long_description')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <label for="thumbnail">Product Thumbnail Image</label>
                <img src="{{ asset('uploads/products') }}/{{ $product->product_thumbnail_image }}" alt="Not Found" width="100">
                <input id="thumbnail" class="form-control" type="file" name="product_thumbnail_image">
                @error ('product_thumbnail_image')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <label for="multiple">Product multiple Image</label>
                @foreach ($product->get_multiple_images as $multi)
                  <img src="{{ asset('uploads/products_multiple_images') }}/{{ $multi->product_multiple_images }}" alt="Not Found" width="100">
                @endforeach
                <input id="multiple" class="form-control" type="file" name="product_multiple_images[]" multiple>
                @error ('product_multiple_images')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">Update Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
