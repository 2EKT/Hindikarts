<?php

namespace App\Http\Controllers;

use App\Models\MerchantFranchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class MerchantFranchiseController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('merchant.index');
    }

    
    public function login(Request $request)
    {
        if(Auth::guard('merchant')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/merchant/dashboard');
        }
        else
        {
            return redirect('/merchant')->withInput()->with('error', 'Invalid Credentials');
        }
    }

    public function dashboard()
    {
        return view('merchant.dashboard');
    }
    public function profile()
    {
        return view('merchant.profile');
    }
    
     public function wallet()
    {
        return view('merchant.wallet');
    }

    public function payment()
    {
        return view('merchant.payment');
    }

    public function get_amount(Request $request)
    {
        $type = $request->type;
        $package_id = $request->package;
        $amount = 0;
        $merchant = DB::table('merchants')->where('id', Auth::guard('merchant')->user()->id)->first();
        $charge_data;

        if($type == 'advertise'){
            $charge_data = DB::table('advertisement_charges')->find($package_id);
            $amount = !empty($charge_data) ? $charge_data->amount : 0;
        }

        else if($type == 'registration'){
            $charge_data = DB::table('merchanttypes')->where('id', $merchant->merchant_type_id)->first();
            $amount = !empty($charge_data) ? $charge_data->registration_fee : 0;
        }

        else if($type == 'subscription'){
            $charge_data = DB::table('merchanttypes')->where('id', $merchant->merchant_type_id)->first();
            $amount = !empty($charge_data) ? $charge_data->monthly_fee : 0;
        }

        return $amount;
    }

    public function make_payment(Request $request)
    {
        $type = $request->type;
        $user_id = Auth::guard('merchant')->user()->id;
        $package_id = $request->advertisement_charge;
        $amount = $request->amount;
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $data = [
            'merchant_id' =>  $user_id,
            'type' => $type,
            'amount' => $amount,
            "package_name" => '',
            "package_details" => '',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $already_registered =  DB::table('merchant_payments')
                                ->where('merchant_id', $user_id)
                                ->where('type', 'registration')
                                ->exists();

        $already_registered_in_current_month =  DB::table('merchant_payments')
                                ->where('merchant_id', $user_id)
                                ->where('type', 'registration')
                                ->whereDate('created_at', '>=', $from_date)
                                ->whereDate('created_at', '<=', $to_date)
                                ->exists();                        

        $already_subscribed =  DB::table('merchant_payments')
                                ->where('merchant_id', $user_id)
                                ->where('type', 'subscription')
                                ->whereDate('created_at', '>=', $from_date)
                                ->whereDate('created_at', '<=', $to_date)
                                ->exists();    
                                
        $already_advertised =  DB::table('merchant_payments')
                                ->where('merchant_id', $user_id)
                                ->where('type', 'advertise')
                                ->whereDate('created_at', '>=', $from_date)
                                ->whereDate('created_at', '<=', $to_date)
                                ->exists();  
                                
        if(!$already_registered && $type != 'registration'){
            return redirect('/merchant/payments')->with('error', 'Please Send Registration Fee First');
        }
        else if($already_registered && $type == 'registration')  {
            return redirect('/merchant/payments')->with('error', 'Already Registered');
        }  
        else if($already_registered_in_current_month && $type == 'subscription')  {
            return redirect('/merchant/payments')->with('error', 'Please Subscribe For Next Month');
        } 
        
        else if($already_subscribed && $type == 'subscription')  {
            return redirect('/merchant/payments')->with('error', 'Already Subscribed');
        }

        else if($already_advertised && $type == 'advertise')  {
            return redirect('/merchant/payments')->with('error', 'Already Paid');
        }
                    
        if($amount > 0){
            if($type == 'advertise'){
                $charge_data = DB::table('advertisement_charges')->find($package_id);
                $data['package_name'] = $charge_data->package_name;
                $data['package_details'] = $charge_data->package_details;
            }
            DB::table('merchant_payments')->insert($data);
            return redirect('/merchant/payments')->with('success', 'Payment Successful');
        }
        else{
            return redirect('/merchant/payments')->with('error', 'Something Went Wrong');
        }
    }


    public function update_profile(Request $request)
    {
            $result=array(
                'name'=>$request->name,
                'email'=>$request->email
            );
               $status = DB::table('merchants')
                  ->where('id', Auth::guard('merchant')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/merchant/profile')->with('success', 'Updated Successfully');
            }
            else{
                return redirect('/merchant/profile')->with('error', 'Something Went Wrong');
            }
           
    }
    public function change_password()
    {
        return view('merchant.change_password');
    }

    public function update_password(Request $request)
    {
            $result=array(
                'password'=>Hash::make($request->password)
            );
               $status = DB::table('merchants')
                  ->where('id', Auth::guard('merchant')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/merchant/change-password')->with('success', 'Password Changed Successfully');
            }
            else{
                return redirect('/merchant/change-password')->with('error', 'Something Went Wrong');
            }
        
           
    }
    public function logout()
    {
        Auth::guard('merchant')->logout();
        return redirect('/merchant/');
    }
}