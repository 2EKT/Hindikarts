@include('Shoping_Store.include.header')




<div class="checkout-left">
    <div class="address_form_agile mt-sm-5 mt-4">
        <h4 class="mb-sm-4 mb-3">Add a new Details</h4>
        <form action="payment.html" method="post" class="creditly-card-form agileinfo_form">
            <div class="creditly-wrapper wthree, w3_agileits_wrapper">
                <div class="information-wrapper">
                    <div class="first-row">
                        <div class="controls form-group">
                            <input class="billing-address-name form-control" type="text" name="name" placeholder="Full Name" required="">
                        </div>
                        <div class="w3_agileits_card_number_grids">
                            <div class="w3_agileits_card_number_grid_left form-group">
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Mobile Number" name="number" required="">
                                </div>
                            </div>
                            <div class="w3_agileits_card_number_grid_right form-group">
                                <div class="controls">
                                    <input type="text" class="form-control" placeholder="Landmark" name="landmark" required="">
                                </div>
                            </div>
                        </div>
                        <div class="controls form-group">
                            <input type="text" class="form-control" placeholder="Town/City" name="city" required="">
                        </div>
                        <div class="controls form-group">
                            <select class="option-w3ls">
                                <option>Select Address type</option>
                                <option>Office</option>
                                <option>Home</option>
                                <option>Commercial</option>

                            </select>
                        </div>
                    </div>
                    <button class="submit check_out btn">Delivery to this Address</button>
                </div>
            </div>
        </form>
        <div class="checkout-right-basket">
            <a href="payment.html">Buy Now
                <span class="far fa-hand-point-right"></span>
            </a>
        </div>
    </div>
</div>






@include('Shoping_Store.include.footer')
