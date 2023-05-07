<!DOCTYPE html>
<html>
<head>
	<title>Home || Hindkart</title>
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
	<section class="banner">
		<div class="banner-slider">
			@php
			$banner_row=DB::table('websitebanners')->get();
			@endphp
			@foreach ($banner_row as $banner_details)
			@php
			$image_url=URL::asset('public/banner_image/'.$banner_details->image);
			@endphp
			<!--<div class="banner-item d-flex align-items-center">-->
			<div class="d-flex align-items-center" style="background-image: url('{{$image_url}}');height:400px;">
				<div class="banner-content">
					<h1>{{ $banner_details->title }}</h1>
					<p>{{ $banner_details->sub_title }}</p>
					{{-- <a href="about.php" title="" class="btn my-btn">read more</a> --}}
				</div>
			</div>
			@endforeach
			
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
					<div class="about-left">
						<img src="{{  URL::asset('public/assets/images/about.jpg') }}" alt="" class="img-fluid">
					</div>
				</div>
				<div class="col-md-6">
					<div class="about-right">
						<h3>about our company</h3>
						<p>Hindkart is a multi vendor platform where you can promotion, sell and purchase any product and service from your nearest marketplace.we help our clients solve their business challenges through digital transformation.The Company brings a wide range digital marketing solutions like e-commerce, Courier Service,Doorstep services,Transportation and medical service.</p>
					</div>
					<div class="subscribe">
					    <h4>Download our app</h4>
						<img src="{{  URL::asset('public/assets/images/play-store.png') }}" style="height:50px;">
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="mission">
		<div class="container">
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
	<section class="service">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="heading-box">
						<h2>our services</h2>
						<p>Being a online service provider, we offer a very diverce range of services that cover the
                            startups and estebelished business owner growth their business and service to the customers. And also
                            fullfill the user requirments to get there product, food, medicine or doorstape service at one place.
                        </p>
					</div>
				</div>
			</div>
			<div class="row justify-content-center">
				@php
			$service_row=DB::table('services')->get();
			@endphp
			@foreach ($service_row as $service_details)
			<div class="col-lg-4 col-md-6">
				<div class="service-box">
					<div class="service-content">
						<img src="{{ URL::asset('public/service_image/'.$service_details->image) }}" alt="" class="img-fluid">
						<span>{{$loop->iteration }}</span>
						<h3>{{ $service_details->service }}</h3>
						<p>{{ $service_details->description }}</p>
						<a href="{{ URL('/services') }}" title="" class="btn my-btn">read more</a>
					</div>
				</div>
			</div>
			@endforeach
				
				
			</div>
			</div>
		</div>
	</section>
	<section class="faq">
		    <div class="container">
				<div class="row">
					<div class="col-12">
						<div class="heading-box">
							<h2>Frequently Asked Question</h2>
						</div>
					</div>
				</div>
				<div class="row justify-content-center">
					<div class="col-lg-8 col-md-8">
						<div class="faq-inner">
							<div class="accordion" id="accordionExample">
								  @php
                                    $row=DB::table('frequent_questions')->get();
								  @endphp
                                  @foreach ($row as $key => $value)
								     @if($key > 0)
										   <div class="card">
												<div class="card-header" id="{{'heading'.$key}}">
													<h2 class="mb-0">
														<button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="{{'#collapse'.$key}}" aria-expanded="false" aria-controls="{{'collapse'.$key}}">
														<i class="fa-solid fa-plus"></i> {{$value->question}} 
														</button>
													</h2>
												</div>

												<div id="{{'collapse'.$key}}" class="collapse" aria-labelledby="{{'heading'.$key}}" data-parent="#accordionExample" style="">
													<div class="card-body">
													{{$value->answer}} 
													</div>
												</div>
										    </div>
									 @else
										<div class="card">
											<div class="card-header" id="{{'heading'.$key}}">
												<h2 class="mb-0">
													<button class="btn btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="{{'#collapse'.$key}}" aria-expanded="false" aria-controls="{{'collapse'.$key}}">
														<i class="fa-solid fa-minus"></i> {{$value->question}} 
													</button>
												</h2>
											</div>

											<div id="{{'collapse'.$key}}" class="collapse show" aria-labelledby="{{'heading'.$key}}" data-parent="#accordionExample" style="">
												<div class="card-body">
												{{$value->answer}} 
												</div>
											</div>
										</div>
									 @endif
								  @endforeach
						    </div>
				        </div>
			        </div>
		        </div>
	       </div>
