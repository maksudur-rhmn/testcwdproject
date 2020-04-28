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
    <span class="breadcrumb-item active">Categories</span>
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
        @if ($errors->all())
          <div class="alert alert-danger" role="alert">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
          </div>
        @endif
        <div class="card">
          <div class="card-header">
            <h5 class="text-center">Add Category</h5>
          </div>
          <div class="card-body">
            <form class="form-group" action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
              @csrf
              <div class="py-3">
                <input class="form-control" type="text" name="category_name" placeholder="Enter Category">
                @error ('category_name')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="file" name="category_image">
                @error ('category_image')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">Add Category</button>
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
                <th>Category Name</th>
                <th>Category Image</th>
                <th>Added By</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>
                <th></th>
              </tr>

              @foreach ($categories as $category)
              <tr>
                <td>{{ $loop -> index +1 }}</td>
                <td>{{ $category->category_name }}</td>
                <td>
                  <img src="{{ asset('uploads/categories') }}/{{ $category->category_image }}" alt="cat_image" width="50" class="rounded-circle">
                </td>
                <td>{{ App\User::findOrFail($category->added_by)->name }}</td>
                <td>{{ $category->created_at->diffForHumans() }}</td>
                <td>
                @if(isset($category->updated_at))
                  {{ $category->updated_at->diffForHumans() }}
                @else
                   --
                @endif
                </td>
                <td>
                  <a href="{{ route('category.edit', $category->id) }}" class="btn btn-warning">Edit</a>

                </td>
                <td>
                    <form class="" action="{{ route('category.destroy', $category->id) }}" method="post">
                      {{ method_field('DELETE') }}
                      @csrf
                      <input type="hidden" name="category_id" value="{{ $category->id }}">
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                    {{-- <a href="{{ route('category_delete', $category->id) }}" class="btn btn-info">get delete</a> --}}
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
