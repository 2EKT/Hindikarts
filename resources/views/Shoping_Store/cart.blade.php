@include('Shoping_Store.include.header')



<div class="privacy py-sm-5 py-4">
    <div class="container py-xl-4 py-lg-2">
        <!-- tittle heading -->
        <h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
            <span>A</span>dd To Cart
        </h3>
        <!-- //tittle heading -->

          <?php 
          
        //   Auth::guard('web')->user()->id
          $carts = DB::table('carts')->where('user_id',Auth::guard('web')->user()->id)->get(); 
          $Count = DB::table('carts')->where('user_id',Auth::guard('web')->user()->id)->count(); 
          $products = [];
          $Amount=0;
          $Sr=1;
          $id=1;
          $sr=1;
          $qty=1;
            foreach($carts as $cart){
                $datas = DB::table('products')->where('id',$cart->product_id)->get(); 
                // dd( $datas);
                // exit();
                foreach ($datas as $key => $value) {
                    // echo $value->id;
                    # code...
                     $products[]=[
                        'id' => $value->id,
                        'title' => $value->title,
                        'image' => $value->main_image,
                        'price' => $value->market_price,
                        'qnty' => $cart->qty,
                    ];
                }
                
            }
          ?>
        <div class="checkout-right">
            <h4 class="mb-sm-4 mb-3">Your shopping cart contains:
                <span> {{$Count}}  Products</span>
            </h4>
            <div class="table-responsive">
                <table class="timetable_sub">
                    <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Product</th>
                            <th>Quality</th>
                            <th>Product Name</th>

                            <th>Price</th>
                            <th>Remove</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $products as $data)
                      
                           @php
                            //    $qty++;
                               $Amount += $data['price'] * $data['qnty'] ;
                           @endphp 
                        <tr class="rem{{$Sr++}}">
                            <td class="invert">{{$id++}}</td>
                            <td class="invert-image">
                                <a href="single.html">
                                    <img src="{{asset('product_image/'.$data['image'])}}" alt="{{$data['image']}}" >
                                </a>
                            </td>
                            <td class="invert">
                                <div class="quantity">
                                    <div class="quantity-select">
                                        <div class="entry value-minus" data-id="{{$data['id']}}" >&nbsp;</div>
                                        <div class="entry value">
                                            <span>{{$data['qnty']}}</span>
                                        </div>
                                        <div class="entry value-plus "  data-price="{{$data['price']}}" data-id="{{$data['id']}}" >&nbsp;</div>
                                    </div>
                                </div>
                            </td>
                            <td class="invert">{{$data['title']}}</td>
                            <td class="invert " >₹{{$data['price']}}</td>
                            <td class="invert">
                                <div class="rem">
                                    <div class="close1 close" data-product_id="{{$data['id']}}" data-id="{{$sr++}}" ></div>
                                </div>
                            </td>
                        </tr>
                        
                        @endforeach
                        <tr>
                            <th>
                                Total Amount
                            </th>
                            <td colspan="6" class="Amount" data-value="{{$Amount}}">
                                ₹{{$Amount}}
                            </td>
                        </tr>
                        {{-- <tr class="rem2">
                            <td class="invert">2</td>
                            <td class="invert-image">
                                <a href="single2.html">
                                    <img src="images/a4.jpg" alt=" " class="img-responsive">
                                </a>
                            </td>
                            <td class="invert">
                                <div class="quantity">
                                    <div class="quantity-select">
                                        <div class="entry value-minus">&nbsp;</div>
                                        <div class="entry value">
                                            <span>1</span>
                                        </div>
                                        <div class="entry value-plus active">&nbsp;</div>
                                    </div>
                                </div>
                            </td>
                            <td class="invert">Cordless Trimmer</td>
                            <td class="invert">$1,999</td>
                            <td class="invert">
                                <div class="rem">
                                    <div class="close2"> </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="rem3">
                            <td class="invert">3</td>
                            <td class="invert-image">
                                <a href="single.html">
                                    <img src="images/a3.jpg" alt=" " class="img-responsive">
                                </a>
                            </td>
                            <td class="invert">
                                <div class="quantity">
                                    <div class="quantity-select">
                                        <div class="entry value-minus">&nbsp;</div>
                                        <div class="entry value">
                                            <span>1</span>
                                        </div>
                                        <div class="entry value-plus active">&nbsp;</div>
                                    </div>
                                </div>
                            </td>
                            <td class="invert">Nikon Camera</td>
                            <td class="invert">$37,490</td>
                            <td class="invert">
                                <div class="rem">
                                    <div class="close3"> </div>
                                </div>
                            </td>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
        <div class="checkout-left">
            <div class="address_form_agile mt-sm-5 mt-4">
                {{-- <h4 class="mb-sm-4 mb-3">Add a new Details</h4>
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
                </form> --}}
                <div class="checkout-right-basket">
                    @if($Amount>0)
                    <a href="{{url('/Checkout'.$Amount)}}">Go Check Out
                        <span class="far fa-hand-point-right"></span>
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('Shoping_Store.include.footer')
<script>
    $('.value-plus').on('click', function () {
        var divUpd = $(this).parent().find('.value'),
            newVal = parseInt(divUpd.text(), 10) + 1;
            let qyt =newVal;
        divUpd.text(newVal);
        // console.log(newVal);
          let total=0;
          let Grand_total=0;
          let  price =   $(this).data('price');
          total=   price*newVal;
          console.log(total);
          let Amount =   $('.Amount').data('value');
          
          
          Grand_total =total+Amount;
            console.log(Grand_total);
            // $('.Amount').text("₹"+Grand_total);
// console.log();
            $.ajax({
                type: "Get",
                url: "{{url('Qunantiy/update')}}",
                data: {
                    qty:qyt,
                    id:$(this).data('id'),
                },
                // dataType: "dataType",
                success: function (response) {
                    location.reload();
                    alert(response.ok)
                }
            });
    });

    $('.value-minus').on('click', function () {
        var divUpd = $(this).parent().find('.value'),
            newVal = parseInt(divUpd.text(), 10) - 1;
        if (newVal >= 1) divUpd.text(newVal);
        let qyt =newVal;
        $.ajax({
                type: "Get",
                url: "{{url('Qunantiy/update')}}",
                data: {
                    qty:qyt,
                    id:$(this).data('id'),
                },
                // dataType: "dataType",
                success: function (response) {
                    location.reload();
                    alert(response.ok)
                }
            });
    });
</script>
<!--quantity-->
<script>
    $(document).ready(function (c) {
        $('.close').on('click', function (c) {
           let id = $(this).data('id');
           let prid = $(this).data('product_id');
            $(`.rem${id}`).fadeOut('slow', function (c) {
                $(`.rem${id}`).remove();
                $.ajax({
                type: "Get",
                url: "{{url('product/del')}}",
                data: {
                    // qty:qyt,
                    id:prid,
                },
                // dataType: "dataType",
                success: function (response) {
                    location.reload();
                    alert(response.ok)
                }
            });
            });
        });
    });
</script>
{{-- <script>
    $(document).ready(function (c) {
        $('.close2').on('click', function (c) {
            $('.rem2').fadeOut('slow', function (c) {
                $('.rem2').remove();
            });
        });
    });
</script>
<script>
    $(document).ready(function (c) {
        $('.close3').on('click', function (c) {
            $('.rem3').fadeOut('slow', function (c) {
                $('.rem3').remove();
            });
        });
    });
</script> --}}
