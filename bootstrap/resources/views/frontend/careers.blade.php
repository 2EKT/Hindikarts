@extends('layouts.master')
@section('title', 'Career')
@section('content')
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
@endsection
@section('scripts')
@endsection
