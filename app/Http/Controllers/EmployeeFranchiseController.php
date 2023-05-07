<?php

namespace App\Http\Controllers;

use App\Models\EmployeeFranchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class EmployeeFranchiseController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('employee.index');
    }
    
    public function wallet()
    {
        return view('employee.wallet');
    }


    
    public function login(Request $request)
    {
        // dd($request->all());
        if(Auth::guard('employee')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/employee/dashboard');
        }
        else
        {
            return redirect('/employee')->withInput()->with('error', 'Invalid Credentials');
        }
    }

    public function dashboard()
    {
        return view('employee.dashboard');
    }
    public function profile()
    {
        return view('employee.profile');
    }

    public function update_profile(Request $request)
    {
            $result=array(
                'name'=>$request->name,
                'email'=>$request->email
            );
               $status = DB::table('employees')
                  ->where('id', Auth::guard('employee')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/employee/profile')->with('success', 'Updated Successfully');
            }
            else{
                return redirect('/employee/profile')->with('error', 'Something Went Wrong');
            }
           
    }
    public function change_password()
    {
        return view('employee.change_password');
    }

    public function update_password(Request $request)
    {
            $result=array(
                'password'=>Hash::make($request->password)
            );
               $status = DB::table('employees')
                  ->where('id', Auth::guard('employee')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/employee/change-password')->with('success', 'Password Changed Successfully');
            }
            else{
                return redirect('/employee/change-password')->with('error', 'Something Went Wrong');
            }
        
           
    }
    public function logout()
    {
        Auth::guard('employee')->logout();
        return redirect('/employee/');
    }


    public function view_merchant()
    {
        return view('employee.merchant.view');
    }

    public function business_details()
    {
        return view('employee.business_details.view');
    }

    public function create_merchant()
    {
        return view('employee.merchant.create');
    }

    public function store_merchant(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
            'phone' => 'required|digits:10',
            'email'=> 'required|unique:merchants',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);

        
        $val=array(
            'zone_partner_id'=>Auth::guard('employee')->user()->zone_partner_id,
            'district_partner_id'=>Auth::guard('employee')->user()->district_partner_id,
            'block_partner_id'=>Auth::guard('employee')->user()->block_partner_id,
            'employer_id'=>Auth::guard('employee')->user()->id,
            'merchant_type_id'=> $request->merchant_type_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($request->password),
            'image'=>$imageName,
            'wallet_balance' => 0,
            'active_status'=>'YES',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

       $affected = DB::table('merchants')->insert($val);
          
        if($affected==true)
        {
            return redirect('/employee/merchant/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/employee/merchant/create')->with('error', 'Something Went Wrong');
        }
    }

    public function edit_merchant($id){
        return view('employee.merchant.update',compact('id'));
    }

    public function update_merchant(Request $request){
        if($request->hasFile('image'))
        {
             $validated = $request->validate([
                 'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
             ]);
             $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
             request()->image->move(public_path('user_image'), $imageName);
            
             $previous_path=public_path().'/user_image/'.$request->previous_image;
             if($request->previous_image!='')
             {
                 if(File::exists($previous_path)){
                     unlink($previous_path);
                 }
             } 
        }
        else
        {
             $imageName=$request->previous_image;
        }

        if($request->password=='')
        {
            $new_password=$request->previous_password;
        }
        else
        {
            $new_password=Hash::make($request->password);
        }
        $val=array(
            'merchant_type_id'=> $request->merchant_type_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>$new_password,
            'image'=>$imageName,
            'active_status'=>$request->active_status
        );

        try{
            DB::table('merchants')->where('id',$request->id)->update($val);
            return redirect('/employee/merchant/edit/'.$request->id)->with('success', 'Inserted Successfully');
        }catch(\Exception $e){
            return redirect('/employee/merchant/edit/'.$request->id)->with('error', 'Something Went Wrong');
            //dd($e->getMessage());
        }
    }

    public function destroy_merchant(Request $request){
        $previous_path=public_path().'/user_image/'.$request->image;
        if($request->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 

        $deleted = DB::table('merchants')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/employee/merchant/')->with('success', 'Deleted Successfully');
        }
    }

    public function generateBusinessReport(Request $request){
          $employee_id = Auth::guard('employee')->user()->id;
          $from_date = $request->from_date;
          $to_date = $request->to_date;
          $service_charges = DB::table('service_charges')->find(1);
          $other_collection = !empty($service_charges) ? $service_charges->value : 0;  
          $other_collection = $this->twoDecimalPoint($other_collection);  

          $all_merchants = [];
          $query = DB::table('merchants')->where('employer_id',$employee_id);
          $merchants = $query->get();
          $total_merchant = $query->count();
          $total_collection_by_merchants = $this->twoDecimalPoint(0);
          $total_subscription_collection_by_merchants = $this->twoDecimalPoint(0);
          $total_advertise_collection_by_merchants = $this->twoDecimalPoint(0);
          $total_other_collection_by_merchants = $this->twoDecimalPoint(0);
          $all_total_collection_by_merchants = $this->twoDecimalPoint(0); 
          $total_gst_by_merchants = $this->twoDecimalPoint(0); 
          $total_net_collection_by_merchants = $this->twoDecimalPoint(0); 
          $total_earnings = $this->twoDecimalPoint(0);
          $bonus = $this->twoDecimalPoint(0);
          $wallet_balance = $this->twoDecimalPoint(0);
          $withdrawl_balance = $this->twoDecimalPoint(0);
          
          
          foreach($merchants as $merchant){
            $merchant_collection = DB::table('merchant_payments')
                                   ->where('merchant_id',$merchant->id)
                                   ->where('type', 'registration')
                                   ->whereDate('created_at', '>=', $from_date)
                                   ->whereDate('created_at', '<=', $to_date)
                                   ->sum('amount');

            $subscription_collection = DB::table('merchant_payments')
                                    ->where('merchant_id',$merchant->id)
                                    ->where('type', 'subscription')
                                    ->whereDate('created_at', '>=', $from_date)
                                    ->whereDate('created_at', '<=', $to_date)
                                    ->sum('amount');

            $adverise_collection = DB::table('merchant_payments')
                                    ->where('merchant_id',$merchant->id)
                                    ->where('type', 'advertise')
                                    ->whereDate('created_at', '>=', $from_date)
                                    ->whereDate('created_at', '<=', $to_date)
                                    ->sum('amount');  

            $total_collection = $merchant_collection + $subscription_collection + $adverise_collection + $other_collection;
            $gst = ($total_collection > 0) ? ($total_collection * 18) / 100 : 0;
            $net_collection = $total_collection - $gst;

            $total_collection_by_merchants += $merchant_collection;
            $total_subscription_collection_by_merchants += $subscription_collection;
            $total_advertise_collection_by_merchants += $adverise_collection;
            $total_other_collection_by_merchants += $other_collection;
            $all_total_collection_by_merchants += $total_collection;
            $total_gst_by_merchants += $gst;
            $total_net_collection_by_merchants += $net_collection;
                              
            $merchant_collection = $this->twoDecimalPoint($merchant_collection);
            $subscription_collection = $this->twoDecimalPoint($subscription_collection);
            $adverise_collection = $this->twoDecimalPoint($adverise_collection); 
            $total_collection = $this->twoDecimalPoint($total_collection); 
            $gst = $this->twoDecimalPoint($gst); 
            $net_collection = $this->twoDecimalPoint($net_collection); 
            $total_collection_by_merchants = $this->twoDecimalPoint($total_collection_by_merchants);
            $total_subscription_collection_by_merchants = $this->twoDecimalPoint($total_subscription_collection_by_merchants);
            $total_advertise_collection_by_merchants = $this->twoDecimalPoint($total_advertise_collection_by_merchants);
            $total_other_collection_by_merchants = $this->twoDecimalPoint($total_other_collection_by_merchants);
            $all_total_collection_by_merchants = $this->twoDecimalPoint($all_total_collection_by_merchants); 
            $total_gst_by_merchants = $this->twoDecimalPoint($total_gst_by_merchants); 
            $total_net_collection_by_merchants = $this->twoDecimalPoint($total_net_collection_by_merchants); 
            $wallet_balance = $this->twoDecimalPoint($merchant->wallet_balance);

            if($total_net_collection_by_merchants > 0){
                $total_earnings = $this->twoDecimalPoint(($total_net_collection_by_merchants * 25) / 100);
            }

            if($total_net_collection_by_merchants > 200000){
                $bonus = $this->twoDecimalPoint(($total_net_collection_by_merchants * 10) / 100);
            }

            $all_merchants[] = [
                "name" => $merchant->name,
                "merchant_collection" => $merchant_collection,
                "subscription_collection" => $subscription_collection,
                "adverise_collection" => $adverise_collection,
                "other_collection" => $other_collection,
                "total_collection" => $total_collection,
                "gst" => $gst,
                "net_collection" => $net_collection   
            ];
          }

          $data = [
              "merchants" => $all_merchants,
              "total_estimation" => (Object) [
                 "total_merchant" => $total_merchant,
                 "total_collection_by_merchants" => $total_collection_by_merchants,
                 'total_subscription_collection_by_merchants' => $total_subscription_collection_by_merchants,
                 'total_advertise_collection_by_merchants' => $total_advertise_collection_by_merchants,
                 'total_other_collection_by_merchants' => $total_other_collection_by_merchants,
                 'all_total_collection_by_merchants' => $all_total_collection_by_merchants,
                 'total_gst_by_merchants' => $total_gst_by_merchants,
                 'total_net_collection_by_merchants' => $total_net_collection_by_merchants,
              ],
              "total_earnings" => $total_earnings,
              "bonus" => $bonus,
              "wallet_balance" => $wallet_balance,
              "withdrawl_balance" => $withdrawl_balance,
          ];

          return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }

    public function twoDecimalPoint($number){
        return number_format((float)$number, 2, '.', '');
    }
    
}