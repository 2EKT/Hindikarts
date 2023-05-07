<!DOCTYPE html>
<html>
<head>
	<title>Mission || Hindkart</title>
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
			
	<section class="mission mission-page">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="heading-box">
						<h2 class="text-white">our mission</h2>
					</div>
				</div>
			</div>
			<div class="row align-items-center">
				<div class="col-md-6">
					<div class="mission-left">
						<h3>our MISSION & VISION</h3>
						<p>Hindkart is the first company having a mission to deliver excellence in various diverse range
							of service like ecommerce, Transportation, Courier Service, Food & Grocery delivery,
							Doorstep service, Medical and Health care service to customer and also for the business
							merchant to growth their business. Our mission is to provide excellent, qualitative and
							prompt professional services all the time at a very competitive price with an aim to be the
							first preference amongst the entrepreneurs <span>our vision is to create a better daily life for the customers, merchants, franchise
							partners and the employees of the company</span></p>
						</div>
					</div>
					<div class="col-md-6">
						<div class="mission-right">
							<img src="{{  URL::asset('public/assets/images/mission1.jpg') }}" alt="" class="img-fluid">
						</div>
					</div>
				</div>
			</div>
		</section>
		@include("frontend.include.footer")
</body>
</html>