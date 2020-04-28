@extends('layouts.dashboard')

@section('title')
  Customer Dashboard
@endsection

@section('content')

  <h1>Hello, {{ Auth::user()->name }}</h1>
  <h3>Welcome to customer admin panel</h3>

@endsection
