@include('Shoping_Store.include.header')
@php
$product_id = Request::segment(2);
$product_info = DB::table('products')
->where('products.id', $product_id)
->first();


// dd($product_info)
@endphp
<div class="services-breadcrumb">
    <div class="agile_inner_breadcrumb">
        <div class="container">
            <ul class="w3_short">
                <li>
                    <a href="{{url('/shoping')}}">Home</a>
                    <i>|</i>
                </li>
                <li>{{$product_info->title}}</li>
            </ul>
        </div>
    </div>
</div>
<div class="banner-bootom-w3-agileits py-5">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        {{-- <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>S</span>ingle
            <span>P</span>age</h3>
        <!-- //tittle heading --> --}}
   
                <div class="row">
                    <div class="col-lg-5 col-md-8 single-right-left ">
                        <div class="grid images_3_of_2">
                            <div class="flexslider">
                                <ul class="slides">
                                    <li data-thumb="{{asset('product_image/' . $product_info->main_image)}}">
                                        <div class="thumb-image">
                                            <img src="{{asset('product_image/' . $product_info->main_image)}}" data-imagezoom="true" class="img-fluid" alt=""> </div>
                                    </li>
                                    <li data-thumb="{{asset('product_image/' . $product_info->img1)}}">
                                        <div class="thumb-image">
                                            <img src="{{asset('product_image/' . $product_info->img1)}}" data-imagezoom="true" class="img-fluid" alt=""> </div>
                                    </li>
                                    <li data-thumb="{{asset('product_image/' . $product_info->img2)}}">
                                        <div class="thumb-image">
                                            <img src="{{asset('product_image/' . $product_info->img2)}}" data-imagezoom="true" class="img-fluid" alt=""> </div>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
            <div class="col-lg-7 single-right-left simpleCart_shelfItem">
                    <h3 class="mb-3">{{$product_info->title}}</h3>
                    <p class="mb-3">
                    <span class="item_price">₹{{$product_info->market_price}}</span>
                    {{-- <del class="mx-2 font-weight-light">$250.00</del> --}}
                    {{-- <label>Free delivery</label> --}}
                </p>
                <div class="single-infoagile">
                    <ul>
                            <li class="mb-3">
                            Cash on Delivery Eligible.
                        </li>
                        <li class="mb-3">
                            Shipping Speed to Delivery.
                        </li>
                        <li class="mb-3">
                            EMI starts at $958.
                        </li>
                        <li class="mb-3">
                            3 offers from
                            <span class="item_price">₹{{$product_info->market_price}}</span>
                        </li>
                    </ul>
                </div>
                <div class="product-single-w3l">
                        {{-- <p class="my-3">
                                <i class="far fa-hand-point-right mr-2"></i>
                        Free standard installation within
                        <label>48 hours</label> of delivery</p>
                    <ul>
                            <li class="mb-1">
                            Frost Free Double Door: Auto defrost to stop ice-build up
                        </li>
                        <li class="mb-1">
                            Capacity 260 L: Suitable for families with 2 to 3 members
                        </li>
                        <li class="mb-1">
                            Energy Rating: 3 Star
                        </li>
                        <li class="mb-1">
                            Warranty: 1 year warranty on product and 10 years warranty on compressor
                        </li>
                        <li class="mb-1">
                            Shelf Type: Toughened Glass to withstand the weight of heaviest vessels
                        </li>
                        <li class="mb-1">
                            Inverter Compressor: Energy efficient, less noise & more durable
                        </li>
                        <li class="mb-1">
                            Also included in the box: User manual, Warranty card
                        </li>
                    </ul>
                    <p class="my-sm-4 my-3">
                            <i class="fas fa-retweet mr-3"></i>Net banking & Credit/ Debit/ ATM card
                    </p> --}}
                    <p>
                        {!!$product_info->description!!}
                    </p>
                </div>
                <div class="occasion-cart">
                    @auth('web')
                                                    
                    {{-- {{url('/addcart')}} --}}
                    <a class="btn btn-primary btn-lg cart "  href="javascript:void(0)"
                    data-id="{{ $product_info->id }}"
                    data-user_id="{{Auth::guard('web')->user()->id}}"
                    data-price="{{$product_info->market_price}}"
                    data-quantity="1"
                        role="button">Add to cart </a>
                        
                  <a class="btn btn-danger btn-lg Buy" href="javascript:void(0)"
                        role="button">Buy Now </a>
                        @endauth
                        @guest('web')
                           
                    <a class="btn btn-primary btn-lg  " onclick="login()" href="javascript:void(0)"
                    role="button">Add to cart </a>
                    
              <a class="btn btn-danger btn-lg " onclick="login()" href="javascript:void(0)"
                    role="button">Buy Now </a>

                            
                        @endguest

                </div>

            </div>
        </div>
    </div>
</div>
@include('Shoping_Store.include.footer')
