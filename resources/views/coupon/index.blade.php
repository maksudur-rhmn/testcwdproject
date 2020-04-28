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
    <span class="breadcrumb-item active">Coupon</span>
  </nav>
@endsection

@section('content')
  <div class="container">
  <div class="row">
      <div class="col-lg-3">
        @if (session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        <div class="card">
          <div class="card-header">
            <h5 class="text-center">Add Coupon</h5>
          </div>
          <div class="card-body">
            <form class="form-group" action="{{ route('coupon.store') }}" method="post">
              @csrf
              <div class="py-3">
                <input class="form-control" type="text" name="coupon_name" placeholder="Enter Coupon">
                @error ('coupon_name')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="coupon_discount" placeholder="Enter Discount Percentage">
                @error ('coupon_discount')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <input class="form-control" type="date" name="valid_till" placeholder="Valid Till" min="{{ \Carbon\Carbon::now()->toDateString() }}">
                @error ('valid_till')
                  <small class="text-danger">{{ $message }}</small>
                @enderror
              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">Add Coupons</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-9 w-100">
        <div class="card">
          @if ($errors->all())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </div>
          @endif
          <div class="card-header">
            <h5 class="text-center">All Coupons</h5>
          </div>
          <div class="card-body">
            <table class="table table-dark table-striped">
              <tr>
                <th>SL.</th>
                <th>Coupon Name</th>
                <th>Coupon Discount</th>
                <th>Coupon Valid Till</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Status</th>
                <th>Active</th>
                <th>Action</th>
                <th></th>
              </tr>

              @foreach ($coupons as $coupon)
              <tr>
                <td>{{ $loop -> index +1 }}</td>
                <td>{{ $coupon->coupon_name }}</td>
                <td>{{ $coupon->coupon_discount }}%</td>
                <td>{{ $coupon->valid_till }}</td>
                <td>{{ $coupon->created_at->diffForHumans() }}</td>
                <td>

                @if(isset($category->updated_at))
                  {{ $coupon->updated_at->diffForHumans() }}
                @else
                   --
                @endif
                </td>
                <td>
                  @if($coupon->valid_till >= \Carbon\Carbon::now())
                    <span class="badge badge-success p-1">Active</span>
                  @else
                    <span class="badge badge-danger p-1">Expired</span>
                  @endif
                </td>
                <td>
                  @if($coupon->valid_till >= \Carbon\Carbon::now()->format('Y-m-d'))
                    <span class="badge badge-success">{{ \Carbon\Carbon::parse($coupon->valid_till)->diffInDays(\Carbon\Carbon::now()->format('Y-m-d')) }} Days Left</span>
                  @else
                    <span class="badge badge-danger">Expired</span>
                  @endif
                </td>
                <td>
                  <a href="{{ route('coupon.edit', $coupon->id) }}" class="btn btn-warning">Edit</a>

                </td>
                <td>
                    <form class="" action="{{ route('coupon.destroy', $coupon->id) }}" method="post">
                      {{ method_field('DELETE') }}
                      @csrf
                      <input type="hidden" name="id" value="{{ $coupon->id }}">
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
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
