@extends('layouts.frontend')


@section('content')
  <!-- .breadcumb-area start -->
  <div class="breadcumb-area bg-img-4 ptb-100">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <div class="breadcumb-wrap text-center">
                      <h2>Shop Page</h2>
                      <ul>
                          <li><a href="index.html">Home</a></li>
                          <li><span>Shop</span></li>
                      </ul>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- .breadcumb-area end -->
  <!-- single-product-area start-->
  <div class="single-product-area ptb-100">
      <div class="container">
          <div class="row">
              <div class="col-lg-6">
                  <div class="product-single-img">
                      <div class="product-active owl-carousel">
                        <div class="item">
                            <img src="{{ asset('uploads/products') }}/{{ $single_products->product_thumbnail_image }}" alt="">
                        </div>
                        @foreach ($single_products->get_multiple_images as $multi)
                          <div class="item">
                            <img src="{{ asset('uploads/products_multiple_images') }}/{{ $multi->product_multiple_images }}" alt="">
                          </div>
                        @endforeach

                      </div>
                      <div class="product-thumbnil-active  owl-carousel">
                        <div class="item">
                            <img src="{{ asset('uploads/products') }}/{{ $single_products->product_thumbnail_image }}" alt="">
                        </div>
                         @foreach ($single_products->get_multiple_images as $multi)
                           <div class="item">
                             <img src="{{ asset('uploads/products_multiple_images') }}/{{ $multi->product_multiple_images }}" alt="">
                           </div>
                         @endforeach
                      </div>
                  </div>
              </div>
              <div class="col-lg-6">
                  <div class="product-single-content">
                      {{-- <h3>{{ $single_products[0]->product_name }}</h3>   If use get() in show method you must call the indexing array for single collections --}}
                      <h3>{{ $single_products->product_name }}</h3> {{-- If use first() in show method --}}
                      <div class="rating-wrap fix">
                          <span class="pull-left">${{ $single_products->product_price }}</span>
                          <ul class="rating pull-right">
                              @if(average_stars($single_products->id) == 1)
                                <li><i class="fa fa-star"></i></li>    
                              @elseif(average_stars($single_products->id) == 2)
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                              @elseif(average_stars($single_products->id) == 3)
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                              @elseif(average_stars($single_products->id) == 4)
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                              @elseif(average_stars($single_products->id) == 5)
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                                <li><i class="fa fa-star"></i></li>
                              @endif
                              <li>({{ \App\Order_item::where('product_id', $single_products->id)->whereNotNull('review')->count() }} Customar Review)</li>
                          </ul>
                      </div>
                      <p>{{ $single_products->product_short_description }}</p>
                      {{-- {{ $single_products->get_multiple_images }} --}}
                      <ul class="input-style">
                        <form class="" action="{{ route('add.cart') }}" method="post">
                          @csrf
                            <input type="hidden" name="product_id" value="{{ $single_products->id }}">
                            <li class="quantity cart-plus-minus">
                                <input name="amount" type="text" value="1" />
                            </li>
                            <li><button type="submit" class="btn btn-danger">Add to Cart</button></li>
                          </form>
                      </ul>
                      @if (session('cartadded'))
                        <div class="alert alert-success">
                          {{ session('cartadded') }}
                        </div>
                      @endif
                      <ul class="cetagory">
                          <li>Categories:</li>
                          {{-- <li><a href="#">{{ App\Category::findOrFail($single_products->category_id)->category_name }}</a></li>   Chorami buddhi  --}}
                          <li><a href="#">{{$single_products->relationBetweenCategory->category_name}}</a></li>   {{-- Database Relation --}}
                      </ul>
                      <ul class="socil-icon">
                          <li>Share :</li>
                          <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                          <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                          <li><a href="#"><i class="fa fa-linkedin"></i></a></li>
                          <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                          <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                      </ul>
                  </div>
              </div>
          </div>
          <div class="row mt-60">
              <div class="col-12">
                  <div class="single-product-menu">
                      <ul class="nav">
                          <li><a class="active" data-toggle="tab" href="#description">Description</a> </li>
                          <li><a data-toggle="tab" href="#tag">Faq</a></li>
                          <li><a data-toggle="tab" href="#review">Review</a></li>
                      </ul>
                  </div>
              </div>
              <div class="col-12">
                  <div class="tab-content">
                      <div class="tab-pane active" id="description">
                          <div class="description-wrap">
                              <p>{{ $single_products->product_long_description }}</p>
                          </div>
                      </div>
                      <div class="tab-pane" id="tag">
                          <div class="faq-wrap" id="accordion">
                              <div class="card">
                                  <div class="card-header" id="headingOne">
                                      <h5><button data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">General Inquiries ?</button> </h5>
                                  </div>
                                  <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                                      <div class="card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                      </div>
                                  </div>
                              </div>
                              <div class="card">
                                  <div class="card-header" id="headingTwo">
                                      <h5><button class="collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">How To Use ?</button></h5>
                                  </div>
                                  <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                      <div class="card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                      </div>
                                  </div>
                              </div>
                              <div class="card">
                                  <div class="card-header" id="headingThree">
                                      <h5><button class="collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">Shipping & Delivery ?</button></h5>
                                  </div>
                                  <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                                      <div class="card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                      </div>
                                  </div>
                              </div>
                              <div class="card">
                                  <div class="card-header" id="headingfour">
                                      <h5><button class="collapsed" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">Additional Information ?</button></h5>
                                  </div>
                                  <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
                                      <div class="card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                      </div>
                                  </div>
                              </div>
                              <div class="card">
                                  <div class="card-header" id="headingfive">
                                      <h5><button class="collapsed" data-toggle="collapse" data-target="#collapsefive" aria-expanded="false" aria-controls="collapsefive">Return Policy ?</button></h5>
                                  </div>
                                  <div id="collapsefive" class="collapse" aria-labelledby="headingfive" data-parent="#accordion">
                                      <div class="card-body">
                                          Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                      <div class="tab-pane" id="review">
                          <div class="review-wrap">
                              <ul>
                                   @foreach ($reviews as $review)
                                   <li class="review-items">
                                    <div class="review-content">
                                        <h3><a href="#">{{ App\User::find($review->user_id)->name }}</a></h3>
                                        <span>{{ \Carbon\Carbon::parse($review->created_at)->format('jS M Y') }}</span>
                                        <p>{{ $review->review }}</p>
                                        <ul class="rating">
                                            @if($review->stars == 1)
                                            <li><i class="fa fa-star"></i></li>    
                                          @elseif($review->stars == 2)
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                          @elseif($review->stars == 3)
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                          @elseif($review->stars == 4)
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                          @elseif($review->stars == 5)
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                            <li><i class="fa fa-star"></i></li>
                                          @endif
                                        </ul>
                                    </div>
                                </li>
                                   @endforeach
                               
                              </ul>
                          </div>

                          @auth
                          @if(\App\Order_item::where('user_id', Auth::id())->where('product_id', $single_products->id)->whereNull('review')->exists())
                          <div class="add-review">
                              <h4>Add A Review</h4>
                              <div class="ratting-wrap">
                                  <table>
                                      <thead>
                                          <tr>
                                              <th>task</th>
                                              <th>1 Star</th>
                                              <th>2 Star</th>
                                              <th>3 Star</th>
                                              <th>4 Star</th>
                                              <th>5 Star</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                          <tr>
                                              <td>How Many Stars?</td>
                                              <td>
                                                <form action="{{ route('add.review') }}" method="post">
                                                    @csrf
                                                    <input name="product_id" type="hidden" value="{{ $single_products->id }}">
                                                    <input type="radio" name="stars" value="1" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="2" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="3" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="4" />
                                                </td>
                                                <td>
                                                    <input type="radio" name="stars" value="5" />
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 col-12">
                                      <h4>Name:</h4>
                                      <input type="text" value={{ Auth::user()->name }} />
                                    </div>
                                  <div class="col-md-6 col-12">
                                      <h4>Email:</h4>
                                      <input type="email" value="{{ Auth::user()->email }}" />
                                    </div>
                                    <div class="col-12">
                                        <h4>Your Review:</h4>
                                        <textarea name="review" id="massage" cols="30" rows="10" placeholder="Your review here..."></textarea>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn-style">Submit</button>
                                    </form>
                                  </div>
                              </div>
                          </div>
                          @else
                           <h5>Only Customers who bought the product can review the items. Or you may have already reviewed the item</h5>
                          @endif

                          @else 
                            Please <a href="{{ url('/login')}}">Login</a> to review this product
                          @endauth

                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- single-product-area end-->
  <!-- featured-product-area start -->
  <div class="featured-product-area">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <div class="section-title text-left">
                      <h2>Related Product</h2>
                  </div>
              </div>
          </div>
          <div class="row">
            @foreach ($related_products as $related)
              <div class="col-lg-3 col-sm-6 col-12">
                  <div class="featured-product-wrap">
                      <div class="featured-product-img">
                          <img src="{{ asset('uploads/products') }}/{{ $related->product_thumbnail_image }}" alt="">
                      </div>
                      <div class="featured-product-content">
                          <div class="row">
                              <div class="col-7">
                                  <h3><a href="{{ route('product.show', $related->product_slug) }}">{{ $related->product_name }}</a></h3>
                                  <p>${{ $related->product_price }}</p>
                              </div>
                              <div class="col-5 text-right">
                                  <ul>
                                      <li><a href="cart.html"><i class="fa fa-shopping-cart"></i></a></li>
                                      <li><a href="cart.html"><i class="fa fa-heart"></i></a></li>
                                  </ul>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
            @endforeach
          </div>
      </div>
  </div>
  <!-- featured-product-area end -->
@endsection
