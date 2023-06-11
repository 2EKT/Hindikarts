@include('Shoping_Store.include.header')


<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>C</span>heck Out
        </h3>

@php
$user =Auth::guard('web')->user();
@endphp
        <div class="checkout-left">
            <div class="address_form_agile mt-sm-5 mt-4">
                <h4 class="mb-sm-4 mb-3">Confirm your Details</h4>
                <form action="payment.html" method="post" class="creditly-card-form agileinfo_form">
                    <div class="creditly-wrapper wthree, w3_agileits_wrapper">
                        @csrf
                        <div class="information-wrapper">
                            <div class="first-row">
                                <div class="controls form-group">
                                    <input class="billing-address-name form-control" type="text" name="name"
                                        placeholder="Full Name" value="{{$user->name}}" required="">
                                </div>
                                <div class="w3_agileits_card_number_grids">
                                    <div class="w3_agileits_card_number_grid_left form-group">
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Mobile Number"
                                                name="number" value="{{$user->phone}}" required="">
                                        </div>
                                    </div>
                                    <div class="w3_agileits_card_number_grid_right form-group">
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Landmark"
                                                name="landmark" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="controls form-group">
                                    <input type="text" class="form-control" placeholder="Town/City" name="city"
                                        required="">
                                </div> 
                                <div class="controls form-group">
                                    {{-- <input type="text" class="form-control" placeholder="Full Address" name="Address"
                                        required=""> --}}
                                        {{-- <div class="mb-3"> --}}
                                          {{-- <label for="address" class="form-label">Address</label> --}}
                                          <textarea class="form-control" name="address" id="address" placeholder="Full Address" rows="3"></textarea>
                                        {{-- </div> --}}
                                </div>
                                <div class="controls form-group">
                                    <select class="option-w3ls">
                                        <option>Select Payment type</option>
                                        <option>Cash on Delivery</option>
                                        <option>Card</option>
                                        {{-- <option></option>
                                        <option>Commercial</option> --}}

                                    </select>
                                </div>
                            </div>
                            {{-- <button class="submit check_out btn">Delivery to this Address</button> --}}
                        </div>
                    </div>
                </form>
                <div class="checkout-right-basket">
                    <a href="#" class="order">Buy Now
                        <span class="far fa-hand-point-right"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>





@include('Shoping_Store.include.footer')
