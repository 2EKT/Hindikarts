<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Auth;
use DB;
use Mail;

class HomeController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('frontend.index');
    }
    public function about_us()
    {
        return view('frontend.about');
        // echo "hit";
    }
    public function mission()
    {
        return view('frontend.mission');
    }
    public function services()
    {
        return view('frontend.services');
    }
    public function block_franchise()
    {
        return view('frontend.block_franchise');
    }
    public function district_franchise()
    {
        return view('frontend.district_franchise');
    }
    public function zonal_franchise()
    {
        return view('frontend.zonal_franchise');
    }
    public function career()
    {
        return view('frontend.careers');
    }

    public function thankyou()
    {
        return view('frontend.thankyou');
    }
    
    
    public function contact_us()
    {
        return view('frontend.contact');
    }
    public function submit_contact(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $message = $request->message;
        $subject="Enquiry Details";
        $msg="";
        $from_mail="papukhanra2@gmail.com";

        // Always set content-type when sending HTML email
					$headers = "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

					// More headers
					$headers .= 'From: <'.$from_mail.'>' . "\r\n";
					// $headers .= 'Cc: dibya@gmail.com' . "\r\n";
					// the message

                    

					$msg .= "<table style='border:1px solid #000;' border='1' cellspacing='0' cellpadding='10'>
					<tr>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Message</th>

					</tr>
					 <tr>
					 <td>$name</td>
					 <td>$email</td>
					 <td>$phone</td>
					 <td>$message</td>
					 </tr>

					</table>";

					if(mail("dibyasundarkhanra2@gmail.com",$subject,$msg,$headers)){
                        return redirect('/thankyou');
                    }
                    else
                    {
                        return redirect('/thankyou');
					}
    }
    
 

}