<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
// sdasda
// SdA
// dSA
// D
// AD
// AD
// ADad
// sdA

use Mail;
use Session;
use App\Mail\DemoMail;

class AdminController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return view('admin.index');
        } else {
            return redirect('/admin/dashboard');
        }
    }
    public function business_details()
    {
        return view('admin.business_details.view');
    }
  public  function payment_record(Request $request)  {
    // dd($request->all());
       $amount= $request->amount;
        $result  = 'Update Sucessfully ';
        // $error  = '';
        if(DB::table('merchants')->where('email',$request->Email)->exists() ){
       $Db=   DB::table('merchants')->where('email',$request->Email)->first()->wallet_balance ;
       $sum = $Db+$amount;
       DB::table('merchants')->where('email',$request->Email)->update(['wallet_balance' => $sum]);
    //    $sum =;

        }elseif(DB::table('zonepartners')->where('email',$request->Email)->exists() ){
            $Db  =   DB::table('zonepartners')->where('email',$request->Email)->first()->wallet_balance;
            $sum = $Db+$amount;
            DB::table('zonepartners')->where('email',$request->Email)->update(['wallet_balance
            ' => $sum]);
        }elseif(DB::table('employees')->where('email',$request->Email)->exists() ){
            $Db = DB::table('employees')->where('email',$request->Email)->first()->wallet_balance;
            $sum = $Db+$amount;
            DB::table('employees')->where('email',$request->Email)->update(['wallet_balance'
            => $sum]);
        }elseif(DB::table('blockpartners')->where('email',$request->Email)->exists() ){
            $Db = DB::table('blockpartners')->where('email',$request->Email)->first()->wallet_balance;
            $sum = $Db+$amount;
            DB::table('blockpartners')->where('email',$request->Email)->update(['wallet_balance
            ' => $sum]);

        }elseif(DB::table('districtpartners')->where('email',$request->Email)->exists() ){
            $Db=DB::table('districtpartners')->where('email',$request->Email)->first()->wallet_balance;
            $sum = $Db+$amount;
            DB::table('districtpartners')->where('email',$request->Email)->update(['wallet_balance
            ' => $sum]);
        }
        else{
                       $result = "No user Found ";
                    // $result = [];
        }
        // dd($result);
        // return back()->with('data',compact('result'));
        return back()->with( ['result' => $result] );
        // return $result;
        

   }
    public function payment()
    {
         $result= '';
        return view('admin.Ofline_payment',compact('result'));
    }
    public function razorpay()
    {
        return view('admin.razorpay');
    }


    public function update_razorpay(Request $request)
    {
        $val = array(
            'key_id' => $request->key_id,
            'secret_id' => $request->secret_id
        );
        DB::table('razorpays')->where('id', '=', 1)->update($val);
        return redirect('/admin/razorpay')->with('success', 'Updated Successfully');
    }


    public function users()
    {
        return view('admin.users.view');
    }
    public function orders()
    {
        return view('admin.order');
    }
    public function profile()
    {
        return view('admin.profile');
    }
    public function update_profile(Request $request)
    {
        $result = array(
            'name' => $request->name,
            'email' => $request->email
        );
        $status = DB::table('admins')
            ->where('id', Auth::guard('admin')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/admin/profile')->with('success', 'Updated Successfully');
        } else {
            return redirect('/admin/profile')->with('error', 'Something Went Wrong');
        }
    }
    public function change_password()
    {
        return view('admin.change_password');
    }
    public function update_password(Request $request)
    {
        $result = array(
            'password' => Hash::make($request->password)
        );
        $status = DB::table('admins')
            ->where('id', Auth::guard('admin')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/admin/change-password')->with('success', 'Password Changed Successfully');
        } else {
            return redirect('/admin/change-password')->with('error', 'Something Went Wrong');
        }
    }
    public function company_details()
    {
        return view('admin.company_details');
    }
    public function update_company(Request $request)
    {
        $validatedData = $request->validate([
            'phone' => 'required|digits:10|numeric',
            'pincode' => 'required|digits:6|numeric'

        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('admin_image'), $imageName);

            $previous_path = public_path() . '/admin_image/' . $request->previous_image;
            if ($request->previous_image != '') {
                if (File::exists($previous_path)) {
                    unlink($previous_path);
                }
            }
        } else {
            $imageName = $request->previous_image;
        }
        $result = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'house_no' => $request->house_no,
            'area' => $request->area,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'image' => $imageName,
            'gst_no' => $request->gst_no,
            'pan_no' => $request->pan_no,
            'licence_no' => $request->licence_no
        );
        $status = DB::table('company_details')
            ->where('admin_id', Auth::guard('user')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/admin/company-details')->with('success', 'Updated Successfully');
        } else {
            return redirect('/admin/company-details')->withInput()->with('error', 'Something Went Wrong');
        }
    }

    public function admin_login(Request $request)
    {


        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/admin')->withInput()->with('error', 'Invalid Credentials');
        }
    }
    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function edit_users($id)
    {
        $user_result = DB::table('users')->where('id', $id)->first();
        return view('admin.users.update', compact('user_result'));
    }
    public function update_user(Request $request)
    {
        $result = array(
            'active_status' => $request->active_status
        );
        $status = DB::table('users')->where('id', $request->user_id)->update($result);
        return redirect('/admin/edit-users/' . $request->user_id)->with('success', 'Updated Successfully');
    }
    public function delete_user(Request $request)
    {
        $status = DB::table('users')->where('id', $request->user_id)->delete();
        return redirect('/admin/users')->with('success', 'Deleted Successfully');
    }
    public function admin_logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin/');
    }
    public function generateBusinessReport(Request $request)
    {

        // exit();
        $admin_id = Auth::guard('admin')->user()->id;
        // exit();
        //$admin_id = 2;
        // $employee_id = 
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $service_charges = DB::table('service_charges')->find(1);
        // $other_collection = !empty($service_charges) ? $service_charges->value : 0;
        $other_collection = 0;
        $other_collection = $this->twoDecimalPoint($other_collection);

        $all_Empolyees = [];
        // $employee= 
        // $query = DB::table('employees')->where('block_partner_id',$admin_id);
        $query = DB::table('zonepartners');

        $Empolyees = $query->get();
        $total_block = $query->count();


        // $total_collection_by_merchants = $this->twoDecimalPoint(0);
        // $total_collection_by_EMPLOYEE_COM  = $this->twoDecimalPoint(0);
        // $total_subscription_collection_by_merchants = $this->twoDecimalPoint(0);
        // $total_advertise_collection_by_merchants = $this->twoDecimalPoint(0);
        // $total_other_collection_by_merchants = $this->twoDecimalPoint(0);
        // $all_total_collection_by_merchants = $this->twoDecimalPoint(0);
        // $total_gst_by_merchants = $this->twoDecimalPoint(0);
        // $total_net_collection_by_merchants = $this->twoDecimalPoint(0);
        $total_earnings = $this->twoDecimalPoint(0);
        $bonus = $this->twoDecimalPoint(0);
        $wallet_balance = $this->twoDecimalPoint(0);
        $withdrawl_balance = $this->twoDecimalPoint(0);
        // $merchant_collection=0;
        $total_Sum_Merchant_collection = 0;
        $total_Sum_subscription_collection = 0;
        $total_Sum_adverise_collection = 0;

        foreach ($Empolyees as $Empolyee) {
            $merchant_id = DB::table('merchants')->where('zone_partner_id', $Empolyee->id)->get();
            foreach ($merchant_id  as  $merchant_ids) {

                //   echo $merchant_ids->id ."<br>";
                $merchant_collection = DB::table('merchant_payments')
                    ->where('merchant_id',  $merchant_ids->id)
                    ->where('type', 'registration')
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');
                //  echo   " sum = $merchant_collection";
                $subscription_collection = DB::table('merchant_payments')
                    ->where('merchant_id',  $merchant_ids->id)
                    ->where('type', 'subscription')
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');

                $adverise_collection = DB::table('merchant_payments')
                    ->where('merchant_id',  $merchant_ids->id)
                    ->where('type', 'advertise')
                    ->whereDate('created_at', '>=', $from_date)
                    ->whereDate('created_at', '<=', $to_date)
                    ->sum('amount');

                $total_Sum_Merchant_collection = $total_Sum_Merchant_collection + $merchant_collection;
                $total_Sum_subscription_collection = $total_Sum_subscription_collection + $subscription_collection;
                $total_Sum_adverise_collection = $total_Sum_adverise_collection + $adverise_collection;

                // $total_collection = $merchant_collection +  $subscription_collection + $adverise_collection + $other_collection;
                $total_collection =  $total_Sum_Merchant_collection + $total_Sum_subscription_collection + $total_Sum_adverise_collection + $other_collection;

                // echo   " sum = $total_Sum_Merchant_collection";
                $gst = ($total_collection > 0) ? ($total_collection * 18) / 100 : 0;
                $net_collection = $total_collection - $gst;
                $EMPLOYEE_COM = ($net_collection  > 0) ? ($net_collection * 25) / 100 : 0;
                $Block_COM = ($net_collection  > 0) ? ($net_collection * 12) / 100 : 0;
                $Distric_COM = ($net_collection  > 0) ? ($net_collection * 5) / 100 : 0;
                $Zone_COM = ($net_collection  > 0) ? ($net_collection * 2) / 100 : 0;



                $EMPLOYEE_COM = $this->twoDecimalPoint($EMPLOYEE_COM);
                $Block_COM = $this->twoDecimalPoint($Block_COM);
                $Distric_COM = $this->twoDecimalPoint($Distric_COM);
                $Zone_COM = $this->twoDecimalPoint($Zone_COM);
                $total_Sum_Merchant_collection = $this->twoDecimalPoint($total_Sum_Merchant_collection);
                $total_Sum_subscription_collection = $this->twoDecimalPoint($total_Sum_subscription_collection);
                $total_Sum_adverise_collection = $this->twoDecimalPoint($total_Sum_adverise_collection);
                $total_collection = $this->twoDecimalPoint($total_collection);
                $gst = $this->twoDecimalPoint($gst);
                $net_collection = $this->twoDecimalPoint($net_collection);




                $wallet_balance = $this->twoDecimalPoint($Empolyee->wallet_balance);
            }
            //  echo $Empolyee->name;
            $all_Empolyees[] = [
                "name" => $Empolyee->name,
                "merchant_collection" => $total_Sum_Merchant_collection,
                "subscription_collection" =>  $total_Sum_subscription_collection,
                "adverise_collection" => $total_Sum_adverise_collection,
                "other_collection" => $other_collection,
                "total_collection" => $total_collection,
                "gst" => $gst,
                "net_collection" => $net_collection,
                "Employee_Com" => $EMPLOYEE_COM,
                "Block_Com" => $Block_COM,
                "Distric_Com" => $Distric_COM,
                "Zone_Com" => $Zone_COM,

            ];
            $total_Sum_Merchant_collection = 0;
            $total_Sum_subscription_collection = 0;
            $total_Sum_adverise_collection = 0;
        }

        $merchant_total = DB::table('merchants')->get();

        $total_merchant_Collection_sum = 0;
        $total_Collection_sub = 0;
        $total_advertize = 0;
        $total_collection_Grand = 0;
        $Grand_gsts = 0;
        $Grand_net_collection = 0;
        // $G_EMPLOYEE_COMs = 0;

        $Total_other_collection = 0;
        foreach ($merchant_total  as $tables) {

            $merchant_collection_Total = DB::table('merchant_payments')
                ->where('merchant_id', $tables->id)
                ->where('type', 'registration')
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)
                ->sum('amount');

            $merchant_collection_Sub = DB::table('merchant_payments')
                ->where('merchant_id', $tables->id)
                ->where('type', 'subscription')
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)
                ->sum('amount');
            $adverise_collection_block_total = DB::table('merchant_payments')
                ->where('merchant_id',  $tables->id)
                ->where('type', 'advertise')
                ->whereDate('created_at', '>=', $from_date)
                ->whereDate('created_at', '<=', $to_date)
                ->sum('amount');

            // dd($merchant);
            // $merchant_collection +=  $merchant_collection + 0;
            $total_merchant_Collection_sum = $total_merchant_Collection_sum +  $merchant_collection_Total;
            $total_Collection_sub += $merchant_collection_Sub;
            $total_advertize += $adverise_collection_block_total;

            $total_collection_Grand =    $total_merchant_Collection_sum + $total_Collection_sub + $other_collection + $total_advertize;

            $Grand_gsts = ($total_collection_Grand > 0) ? ($total_collection_Grand * 18) / 100 : 0;
            $Grand_net_collection =   $total_collection_Grand - $Grand_gsts;
            $G_EMPLOYEE_COMs = ($Grand_net_collection > 0) ? ($Grand_net_collection * 25) / 100 : 0;
            $G_BLOCk_COM = ($Grand_net_collection > 0) ? ($Grand_net_collection * 12) / 100 : 0;
            $G_distric_COM = ($Grand_net_collection > 0) ? ($Grand_net_collection * 5) / 100 : 0;
            $GZoneCOM = ($Grand_net_collection > 0) ? ($Grand_net_collection * 2) / 100 : 0;
            $Total_other_collection +=  $other_collection;
            if ($Grand_net_collection > 0) {
                $total_earnings = $this->twoDecimalPoint(($Grand_net_collection * 25) / 100);
            }

            if ($Grand_net_collection > 200000) {
                $bonus = $this->twoDecimalPoint(($Grand_net_collection * 10) / 100);
            }

            $total_collection_Grand =  $this->twoDecimalPoint($total_collection_Grand);
            $total_Collection_sub =  $this->twoDecimalPoint($total_Collection_sub);
            $total_advertize =  $this->twoDecimalPoint($total_advertize);
            $Grand_gsts =  $this->twoDecimalPoint($Grand_gsts);
            $Grand_net_collection =  $this->twoDecimalPoint($Grand_net_collection);
            $total_merchant_Collection_sum =  $this->twoDecimalPoint($total_merchant_Collection_sum);
            $Total_other_collection =  $this->twoDecimalPoint($Total_other_collection);
            $G_EMPLOYEE_COMs =  $this->twoDecimalPoint($G_EMPLOYEE_COMs);
            $G_BLOCk_COM =  $this->twoDecimalPoint($G_BLOCk_COM);
            $G_distric_COM =  $this->twoDecimalPoint($G_distric_COM);
            $GZoneCOM =  $this->twoDecimalPoint($GZoneCOM);

            // echo $merchant_collection . "<br>";

            // echo($record);
        }

        $data = [
            "merchants" => $all_Empolyees,
            "total_estimation" => (object) [
                "total_block" =>  $total_block,
                "total_collection_by_merchants" => $total_merchant_Collection_sum,
                'total_subscription_collection_by_merchants' => $total_Collection_sub,
                'total_advertise_collection_by_merchants' =>  $total_advertize,
                'total_other_collection_by_merchants' => $Total_other_collection,
                'all_total_collection_by_merchants' =>  $total_collection_Grand,
                'total_gst_by_merchants' => $Grand_gsts,
                'total_collection_by_EMPLOYEE_COM' =>  $G_EMPLOYEE_COMs,
                'total_net_collection_by_merchants' =>  $Grand_net_collection,
                'total_collection_by_BlOCK_COM' => $G_BLOCk_COM,
                'total_collection_by_Distric_COM' => $G_distric_COM,
                'total_collection_by_Zone_COM' =>  $GZoneCOM,
            ],
            "total_earnings" => $total_earnings,
            "bonus" => $bonus,
            "wallet_balance" => $wallet_balance,
            "withdrawl_balance" => $withdrawl_balance,
        ];
        // $total_collection_by_EMPLOYEE_COM= 0;
        return response()->json(['status' => true, 'message' => 'Success', 'data' => $data,]);
    }

    public function twoDecimalPoint($number)
    {
        return number_format((float)$number, 2, '.', '');
    }
}
