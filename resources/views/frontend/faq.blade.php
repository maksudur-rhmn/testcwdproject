@extends('layouts.frontend')

@section('faq')
  active
@endsection

@section('content')
  <!-- Faq-area start -->
    <div class="about-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-12">
                  <div class="about-wrap text-center">
                    <h3>Frequently Asked Question</h3>
                  </div>
                  <div class="accordion" id="accordionExample">
                    @php
                      $i = 1;
                    @endphp
                    @foreach ($faqs as $faq)
                      <div class="card border-0">
                      <div class="card-header border-0 p-0 my-3">
                          <button class="btn btn-link text-left py-3 w-100 text-white {{ ($i == 1)? '' : 'collapsed' }}" type="button" data-toggle="collapse" data-target="#faq{{ $faq->id }}" aria-expanded="true" aria-controls="faq{{ $faq->id }}">
                           {{ $faq->faq_question }}
                          </button>
                      </div>

                      <div id="faq{{ $faq->id }}" class="collapse {{ ($i == 1)? 'show': '' }}" aria-labelledby="faq{{ $faq->id }}" data-parent="#accordionExample">
                        <div class="card-body">
                          {{ $faq->faq_answer }}
                        </div>
                      </div>
                    </div>
                    @php
                      $i++;
                    @endphp
                    @endforeach
                  </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Faq-area end -->
@endsection
