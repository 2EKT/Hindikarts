<!DOCTYPE html>
<html>
<head>
	<title>Career || Hindkart</title>
	<link rel="icon" type="image/x-icon" href="{{  URL::asset('public/assets/images/favicon.png')}}">
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
		<section class="contact">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="heading-box">
					<h2>Explore Career at Hindkart</h2>
				</div>
			</div>
		</div>
		<div class="row mt-md-5 align-items-center" style="justify-content: center;">
			<div class="col-md-6">
				<div class="contact-form">
					<form action="mail.php" method="POST">
						<div class="form-group">
							<label>name *</label>
							<input type="text" name="name" class="form-control name" required="">
						</div>
						<div class="form-group">
							<label>email *</label>
							<input type="email" name="email" class="form-control email" required="">
						</div>
						<div class="form-group">
							<label>mobile *</label>
							<input type="text" name="phone" class="form-control" max="9999999999" required="">
						</div>
						<div class="form-group">
							<label>message *</label>
							<textarea class="form-control" name="message" required=""></textarea>
						</div>
						<button class="btn my-btn text-white mt-4" type="submit" name="submit">send message</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>
@include("frontend.include.footer")
</body>
</html>