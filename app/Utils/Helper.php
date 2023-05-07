<?php

namespace App\Utils;

use DateTime;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Cart;
use App\Models\WishList;
use App\Models\Order;
use Str;

class Helper
{

    public static function getUniqueId()
    {
        return md5(microtime().\Config::get('app.key'));
    }

    public static function splitName($name)
    {
        $name_arr = [];
        if (!empty($name)) {
            $name_arr2 = explode(" ", $name);

            $name_arr[] = trim($name_arr2[0]);
            $name_arr[] = trim(!empty($name_arr2[1]) ? substr($name, strlen($name_arr2[0]) + 1) : '');
        }

        return $name_arr;
    }

    public static function jsonDecode($string)
    {
        if (self::isJson($string)) {
            return json_decode($string);
        }

        return (array)$string;
    }

    public static function isJson($string)
    {
        if (!empty($string)) {
            json_decode($string);
            return (json_last_error() == JSON_ERROR_NONE);
        }

        return false;
    }

    public static function convertObjectToArray($data){
        return json_decode(json_encode($data), true);
    }

    public static function getDateDiff($start_date, $end_date){
        $date1 = date_create($start_date);
        $date2 = date_create($end_date);
        return date_diff($date1,$date2)->format("%R%a");
    }

    public static function getTimeDiff($start_time, $end_time){
        $time_diff = strtotime($end_time) - strtotime($start_time);  
        $formatted_time = date('H:i', mktime(0, 0, $time_diff));
        return $formatted_time;
    }

    public static function convertToHour($time){
        $hour = Carbon::now()->startOfDay()->addSeconds($time)->toTimeString(); 
        return $hour;
      }

    public static function getRawJSONRequest($data){
        $data = (array) self::jsonDecode($data);
        return $data;
    }

    public static function getValueFromRawJSONRequest($data, $key){
       $value = (isset($data[$key]) && !empty($data[$key])) ? $data[$key] : null;
       return $value;
    }

    public static function isMultiArray( $arr ) {
        rsort( $arr );
        return isset( $arr[0] ) && is_array( $arr[0] );
    }

    public static function formatDateTime($created_at, $format = 1, $timezone_name = null){
        if (!empty($created_at)) {
            $created_at = date('Y-m-d H:i:s', strtotime($created_at));
            $d = Carbon::createFromFormat('Y-m-d H:i:s', $created_at);

            if ($format == 1) {
                $d = $d->format('d/m/Y');
            } else if ($format == 2) {
                $d = $d->format('d/m/Y h:i:s');
            } else if ($format == 3) {
                $date = $d->format('Y-m-d');
                $today = today()->format('Y-m-d'); // Helper::today();
                $yesterday = now()->addDays(-1)->format('Y-m-d'); // Helper::yesterday();

                if ($date == $today) {
                    $d = 'Today';
                } else if ($date == $yesterday) {
                    $d = 'Yesterday';
                } else {
                    $d = $d->format('d M, Y');
                }
            } else if ($format === 4) {
                $d = $d->format('l , jS M, Y');
            } else if ($format === 5) {
                $d = $d->format('Y-m-d');
            } // October 13, 2014 11:13:00
            else if ($format === 6) {
                $d = $d->format('F d, Y H:i:s');
            } else if ($format === 7) {
                $d = $d->format('d/m/y');
            }
            else if ($format === 8) {
                $d = $d->format('g:i A');
            }
            else if ($format === 9) {
                $d = $d->format('Y-m-d');
            }
            else if ($format === 10) {
                $d = $d->format('d/m');
            }
            else if ($format === 11) {
                $d = $d->format('g:i:s A');
            }else if($format === 12){
                $d = $d->format('d M, Y g:i A');
            }else if($format === 13){
                $d = $d->format('d/m/Y h:i A');
            }else if($format === 14){
                $d = $d->format('H:i:s');
            }else if($format === 15){
                $d = $d->format('Y-m-d h:i');
            }else if ($format === 16) {
                $d = $d->format('jS M');
            }else if ($format === 17) {
                $d = $d->format('H:i');
            }else if ($format === 18) {
                $d = $d->format('l, M j, Y');
            }else if ($format === 19) {
                $d = $d->format('j-M-Y');
            }else if ($format === 20) {
                $d = $d->format('jS F, Y');
            }else if ($format === 21) {
                $d = $d->format('D, M j');
            }else if ($format === 22) {
                $d = $d->format('dS M, Y');
            }else if ($format === 23) {
                $d = $d->format('F,d,Y');
            }else if ($format === 24) {
                $d = $d->format('D d M Y');
            }else if ($format === 25) {
                $d = $d->format('jS F, Y h:i A');
            }else if ($format === 26) {
                $d = $d->format('F j, Y');
            }else if ($format == 27) {
                $d = $d->format('m/d/Y');
            }else if ($format == 28) {
                $d = $d->format('h:i:s A');
            }
            

            if (!empty($timezone_name)) {
                return $d . ' ' . $timezone_name;
            }

            return $d;
        }

        return '';
    }

