<?php

namespace App\Http\Resources\Api\App\DeliveryBoy;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\VehicleDetail;
use App\Models\Order;
use App\Models\Monthlyfee;
use App\Models\DeliveryBoyPayment;

class DashboardCollection extends JsonResource
{
   
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        $vehicleDetail = VehicleDetail::where('user_id', $this->id)->first();
        $vehicle_no = !empty($vehicleDetail) ? $vehicleDetail->vehicle_number : '';
        $monthlyfee = Monthlyfee::where('id', 1)->first();
        $merchant_monthly = !empty($monthlyfee) ? $monthlyfee->merchant_monthly : 0;
        $wallet_balance = !empty($this->wallet_balance) ? $this->wallet_balance : 0;
        $today_spent_time = '';
        $today_added_spent_time = 0;
        $withdrawl_amount = 0;
        $payment_type = '';
        $payment_amount = 0;
        $payment_remaining = false;
        $from_date = date('Y-m-01');
        $to_date = date('Y-m-05');
        $current_date = date('Y-m-d');
       
        if($wallet_balance >= $merchant_monthly){
            $wallet_balance -= $merchant_monthly;
        }

        $today_earning = Order::where([
            'delivery_boy_id' => $this->id,
            'status' => 'completed'
         ])->whereDate('delivery_date', date('Y-m-d'))
            ->sum('total_amount');

        $today_spent_time_arr = Order::where([
                'delivery_boy_id' => $this->id,
                'status' => 'completed'
                ])->whereDate('delivery_date', date('Y-m-d'))
                  ->get()
                  ->toArray();

        $new_orders =  Order::where([
                        'delivery_boy_id' => $this->id,
                        'status' => 'pending'
                    ])->whereDate('delivery_date', date('Y-m-d'))
                        ->count();   
                        
        $processing_orders =  Order::where([
            'delivery_boy_id' => $this->id,
            'status' => 'accepted'
        ])->whereDate('delivery_date', date('Y-m-d'))
            ->count();  
            
        $completed_orders =  Order::where([
            'delivery_boy_id' => $this->id,
            'status' => 'completed'
        ])->whereDate('delivery_date', date('Y-m-d'))
            ->count();  
            
        $cancelled_orders =  Order::where([
            'delivery_boy_id' => $this->id,
            'status' => 'cancelled'
        ])->whereDate('delivery_date', date('Y-m-d'))
            ->count();     

        foreach($today_spent_time_arr as $key => $value){
             $time_diff = $this->getTimeDiff($value['created_at'], $value['delivery_date']);
             $time_in_second = $this->convertTimeToSecond($time_diff);
             $today_added_spent_time += $time_in_second;
        }   
 
        $today_spent_hour = (int) date('H', mktime(0, 0, $today_added_spent_time));
        $today_spent_minute =  (int) date('i', mktime(0, 0, $today_added_spent_time));

        if($today_spent_hour > 0 && $today_spent_minute > 0){
            $today_spent_time = $today_spent_hour. 'h '.$today_spent_minute.'m';
        }
        else if($today_spent_hour > 0 && $today_spent_minute == 0){
            $today_spent_time = $today_spent_hour.'h';
        }
        else if($today_spent_hour == 0 && $today_spent_minute > 0){
            $today_spent_time = $today_spent_minute.'m';
        }

        $already_registered =  DeliveryBoyPayment::where([
                                'delivery_boy_id' => $this->id,
                                'type' => 'registration'
                               ])->exists();
                                        
        $already_subscribed =  DeliveryBoyPayment::where([
                                'delivery_boy_id' => $this->id,
                                'type' => 'subscription'
                                ])->whereDate('created_at', '>=', $from_date)
                                  ->whereDate('created_at', '<=', $current_date)
                                  ->exists();  

        $already_registered_in_current_month =  DeliveryBoyPayment::where([
                                'delivery_boy_id' => $this->id,
                                'type' => 'registration'
                              ]) ->whereDate('created_at', '>=', $from_date)
                                 ->whereDate('created_at', '<=', $current_date)
                                 ->exists();
             
         if(!$already_registered){
            $payment_type = 'registration';
            $payment_amount = !empty($monthlyfee) ? $monthlyfee->delivery_boy_reg : 0;
            $payment_remaining = true;
         }  
         else {
            if(!$already_subscribed && !$already_registered_in_current_month && $to_date <= $current_date){
                $payment_type = 'subscription';
                $payment_amount = !empty($monthlyfee) ? $monthlyfee->delivery_boy_monthly : 0;
                $payment_remaining = true;
            } 
         }                       

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => !empty($this->image) ? \asset('delivery_boy_image/'.$this->image) : '',
            'today_earning' => (int)$today_earning,
            'withdrawl_amount' => (int)$withdrawl_amount,
            'today_spent_time' => $today_spent_time,
            'vehicle_no' => $vehicle_no,
            'wallet_balance' => (int)$wallet_balance,
            'new_orders' => $new_orders,
            'processing_orders' => $processing_orders,
            'completed_orders' => $completed_orders,
            'cancelled_orders' => $cancelled_orders,
            'payment_type' => $payment_type,
            'payment_amount' => $payment_amount,
            'payment_remaining' => $payment_remaining,
        ];
    }

    public function getTimeDiff($start_time, $end_time){
        $time_diff = strtotime($end_time) - strtotime($start_time);
        $formatted_time = date('H:i:s', mktime(0, 0, $time_diff));
        return $formatted_time;
    }

    public function convertTimeToSecond(string $time)
    {
        $d = explode(':', $time);
        return ($d[0] * 3600) + ($d[1] * 60) + $d[2];
    }
}