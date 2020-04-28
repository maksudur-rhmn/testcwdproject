@extends('layouts.dashboard')

@section('title')
  Home
@endsection


@section('home')
  active
@endsection


@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    {{-- <a class="breadcrumb-item" href="index.html">Pages</a>
    <span class="breadcrumb-item active">Blank Page</span> --}}
  </nav>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Total Users : {{ $total_users }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <table class="table table-striped">
                      <tr>
                        <th>SL</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                      </tr>
                      @foreach ($users as $user)
                        <tr>
                          <td>{{ $loop-> index + 1 }}</td>
                          <td>{{ $user->name }}</td>
                          <td>{{ $user->email }}</td>
                          <td>{{ $user->created_at->diffForHumans() }}</td>
                          @if($user->updated_at)
                            <td>{{ $user->updated_at->diffForHumans() }}</td>
                          @else
                            <td>{{ '--' }}</td>
                          @endif
                        </tr>
                      @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
