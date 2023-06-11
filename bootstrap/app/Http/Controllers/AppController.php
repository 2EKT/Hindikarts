<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Api\App\User\NewProductCollection;
use App\Http\Resources\Api\App\User\SearchProductCollection;
use App\Http\Resources\Api\App\User\FilterProductCollection;
use App\Http\Resources\Api\App\User\RatingCollection;
use App\Http\Resources\Api\App\User\SpecificProductCollection;
use Carbon\Carbon;
use Auth;
use Mail;
use Session;

class AppController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }

    public function userRegistration(Request $request)
    {
        $json = $request;
          
        $id = $json->id;
        $name = $json->name;
        $email = $json->email;
        $phone = $json->phone;
        $password = $json->password;
        
        $count_phone=DB::table('users')->where('phone','=',$phone)->count();
        $count_email=DB::table('users')->where('email','=',$email)->count();
        
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
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                    );
                
                $dta=DB::table('users')->insert($arr);
                if($dta==true)
                {
                    return response()->json(['status' => true, 'message' => 'Success','data' => $dta,]);
                }
                else
                {
                    return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
                }
        }
       
        
    }
    
    public function userLogin(Request $request)
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
            
            
            $row_count = DB::table('users')
                         ->where('phone', '=',$phone)
                         ->where('password', '=',$password)
                         ->count();
                         
            $row_result = DB::table('users')
                         ->where('phone', '=',$phone)
                         ->where('password', '=',$password)
                         ->first();
                         
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
    
    public function compAnnouncement(Request $request)
    {
        $row_result = DB::table('comp_announcements')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    public function dealsoftheDay(Request $request)
    {
        $row_result = DB::table('dealsofthe_days')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function recentlyViewed(Request $request)
    {
        $row_result = DB::table('recentlyvieweds')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function bestDiscount(Request $request)
    {
        $row_result = DB::table('best_discounts')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
     public function ecomCategory(Request $request)
    {
        $row_result = DB::table('categories')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function ecomSubcategory(Request $request)
    {
        $cat_id = $request->cat_id;
        $row_result = DB::table('subcategories')->where('cat_id','=',$cat_id)->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function ecomMegacategory(Request $request)
    {
        $subcat_id = $request->subcat_id;
        $row_result = DB::table('megacategories')->where('subcat_id','=',$subcat_id)->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function productforMegacategry(Request $request)
    {
        $megacat_id = $request->megacat_id;
        $user_id = $request->user_id;
        $row = DB::table('products')->where('megacat_id','=',$megacat_id)->where('active','=','YES')->get();
        
        foreach($row as $row_result)
        {
            $merchant_row=DB::table('merchants')->where('id','=',$row_result->merchant_id)->first();
            $price_row=DB::table('product_details')->where('product_id','=',$row_result->id)->first();
            $wishlist_check=DB::table('wishlists')->where('product_id','=',$row_result->id)->where('user_id','=',$user_id)->count();
            if($wishlist_check>0)
            {
                $wishlist_status=true;
            }
            else
            {
                $wishlist_status=false;
            }
            
            $arrayValue[]=array(
            'product_id'=>$row_result->id,
            "title"=>$row_result->title,
            "main_image"=>$row_result->main_image,
            "img1"=>$row_result->img1,
            "img2"=>$row_result->img2,
            "img3"=>$row_result->img3,
            "img4"=>$row_result->img4,
            "description"=>$row_result->description,
            "merchant_name"=>$merchant_row->name,
            "market_price"=>$price_row->market_price,
            "sale_price"=>$price_row->sale_price,
            "wishlist_status"=>$wishlist_status
            );
        }
        
        return response()->json(['status' => true, 'message' => 'Success','data' => $arrayValue,]);
    }
    
    
    
     public function services(Request $request)
    {
        $row_result = DB::table('services')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
     public function newlyAddedproducts(Request $request)
    {
        $row_result = DB::table('products')
        ->leftJoin('merchants', 'products.merchant_id', '=', 'merchants.id')
        ->select('products.*', 'merchants.name AS merchant_name')
        ->where('active','=','YES')
        ->orderBy('products.id', 'desc')
        ->get();
        $row_result = NewProductCollection::collection($row_result);
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function productDetails(Request $request)
    {
        $product_id = $request->product_id;
        $user_id = $request->user_id;
        $row_result = DB::table('products')->where('id','=',$product_id)->where('active','=','YES')->first();
        
            $merchant_row=DB::table('merchants')->where('id','=',$row_result->merchant_id)->first();
            $price_row=DB::table('product_details')->where('product_id','=',$row_result->id)->get();
            $wishlist_check=DB::table('wishlists')->where('product_id','=',$row_result->id)->where('user_id','=',$user_id)->count();
            if($wishlist_check>0)
            {
                $wishlist_status=true;
            }
            else
            {
                $wishlist_status=false;
            }
            
            foreach($price_row as $price_result)
            {
                $arr[]=array(
                    'id'=>$price_result->id,
                    'attr_type'=>$price_result->attr_type,
                    'attr_value'=>$price_result->attr_value,
                    'market_price'=>$price_result->market_price,
                    'sale_price'=>$price_result->sale_price,
                    'stock'=>$price_result->stock
                    );
            }
            
            for($i=1;$i<6;$i++)
            {
                if($i==1)
                {
                    $img=$row_result->main_image;
                }
                else if($i==2)
                {
                    $img=$row_result->img1;
                }
                else if($i==3)
                {
                    $img=$row_result->img2;
                }
                else if($i==4)
                {
                    $img=$row_result->img3;
                }
                else if($i==5)
                {
                    $img=$row_result->img4;
                }
                
                $imageSection[]=array(
                "image"=>$img,
                );
            }
            
            $arrayValue=array(
            'product_id'=>$row_result->id,
            "title"=>$row_result->title,
            "imageSection"=>$imageSection,
            "description"=>$row_result->description,
            "merchant_name"=>$merchant_row->name,
            "wishlist_status"=>$wishlist_status,
            "others"=>$arr
            );
        
        
        return response()->json(['status' => true, 'message' => 'Success','data' => $arrayValue,]);
    }
    
    public function getproductSize(Request $request)
    {
        $product_id = $request->product_id;
        $row_result = DB::table('product_details')->where('product_id','=',$product_id)->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function cartDetails(Request $request)
    {
        $user_id = $request->user_id;
        $total_price=0;
        $check_cart=DB::table('carts')->where('user_id','=',$user_id)->count();
        if($check_cart>0)
        {
            $cart_row=DB::table('carts')->where('user_id','=',$user_id)->get();
            foreach($cart_row as $cart_result)
            {
                $quantity=$cart_result->qty;
                $price_details=DB::table('product_details')->where('id','=',$cart_result->size_id)->first();
                $sale_price=$price_details->sale_price;
                $total_price+=$sale_price*$quantity;
                $delivery_charge=0;

                $delivery_type=DB::table('deliverytypes')->find(1);

                if(!empty($delivery_type)){
                    $delivery_charge = $delivery_type->delivery_charge;
                }
                
                $product_row = DB::table('products')->where('id','=',$cart_result->product_id)->first();
                $merchant_row=DB::table('merchants')->where('id','=',$product_row->merchant_id)->first();

                $product_price_details = DB::table('product_details')->select('id', 'product_id', 'attr_type', 'attr_value', 'market_price', 'sale_price', 'stock')
                ->where('product_id','=',$product_row->id)->get();
               
                
                $product_section[]=array(
                        'cart_id'=>$cart_result->id,
                        'product_id'=>$product_row->id,
                        "title"=>$product_row->title,
                        "main_image"=>$product_row->main_image,
                        "description"=>$product_row->description,
                        "merchant_name"=>$merchant_row->name,
                        'size_id'=>$price_details->id,
                        'qty'=>$cart_result->qty,
                        'attr_type'=>$price_details->attr_type,
                        'attr_value'=>$price_details->attr_value,
                        'market_price'=>$price_details->market_price,
                        'sale_price'=>$price_details->sale_price,
                        'stock'=>$price_details->stock,
                        'product_price_details' => $product_price_details
                    );
                
                // $arrayValue[]=array(
                //         "product_section"=>$product_section,
                //         );
                        
                
                // unset( $product_section );
            }
            
            $total_amount=$total_price+$delivery_charge;
            
            
            
            return response()->json(['status' => true, 'message' => 'Success','data' => $product_section,'total_price' => $total_price,'delivery_charge'=>$delivery_charge,'total_amount'=>$total_amount]);
        }
        else
        {
            return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
        }
            
        
    }
    
    
    
    public function addCart(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $size_id = $request->size_id;
        $qty = $request->qty;
        
        $arr=array(
            'user_id'=>$user_id,
            'product_id'=>$product_id,
            'size_id'=>$size_id,
            'qty'=>$qty,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            );

        $product_exists = DB::table('product_details')->where('id', $size_id)->where('stock', '>', 0)->exists();    

        if($product_exists){
            $count=DB::table('carts')->where(['user_id' => $user_id, 'product_id' => $product_id, 'size_id' => $size_id])->count();
            if($count>0)
            {
                return response()->json(['status' => true, 'message' => 'Success','data' => 'exist']);
            }
            else
            {
                $row_result = DB::table('carts')->insert($arr);
                return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
            }
        }
        else{
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        }
    }
    
    public function removeCart(Request $request)
    {
        $cart_id = $request->cart_id;
        $row_result = DB::table('carts')->where('id','=',$cart_id)->delete();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function changeSize(Request $request)
    {
        $cart_id = $request->cart_id;
        $size_id = $request->size_id;
        $user_id = $request->user_id;
        $arr=array(
            'size_id'=>$size_id
            );
        $row_result = DB::table('carts')->where('id','=',$cart_id)->update($arr);
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function changeQty(Request $request)
    {
        $user_id = $request->user_id;
        $cart_id = $request->cart_id;
        $qty = $request->qty;
        $arr=array(
            'qty'=>$qty
            );
        $row_result = DB::table('carts')->where('id','=',$cart_id)->update($arr);
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    
    public function razorpayDetails(Request $request)
    {
        $row_result = DB::table('razorpays')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    
     public function wishlistDetails(Request $request)
    {
        $user_id = $request->user_id;
        $total_price=0;
        $check_wishlist=DB::table('wishlists')->where('user_id','=',$user_id)->count();
        if($check_wishlist>0)
        {
            $wishlist_row=DB::table('wishlists')->where('user_id','=',$user_id)->get();
            foreach($wishlist_row as $wishlist_result)
            {
                $price_details=DB::table('product_details')->where('product_id','=',$wishlist_result->product_id)->first();
                $sale_price=$price_details->sale_price;
                
                $product_row = DB::table('products')->where('id','=',$wishlist_result->product_id)->first();
                $merchant_row=DB::table('merchants')->where('id','=',$product_row->merchant_id)->first();
               
                
                $product_section[]=array(
                        'product_id'=>$product_row->id,
                        "title"=>$product_row->title,
                        "main_image"=>$product_row->main_image,
                        "description"=>$product_row->description,
                        "merchant_name"=>$merchant_row->name,
                        'market_price'=>$price_details->market_price,
                        'sale_price'=>$price_details->sale_price,
                        'wishlist_id'=>$wishlist_result->id
                    );
                
            }
            
            
            return response()->json(['status' => true, 'message' => 'Success','data' => $product_section,]);
        }
        else
        {
            return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
        }
            
        
    }
    
    
    
    public function addWishlist(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        
        $arr=array(
            'user_id'=>$user_id,
            'product_id'=>$product_id,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            );
            
        $count=DB::table('wishlists')->where('user_id','=',$user_id)->where('product_id','=',$product_id)->count();
        if($count>0)
        {
            return response()->json(['status' => true, 'message' => 'Success','data' => 'exist']);
        }
        else
        {
            $row_result = DB::table('wishlists')->insert($arr);
            return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
        }
        
    }
    
    public function removeWishlist(Request $request)
    {
        $wishlist_id = $request->wishlist_id;
        $row_result = DB::table('wishlists')->where('id','=',$wishlist_id)->delete();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }

    public function removeWishlistByProduct(Request $request)
    {
        $product_id = $request->product_id;
        $user_id = $request->user_id;
        $row_result = DB::table('wishlists')->where([
            'product_id' => $product_id,
            'user_id' => $user_id
        ])->delete();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function stateList(Request $request)
    {
        $row_result = DB::table('state')->orderBY('state','ASC')->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function addAddress(Request $request)
    {
        $count=DB::table('address')->where('user_id','=',$request->user_id)->count();
        if($count==0)
        {
            $status="Active";
        }
        else
        {
            $status="";
        }
        $arr=array(
            'user_id' => $request->user_id,
            'name' => $request->name,
            'mobile' => $request->mobile,
            'state_id' => $request->state_id,
            'state' => $request->state,
            'city' => $request->city,
            'landmark' => $request->landmark,
            'pincode' => $request->pincode,
            'address1' => $request->address1,
            'address2' => $request->address2,
            'type' => $request->type,
            'status' => $status,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            );
            
        $row_result=DB::table('address')->insert($arr);
        if($row_result==true)
        {
            return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        } 
    }
    
    public function activeAddress(Request $request)
    {
        $address_id = $request->address_id;
        $user_id = $request->user_id;
        
        $status="";
        $arr=array(
            'status' => $status
            );
            
        $row_result=DB::table('address')->where('user_id','=',$request->user_id)->update($arr);
        
        $arr2=array(
            'status' => 'Active'
            );
            
        $row_result2=DB::table('address')->where('id','=',$address_id)->update($arr2);
        if($row_result2==true)
        {
            $details=DB::table('address')->where('user_id','=',$request->user_id)->get();
            return response()->json(['status' => true, 'message' => 'Success','data' => $details,]);
        }
        else
        {
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        }
    }
    
    public function fetchAddress(Request $request)
    {
        $user_id = $request->user_id;
        $row_result = DB::table('address')->where('user_id','=',$user_id)->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function removeAddress(Request $request)
    {
        $address_id = $request->address_id;
        $row_result = DB::table('address')->where('id','=',$address_id)->delete();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    public function fetchProfile(Request $request)
    {
        $user_id = $request->user_id;
        $row_result = DB::table('users')->where('id','=',$user_id)->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }
    
    
     public function updateUserProfile(Request $request)
    {
        $json = $request;
        $user_id = $request->user_id;
        $name = $request->name;
        $email = $request->email;
        $phone = $request->phone;
        $count_phone=DB::table('users')->where('phone','=',$phone)->where('id','!=',$user_id)->count();
        $count_email=DB::table('users')->where('email','=',$email)->where('id','!=',$user_id)->count();
        
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
                    'phone'=>$phone
                    );
                
                $dta=DB::table('users')->where('id','=',$user_id)->update($arr);
                $details=DB::table('users')->where('id','=',$user_id)->get();
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
    
    
    public function searchProduct(Request $request)
    {
        $product = $request->product;
        $row_result = DB::table('products')
        ->leftJoin('merchants', 'products.merchant_id', '=', 'merchants.id')
        ->select('products.*', 'merchants.name AS merchant_name')
        ->where('title','LIKE',"%{$product}%")
        ->orderBy('products.id', 'desc')
        ->get();
        $row_result = SearchProductCollection::collection($row_result);
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }

    public function filterProduct(Request $request)
    {
        $filter_by = $request->filter_by;
        $filters = ['low_to_high', 'high_to_low', 'popular'];
        $data = [];
        $row_result = [];
        
        switch($filter_by){
            case 'low_to_high': 
                $row_result = DB::table('product_details')
                ->join('products', 'product_details.product_id', '=', 'products.id')
                ->select('product_details.*', 'products.main_image AS main_image', 'products.title AS title', 'products.merchant_id AS merchant_id')
                ->orderBy('product_details.sale_price', 'asc')
                ->get();
                $data = FilterProductCollection::collection($row_result);
            break;

            case 'high_to_low':
                $row_result = DB::table('product_details')
                ->join('products', 'product_details.product_id', '=', 'products.id')
                ->select('product_details.*', 'products.main_image AS main_image', 'products.title AS title', 'products.merchant_id AS merchant_id')
                ->orderBy('product_details.sale_price', 'desc')
                ->get();
                $data = FilterProductCollection::collection($row_result);
            break;

            case 'popular':
                 $product_ids = DB::table('order_items')
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->select('order_items.product_id', DB::raw('COUNT(order_items.product_id) AS product_count'))
                ->orderBy('product_count', 'desc')
                ->groupBy('order_items.product_id')
                ->get()
                ->toArray();

                if(count($product_ids) > 0){
                    $product_ids = array_column($product_ids, 'product_id');
                    $row_result = DB::table('product_details')
                    ->join('products', 'product_details.product_id', '=', 'products.id')
                    ->select('product_details.*', 'products.main_image AS main_image', 'products.title AS title', 'products.merchant_id AS merchant_id')
                    ->whereIn('products.id', $product_ids)
                    ->orderBy('product_details.sale_price', 'desc')
                    ->get();
                    $data = FilterProductCollection::collection($row_result);
                }
                else{
                    $data = [];
                }
            break;
        }
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }
    
    

    public function ecommercebanners(Request $request)
    {
        $row_result = DB::table('ecommercebanners')->select('id', 'image')->orderBY('id','ASC')->get();
        $row_result = collect($row_result)->map(function($row) {
            $row->image = \asset('banner_image/'.$row->image);
            return $row;
        });

        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }

    public function placeOrder(Request $request){
        $user_id = $request->user_id;
        $delivery_address_id  = $request->delivery_address_id;
        $delivery_address = DB::table('address')->where('id','=',$delivery_address_id)->first();
        $landmark = !empty($delivery_address) ? $delivery_address->landmark: '';
        $sub_total = 0.00;
        $discount_amount = 0.00;
        $delivery_charge = 0.00;
        $total_amount = 0.00;
        $payment_type = $request->payment_type;
        $pickup_address = '';
        $delivery_name = '';
       
        if(!empty($request->delivery_name)){
            $delivery_type=DB::table('deliverytypes')->where('delivery_name','=',$request->delivery_name)->first();

            if(!empty($delivery_type)){
                $delivery_charge = $delivery_type->delivery_charge;
                $delivery_name = $request->delivery_name;
            }
        }
        else{
            $delivery_type=DB::table('deliverytypes')->where('delivery_name','=','Normal Delivery')->first();

            if(!empty($delivery_type)){
                $delivery_charge = $delivery_type->delivery_charge;
                $delivery_name = 'Normal Delivery';
            }
        }

        try{
            DB::beginTransaction();
            
            $cart_row=DB::table('carts')->where('user_id','=',$user_id)->get();
 
            $order_arr = array(
                'user_id'=> $user_id,
                'delivery_address_id' => $delivery_address_id,
                'delivery_address' => $delivery_address->address1,
                'delivery_name' => $delivery_name,
                'landmark' => $landmark,
                'order_no' => time(),
                'payment_type' => $payment_type,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );

            $order_id = DB::table('orders')->insertGetId($order_arr);

            foreach($cart_row as $cart_result)
            {
                $quantity=$cart_result->qty; 
                $price_details=DB::table('product_details')->where('id','=',$cart_result->size_id)
                                 ->where('product_id','=',$cart_result->product_id)->first();

                if(!empty($price_details)){
                        $sale_price=$price_details->sale_price; 
                        $sub_total+=$sale_price*$quantity;
                        
                        $product_row = DB::table('products')->where('id','=',$cart_result->product_id)->first();
                        $merchant_row=DB::table('merchants')->where('id','=',$product_row->merchant_id)->first();
                        $price_row=DB::table('product_details')->where('id','=',$cart_result->size_id)->first();
                        
                        $discount_amount += !empty($product_row) ? $product_row->discount: 0;
 
                        if(empty($pickup_address)) {
                            $shop = DB::table('shops')->where('merchant_id', $product_row->merchant_id)->first();
                            $pickup_address = !empty($shop) ? $shop->address: '';
                        }   
                        
                        $order_item_arr = array(
                            'user_id'=> $user_id,
                            'order_id'=> $order_id,
                            'product_id' => $cart_result->product_id,
                            'size_id' => $cart_result->size_id,
                            'merchant_id' => $product_row->merchant_id,
                            'qty' => $quantity,
                            'price' => $sale_price,
                            'product_name' => $product_row->title,
                            'size' => $price_row->attr_value,
                            'merchant_name' => $merchant_row->name,
                            'status' => 'active',
                            'created_at' => date('Y-m-d H:i:s'),
                            'updated_at' => date('Y-m-d H:i:s')
                        );
        
                        DB::table('order_items')->insert($order_item_arr);   
        
                        DB::table('product_details')->where('id','=',$cart_result->size_id)->update([
                            'stock' => $price_row->stock - $quantity
                        ]);
                    }
        
                    $total_amount = $sub_total - $discount_amount + $delivery_charge;
        
                    DB::table('orders')->where('id','=',$order_id)->update([
                        'pickup_address' => $pickup_address,
                        'sub_total' => $sub_total,
                        'discount_amount' => $discount_amount,
                        'delivery_charge' => $delivery_charge,
                        'total_amount' => $total_amount
                    ]);
                }

            DB::table('carts')->where('user_id','=',$user_id)->delete();

            DB::commit();

            return response()->json(['status' => true, 'message' => 'Success','data' => null]);
            
        }catch(\Exception $e){ 
            DB::rollBack();
            //throw new $e;
            return response()->json(['status' => false, 'message' => 'Error','data' => null,]);
        }
    }

    public function allUserOrders(Request $request){ 
        $data = [];
        $user_id = $request->user_id;
        $order_results = DB::table('orders')->where('user_id','=',$user_id)->orderBY('id','DESC')->get();

        foreach($order_results as $order_result){
            $order_item_result = DB::table('order_items')->where('order_id','=',$order_result->id)->first();
            $product_row = DB::table('products')->where('id','=',$order_item_result->product_id)->first();
            $data[] = array(
                'id' => $order_result->id,
                'user_id'=> $user_id,
                'order_no' => $order_result->order_no,
                'status' => $order_result->status,
                'date' => date('d.m.Y', strtotime($order_result->created_at)),
                'order_item' => (Object)
                    array(
                        'id' => $order_item_result->id,
                        'name' => $order_item_result->product_name,
                        'merchant_name' => $order_item_result->merchant_name,
                        'size' => $order_item_result->size,
                        'qty' => $order_item_result->qty,
                        'image' => \asset('product_image/'.$product_row->main_image)
                    )
            );
        }
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }

    public function userOrderDetails(Request $request){
        $user_id = $request->user_id;
        $order_id = $request->order_id;
        $order_items = [];

        $order_row = DB::table('orders')->where('id','=',$order_id)->first();
        $order_item_results = DB::table('order_items')->where('order_id','=',$order_id)->get();

        foreach($order_item_results as $order_item_result){
            $product_row = DB::table('products')->where('id','=',$order_item_result->product_id)->first();
            $image = \asset('product_image/'.$product_row->main_image);

            $order_items[] = array(
                  'id' => $order_item_result->id,
                  'product_id' => $order_item_result->product_id,
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
                'user_id'=> $user_id,
                'order_no' => $order_row->order_no,
                'delivery_address' =>  $order_row->delivery_address,
                'sub_total' =>  $order_row->sub_total,
                'discount_amount' =>  $order_row->discount_amount,
                'delivery_charge' =>  $order_row->delivery_charge,
                'total_amount' =>  $order_row->total_amount,
                'payment_type' =>  $order_row->payment_type,
                'status' => $order_row->status,
                'order_items' => $order_items,
                'order_date' => date('d.m.Y', strtotime($order_row->created_at)),
                'delivery_date' => !empty($order_row->delivery_date) ? date('d.m.Y', strtotime($order_row->delivery_date)) : ''
            );
        
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }

    public function topRatedProducts(){
        $product_ids = DB::table('ratings')
                                ->join('products', 'ratings.product_id', '=', 'products.id')
                                ->select('ratings.product_id')
                                ->orderBy('rating', 'desc')
                                ->groupBy('ratings.product_id')
                                ->get()
                                ->toArray();

        if(count($product_ids) > 0){
            $product_ids = array_column($product_ids, 'product_id');
            $row_result = DB::table('products')
            ->leftJoin('merchants', 'products.merchant_id', '=', 'merchants.id')
            ->select('products.*', 'merchants.name AS merchant_name')
            ->where('active','=','YES')
            ->whereIn('products.id', $product_ids)
            ->orderBy('products.id', 'desc')
            ->get();
            $row_result = NewProductCollection::collection($row_result);
            return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
        }

        return response()->json(['status' => true, 'message' => 'Success','data' => [],]);
    }

    public function productsOnSale(){
            $row_result = DB::table('products')
            ->leftJoin('merchants', 'products.merchant_id', '=', 'merchants.id')
            ->select('products.*', 'merchants.name AS merchant_name')
            ->where('products.discount','>', 0)
            ->orderBy('products.id', 'desc')
            ->get();
            $row_result = NewProductCollection::collection($row_result);
            return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }

    public function specificProduct(Request $request){
        $product_id = $request->product_id;
        $row_result = DB::table('products')
        ->leftJoin('merchants', 'products.merchant_id', '=', 'merchants.id')
        ->select('products.*', 'merchants.name AS merchant_name')
        ->where('products.id', $product_id)
        ->orderBy('products.id', 'desc')
        ->first();
        $row_result = !empty($row_result) ? new SpecificProductCollection($row_result): (Object)[];
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }

    public function allRatings($id){
        $ratings = DB::table('ratings')->where('product_id','=',$id)->orderBy('id', 'desc')->get();
        $ratings = RatingCollection::collection($ratings);
        return response()->json(['status' => true, 'message' => 'Success','data' => $ratings,]);
    }

    public function saveRating(Request $request){
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $review = $request->review;
        $rating = $request->rating;

        $ratings = DB::table('ratings')->where(['user_id' => $user_id, 'product_id' => $product_id])->first();

        $arr=array(
            'user_id'=>$user_id,
            'product_id'=>$product_id,
            'review'=>$review,
            'rating'=>$rating,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        );

        if(!empty($ratings)){
            DB::table('ratings')->where('id', $ratings->id)->update($arr);
        }
        else{
            DB::table('ratings')->insert($arr);
        }
        return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }

    public function searchHistory($id){
        $data = DB::table('customer_searches')->where('user_id', $id)->select('id', 'keyword')
                                              ->orderBy('id', 'desc')->take(10)->get();
        return response()->json(['status' => true, 'message' => 'Success','data' => $data,]);
    }

    public function saveHistory(Request $request){
        $user_id = $request->user_id;
        $keyword = $request->keyword;

        $search_history = DB::table('customer_searches')
                                ->where('user_id', $user_id)
                                ->where('keyword','LIKE',"%{$keyword}%")
                                ->first();

       if(empty($search_history)) {
            $arr=array(
                'user_id'=>$user_id,
                'keyword'=>$keyword,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
          DB::table('customer_searches')->insert($arr);
       }        
       return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }

    public function searchedProduct($id){
        $product_ids = DB::table('search_products')->where('user_id', $id)->pluck('product_id');
        
        $row_result = DB::table('products')
        ->leftJoin('merchants', 'products.merchant_id', '=', 'merchants.id')
        ->select('products.*', 'merchants.name AS merchant_name')
        ->where('active','=','YES')
        ->whereIn('products.id', $product_ids)
        ->orderBy('products.id', 'desc')
        ->get();

        $row_result = NewProductCollection::collection($row_result);
        return response()->json(['status' => true, 'message' => 'Success','data' => $row_result,]);
    }

    public function saveSearchedProduct(Request $request){
        $user_id = $request->user_id;
        $product_id = $request->product_id;

        $search_history = DB::table('search_products')->where(['user_id' => $user_id, 'product_id' => $product_id])->first();

       if(empty($search_history)) {
            $arr=array(
                'user_id'=>$user_id,
                'product_id'=>$product_id,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            );
          DB::table('search_products')->insert($arr);
       }        
       return response()->json(['status' => true, 'message' => 'Success','data' => null,]);
    }


    
}