</section>
<section class="happy-cust">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-box">
					<h2>happy clients</h2>
				</div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-lg-3 col-md-6">
				<div class="count-box">
					<h2><span class="counter">869</span>+</h2>
					<span>Projects Complete</span>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="count-box">
					<h2><span class="counter">317</span>+</h2>
					<span>Happy Customer</span>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="count-box">
					<h2><span class="counter">98</span>%</h2>
					<span>Success Rate</span>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="count-box">
					<h2><span class="counter">56</span>+</h2>
					<span>Awards</span>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="clients-say">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-box">
					<h2>What Is clients say</h2>
				</div>
			</div>
		</div>
		<div class="client-slider">
			@php
			$client_row=DB::table('client_reviews')->get();
			@endphp
			@foreach ($client_row as $client_details)
			<div class="row align-items-center d-flex">
				<div class="col-md-2">
					<div class="client-img text-center">
						<img src="{{ URL::asset('public/banner_image/'.$client_details->image) }}" class="img-fluid d-block mx-auto">
					</div>
						<div class="client-info text-center">
							<h5>{{ $client_details->name }}</h5>
							<span>{{ $client_details->designation }}</span>
						</div>
				</div>
				<div class="col-md-10">
					<div class="client-box">
						<p>{{ $client_details->comment }}</p>
					</div>
				</div>
			</div>
			@endforeach
				
				
				
			</div>
	</div>
</section>


<section class="clients-say">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-box">
					<h2>Meet With Our Team</h2>
				</div>
			</div>
		</div>
		<div class="client-slider">
		    @php
			$team_members_row=DB::table('team_members')->get();
			@endphp
			@foreach ($team_members_row as $team_members_details)
				<div class="row align-items-center d-flex">
					<div class="col-md-12">
						<div class="client-img text-center">
							<img src="{{ URL::asset('public/banner_image/'.$team_members_details->image) }}" class="img-fluid d-block mx-auto">
						</div>
							<div class="client-info text-center">
								<h5>{{ $team_members_details->name }}</h5>
								<span style="margin-bottom:10px;">{{ $team_members_details->designation }}</span>
							</div>
					</div>
				</div>
			@endforeach

				
			</div>
	</div>
</section> 

<section class="contact">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-box">
					<h2>contact us</h2>
				</div>
			</div>
		</div>
		<div class="row mt-md-5 align-items-center">
			<div class="col-md-6">
				<div class="map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d29368.915441609326!2d88.74803636705165!3d23.056266007295413!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39f8cb11828b28fb%3A0x1a789fcb8a430b06!2sGopalnagar%2C%20West%20Bengal%20743262!5e0!3m2!1sen!2sin!4v1674361708721!5m2!1sen!2sin" style="border:0; width: 100%; height: 450px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
				</div>
			</div>
			<div class="col-md-6">
				<div class="contact-form">
					<form action="{{ URL('/submit_contact') }}" method="POST">
						@csrf
						<div class="form-group">
							<label>name *</label>
							<input type="text" name="name" class="form-control" required="">
						</div>
						<div class="form-group">
							<label>email *</label>
							<input type="email" name="email" class="form-control" required="">
						</div>
						<div class="form-group">
							<label>Phone No *</label>
							<input type="tel" name="phone" class="form-control"  pattern="[0-9]{3}[0-9]{3}[0-9]{4}" onkeypress="if(this.value.length==10) return false;"  required="">
						</div>
						<div class="form-group">
							<label>message *</label>
							<textarea class="form-control" name="message" required=""></textarea>
						</div>
						<button class="btn my-btn text-white mt-4">send message</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@include("frontend.include.footer")
</body>
</html>