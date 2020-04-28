@extends('layouts.dashboard')

@section('title')
  Frequently Asked Question
@endsection

@section('faq')
  active
@endsection

@section('breadcrumb')
  <nav class="breadcrumb sl-breadcrumb">
    <a class="breadcrumb-item" href="{{ route('home') }}">Home</a>
    <a class="breadcrumb-item" href="{{ route('faq_index') }}">All Faq's</a>
    <span class="breadcrumb-item active">{{ $faq->faq_question }}</span>
  </nav>
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
        <div class="card">
          <div class="card-header">
            <h1 class="text-center">Edit Faq</h1>
          </div>
          <div class="card-body">
            <form class="form-group" action="{{ route('faq_update') }}" method="post">
              @csrf
              <div class="py-3">
                <input type="hidden" name="id" value="{{ $faq->id }}">
                <input class="form-control" type="text" name="faq_question" placeholder="Enter FAQ?" value="{{ $faq->faq_question }}">

              </div>
              <div class="py-3">
                <input class="form-control" type="text" name="faq_answer" placeholder="Answer" value="{{ $faq->faq_answer }}">

              </div>
              <div class="py-3">
                <button type="submit" class="btn btn-primary">Add Faq</button>
              </div>

                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
