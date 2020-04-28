@extends('layouts.dashboard')

@section('title')
  Category
@endsection

@section('category')
  active
@endsection

@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    <a class="breadcrumb-item" href="{{ route('category.index') }}">Categories</a>
    <span class="breadcrumb-item active">{{ $category->category_name }}</span>
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
            <h5 class="text-center">Edit Category</h5>
          </div>
          <div class="card-body">
            <form class="form-group" action="{{ route('category.update', $category->id) }}" method="post" enctype="multipart/form-data">
               {{ method_field('PUT') }}
              @csrf
              <div class="py-3">
                <input class="form-control" type="text" name="category_name" value="{{ $category->category_name }}">

              </div>
              <div class="py-3">
                <input class="form-control" type="file" name="category_image">
              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">Edit Category</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
