@extends('layouts.dashboard')

@section('title')
  Change Password
@endsection


@section('content')
  <div class="container">
    <div class="row">
      <div class="col-lg-8 m-auto">
        @if(session('success'))
          <div class="alert alert-success">
            {{ session('success') }}
          </div>
        @endif
        <form class="form-group" action="{{ route('change_pass') }}" method="post">
          @csrf
          <div class="py-3">
            <input class="form-control" type="password" name="old_password" placeholder="Enter Old Password">
          </div>
          <div class="py-3">
            <input class="form-control" type="password" name="password" placeholder="Enter New Password">
          </div>
          <div class="py-3">
            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
          </div>
          <div class="py-3">
             <button type="submit" class="btn btn-primary">Change Password</button>
          </div>
          @if ($errors->all())
            <div class="alert alert-danger">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </div>
          @endif
        </form>
      </div>
    </div>
  </div>
@endsection
