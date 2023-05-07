@extends('layouts.master')
@section('title', 'Thank You')
@section('content')
<section style="padding:150px 0;">
    <div class="thankyouimage text-center">
        <img src="{{ asset('assets/images/thanks.jpg') }}" alt="" class="img-fluid">
        <h4>We Will Get back To You Soon!</h4>
        <a href="{{url('/')}}" class="btn-info btn">Go Home</a>
    </div>
</section>
@endsection
@section('scripts')
@endsection
