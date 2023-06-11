@include('Shoping_Store.include.header')
<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>A</span>ccount
            <span>S</span>etting
        </h3>

@php
$user =Auth::guard('web')->user();
@endphp
        <div class="checkout-left">
            <div class="address_form_agile mt-sm-5 mt-4">
                <h4 class="mb-sm-4 mb-3">Edit your Details</h4>
                <form action="{{url('user/update/profile')}}" method="post" class="creditly-card-form agileinfo_form">
                    @csrf
                    <div class="creditly-wrapper wthree, w3_agileits_wrapper">
                        <div class="information-wrapper">
                            <div class="first-row">
                                <div class="controls form-group">
                                    <input class="billing-address-name form-control" type="text" name="name"
                                        placeholder="Full Name" value="{{$user->name}}" required="">
                                </div>
                                <div class="w3_agileits_card_number_grids">
                                    <div class="w3_agileits_card_number_grid_right form-group">
                                        <div class="controls">
                                            <input type="email" class="form-control" placeholder="Email"
                                                name="email" value="{{$user->email}}" required="">
                                        </div>
                                    </div>
                                    <div class="w3_agileits_card_number_grid_left form-group">
                                        <div class="controls">
                                            <input type="text" class="form-control" placeholder="Mobile Number"
                                                name="number" value="{{$user->phone}}" required="">
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="controls form-group">
                                    <input type="text" class="form-control" placeholder="Town/City" name="city"
                                        required="">
                                </div>  --}}
                                <div class="controls form-group">
                                    <input class="billing-address-name form-control" type="password" name="password"
                                        placeholder="New Password" >
                                </div>
                                <div class="controls form-group">
                                    <input class="billing-address-name form-control" type="password" name="Confrimpassword"
                                        placeholder="Confirm Password"  >
                                </div>
                           
                            </div>
                           <input type="submit" value="Update Profile"  class="btn btn-danger">
                        </div>
                    </div>
                </form>
               
            </div>
        </div>
    </div>
</div>
@include('Shoping_Store.include.footer')
