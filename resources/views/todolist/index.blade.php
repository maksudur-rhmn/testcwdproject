@extends('layouts.dashboard')

@section('title')
  To Do List
@endsection

@section('todolist')
  active
@endsection

@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    <span class="breadcrumb-item active">To Do List</span>
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
            <h5 class="text-center">Add To Do List</h5>
          </div>
          <div class="card-body">
            <form class="form-group" action="{{ route('todolist.store') }}" method="post">
              @csrf
              <div class="py-3">
                <input class="form-control" type="text" name="what_to_do" placeholder="What to do?">
              </div>
              <div class="py-3">
                <input class="form-control" type="date" name="when_to_do" placeholder="When?">

              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">List it</button>
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
      <div class="col-lg-8 w-100">
        <div class="card">
          <div class="card-header">
            <h5 class="text-center">All Schedule</h5>
          </div>
          <div class="card-body">
            <table class="table table-dark table-striped">
              <tr>
                <th>SL.</th>
                <th>What?</th>
                <th>When?</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th>Action</th>

              </tr>

              @forelse ($todolists as $todolist)
              <tr>
                <td>{{ $loop -> index +1 }}</td>
                <td>{{ $todolist->what_to_do }}</td>
                <td>{{ $todolist->when_to_do }}</td>
                <td>{{ $todolist->created_at->diffForHumans() }}</td>
                <td>
                @if(isset($todolist->updated_at))
                  {{ $todolist->updated_at->diffForHumans() }}
                @else
                   --
                @endif
                </td>
                <td class=" text-center">
                @if ($todolist->done == 0)
                   <a href="{{ route('todolist.edit', $todolist->id) }}" class="btn btn-success">Click Done</a>
                 @else
                  <i class="fa fa-check-circle" style="color:green;font-size:18px;"></i>
                @endif
             </td>
              </tr>
            @empty
             <tr>
               <td>No Schedule Available</td>
             </tr>

            @endforelse
            </table> 
            @if($done == 1)
            <a href="{{ route('todolist.alldone') }}" class="btn btn-success">Mark all as Done</a>
          @else
            {!! 'All done <i class="fa fa-check-circle" style="color:green;font-size:18px;"></i>' !!}
          @endif

          <a href="{{ route('todolist.alldelete') }}" class="btn btn-danger">Delete All</a>

          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
