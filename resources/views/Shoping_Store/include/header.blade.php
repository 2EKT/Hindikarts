<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Hindkart</title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <meta name="keywords" content="E-commerce">
    <meta name="author" content="Hindkart">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}
    <script>
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //Meta tag Keywords -->

    <!-- Custom-Files -->
    <link href="{{ asset('shoping_kart/css/bootstrap.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- Bootstrap css -->
    <link href="{{ asset('shoping_kart/css/style.css') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- Main css -->
    <link rel="stylesheet" href="{{ asset('shoping_kart/css/fontawesome-all.css') }}">
    <!-- Font-Awesome-Icons-CSS -->
    <link href="{{ asset('shoping_kart/css/popuo-box.css ') }}" rel="stylesheet" type="text/css" media="all" />
    <!-- pop-up-box -->
    <link href="{{ asset('shoping_kart/css/menu.css" rel="stylesheet" type="text/css') }}" media="all " />
    <!-- menu style -->
    <!-- //Custom-Files -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <!-- web fonts -->
    <link
        href="//fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i&amp;subset=latin-ext"
        rel="stylesheet">
    <link
        href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
        rel="stylesheet">
    <!-- //web fonts -->

</head>

<body>
    <!-- top-header -->
    <div class="agile-main-top">
        <div class="container-fluid">
            <div class="row main-top-w3l py-2">
                <div class="col-lg-4 header-most-top">
                    <p class="text-white text-lg-left text-center">
                        <!-- <i class="fas fa-shopping-cart ml-1"></i> -->
                        <i class="fas fa-map-marker"></i>
                        BC Road, North 24 Parganas, West Bengal.
                    </p>


                </div>
                <div class="col-lg-4 header-most-top">
                    <p class="text-white text-lg-left text-center">
                        <i class="fas fa-envelope ml-1"></i>
                        Email: info.myhindkart@gmail.com
                    </p>


                </div>

                <div class="col-lg-4 header-most-top">
                    <p class="text-white text-lg-left text-center">
                        <i class="fas fa-phone ml-1"></i>
                        <a href="tel:+918902984964" class="text-white"> +91-8902984964</a>
                    </p>


                </div>

                {{-- <div class="col-lg-4 header-most-top"> --}}
                {{-- <li class="text-center border-right text-white">
                     
                            <i class="fas fa-sign-in-alt mr-2"></i> Log In </a>
                    </li>
                    <li class="text-center text-white">
                        <a href="#" data-toggle="modal" data-target="#exampleModal2" class="text-white">
                            <i class="fas fa-sign-out-alt mr-2"></i>Register </a>
                    </li> --}}
                {{-- <p class="text-white text-lg-left text-center">
                        <i class="fas fa-phone ml-1"></i>
                        <a href="#" data-toggle="modal" data-target="#exampleModal" class="text-white">
                            <i class="fas fa-sign-in-alt mr-2"></i> Log In </a>
                    </p>


                </div> --}}


            </div>
        </div>
    </div>

    <!-- Button trigger modal(select-location) -->

    <!-- //shop locator (popup) -->

    <!-- modals -->
    <!-- log in -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center">Log In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/user/loging') }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label">Username</label>
                            <input type="email" class="form-control" placeholder=" " name="email" required="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Password</label>
                            <input type="password" class="form-control" placeholder=" " name="password" required="">
                        </div>
                        <div class="right-w3l">
                            <input type="submit" class="form-control" value="Log in">
                        </div>
                        <div class="sub-w3l">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                <label class="custom-control-label" for="customControlAutosizing">Remember me?</label>
                            </div>
                        </div>
                        <p class="text-center dont-do mt-3">Don't have an account?
                            <a href="#" data-toggle="modal" data-target="#exampleModal2">
                                Register Now</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- register -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('/user/register') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label">Your Name</label>
                            <input type="text" class="form-control" placeholder=" " name="name"
                                required="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Email</label>
                            <input type="email" class="form-control" placeholder=" " name="email"
                                required="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Phone</label>
                            <input type="tel" class="form-control" placeholder=" " name="phone"
                                required="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Image</label>
                            <input type="file" class="form-control" placeholder=" " name="image"
                                required="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Password</label>
                            <input type="password" class="form-control" placeholder=" " name="password"
                                id="password1" required="">
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Confirm Password</label>
                            <input type="password" class="form-control" placeholder=" " name="ConfirmPassword"
                                id="password2" required="">


                        </div>
                        <div class="right-w3l">
                            <input type="submit" class="form-control" value="Register">
                        </div>
                        {{-- <div class="sub-w3l">
                            <div class="custom-control custom-checkbox mr-sm-2">
                                <input type="checkbox" class="custom-control-input" id="customControlAutosizing2">
                                <label class="custom-control-label" for="customControlAutosizing2">I Accept to the
                                    Terms & Conditions</label>
                            </div> --}}
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
    <!-- //modal -->
    <!-- //top-header -->

    <!-- header-bottom-->
    <div class="header-bot">
        <div class="container">
            <div class="row header-bot_inner_wthreeinfo_header_mid">
                <!-- logo -->
                <div class="col-md-3 logo_agile">
                    {{-- <h1 class="text-center"> --}}
                    <a href="/shoping">
                        {{-- <img src="{{ asset('shoping_kart/images/logo2.png') }}" alt=" "
                                class="img-fluid">Hind Kart --}}
                        <img src="{{ asset('assets/images/logo.png') }}"
                            style="  border-radius: 8px;
                                 max-width: 50%;
                          height: auto;                                "
                            alt="Hindkart_logo">

                    </a>
                    {{-- </h1> --}}
                </div>
                <!-- //logo -->
                <!-- header-bot -->
                <div class="col-md-9 header mt-4 mb-md-0 mb-4">
                    <div class="row">
                        <!-- search -->
                        <div class="col-10 agileits_search">
                            <form class="form-inline" action="#" method="post">
                                <input class="form-control mr-sm-2" type="search" placeholder="Search"
                                    aria-label="Search" required>
                                <button class="btn my-2 my-sm-0" type="submit">Search</button>
                            </form>
                        </div>
                        <!-- //search -->
                        <!-- cart details -->
                        <div class="col-2 top_nav_right text-center mt-sm-0 mt-2">
                            <div class="wthreecartaits wthreecartaits2 cart cart box_1">
                                <form action="#" method="post" class="last">
                                    <input type="hidden" name="cmd" value="_cart">
                                    <input type="hidden" name="display" value="1">
                                    @auth('web')
                                        <button class="btn w3view-cart" type="button" name="submit" value="">
                                            <a href="{{ url('/addcart') }}"><i class="fas fa-cart-arrow-down"></i></a>

                                        </button>
                                    @endauth
                                    @guest('web')
                                        <button class="btn w3view-cart" onclick="login()" type="button" name="submit"
                                            value="">
                                            <a href="javascript:void(0)"><i class="fas fa-cart-arrow-down"></i></a>

                                        </button>
                                    @endguest
                                </form>
                            </div>
                        </div>
                        <!-- //cart details -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php
        $categories = DB::table('categories')
            ->limit(5)
            ->get();
        $category = DB::table('categories')->get();
    @endphp

    <div class="navbar-inner">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="agileits-navi_search">
                    <form action="#" method="post">
                        <select id="agileinfo-nav_search" name="agileinfo_search" class="border" required="">

                            <option value="">All Categories</option>
                            @foreach ($category as $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ml-auto text-center mr-xl-5">
                        <li class="nav-item active mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link" href="{{ url('/shoping') }}">Home
                                <span class="sr-only">(current)</span>
                            </a>
                        </li>
                        {{-- <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Electronics
                            </a>
                            <div class="dropdown-menu">
                                <div class="agile_inner_drop_nav_info p-4">
                                    <h5 class="mb-3">Mobiles, Computers</h5>
                                    <div class="row">
                                        <div class="col-sm-6 multi-gd-img">
                                            <ul class="multi-column-dropdown">
                                                <li>
                                                    <a href="product.html">All Mobile Phones</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">All Mobile Accessories</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Cases & Covers</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Screen Protectors</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Power Banks</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">All Certified Refurbished</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Tablets</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Wearable Devices</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Smart Home</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 multi-gd-img">
                                            <ul class="multi-column-dropdown">
                                                <li>
                                                    <a href="product.html">Laptops</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Drives & Storage</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Printers & Ink</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Networking Devices</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Computer Accessories</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Game Zone</a>
                                                </li>
                                                <li>
                                                    <a href="product.html">Software</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Appliances
                            </a>
                            <div class="dropdown-menu">
                                <div class="agile_inner_drop_nav_info p-4">
                                    <h5 class="mb-3">TV, Appliances, Electronics</h5>
                                    <div class="row">
                                        <div class="col-sm-6 multi-gd-img">
                                            <ul class="multi-column-dropdown">
                                                <li>
                                                    <a href="product2.html">Televisions</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Home Entertainment Systems</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Headphones</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Speakers</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">MP3, Media Players & Accessories</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Audio & Video Accessories</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">DSLR Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Camera Accessories</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 multi-gd-img">
                                            <ul class="multi-column-dropdown">
                                                <li>
                                                    <a href="product2.html">Musical Instruments</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Gaming Consoles</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">All Electronics</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Air Conditioners</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Refrigerators</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Washing Machines</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Kitchen & Home Appliances</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Heating & Cooling Appliances</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">All Appliances</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}

                        @foreach ($categories as $Value)
                            @php
                                $subcategories = DB::table('subcategories')
                                    ->where('cat_id', $Value->id)
                                    ->get();
                                
                            @endphp
                            <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
                                <a class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    {{ $Value->category }}

                                </a>
                                    <div class="dropdown-menu">
                                @foreach ($subcategories as $subcategorie)
                                    @php
                                        $megacategories = DB::table('megacategories')
                                            ->where('subcat_id', $subcategorie->id)
                                            ->get();
                                        // echo   " <pre>" ;
                                        //         //  var_dump($subcategorie);
                                        //       echo    " </pre>" ;
                                    @endphp
                                        <div class="agile_inner_drop_nav_info p-4">
                                            {{-- <h5 class="mb-3">Categories</h5> --}}
                                            <h5 class="mb-3">{{ $subcategorie->subcategory }}</h5>
                                            {{-- <h5 class="mb-3">Mobiles, Computers</h5> --}}

                                            <div class="row">
                                                @foreach ($megacategories as $mega)
                                                    <div class="col-sm-6 multi-gd-img">
                                                        <ul class="multi-column-dropdown">

                                                            <li>
                                                                <a href="{{url('/Product/Show', $mega->id)}}"> {{ $mega->megacategory }} </a>
                                                            </li>

                                                        </ul>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                <div>
                            </li>
                        @endforeach
                        {{-- <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                Appliances
                            </a>
                            <div class="dropdown-menu">
                                <div class="agile_inner_drop_nav_info p-4">
                                    <h5 class="mb-3">TV, Appliances, Electronics</h5>
                                    <div class="row">
                                        <div class="col-sm-6 multi-gd-img">
                                            <ul class="multi-column-dropdown">
                                                <li>
                                                    <a href="product2.html">Televisions</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Home Entertainment Systems</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Headphones</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Speakers</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">MP3, Media Players & Accessories</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Audio & Video Accessories</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">DSLR Cameras</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Camera Accessories</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-6 multi-gd-img">
                                            <ul class="multi-column-dropdown">
                                                <li>
                                                    <a href="product2.html">Musical Instruments</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Gaming Consoles</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">All Electronics</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Air Conditioners</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Refrigerators</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Washing Machines</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Kitchen & Home Appliances</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">Heating & Cooling Appliances</a>
                                                </li>
                                                <li>
                                                    <a href="product2.html">All Appliances</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}

                        <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                            <a class="nav-link" href="{{ url('/about-us') }}">About Us</a>
                        </li>
                        @guest('web')
                            <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal"><i
                                        class="fas fa-sign-in-alt mr-2"></i> Log In
                                </a>


                            </li>

                            <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                                <a class="nav-link" href="#" data-toggle="modal" data-target="#exampleModal2">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Register </a>


                            </li>
                        @endguest
                        @auth('web')
                            {{-- <li class="nav-item mr-lg-2 mb-lg-0 mb-2">
                            <a  class="nav-link" href="/user/logout" >
								<i class="fas fa-sign-out-alt mr-2"></i>logout </a>
                            
								
                        </li>
                         --}}

                            <li class="nav-item dropdown mr-lg-2 mb-lg-0 mb-2">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    {{ Auth::guard('web')->user()->name }}
                                </a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="/user/logout">logout</a>
                                </div>
                            </li>
                            {{-- <li class="nav-item">
                            <a class="nav-link" href="contact.html">Contact Us</a>
                        </li>
                         <a class="dropdown-item" href="product2.html">Product 2</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="single.html">Single Product 1</a>
                                <a class="dropdown-item" href="single2.html">Single Product 2</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="checkout.html">Checkout Page</a>
                                <a class="dropdown-item" href="payment.html">Payment Page</a>
                    --}}
                        @endauth

                    </ul>


                </div>
            </nav>
        </div>
    </div>
