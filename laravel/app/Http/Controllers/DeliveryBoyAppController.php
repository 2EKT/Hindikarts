<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\App\DeliveryBoy\PersonalInformationCollection;
use App\Http\Resources\Api\App\DeliveryBoy\ProfileCollection;
use App\Http\Resources\Api\App\DeliveryBoy\LoginCollection;
use App\Http\Resources\Api\App\DeliveryBoy\DashboardCollection;
use App\Http\Resources\Api\App\DeliveryBoy\TransactionCollection;
use App\Http\Resources\Api\App\DeliveryBoy\PersonalDocumentCollection;
use App\Http\Resources\Api\App\DeliveryBoy\WorkPreferenceCollection;
use App\Http\Resources\Api\App\DeliveryBoy\VehicleDetailsCollection;
use App\Http\Resources\Api\App\DeliveryBoy\BankDetailsCollection;
use Carbon\Carbon;
use Auth;
use Mail;
use Session;

class DeliveryBoyAppController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function deliveryBoyRegistration(Request $request)
    {
        $json = $request;
          
        $id = $json->id;
        $name = $json->name;
        $email = $json->email;
        $phone = $json->phone;
        $password = $json->password;
        
        $count_phone=DB::table('delivery_boys')->where('phone','=',$phone)->count();
        $count_email=DB::table('delivery_boys')->where('email','=',$email)->count();
        
        if($count_phone>0) {
           return response()->json(['status' => false,'data' => null,]);
        }
        else if($count_email>0)
        {
            return response()->json(['status' => false,'data' => null,]);
        }
        else
        {  
            $arr=array(
                'name'=>$name,
                'email'=>$email,
                'phone'=>$phone,
                'password'=>$password,
                'wallet_amount'=>0,
                'active_status'=>'YES',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
                );
            
            $data=DB::table('delivery_boys')->insert($arr);
            if($data==true)
            {
                return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
            }
            else
            {
                return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
            }
        }
       
        
    }
    
    public function deliveryBoyLogin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
            'password' => 'required',
        ]);
        
        if($validator->fails()) {
            $errors = $validator->errors();
           return response()->json(['status' => false, 'message' => $errors,'data' => null,]);
        }
        else
        {
            $phone = $request->phone;
            $password = $request->password;
            
            
            $row_count = DB::table('delivery_boys')
                         ->where('phone', '=',$phone)
                         ->where('password', '=',$password)
                         ->where('active_status', '=', 'YES')
                         ->count();
                         
            $row_result = DB::table('delivery_boys')
                         ->where('phone', '=',$phone)
                         ->where('password', '=',$password)
                         ->where('active_status', '=', 'YES')
                         ->first();


            $row_result = new LoginCollection($row_result);
 
            if($row_count>0)
            {
              return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
            }
            else
            {
                return response()->json(['status' => false, 'message' => "Invalid Credentials",'data' => null,]);
            }
               
        }
    }

    public function updatePersonalInfo(Request $request)
    {
        $json = $request;
        $user_id = $request->user_id;
        $name = $request->name;
        $phone = $request->phone;
        $father_name = $request->father_name;
        $city = $request->city;
        $address = $request->address;
        $lang = $request->lang;
        $image = $request->image;

        $count_phone=DB::table('delivery_boys')->where('phone','=',$phone)->where('id','!=',$user_id)->count();
       
        if($count_phone>0) {
           return response()->json(['status' => false,'data' => null,]);
        }
        else
        {
                
                $arr=array(
                    'name'=>$name,
                    'phone'=>$phone,
                    'father_name'=>$father_name,
                    'city'=>$city,
                    'address'=>$address,
                    'lang'=>$lang
                );

                if(!empty($image)){
                    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
                    $imageName = time().'.jpg';
                    $save_path = public_path().'/delivery_boy_image/'.$imageName;
                    file_put_contents($save_path, $image);
                    $arr['image'] = $imageName;
                }
                
                $dta=DB::table('delivery_boys')->where('id','=',$user_id)->update($arr);
                $details=DB::table('delivery_boys')->where('id','=',$user_id)->get();
                $details= PersonalInformationCollection::collection($details);
                
                if($dta==true)
                {
                    return response()->json(['status' => true, 'message' => 'Success','data' => $details,]);
                }
                else
                {
                    return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
                }
        }
    }

    public function getProfile($id){
        $details=DB::table('delivery_boys')->where('id','=',$id)->first();
        $details= new ProfileCollection($details);
        return response()->json(['status' => true, 'message' => 'Success','data' => $details,]);
    }

    public function getOtherDetails($id){
        $pan_document= DB::table('personal_documents')->where([
            'user_id' => $id,
            'type' => 'pan'
        ])->first();

        $aadhar_document = DB::table('personal_documents')->where([
            'user_id' => $id,
            'type' => 'aadhar'
        ])->first();

        $driving_license_document= DB::table('personal_documents')->where([
            'user_id' => $id,
            'type' => 'driving_license'
        ])->first();

        $work_preferences = DB::table('work_preferences')->where([
            'user_id' => $id,
        ])->first();

        $vehicle_details = DB::table('vehicle_details')->where([
            'user_id' => $id,
        ])->first();

        $bank_details = DB::table('bank_details')->where([
            'user_id' => $id,
        ])->first();

        $personal_details = DB::table('delivery_boys')->find($id);

        $otherDetails = (Object) [
             "pan_document_exists" => !empty($pan_document),
             "aadhar_document_exists" => !empty($aadhar_document),
             "driving_license_document_exists" => !empty($driving_license_document),
             "work_preferences_exists" => !empty($work_preferences),
             "vehicle_details_exists" => !empty($vehicle_details),
             "bank_details_exists" => !empty($bank_details),
             "personal_details_exists" => !empty($personal_details),
             "pan_document" => !empty($pan_document) ? new PersonalDocumentCollection($pan_document) : (Object) [] ,
             "aadhar_document" => !empty($aadhar_document) ? new PersonalDocumentCollection($aadhar_document) : (Object) [] ,
             "driving_license_document" => !empty($driving_license_document) ? new PersonalDocumentCollection($driving_license_document) : (Object) [] ,
             "work_preferences" => !empty($work_preferences) ? new WorkPreferenceCollection($work_preferences) : (Object) [] ,
             "vehicle_details" => !empty($vehicle_details) ? new VehicleDetailsCollection($vehicle_details) : (Object) [] ,
             "bank_details" => !empty($bank_details) ? new BankDetailsCollection($bank_details) : (Object) [] ,
             "personal_details" => !empty($personal_details) ? new ProfileCollection($personal_details) : (Object) [] ,
      ];

      return response()->json(['status' => true, 'message' => 'Success','data' => $otherDetails,]);
    }


    public function updateProfile(Request $request)
    {
        $json = $request;
        $user_id = $request->user_id;
        $name = $json->name;
        $email = $json->email;
        $phone = $json->phone;
        $password = $json->password;
        $image = $request->image;

        $count_phone=DB::table('delivery_boys')->where('phone','=',$phone)->where('id','!=',$user_id)->count();
        $count_email=DB::table('delivery_boys')->where('email','=',$email)->where('id','!=',$user_id)->count();
       
        if($count_phone>0) {
           return response()->json(['status' => false,'data' => null,]);
        }
        else if($count_email>0)
        {
            return response()->json(['status' => false,'data' => null,]);
        }
        else
        {
                
                $current_profile = DB::table('delivery_boys')->where('id','=',$user_id)->first();

                $arr=array(
                    'name'=>$name,
                    'phone'=>$phone,
                    //'password'=>$password,
                    'email'=>$email
                );

                if(!empty($image)){
                    if(!empty($current_profile->image)){
                        $previous_path=public_path().'/delivery_boy_image/'.$current_profile->image;

                        if(File::exists($previous_path)){
                            unlink($previous_path);
                        }
                    }

                    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image));
                    $imageName = time().'.jpg';
                    $save_path = public_path().'/delivery_boy_image/'.$imageName;
                    file_put_contents($save_path, $image);
                    $arr['image'] = $imageName;
                }
                
                $dta=DB::table('delivery_boys')->where('id','=',$user_id)->update($arr);
                $details=DB::table('delivery_boys')->where('id','=',$user_id)->get();
                $details= ProfileCollection::collection($details);
                
                if($dta==true)
                {
                    return response()->json(['status' => true, 'message' => 'Success','data' => $details,]);
                }
                else
                {
                    return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
                }
        }
    }

    public function savePersonalDocument(Request $request)
    {
        $user_id = $request->user_id;
        $type = $request->type;
        $card_number = $request->card_number;
        $document_types = ['pan', 'aadhar', 'driving_license'];

        if(in_array($type, $document_types)){
            $arr = array(
                'user_id' => $user_id,
                'card_number'=>$card_number,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            switch($type){
                case 'pan';
                    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
                    $imageName = time().'.jpg';
                    $save_path = public_path().'/personal_documents_image/'.$imageName;
                    file_put_contents($save_path, $image);
                    $arr['image'] = $imageName;
                    $arr['type'] = 'pan';
                break;

                case 'aadhar';
                    $front_image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->front_image));
                    $frontImageName = 'front_'.time().'.jpg';
                    $save_path = public_path().'/personal_documents_image/'.$frontImageName;
                    file_put_contents($save_path, $front_image);
                    $arr['front_image'] = $frontImageName;

                    $back_image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->back_image));
                    $backImageName = 'back_'.time().'.jpg';
                    $save_path = public_path().'/personal_documents_image/'.$backImageName;
                    file_put_contents($save_path, $back_image);
                    $arr['back_image'] = $backImageName;

                    $arr['type'] = 'aadhar';
                break;

                case 'driving_license';
                    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->image));
                    $imageName = time().'.jpg';
                    $save_path = public_path().'/personal_documents_image/'.$imageName;
                    file_put_contents($save_path, $image);
                    $arr['image'] = $imageName;

                    $arr['type'] = 'driving_license';
                break;
            }

            $data=DB::table('personal_documents')->insert($arr);
            if($data==true)
            {
                return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
            }
            else
            {
                return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
            }
        }

        return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        
    }

    public function saveWorkPreference(Request $request)
    {
        $user_id = $request->user_id;
        $option = $request->option;

        $arr = array(
            'user_id' => $user_id,
            'option'=>$option,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        $data=DB::table('work_preferences')->insert($arr);
        if($data==true)
        {
            return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        }
       
    }

    public function saveVehicleDetail(Request $request)
    {
        $user_id = $request->user_id;
        $model = $request->model;
        $vehicle_number = $request->vehicle_number;

        $arr = array(
            'user_id' => $user_id,
            'model'=>$model,
            'vehicle_number'=>$vehicle_number,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $data=DB::table('vehicle_details')->insert($arr);
        if($data==true)
        {
            return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        }
    }

    public function dashboard($id)
    {
        $details=DB::table('delivery_boys')->where('id','=',$id)->first();
        $details= new DashboardCollection($details);
        return response()->json(['status' => true, 'message' => 'Success','data' => $details,]);
    }

    public function updateOrderStatus($id, Request $request){
        $user_id = $request->user_id;
        $status = $request->status;
        $current_order=DB::table('orders')->where([
            'id' => $id,
            'delivery_boy_id' => $user_id,
        ])->first();

        try{
            DB::beginTransaction();

            if(!empty($current_order)){
                switch($status){
                    case 'accepted':
                        DB::table('orders')->where([
                            'id' => $id,
                            'delivery_boy_id' => $user_id,
                            'status' => 'pending'
                        ])->update([
                            'status' => $status
                        ]);
                    break;

                    case 'cancelled':
                            DB::table('orders')->where([
                                'id' => $id,
                                'delivery_boy_id' => $user_id,
                            ])->update([
                                'delivery_boy_id' => null,
                                'status' => 'pending'
                            ]);
                    break;

                    case 'completed':
                        DB::table('orders')->where([
                            'id' => $id,
                            'delivery_boy_id' => $user_id,
                        ])->update([
                            'status' => $status,
                            'delivery_date' => date('Y-m-d H:i:s')
                        ]);

                        $delivery_boys_row=DB::table('delivery_boys')->where('id','=',$user_id)->first();
                        $wallet_balance = !empty($delivery_boys_row->wallet_balance) ? $delivery_boys_row->wallet_balance : 0;
                        $delivery_charge = $current_order->delivery_charge;
                        $total_wallet_balance = $wallet_balance + $delivery_charge;
                        
                        DB::table('delivery_boys')->where('id','=',$user_id)->update([
                        'wallet_balance' => $total_wallet_balance
                        ]);
                        
                        DB::table('transactions')->insert([
                            'user_id'=> $user_id,
                            'type' => 'credit',
                            'amount' => $delivery_charge,
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                    break;
                }

                DB::commit();

                return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
            }
            else{
                return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
            }
 
        }catch(\Exception $e){ 
            DB::rollBack();
            //throw new $e;
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        }
    }

    public function getTransactions($id){
        $transactions = DB::table('transactions')->where('user_id', '=', $id)->orderBy('id', 'asc')->get();
        $data = TransactionCollection::collection($transactions);
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }


    public function allOrders(Request $request){
        $data = [];
        $order_results = [];
        $user_id = $request->user_id;
        $status = !empty($request->status) ? $request->status : 'pending';

        if($status == 'all'){
            $order_results = DB::table('orders')->where('delivery_boy_id','=',$user_id)->whereDate('delivery_date', date('Y-m-d'))->orderBY('id','DESC')->get();
        }
        else{
            $order_results = DB::table('orders')->where('delivery_boy_id','=',$user_id)->whereDate('delivery_date', date('Y-m-d'))->where('status', $status)->orderBY('id','DESC')->get();
        }

      
        foreach($order_results as $order_result){
            $order_item_result = DB::table('order_items')->where('order_id','=',$order_result->id)->first();
            $data[] = array(
                'id' => $order_result->id,
                'order_no' => $order_result->order_no,
                'product_name' => $order_item_result->product_name,
                'addrsss' => $order_result->delivery_address,
                'price' => (int)$order_result->total_amount,
                'delivery_date' => date('d/m/Y', strtotime($order_result->delivery_date)),
                'delivery_time' => date('g:i A', strtotime($order_result->delivery_date)),
                'status' => strtoupper($order_result->status),
            );
        }
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }

    public function orderDetails(Request $request){
        $user_id = $request->user_id;
        $order_id = $request->order_id;
        $order_items = [];

        $order_row = DB::table('orders')->where('id','=',$order_id)->first();
        $order_item_results = DB::table('order_items')->where('order_id','=',$order_id)->get();

        foreach($order_item_results as $order_item_result){
            $product_row = DB::table('products')->where('id','=',$order_item_result->product_id)->first();
            $image = \URL::asset('public/product_image/'.$product_row->main_image);

            $order_items[] = array(
                  'id' => $order_item_result->id,
                  'name' => $order_item_result->product_name,
                  'merchant_name' => $order_item_result->merchant_name,
                 'size' => $order_item_result->size,
                 'qty' => $order_item_result->qty,
                 'image' => $image
            );
        }
     
        $data = (Object)
            array(
                'id' => $order_row->id,
                'order_no' => $order_row->order_no,
                'delivery_address' =>  $order_row->delivery_address,
                'sub_total' =>  $order_row->sub_total,
                'discount_amount' =>  $order_row->discount_amount,
                'delivery_charge' =>  $order_row->delivery_charge,
                'total_amount' =>  $order_row->total_amount,
                'payment_type' =>  $order_row->payment_type,
                'status' => $order_row->status,
                'order_items' => $order_items
            );
        
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }

    public function updateCurrentLocation(Request $request){
        $user_id = $request->user_id;
        $current_lat = $request->current_lat;
        $current_long = $request->current_long;
        $duty_status = $request->duty_status;
        $device_token = $request->device_token;

        DB::table('delivery_boys')->where('id','=',$user_id)->update([
               'current_lat' => $current_lat,
               'current_long' => $current_long,
               'duty_status' => $duty_status,
               'device_token' => $device_token    
        ]);

        return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }

    public function saveBankDetail(Request $request){
        $user_id = $request->user_id;
        $bank_name = $request->bank_name;
        $branch_name = $request->branch_name;
        $account_holder = $request->account_holder;
        $ifsc_code = $request->ifsc_code;
        $account_no = $request->account_no;

        DB::table('bank_details')->insert([
               'user_id' => $user_id,
               'bank_name' => $bank_name,
               'branch_name' => $branch_name,
               'account_holder' => $account_holder,
               'ifsc_code' => $ifsc_code,
               'account_no' => $account_no,
               'created_at' => date('Y-m-d H:i:s'),
               'updated_at' => date('Y-m-d H:i:s')    
        ]);

        return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }

    public function makePayment(Request $request){
        $user_id = $request->user_id;
        $amount = $request->amount;
        $type = $request->type;

        DB::table('delivery_boy_payments')->insert([
            'delivery_boy_id' => $user_id,
            'type' => $type,
            'amount' => $amount,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')    
       ]);

       return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }

    
}