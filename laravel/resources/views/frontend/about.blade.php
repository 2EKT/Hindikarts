<!DOCTYPE html>
<html>
<head>
	<title>About Us || Hindkart</title>
	<link rel="icon" type="image/x-icon" href="{{  URL::asset('public/assets/images/favicon.png') }}">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1.0">
	<meta name="description" content="Hindkart Website & Application">
    <meta name="keywords" content="E-commerce">
    <meta name="author" content="Hindkart">
	@include("frontend.include.source")
</head>
<body>
	@include("frontend.include.header")
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
	<section class="about">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="heading-box">
						<h2>about us</h2>
					</div>
				</div>
			</div>
			<div class="row align-items-center">	
				<div class="col-md-6">
					<div class="about-right">
						<h3>welcome to <span>hindkart</span></h3>
						<p>Hindkart is a multi vendor platform where you can promotion, sell and purchase any product and service from your nearest marketplace.we help our clients solve their business challenges through digital transformation.The Company brings a wide range digital marketing solutions like e-commerce, Courier Service,Doorstep services,Transportation and medical service.We are committed to helping startups, medium and small business owner in digital marketing, leads provide and introduce their product services to the customer with product and delivery, payment</p>
						<ul class="mt-3 mt-md-5">
							<li><i class="fa fa-check"></i> We provide best delivery services.</li>
							<li><i class="fa fa-check"></i> Digital marketing solutions.</li>
							<li><i class="fa fa-check"></i> Transportation and medical service.</li>
							<li><i class="fa fa-check"></i> We are committed to helping startups.</li>
						</ul>
					</div>
				</div>
				<div class="col-md-6">
					<div class="about-left">
						<img src="{{  URL::asset('public/assets/images/about.jpg') }}" alt="" class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="choose-us">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="heading-box">
						<h2>why choose us</h2>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-lg-6 choose-img">
					<img src="{{  URL::asset('public/assets/images/choose.webp') }}" alt="" class="img-fluid">
				</div>
				<div class="col-lg-6">
					<div class="choose-content">
						<div class="sec-title"><h2>Why Love Us?</h2></div>
						<div class="font-16">
							We want to become number one services and solution provider in eastern region and subsequently in India by maintaining a profitable growth.
						</div>
						<div class="single-item">
							<div class="row align-items-center">
								<div class="col-3">
									<div class="icon-box"><i class="fa fa-truck-field"></i></div>
								</div>
								<div class="col-9">
									<div class="text">
										<h3>Quick Delivery</h3>
										<p>Fastest delivery service (within 60 minutes) .</p>
									</div>
								</div>
							</div>
						</div>
						<div class="single-item">
							<div class="row align-items-center">
								<div class="col-3">
									<div class="icon-box"><i class="fa fa-certificate"></i></div>
								</div>
								<div class="col-9">
									<div class="text">
										<h3>High Quality</h3>
										<p>we provide high quality product and services.</p>
									</div>
								</div>
							</div>
						</div>
						<div class="single-item">
							<div class="row align-items-center">
								<div class="col-3">
									<div class="icon-box"><i class="fa fa-indian-rupee-sign"></i></div>
								</div>
								<div class="col-9">
									<div class="text">
										<h3>Affordable Price</h3>
										<p>we provide all our services in affordable Price</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	@include("frontend.include.footer")
</body>
</html>