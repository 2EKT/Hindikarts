@extends('layouts.master')
@section('title', 'Mission')
@section('content')
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
                            first preference amongst the entrepreneurs <span>our vision is to create a better daily life for
                                the customers, merchants, franchise
                                partners and the employees of the company</span></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mission-right">
                        <img src="{{ asset('assets/images/mission1.jpg') }}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
@endsection