    public static function convertToSecond($value){
        $parsed = date_parse($value);
        $seconds = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
        return $seconds;
    }

    public static function getCurrentRoleId(){
        return \Auth::user()->role_id;
    }

    public static function getUserId(){
        if(!empty(\Auth::user())){
            return \Auth::user()->id;
        }
        else{
            return null;
        }
    }

    /*
     * Get current date and time
     */
    public static function currentDateTime()
    {
        return Carbon::now()->toDateTimeString();
    }

    /*
     * Get today
     */
    public static function today($format = 'Y-m-d')
    {
        return Carbon::now()->format($format);
    }

    public static function yesterday($format = 'Y-m-d')
    {
        return Carbon::now()->subDays(1)->format($format);
    }

    public static function dayBeforeYesterday($format = 'Y-m-d')
    {
        return Carbon::now()->subDays(2)->format($format);
    }

    /*
     * Current Month
     */
    public static function currentMonth($format = 'm')
    {
        return Carbon::now()->format($format);
    }
    
    public static function humanStringFormat($str = '')
    {
      if (!empty($str)) {
        $str = ucwords(str_replace('_', ' ', $str));
      }
  
      return $str;
    }

    /*
     * Last Month
    */
    public static function lastMonth($format = 'm')
    {
        return Carbon::now()->subMonth()->format($format);
    }

    /*
    * Current Year
    */
    public static function currentYear($format = 'Y')
    {
        return Carbon::now()->format($format);
    }

    /*
     * Last Year
    */
    public static function lastMonthYear($format = 'Y')
    {
        return Carbon::now()->subMonth()->format($format);
    }

    public static function firstDateOfThisMonth($format = 'Y-m-d', $date = NULL)
    {
        if (!empty($date)) {
          $d = new \DateTime($date);
          $d->modify('first day of this month');
        } else {
          $d = new \DateTime('first day of this month');
        }
        return $d->format($format);
    }


    public static function lastDateOfThisMonth($format = 'Y-m-d', $date = NULL)
    {
        if (!empty($date)) {
          $d = new \DateTime($date);
          $d->modify('last day of this month');
        } else {
          $d = new \DateTime('last day of this month');
        }
        return $d->format($format);
    }


    public static function firstDateOfLastMonth($format = 'Y-m-d')
    {
        $d = new \DateTime('first day of last month');
        return $d->format($format);
    }


    public static function lastDateOfLastMonth($format = 'Y-m-d')
    {
        $d = new \DateTime('last day of last month');
        return $d->format($format);
    }


    public static function firstDateOfThreeMonthAgo($format = 'Y-m-d')
    {
        $d = new \DateTime('first day of 3 month ago');
        return $d->format($format);
    }


    public static function lastDateOfThreeMonthAgo($format = 'Y-m-d')
    {
        $d = new \DateTime('last day of 3 month ago');
        return $d->format($format);
    }

    public static function cleanPhone($phone)
    {
        $phone = preg_replace("/[^\d]/", "", $phone);

        return $phone;
    }

    public static function cleanName($name)
    {
        if (!empty($name)) {
          $name = ucwords(str_replace('_', ' ', $name));
        }

        return $name;
    }

    /*
     * Formatting phone depending on phone
     *
     * @param phone
     *
     * @return formatted phone
     *
     */
    public static function formatPhone($phone)
    {
        $phone = preg_replace("/[^\d]/", "", $phone);

        $l = strlen($phone);
        $c = substr($phone, 0, ($l > 10 ? $l - 10 : 0));
        $p = substr($phone, $l - ($l > 10 ? 10 : $l));
        $p1 = substr($p, 0, 3);
        $p2 = substr($p, 3, 3);
        $p3 = substr($p, 6, 4);

        $ph = "";
        if ($c) {
            $ph .= '+' . $c;
        }
        if ($p1) {
            $ph .= '(' . $p1 . ') ';
        }
        if ($p2) {
            $ph .= $p2 . '-';
        }
        if ($p3) {
            $ph .= $p3;
        }

        return $ph;
    }

