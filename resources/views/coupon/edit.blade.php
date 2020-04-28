@extends('layouts.dashboard')

@section('title')
  Coupon
@endsection

@section('coupon')
  active
@endsection

@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    <a class="breadcrumb-item" href="{{ route('coupon.index') }}">Coupon</a>
    <span class="breadcrumb-item active">{{ $coupon->coupon_name }}</span>
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
            <form class="form-group" action="{{ route('coupon.update', $coupon->id) }}" method="post">
               {{ method_field('PUT') }}
              @csrf
              <div class="py-3">
                <input class="form-control" type="text" name="coupon_name" value="{{ $coupon->coupon_name }}">

              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="coupon_discount" value="{{ $coupon->coupon_discount }}">

              </div>
              <div class="py-3">
                <input class="form-control" type="date" name="valid_till" value="{{ $coupon->valid_till }}" min="{{ \Carbon\Carbon::now()->toDateString() }}">
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
