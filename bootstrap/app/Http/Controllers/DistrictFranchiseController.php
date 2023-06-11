<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Models\{Districtpartner, Payments};
use Illuminate\Support\Facades\Auth;
use Mail;


class DistrictFranchiseController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('district-franchise.index');
    }
    public function business_details()
    {
        return view('district-franchise.business_details.view');
    }

    public function wallet()
    {
        return view('district-franchise.wallet');
    }
    public function check()
    {
        //$today = Carbon::now();
        //   $from_date = date('2023-07-01');
        //            $to_date = date('2023-07-24');
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');

        $user_id =  Auth::guard('districtpartner')->user()->id;
        if (Payments::where('Distric_id', $user_id)->exists()) {
            try {
                if (Payments::where(['Distric_id' => $user_id, 'type' => 'Monthly'])->exists()) {
                    $Mothly =  DB::table('payments')
                        ->where('Distric_id', $user_id)
                        ->where('type', 'Monthly')
                        ->whereDate('created_at', '>=', $from_date)
                        ->whereDate('created_at', '<=', $to_date)
                        ->exists();
                    if ($Mothly) {
                        return response()->json(['oky' => 'oky']);
                    } else {
                        return response()->json(['error' => 'Your Monthly Fee Expire']);
                    }
                } else {
                    $Reg =  DB::table('payments')
                        ->where('Distric_id', $user_id)
                        ->where('type', 'registration')
                        ->whereDate('created_at', '>=', $from_date)
                        ->whereDate('created_at', '<=', $to_date)
                        ->exists();
                    if ($Reg) {
                        return   response()->json(['oky' => 'oky']);
                    } else {

                        return response()->json(['error' => 'Please Submit the Monthly Fee']);
                    }
                }
            } catch (\Throwable $th) {

                return   response()->json(['error' => 'Some Thing went Worng']);
            }
        } else {
            return response()->json(['error' => 'Please Pay  Register Fee First']);
        }
    }
    public function payments()
    {
        return view('district-franchise.payment');
    }
    public function get_amount(Request $request)
    {
        $type = $request->type;
        // $package_id = $request->package;
        $amount = 0;
        //  $districtpartners = DB::table('districtpartners')->where('id', Auth::guard('districtpartner')->user()->id)->first();
        $charge_data = '';
        if ($type == 'registration') {
            // monthlyfees
            $amount = DB::table('monthlyfees')->first()->district_reg;

            //    $amount  = 23;
        } elseif ($type == 'Monthly') {
            $amount = DB::table('monthlyfees')->first()->district_monthly;
        }
        // if ($type == 'advertise') {
        //     $charge_data = DB::table('advertisement_charges')->find($package_id);
        //     $amount = !empty($charge_data) ? $charge_data->amount : 0;
        // } else if ($type == 'registration') {
        //     $charge_data = DB::table('merchanttypes')->where('id', $merchant->merchant_type_id)->first();
        //     $amount = !empty($charge_data) ? $charge_data->registration_fee : 0;
        // } else if ($type == 'subscription') {
        //     $charge_data = DB::table('merchanttypes')->where('id', $merchant->merchant_type_id)->first();
        //     $amount = !empty($charge_data) ? $charge_data->monthly_fee : 0;
        // }

        return $amount;
    }
    public function make_payment(Request $request)
    {
        // echo "Hit";
        $type = $request->type;
        $user_id = Auth::guard('districtpartner')->user()->id;
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        $amount = 0;
        $amount = $request->amount;

        $data = [
            'Distric_id' =>  $user_id,
            'type' => $type,
            'amount' => $amount,

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $already_registered =  DB::table('payments')
            ->where('Distric_id', $user_id)
            ->where('type', 'registration')
            ->exists();
        $already_Monthly_in_current_month =  DB::table('payments')
            ->where('Distric_id', $user_id)
            ->where('type', 'Monthly')
            ->whereDate('created_at', '>=', $from_date)
            ->whereDate('created_at', '<=', $to_date)
            ->exists();
        $already_Monthly =  DB::table('payments')
            ->where('Distric_id', $user_id)
            ->where('type', 'Monthly')
            ->whereDate('created_at', '>=', $from_date)
            ->whereDate('created_at', '<=', $to_date)
            ->exists();
        if (!$already_registered && $type != 'registration') {
            return redirect('/district-franchise/payments')->with('error', 'Please Send Registration Fee First');
        } else if ($already_registered && $type == 'registration') {
            return redirect('/district-franchise/payments')->with('error', 'Already Registered');
        } else if ($already_Monthly_in_current_month && $type == 'Monthly') {
            return redirect('/district-franchise/payments')->with('error', 'Please Subscribe For Next Month');
        } else if ($already_Monthly && $type == 'Monthly') {
            return redirect('/district-franchise/payments')->with('error', 'Already Subscribed');
        }
        // DB::table('payments')->where('Distric_id',Auth::guard('districtpartner')->user()->id)->first()->type == 'Monthly' &&
        if ($amount > 0) {
            if (DB::table('payments')->where('Distric_id', Auth::guard('districtpartner')->user()->id)->exists() && DB::table('payments')->where(['Distric_id' => Auth::guard('districtpartner')->user()->id, 'type' => 'Monthly'])->exists() &&  DB::table('payments')->where(['Distric_id' => Auth::guard('districtpartner')->user()->id, 'type' => 'registration'])->exists()) {
                $update_Monthly = DB::table('payments')->where(['Distric_id' => Auth::guard('districtpartner')->user()->id, 'type' => 'Monthly'])->limit(1);
                //    $update_Monthly->created_at = date('Y-m-d H:i:s');
                //    $update_Monthly->updated_at = date('Y-m-d H:i:s');
                $wallet =   Auth::guard('districtpartner')->user()->wallet_balance;
                if ($wallet > 0  && $wallet >= $amount) {
                    $wallet = $wallet - $amount;

                    $bal = Districtpartner::where('id', Auth::guard('districtpartner')->user()->id)->first();
                    $bal->wallet_balance = $wallet;
                    $bal->update();
                    $update_Monthly->update(
                        array('created_at' => date('Y-m-d H:i:s'))
                    );
                    return redirect('/district-franchise/payments')->with('success', 'Payment Successful');
                } else {
                    return redirect('/district-franchise/payments')->with('error', 'Insufficient Balance');
                }
            } else {
                $wallet =   Auth::guard('districtpartner')->user()->wallet_balance;
                if ($wallet > 0  && $wallet >= $amount) {
                    $wallet = $wallet - $amount;

                    $bal = Districtpartner::where('id', Auth::guard('districtpartner')->user()->id)->first();
                    $bal->wallet_balance = $wallet;
                    $bal->update();
                    DB::table('payments')->insert($data);
                    return redirect('/district-franchise/payments')->with('success', 'Payment Successful');
                } else {
                    return redirect('/district-franchise/payments')->with('error', 'Insufficient Balance');
                }
            }
        } else {
            return redirect('/district-franchise/payments')->with('error', 'Something Went Wrong');
        }
    }
    public function login(Request $request)
    {
        if (Districtpartner::where('email', $request->email)->exists()) {
            $districtpartner = Districtpartner::where('email', $request->email)->first();
            if ($districtpartner->active_status == 'YES') {


                if (Auth::guard('districtpartner')->attempt(['email' => $request->email, 'password' => $request->password])) {
                    return redirect('/district-franchise/dashboard');
                } else {
                    return redirect('/district-franchise')->withInput()->with('error', 'Invalid Credentials');
                }
            } else {
                return redirect('/district-franchise')->withInput()->with('error', 'Your Account is not active.');
            }
        } else {
            return redirect('/district-franchise')->withInput()->with('error', 'Account does not Found');
        }
    }

    public function dashboard()
    {
        return view('district-franchise.dashboard');
    }
    public function profile()
    {
        return view('district-franchise.profile');
    }

    public function update_profile(Request $request)
    {
        $result = array(
            'name' => $request->name,
            'email' => $request->email
        );
        $status = DB::table('districtpartners')
            ->where('id', Auth::guard('districtpartner')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/district-franchise/profile')->with('success', 'Updated Successfully');
        } else {
            return redirect('/district-franchise/profile')->with('error', 'Something Went Wrong');
        }
    }
    public function change_password()
    {
        return view('district-franchise.change_password');
    }

    public function update_password(Request $request)
    {
        $result = array(
            'password' => Hash::make($request->password)
        );
        $status = DB::table('districtpartners')
            ->where('id', Auth::guard('districtpartner')->user()->id)
            ->update($result);

        if ($status == true) {
            return redirect('/district-franchise/change-password')->with('success', 'Password Changed Successfully');
        } else {
            return redirect('/district-franchise/change-password')->with('error', 'Something Went Wrong');
        }
    }
    public function logout()
    {
        Auth::guard('districtpartner')->logout();
        return redirect('/district-franchise/');
    }

    //District Partner Section
    public function view_blockpartner()
    {
        return view('district-franchise.blockpartner.view');
    }
    public function create_blockpartner()
    {
        $user_id = Auth::guard('districtpartner')->user()->id;
        //       $from_date = date('2023-06-01');
        //  $to_date = date('2023-06-24');
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-d');
        if (Payments::where('Distric_id', $user_id)->exists()) {
            try {
                if (Payments::where(['Distric_id' => $user_id, 'type' => 'Monthly'])->exists()) {


                    $Mothly =  DB::table('payments')
                        ->where('Distric_id', $user_id)
                        ->where('type', 'Monthly')
                        ->whereDate('created_at', '>=', $from_date)
                        ->whereDate('created_at', '<=', $to_date)
                        ->exists();
                    if ($Mothly) {
                        return view('district-franchise.blockpartner.create');
                    } else {
                        return redirect('/district-franchise/payments')->with('error', 'Your Monthly Fee Expire');
                    }
                } else {
                    $Reg =  DB::table('payments')
                        ->where('Distric_id', $user_id)
                        ->where('type', 'registration')
                        ->whereDate('created_at', '>=', $from_date)
                        ->whereDate('created_at', '<=', $to_date)
                        ->exists();
                    if ($Reg) {
                        return view('district-franchise.blockpartner.create');
                    } else {
                        return redirect('/district-franchise/payments')->with('error', 'Please Submit the Monthly Fee');
                    }
                }
            } catch (\Throwable $th) {
                return back()->with('error', 'Some Thing went Worng');
                //  $Reg =  DB::table('merchant_payments')
                //  ->where('Distric_id', $user_id)
                //  ->where('type', 'registration')
                //  ->whereDate('created_at', '>=', $from_date)
                //  ->whereDate('created_at', '<=', $to_date)
                //  ->exists();  

                //  if($Reg)  {

                //       return redirect('/merchant/payments')->with('error', 'Please Submit the Monthly Fee');

                //  } else{
                //     return view('merchant.product.view');
                //  }
            }
        } else {
            return redirect('/district-franchise/payments')->with('error', 'Please Pay  Register Fee First');
        }
    }

    public function store_blockpartner(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
            'phone' => 'required|digits:10',
            'email' => 'required|unique:blockpartners',
        ]);
        $imageName = date('Ymdhis') . '.' . request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);




        $val = array(
            'zone_partner_id' => Auth::guard('districtpartner')->user()->zone_partner_id,
            'district_partner_id' => Auth::guard('districtpartner')->user()->id,
            'block_id' => $request->block_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'image' => $imageName,
            'wallet_balance' => 0,
            'active_status' => 'YES'
        );

        $affected = DB::table('blockpartners')->insert($val);

        if ($affected == true) {
            return redirect('/district-franchise/blockpartner/create')->with('success', 'Inserted Successfully');
        } else {
            return redirect('/district-franchise/blockpartner/create')->with('error', 'Something Went Wrong');
        }
    }

    public function edit_blockpartner($id)
    {
        return view('district-franchise.blockpartner.update', compact('id'));
    }

    public function update_blockpartner(Request $request)
    {
        if ($request->hasFile('image')) {
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
            ]);
            $imageName = date('Ymdhis') . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path('user_image'), $imageName);

            $previous_path = public_path() . '/user_image/' . $request->previous_image;
            if ($request->previous_image != '') {
                if (File::exists($previous_path)) {
                    unlink($previous_path);
                }
            }
        } else {
            $imageName = $request->previous_image;
        }

        if ($request->password == '') {
            $new_password = $request->previous_password;
        } else {
            $new_password = $request->password;
        }
        $val = array(
            'block_id' => $request->block_id,
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($new_password),
            'image' => $imageName,
            'active_status' => $request->active_status
        );

        $affected = DB::table('blockpartners')->where('id', $request->id)->update($val);

        if ($affected == true) {
            return redirect('/district-franchise/blockpartner/edit/' . $request->id)->with('success', 'Inserted Successfully');
        } else {
            return redirect('/district-franchise/blockpartner/edit/' . $request->id)->with('error', 'Something Went Wrong');
        }
    }


    public function destroy_blockpartner(Request $request)
    {
        $previous_path = public_path() . '/user_image/' . $request->image;
        if ($request->image != '') {
            if (File::exists($previous_path)) {
                unlink($previous_path);
            }
        }

        $deleted = DB::table('blockpartners')->where('id', $request->id)->delete();
        if ($deleted == true) {
            return redirect('/district-franchise/blockpartner/')->with('success', 'Deleted Successfully');
        }
    }


    public function view_employee()
    {
        return view('district-franchise.employee.view');
    }
    public function view_merchant()
    {
        return view('district-franchise.merchant.view');
    }
    public function generateBusinessReport(Request $request)
    {

        // exit();
       $distric_id = Auth::guard('districtpartner')->user()->id;
        //$distric_id = 2;
        // $employee_id = 
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $service_charges = DB::table('service_charges')->find(1);
        // $other_collection = !empty($service_charges) ? $service_charges->value : 0;
        $other_collection = 0;
        $other_collection = $this->twoDecimalPoint($other_collection);

        $all_Empolyees = [];
        // $employee= 
        // $query = DB::table('employees')->where('block_partner_id',$distric_id);
        $query = DB::table('blockpartners')->where('district_partner_id',$distric_id);

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
            $merchant_id = DB::table('merchants')->where('block_partner_id', $Empolyee->id)->get();
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
                $Block_COM =($net_collection  > 0) ? ($net_collection * 12) / 100 : 0;



                $EMPLOYEE_COM = $this->twoDecimalPoint($EMPLOYEE_COM);
                $Block_COM = $this->twoDecimalPoint($Block_COM);
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

            ];
            $total_Sum_Merchant_collection = 0;
            $total_Sum_subscription_collection = 0;
            $total_Sum_adverise_collection = 0;
        }

        $merchant_total = DB::table('merchants')->where('district_partner_id',$distric_id)->get();

        $total_merchant_Collection_sum = 0;
        $total_Collection_sub = 0;
        $total_advertize = 0;
        $total_collection_Grand = 0;
        $Grand_gsts = 0;
        $Grand_net_collection = 0;
        // $G_EMPLOYEE_COMs = 0;

        $Total_other_collection =0;
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
        
            $G_BLOCk_COM = ($Grand_net_collection > 0) ? ($Grand_net_collection *12) / 100 : 0;
            $Total_other_collection +=  $other_collection ;
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
            $G_EMPLOYEE_COMs =  $this->twoDecimalPoint($G_EMPLOYEE_COMs);
            $total_merchant_Collection_sum =  $this->twoDecimalPoint($total_merchant_Collection_sum);
            $Total_other_collection =  $this->twoDecimalPoint($Total_other_collection);
            $G_BLOCk_COM =  $this->twoDecimalPoint($G_BLOCk_COM);

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
                'total_collection_by_BlOCK_COM' =>$G_BLOCk_COM,
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