      // Push Notifications
      public static function sendPushNotification($to_app = null, $deviceTokens = [], $message = null, $title = '', $params = [])
      {
 
        if (empty($title))
        {
          $title = 'New Notification';
        //   $title = '';
        }
 
        /*if (!empty($params))
        {
          $params = array_merge($params, ['to_app' => $to_app]);
        }*/
        $params = array_merge($params, ['to_app' => $to_app]);
 
        if(is_array($deviceTokens) && sizeof($deviceTokens) > 0)
        {
          $deviceTokenAndroidArr       = !empty($deviceTokens['device_token_android']) ? $deviceTokens['device_token_android'] : [];
 
          $deviceTokenIosArr           = !empty($deviceTokens['device_token_ios']) ? $deviceTokens['device_token_ios'] : [];
 
 
          //////////////////
          // Android
          //////////////////
          if (!empty($deviceTokenAndroidArr))
          {
            $deviceTokenAndroidArr = array_unique($deviceTokenAndroidArr);
 
            // API access key from Google API's Console
            $api_access_key = 'AAAAVY5uWl0:APA91bGh2zTWg5WWg_pcsB_T1Qi0OUY7hYmjBEKFO7Ja0_hxoJ1u8HejhBjzAvjassVdok2fEZEq97pqfpKaHBPhUoBPmxwIiakOIvglocM8rVikyjSx0BPU7S-xG-6YWQ5eyvUe_hWI';
 
            foreach ($deviceTokenAndroidArr as $deviceTokenAndroid)
            {
              if (!empty($deviceTokenAndroid) && $deviceTokenAndroid != 'NO_DEVICE_TOKEN_FOR_IOS_SIMULATOR')
              {
                if (is_array($deviceTokenAndroid) && sizeof($deviceTokenAndroid) > 0)
                {
                  $registrationIds = $deviceTokenAndroid;
                }
                else
                {
                  $registrationIds = array($deviceTokenAndroid);
                }
 
                // prep the bundle
                $msg = array
                (
                  'message' 	=> $message,
                  'title'		=> $title,
                  //'subtitle'	=> 'Subtitle',
                  //'tickerText'	=> 'Ticker text here',
                  'vibrate'	=> 1,
                  //'type'	=> $params['type'],
                  //'to_app'	=> $to_app,
                  'sound'		=> 1,
                  'image' => '',
                  'logo' => asset('public/dashboard_assets/images/favicon.png')
                  //'largeIcon'	=> 'large_icon',
                  //'smallIcon'	=> 'small_icon',
                );
                $msg = array_merge($msg, $params);
 
                // if (!empty($params))
                // {
                //   $msg = array_merge($msg, array('params' => $params));
                // }
 
                $fields = array
                (
                  'registration_ids' => $registrationIds,
                  'data'			   => $msg
                );
 
                $headers = array
                (
                  'Authorization: key=' . $api_access_key,
                  'Content-Type: application/json'
                );
 
                $ch = curl_init();
                curl_setopt( $ch,CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
                curl_setopt( $ch,CURLOPT_POST, true );
                curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
                curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
                curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
                $result = curl_exec($ch );
                curl_close( $ch );
 
                //\Log::info(['push_result' => $result, 'registrationIds' => $registrationIds, 'msg' => $msg]);
                //return $result;
               // print_r($result);
                //\Log::info('Push Result:: App Name: ' . $to_app . ' | Device token Android: ' . $deviceTokenAndroid . ' | Title: ' . $title . ' | Message: ' . $message . ' | Result: ' . $result);
                //echo $result;
              }
            }
          }
        }
 
        return ;
      }

    // Get HH:mm:ss format from time array
    public static function getTime($data)
    {
        $date = new DateTime();
        $time = is_array($data) ? $data :  json_decode($data, true) ;

        $object = $date->setTime($time["hh"] + ($time["A"] === 'PM' ? 12 : 0), $time["mm"]);
        
        return $object->format('H:i:s');
    }
    public static function setTimeZone($timezone)
    {
        if (!empty($timezone)) {
            date_default_timezone_set($timezone);
        }
    }

    public static function getFormattedDate($date){
        if(!empty($date)){
          $date_arr = explode('/',$date);
          $formatted_date = $date_arr[2].'-'.$date_arr['1'].'-'.$date_arr['0'];
          return $formatted_date;
        }
        else{
          return null;
        }
      }

    public static function getPageLimit($limit){
       $given_limit = !empty($limit) ? (int)$limit : 20;
       return $given_limit;
    }


    public static function getDifference($num1, $num2){
		$diff = \Helper::twoDecimalPoint($num1) - \Helper::twoDecimalPoint($num2);
		return \Helper::twoDecimalPoint($diff);
	}

    public static function getSum($num1, $num2){
		$sum = \Helper::twoDecimalPoint($num1) + \Helper::twoDecimalPoint($num2);
		return \Helper::twoDecimalPoint($sum);
	}

    // Calculate Discounted Price
    public static function getDiscountedPrice($originalPrice, $discount = 0, $type = NULL)
    {
        if($discount){
            if(strtolower($type) == "percent" || strtolower($type) == "percent"){
                $originalPrice = $originalPrice * (100 - $discount )/100;
            }else{

                $originalPrice = ($originalPrice - $discount);
            }
        }

        return (float) self::twoDecimalPoint($originalPrice);
    }

    public static function getDiscountedDisplay($discountPrice, $type = NULL)
    {
        if($discountPrice){
            if(strtolower($type) == "percent"){
                $discountPrice = $discountPrice ." %";
            }else{
                
                $discountPrice = self::getDisplayAmount($discountPrice);
            }
        }

        return $discountPrice;
    }

    public static function getDecimalRounded($amount = 0)
    {
      return floatval($amount);
    }
   
   	public static function getCurrencyCode()
   	{
   			return  "Rs";
   	}
     
    public static function numberFormatter($num, $currency = false){
        $type = \NumberFormatter::DECIMAL;
        if($currency){
            $type = \NumberFormatter::CURRENCY;
        }
        $fmt = new \NumberFormatter($locale = 'en_IN', $type);
        return $fmt->format($num);
        //return $num;
    }
}
