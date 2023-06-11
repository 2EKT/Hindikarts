@include('Shoping_Store.include.header')


<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
    <h3 class="heading-tittle text-center font-italic">Search Product </h3>
    <div class="row">
       @if (!count($DB) == 0)
           
      
        @foreach ($DB as $data)
            <div class="col-md-4 product-men mt-5">
                <div class="men-pro-item simpleCart_shelfItem">
                    <div class="men-thumb-item text-center">
                        <img src="{{ asset('product_image/' . $data->main_image) }}"
                           width="200" alt="">
                        <div class="men-cart-pro">
                            <div class="inner-men-cart-pro">
                                <a href="{{url('/product/'.$data->id)}}" class="link-product-add-cart">Quick
                                    View</a>
                            </div>
                        </div>
                    </div>


                    <div class="item-info-product text-center border-top mt-4">
                        <h4 class="pt-1">
                            <a href="{{url('/product/'.$data->id)}}">{{ $data->title }}</a>
                        </h4>
                        <div class="info-product-price my-2">
                            <span class="item_price">₹{{ $data->market_price }}</span><br>
                            <span>Discount {{ $data->discount_type }}</span>
                        </div>
                        {{-- <span class="product-new-top">New</span> --}}
                        {{-- <div
                            class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                            <form action="#" method="post">
                                <fieldset>
                                    <input type="hidden" name="cmd" value="_cart" />
                                    <input type="hidden" name="product_id"
                                        value="{{ $data->id }}" />
                                    <input type="hidden" name="merchant_id"
                                        value="{{ $data->merchant_id }}" />
                                    <input type="hidden" name="item_name"
                                        value="{{ $data->title }}" />
                                    <input type="hidden" name="amount"
                                        value="{{ $data->market_price }}" />
                                    <input type="hidden" name="discount_amount"
                                    value="1.00" />
                                    <input type="hidden" name="currency_code"
                                        value="USD" />
                                    <input type="hidden" name="return" value=" " />
                                    <input type="hidden" name="cancel_return"
                                        value=" " />
                                    <input type="submit" name="submit" value="Add to cart"
                                        class="button btn" />
                                </fieldset>
                            </form>
                        </div> --}}
                        @auth('web')
                            
                        {{-- {{url('/addcart')}} --}}
                        <a class="btn btn-primary btn-lg cart "  href="javascript:void(0)"
                        data-id="{{ $data->id }}"
                        data-user_id="{{Auth::guard('web')->user()->id}}"
                        data-price="{{$data->market_price}}"
                        data-quantity="1"
                            role="button">Add to cart </a>
                            
                      <a class="btn btn-danger btn-lg mt-3 " href="{{url('/Checkout/'.$data->market_price)}}"
                            role="button">Buy Now </a>
                            @endauth
                            @guest('web')
                               
                        <a class="btn btn-primary btn-lg  " onclick="login()" href="javascript:void(0)"
                        role="button">Add to cart </a>
                        
                  <a class="btn btn-danger btn-lg" onclick="login()" href="javascript:void(0)"
                        role="button">Buy Now </a>

                                
                            @endguest
                    </div>
                </div>
            </div>
        @endforeach
        @else
        <h5>
            No Result Found
        </h5>
        @endif
        {{-- <div class="col-md-4 product-men mt-5">
            <div class="men-pro-item simpleCart_shelfItem">
                <div class="men-thumb-item text-center">
                    <img src="{{ asset('shoping_kart/images/m2.jpg') }}" alt="">
                    <div class="men-cart-pro">
                        <div class="inner-men-cart-pro">
                            <a href="single.html" class="link-product-add-cart">Quick View</a>
                        </div>
                    </div>
                    <span class="product-new-top">New</span>

                </div>
                <div class="item-info-product text-center border-top mt-4">
                    <h4 class="pt-1">
                        <a href="single.html">OPPO A37f</a>
                    </h4>
                    <div class="info-product-price my-2">
                        <span class="item_price">$230.00</span>
                        <del>$250.00</del>
                    </div>
                    <div
                        class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                        <form action="#" method="post">
                            <fieldset>
                                <input type="hidden" name="cmd" value="_cart" />
                                <input type="hidden" name="add" value="1" />
                                <input type="hidden" name="business" value=" " />
                                <input type="hidden" name="item_name" value="OPPO A37f" />
                                <input type="hidden" name="amount" value="230.00" />
                                <input type="hidden" name="discount_amount"
                                    value="1.00" />
                                <input type="hidden" name="currency_code" value="USD" />
                                <input type="hidden" name="return" value=" " />
                                <input type="hidden" name="cancel_return" value=" " />
                                <input type="submit" name="submit" value="Add to cart"
                                    class="button btn" />
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4 product-men mt-5">
            <div class="men-pro-item simpleCart_shelfItem">
                <div class="men-thumb-item text-center">
                    <img src="{{ asset('shoping_kart/images/m3.jpg') }}" alt="">
                    <div class="men-cart-pro">
                        <div class="inner-men-cart-pro">
                            <a href="single.html" class="link-product-add-cart">Quick View</a>
                        </div>
                    </div>
                    <span class="product-new-top">New</span>

                </div>
                <div class="item-info-product text-center border-top mt-4">
                    <h4 class="pt-1">
                        <a href="single.html">Apple iPhone X</a>
                    </h4>
                    <div class="info-product-price my-2">
                        <span class="item_price">$280.00</span>
                        <del>$300.00</del>
                    </div>
                    <div
                        class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                        <form action="#" method="post">
                            <fieldset>
                                <input type="hidden" name="cmd" value="_cart" />
                                <input type="hidden" name="add" value="1" />
                                <input type="hidden" name="business" value=" " />
                                <input type="hidden" name="item_name"
                                    value="Apple iPhone X" />
                                <input type="hidden" name="amount" value="280.00" />
                                <input type="hidden" name="discount_amount"
                                    value="1.00" />
                                <input type="hidden" name="currency_code" value="USD" />
                                <input type="hidden" name="return" value=" " />
                                <input type="hidden" name="cancel_return" value=" " />
                                <input type="submit" name="submit" value="Add to cart"
                                    class="button btn" />
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@include('Shoping_Store.include.footer')
