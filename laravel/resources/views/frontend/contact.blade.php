<!DOCTYPE html>
<html>
<head>
	<title>Contact Us || Hindkart</title>
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