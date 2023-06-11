<footer>
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-3 col-md-6">
						<div class="footer-box">
							<h3>get in touch</h3>
							<ul>
								<li><a href="mailto:info.myhindkart@gmail.com"><i class="fa-solid fa-envelope"></i> info.myhindkart@gmail.com</a></li>
								<li><a href="tel:+919802984964"><i class="fa-solid fa-phone"></i> +91-8902984964</a></li>
								<li><a href="javascript:void(0)"><i class="fa-solid fa-location-dot"></i>  BC Road, North 24 Parganas,West Bengal – 743262</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="footer-box">
							<h3>quick link</h3>
							<ul>
								<li><a href="{{ URL('/admin') }}">Admin Panel</a></li>
								<li><a href="{{ URL('/zonal-franchise') }}">Zonal Franchise Panel</a></li>
								<li><a href="{{ URL('/district-franchise') }}">District Franchise Panel</a></li>
								<li><a href="{{ URL('/block-franchise') }}">Block Franchise Panel</a></li>
								<li><a href="{{ URL('/employee') }}">Employee Panel</a></li>
								<li><a href="{{ URL('/merchant') }}">Merchant Panel</a></li>
							</ul>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="footer-box">
							<h3>follow</h3>
							<ul class="d-flex footer-social-icon">
								<li><a href="https://www.facebook.com/profile.php?id=100089570507212&mibextid=ZbWKwL"><i class="fab fa-facebook-f"></i></a></li>
								<!--<li><a href="javascript:void(0)"><i class="fab fa-twitter"></i></a></li>-->
								<li><a href="https://www.instagram.com/invites/contact/?i=inu3d0ucdlnu&utm_content=qio9iev"><i class="fab fa-instagram"></i></a></li>
								<!--<li><a href="javascript:void(0)"><i class="fab fa-whatsapp"></i></a></li>-->
								<!--<li><a href="javascript:void(0)"><i class="fab fa-github"></i></a></li>-->
							</ul>
							<div class="subscribe">
							    <h4>Download our app</h4>
								<img src="{{  asset('assets/images/play-store.png') }}" style="height:50px;">
							</div>
						</div>
					</div>
					<div class="col-lg-3 col-md-6">
						<div class="footer-box">
							<h3>download</h3>
							@php
								$documents=DB::table('brochures')->get();
							@endphp

							@if(count($documents) > 0)
							<ul>
							   @foreach ($documents as $document)
								<li><a target="_blank" href="{{asset('public/document/'.$document->file_name)}}">{{$document->name}}</a>
							   @endforeach	
							</ul>
							@endif
						</div>
					</div>
				</div>
			</div>
			<div class="copy-section">
				<p>Copyright © 2023. All right reserved | Design & Developed by <a href="https://royinformatics.com/" target="_blank">Roy Informatics Pvt Ltd</a></p>
			</div>
			<div class="top-arrow">
				<a href="#header"><i class="fa-solid fa-level-up-alt"></i></a>
			</div>
		</footer>
	<!-- js link -->
	<script src="{{ asset('assets/js/jquery-1.9.1.js')}}"></script>
	<script src="{{ asset('assets/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{ asset('assets/js/slick.min.js')}}"></script>
	<script src="{{ asset('assets/js/jquery.counterup.min.js')}}"></script>
	<script src="{{ asset('assets/js/waypoints.min.js')}}"></script>
	<script src="{{ asset('assets/js/main.js')}}"></script>