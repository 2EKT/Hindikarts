<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shop;
use App\Models\DeliveryBoy;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class MerchantOrderController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('merchant.order.pending');
    }

    public function acceptedOrders()
    {
        return view('merchant.order.accepted');
    }

    public function completedOrders()
    {
        return view('merchant.order.completed');
    }

    public function cancelledOrders()
    {
        return view('merchant.order.cancelled');
    }

    public function acceptOrder(Request $request){
        $merchant_id = Auth::guard('merchant')->user()->id;
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $shop = Shop::where(['merchant_id' => $merchant_id, 'status' => 'active'])->first();
        $selected_delivery_boy = [];
        $found_delivery_boy = 0;

        if(!empty($shop)){
            $shop_lat = $shop->lat;
            $shop_long = $shop->long;

            if($shop_lat > 0 && $shop_long > 0){
                 $delivery_boys = DeliveryBoy::where([
                    'active_status' => "YES",
                    'duty_status' => "on",
                 ])->where('current_lat', '>', 0)
                   ->where('current_long', '>', 0)
                   ->get();
                
                foreach($delivery_boys as $key => $value){
                    $distance = $this->getDistance($shop_lat, $shop_long, $value->current_lat, $value->current_long);
                    
                    if($distance <= 2){
                        $selected_delivery_boy[] = $value->device_token;
                    }
                }
            }
        }

        if(count($selected_delivery_boy) > 0){
            // we will do push notification
            $found_delivery_boy = 1;
            $message = 'New order request #'.$order->order_no;
            $to_app = 'Hindkart Delivery App';
            $title = 'New Order';

            $params = [
				'type' => 'order_request',
				'order_id' => $order->id
			];

            $deviceTokens['device_token_android'] = $selected_delivery_boy;
            \Helper::sendPushNotification($to_app, $deviceTokens, $message, $title, $params );
        }

        else{
             $existing_notification = Notification::where('order_id', $order_id)->first();

             if(empty($existing_notification)){
                Notification::create([
                    'order_id' => $order_id,
                    'message' => "A new order request #".$order_id.' has come'
                ]);
             }
        }

        return response()->json(['status' => true, 'message' => 'Success','data' => $found_delivery_boy,]);
    }

    public function cancelOrder(Request $request){
        $order_id = $request->order_id;
        Order::where('id', $order_id)->update(['status' => 'cancelled']);
        return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }

    public function getDistance($shopLat,$shopLng,$customerLat,$customerLng, $unit = "K")
	{
		$theta = $shopLng - $customerLng; 
        $dist = sin(deg2rad($shopLat)) * sin(deg2rad($customerLat)) +  cos(deg2rad($shopLat)) * cos(deg2rad($customerLat)) * cos(deg2rad($theta)); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $miles = $dist * 60 * 1.1515;
        //$unit = "K";

        if ($unit == "K") 
        {
            return number_format($miles * 1.609344,2); 
        } 
        else if ($unit == "N") 
        {
        	return number_format($miles * 0.8684,2);
        } 
        else 
        {
        	return number_format($miles,2);
      	}
	}

   
}