@extends('layouts.master')
@section('title', 'Zonal Franchise')
@section('content')
    <section class="block-franchise">
        <div class="container">
            <div class="text-center">
                <h2>FRANCHISE MODEL</h2>
                <p>To provide best service to our merchants and customers or users we are offering Franchise in every city
                    in India. Every franchise partners will work for the develop their own area on commission basis. We are
                    looking for them as a Franchise Partners who have working ability and experience in this field. Every
                    Block Franchise has to start their business with minimum three Marketing Representative for his/her
                    area. All the Blocks will be controlled by the District Franchise partner, and 5-7 District will be
                    controlled by the Zonal Franchise Partners.</p>
                <h5 style="margin-top:10px;"><u>MARKETING REPRESENTATIVE :</u></h5>
                <p>Marketing Representative will be working under
                    Block Franchise Partner.</p>
            </div>
            <div class="row">


                <div class="col-md-6 user">
                    <h5> Requirements: </h5>
                    <ul>
                        <li>A bike with Driving License</li>
                        <li>An Android Mobile</li>
                        <li>Minimum 10th pass </li>
                        <li>Photo ID and Bank A/C </li>
                    </ul>
                    <h5 style="margin-top:10px;">Duties:</h5>
                    <ul>
                        <li>Register Merchant in hindkart application
                            from your Area. </li>
                        <li>Communicate with the merchant and help
                            them to use of the application.</li>
                        <li>Adversaries , Product Listing order
                            Collection and Monthly Subscriptions
                            Collections</li>
                        <li>Company Brochure, templates, PDF, QR Codes provide to merchant .</li>
                        <li>Reporting to block franchise regularly and follow the Company Guidelines Properly.</li>
                    </ul>
                </div>
                <div class="col-md-6 user drop">
                    <h5><b>Investment:</b> <span> No investment Required.</span></h5>
                    <h5><b>Registration : </b> <span> Rs. 100 + GST = 118/-</span></h5>
                    <h5><b>Monthly Subscriptions : </b> <span> Rs. 399+GST=471/-</span></h5>
                    <h5><b>Commission : </b> <span> Below 50k 25% of net Collection 50k or above 30%.</span></h5>
                    <h5><b>Earning Possibility :</b><span> 25k – 60k</span></h5>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="heading-box" style="margin-top:50px;">
                        <h2> ZONAL FRANCHISE</h2>
                    </div>
                    <h5 style="margin-top:10px;margin-bottom:10px;">Requirements: </h5>
                    <ul>
                        <li>An Office (as per Requirement)</li>
                        <li> A Desktop/Laptop with Printer</li>
                        <li> Minimum 12 th Pass</li>
                        <li>Basic computer knowledge</li>
                        <li> Photo ID and Bank A/C</li>
                        <li> 2 year experience in this field</li>
                    </ul>
                    <h5 style="margin-top:10px;margin-bottom:10px;">Duties and Responsibility: </h5>
                    <ul>
                        <li>Register 5-7 District Franchise in your Zone,</li>
                        <li> Communicate with the District and Block to help them Recruit their Block franchise and
                            Marketing Representative,</li>
                        <li> Control, motivate and track your District, Blocks, employees and collect reports regularly
                            from district franchises.</li>
                        <li> Take an necessary action against the Franchise, Merchant and MR if any of them involve in
                            illegal activities or against the company rules.</li>
                        <li> Check COD collection amount properly send or not to company from your Zone, if not collect
                            then you have to take necessary action to collect due COD amount through your network.</li>
                        <li> All the Merchants, Delivery Boys, Employees, Blocks are indirectly and District Franchise
                            directly connecting with you.</li>
                        <li> Collect Monthly Subscriptions through your network,</li>
                        <li> Reporting to State franchise or Company regularly and follow the Company Guidelines
                            properly.</li>
                    </ul>
                    <h5 style="margin-top:10px;margin-bottom:10px;">Company Provide: </h5>
                    <ul>
                        <li>Business Platform</li>
                        <li> Business Area</li>
                        <li> Admin Portal</li>
                        <li> Marketing Support and training</li>
                        <li> Franchise Certificate</li>
                        <li> Visiting Card</li>
                        <li> T-Shirt</li>
                        <li> Digital Banner Design</li>
                        <li> Technical Support</li>
                        <li> Best Earning opportunity</li>
                    </ul>
                    <h6 style="margin-top:10px;"><b> Investment: </b><span>Registration Fees - 10000/- (inc GST / Non
                            Refundable) <br> Security Amount - 25000/-(Refundable*) </span></h6>
                    <h6 style="margin-top:5px;"><b> Monthly Subscriptions : </b><span> Rs 4999+GST= 5899/- </span></h6>
                    <h6 style="margin-top:5px;"><b> Earning : </b><span> Below 40L 2% of net Collection 40 or above 3%.
                        </span></h6>
                </div>
                <div class="col-md-6">
                    <div class="contact-form" style="margin-top: 100px;">
                        <h3 style="margin-top:20px;margin-bottom:10px;">Are You Interested? Feel free to submit the form!
                        </h3>
                        <form action="mail.php" method="POST" style="padding: 10px;background: #000;border-radius: 10px;">
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
            <h5 class="last">NB: Payout will be regularly and commission not fixed, it will increase or decrease without
                any prior notice.</h5>
        </div>

    </section>
@endsection
@section('scripts')
@endsection
