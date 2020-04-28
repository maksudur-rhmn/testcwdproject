
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
      <div class="col-lg-4">
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
            <form class="form-group" action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="py-3">
                 <select class="form-control" name="category_id">
                   <option value="">Select One</option>
                   @foreach($categories as $category)
                   <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                 @endforeach
                 </select>
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_name" placeholder="Enter Product">
                @error ('product_name')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_price" placeholder="Enter Product Price">
                @error ('product_price')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_short_description" placeholder="Enter Product Short Description">
                @error ('product_short_description')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="product_long_description" placeholder="Enter Product Long Description">
                @error ('product_long_description')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <label for="thumbnail">Product Thumbnail Image</label>
                <input id="thumbnail" class="form-control" type="file" name="product_thumbnail_image">
                @error ('product_thumbnail_image')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <label for="multiple">Product multiple Image</label>
                <input id="multiple" class="form-control" type="file" name="product_multiple_images[]" multiple>
                @error ('product_multiple_images')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">Add Product</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-8 w-100">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center">All Categories</h5>
          </div>
          <div class="card-body">
            <table class="table table-dark table-striped">
              <tr>
                <th>SL.</th>
                <th>Product Name</th>
                <th>Product Image</th>
                <th>Product Category</th>
                <th>Product Short Description</th>
                <th>Product Long Description</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
              </tr>

              @foreach ($products as $product)
              <tr>
                <td>{{ $loop -> index +1 }}</td>
                <td>{{ $product->product_name }}</td>
                <td>
                  <img src="{{ asset('uploads/products') }}/{{ $product->product_thumbnail_image }}" alt="{{ $product->product_thumbnail_image }}" width="50" class="rounded-circle">
                </td>
                <td>{{ App\Category::findOrFail($product->category_id)->category_name }}</td>
                <td>{{ $product->product_short_description }}</td>
                <td>{{ $product->product_long_description }}</td>
                <td>{{ $product->created_at->diffForHumans() }}</td>
                <td>
                @if(isset($product->updated_at))
                  {{ $product->updated_at->diffForHumans() }}
                @else
                   --
                @endif
                </td>
                <td>
                  <a href="{{ route('product.edit', $product->id) }}" class="btn btn-warning">Edit</a>
                  <a href="{{ route('product.destroy', $product->id) }}" class="btn btn-danger">
                    <form class="" action="index.html" method="post">

                    </form>
                  </a>
                </td>
              </tr>
           @endforeach
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
