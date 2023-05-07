<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
/*use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;*/

class MerchantShopController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
   
    public function index()
    {
        return view('employee.merchant_shops.view');
    }

    public function create()
    {
        return view('employee.merchant_shops.create');
    }

    public function store(Request $request)
    { 
        try{
            Shop::create([
                'merchant_id'=> $request->merchant_id,
                "name" => $request->name,
                'address'=>$request->address,
                'lat'=>$request->lat,
                'long'=>$request->long,
                // 'status'=>$request->status,
                'status'=> 'active',
                'description'=>$request->description,
           ]);
           return redirect('/employee/merchant-shops/create')->with('success', 'Inserted Successfully');
        }catch(\Exception $e){
            return redirect('/employee/merchant-shops/create')->with('error', 'Something Went Wrong');
            //dd($e->getMessage());
        }
    }

    public function edit($id){
        return view('employee.merchant_shops.update',compact('id'));
    }

    public function show($id){

    }

    public function update(Request $request, $id){

    }

    public function updateShop(Request $request, $id){
        try{
            Shop::where('id', $id)->update([
                'merchant_id'=> $request->merchant_id,
                "name" => $request->name,
                'address'=>$request->address,
                'lat'=>$request->lat,
                'long'=>$request->long,
                //'status'=>$request->status,
                'description'=>$request->description,
           ]);
            return redirect('/employee/merchant-shops/'.$id.'/edit')->with('success', 'Inserted Successfully');
        }catch(\Exception $e){
            return redirect('/employee/merchant-shops/'.$id.'/edit')->with('error', 'Something Went Wrong');
            //dd($e->getMessage());
        }
    }

    public function deleteShop($id){
        try{
            Shop::where('id',$id)->update([
                'status'=>'inactive',
           ]);
           return redirect('/employee/merchant-shops/')->with('success', 'Deleted Successfully');
        }catch(\Exception $e){
            return redirect('/employee/merchant-shops/'.$id.'/edit')->with('error', 'Something Went Wrong');
            //dd($e->getMessage());
        }
    }

    public function destroy($id){
        
    }
}
