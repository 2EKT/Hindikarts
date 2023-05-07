<?php
$url_segment = \Request::segment(1);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Hindkart || @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="Hindkart Website & Application">
    <meta name="keywords" content="E-commerce">
    <meta name="author" content="Hindkart">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick-theme.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <a href="https://wa.me/918902984964/?text=HeyThere! I saw your website and I’d like some more information about your services and offerings."
        class="float" target="_blank"><i class="bi bi-whatsapp"
            style="    background: green;
    padding: 5px 10px;
    border-radius: 50%;"></i></a>
    <a href="tel:918902984964" class="float2" target="_blank"><i class="bi bi-telephone-fill"
            style="background: #0066cc;
    padding: 5px 10px;
    border-radius: 50%;"></i></a>
</head>

<body>
	@if($url_segment == 'thankyou')
	@else
    @include('partial.header')
	@endif
    @if($url_segment == 'about-us')
    <section class="redirect-page">
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <div class="redirect-content">
                        <h3>about us</h3>
                        <ul class="d-flex">
                            <li><a href="#" title="">Home</a></li>
                            <li><i class="fa fa-chevron-right"></i></li>
                            <li>about us</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @elseif($url_segment == 'mission')
    <section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>our mission</h3>
						<ul class="d-flex">
							<li><a href="#" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>mission</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
    @elseif($url_segment == 'services')
    <section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>our services</h3>
						<ul class="d-flex">
							<li><a href="#" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>service</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
    @elseif($url_segment == 'career')
	<section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>Career</h3>
						<ul class="d-flex">
							<li><a href="index.php" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>Career</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
    @elseif($url_segment == 'contact-us')
    <section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>contact us</h3>
						<ul class="d-flex">
							<li><a href="index.php" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>contact us</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	@elseif($url_segment == 'block-franchise')
	<section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>block franchise</h3>
						<ul class="d-flex">
							<li><a href="#" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>block franchise</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	@elseif($url_segment == 'district-franchise')
	<section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>district franchise</h3>
						<ul class="d-flex">
							<li><a href="#" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>district franchise</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	@elseif($url_segment == 'zonal-franchise')
	<section class="redirect-page">
		<div class="container">
			<div class="row">
				<div class="col-8">
					<div class="redirect-content">
						<h3>our franchise</h3>
						<ul class="d-flex">
							<li><a href="#" title="">Home</a></li>
							<li><i class="fa fa-chevron-right"></i></li>
							<li>Zonal franchise</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
    @endif
    @yield('content')
    @include('partial.footer')
    @yield('scripts')
</body>

</html>
