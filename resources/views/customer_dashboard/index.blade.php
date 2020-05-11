@extends('layouts.dashboard')

@section('title')
  Customer Dashboard
@endsection

@section('content')

  <h1>Hello, {{ Auth::user()->name }}</h1>
  <h3>Welcome to customer admin panel</h3>


  <table class="table table-light">
    <thead>
      <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Total Products</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($orders as $order)
          <tr>
            <td>{{ Auth::user()->name }}</td>
            <td>{{ Auth::user()->email }}</td>
            <td>{{ $order->phone_number }}</td>
            <td>{{ $order->created_at->diffForHumans() }}</td>
             <td>
             <a href="{{ route('pdf.download', $order->id) }}" class="btn btn-success">Download Invoice</a>
             </td>
             <td>
             <a href="{{ route('send.txt', $order->id) }}" class="btn btn-info">Send Text Message</a>
             </td>
          </tr>
      @endforeach
    </tbody>
  </table>

@endsection
