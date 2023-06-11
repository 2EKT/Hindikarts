<header id="header" class="">
		<div class="top-bar">
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4">
						<div class="top-left text-center">
							<a href="#" title=""><i class="fa fa-location-dot"></i> BC Road, North 24 Parganas, West Bengal.</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="top-bar-mid text-center">
							<a href="#"> <i class="fa fa-envelope"></i> Email: info.myhindkart@gmail.com</a>
						</div>
					</div>
					<div class="col-md-4">
						<div class="top-bar-right text-center">
							<a href="tel:+918902984964"> <i class="fa fa-phone"></i> +91-8902984964</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<nav class="navbar navbar-expand-lg">
			<!-- Brand -->
			<a class="navbar-brand" href="{{ URL('/') }}">
				<img src="{{  URL::asset('public/assets/images/logo.png') }}" alt="" class="img-fluid">
			</a>

			<!-- Toggler/collapsibe Button -->
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="fa fa-bars"></span>
			</button>

			<!-- Navbar links -->
			<div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
				<ul class="navbar-nav align-items-center">
					<li class="nav-item">
						<a class="nav-link" href="{{ URL('/') }}">Home</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ URL('/about-us') }}">about us</a>
					</li>
					
					<li class="nav-item">
						<a class="nav-link" href="{{ URL('/mission') }}">mission</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ URL('/services') }}">services</a>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="javascript:void(0)" id="navbardrop" data-toggle="dropdown">
							FRANCHISE MODEL
						</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="{{ URL('/block-franchise') }}">BLOCK FRANCHISE</a>
							<a class="dropdown-item" href="{{ URL('/district-franchise') }}">DISTRICT FRANCHISE</a>
							<a class="dropdown-item" href="{{ URL('/zonal-franchise') }}">ZONAL FRANCHISE</a>
						</div>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ URL('/career') }}">career Opportunity</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="{{ URL('/contact-us') }}">contact us</a>
					</li>
				</ul>
			</div>
		</nav>
</header>