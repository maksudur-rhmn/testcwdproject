@extends('layouts.dashboard')

@section('title')
  Blogs
@endsection

@section('blogs')
  active
@endsection

@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    <span class="breadcrumb-item active">Blogs</span>
  </nav>
@endsection


@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-12 m-auto">
        <div class="card">
      <div class="card-header text-center">
          <h1>All Blogs</h1>
      </div>
            <div class="card-body">
              <table class="table table-striped">
                <tr>
                  <th>SL</th>
                  <th>Blog Title</th>
                  <th>Category</th>
                  <th>Blog Description</th>
                  <th>Blog Image</th>
                  <th>Added By</th>
                  <th>Created At</th>
                  <th>Updated At</th>
                  <th>Action</th>
                </tr>
                <tr>
                  <td>1</td>
                  <td>Trendy Designs For Men</td>
                  <td>Men</td>
                  <td>  loremalkdjaldsjksakfdja';skfas;kfa;'kfsakfaskfsakfsaf' </td>
                  <td>Image ekhane</td>
                  <td>Shiplu</td>
                  <td>10 minutes ago</td>
                  <td>--</td>
                  <td>
                    buttam
                  </td>
                </tr>
              </table>
           </div>
        </div>
    </div>
  </div>
@endsection
