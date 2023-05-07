<?php

namespace App\Http\Controllers;

use App\Models\ZonalFranchise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Hash;
use Auth;
use Mail;

class ZonalFranchiseController extends Controller
{
    public function __construct()
    {
        date_default_timezone_set('Asia/Kolkata');
    }
    public function index()
    {
        return view('zonal-franchise.index');
    }
    
    public function wallet()
    {
        return view('zonal-franchise.wallet');
    }

    public function login(Request $request)
    {
        if(Auth::guard('zonepartner')->attempt(['email'=>$request->email,'password'=>$request->password])){
            return redirect('/zonal-franchise/dashboard');
        }
        else{
            return redirect('/zonal-franchise')->withInput()->with('error', 'Invalid Credentials');
        }
    }

    public function dashboard()
    {
        return view('zonal-franchise.dashboard');
    }
    public function profile()
    {
        return view('zonal-franchise.profile');
    }

    public function update_profile(Request $request)
    {
            $result=array(
                'name'=>$request->name,
                'email'=>$request->email
            );
               $status = DB::table('zonepartners')
                  ->where('id', Auth::guard('zonepartner')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/zonal-franchise/profile')->with('success', 'Updated Successfully');
            }
            else{
                return redirect('/zonal-franchise/profile')->with('error', 'Something Went Wrong');
            }
           
    }
    public function change_password()
    {
        return view('zonal-franchise.change_password');
    }

    public function update_password(Request $request)
    {
            $result=array(
                'password'=>Hash::make($request->password)
            );
               $status = DB::table('zonepartners')
                  ->where('id', Auth::guard('zonepartner')->user()->id)
                  ->update($result);
    
            if($status==true){
                return redirect('/zonal-franchise/change-password')->with('success', 'Password Changed Successfully');
            }
            else{
                return redirect('/zonal-franchise/change-password')->with('error', 'Something Went Wrong');
            }
        
           
    }
    public function logout()
    {
        Auth::guard('zonepartner')->logout();
        return redirect('/zonal-franchise/');
    }

    //District Partner Section
    public function view_districtpartner()
    {
        return view('zonal-franchise.districtpartner.view');
    }
    public function create_districtpartner()
    {
        return view('zonal-franchise.districtpartner.create');
    }

    public function store_districtpartner(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:1000',
            'phone' => 'required|digits:10',
            'email'=> 'required|unique:districtpartners',
        ]);
        $imageName = date('Ymdhis').'.'.request()->image->getClientOriginalExtension();
        request()->image->move(public_path('user_image'), $imageName);

        if($request->password=='')
        {
            $new_password=$request->previous_password;
        }
        else
        {
            $new_password=$request->password;
        }
        $val=array(
            'zone_partner_id'=>Auth::guard('zonepartner')->user()->id,
            'district_id'=>$request->district_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($new_password),
            'image'=>$imageName,
            'wallet_balance' => 0,
            'active_status'=>'YES'
        );

       $affected = DB::table('districtpartners')->insert($val);
          
        if($affected==true)
        {
            return redirect('/zonal-franchise/districtpartner/create')->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/zonal-franchise/districtpartner/create')->with('error', 'Something Went Wrong');
        }
    }

    public function edit_districtpartner($id)
    {
        return view('zonal-franchise.districtpartner.update',compact('id'));
    }
    
    public function update_districtpartner(Request $request)
    {
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
            $new_password=$request->password;
        }
        $val=array(
            'district_id'=>$request->district_id,
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'password'=>Hash::make($new_password),
            'image'=>$imageName,
            'active_status'=>$request->active_status
        );

       $affected = DB::table('districtpartners')->where('id',$request->id)->update($val);
          
        if($affected==true)
        {
            return redirect('/zonal-franchise/districtpartner/edit/'.$request->id)->with('success', 'Inserted Successfully');
        }
        else
        {
            return redirect('/zonal-franchise/districtpartner/edit/'.$request->id)->with('error', 'Something Went Wrong');
        }
    }

    
    public function destroy_districtpartner(Request $request)
    {
        $previous_path=public_path().'/user_image/'.$request->image;
        if($request->image!='')
        {
            if(File::exists($previous_path)){
                unlink($previous_path);
            }
        } 

        $deleted = DB::table('districtpartners')->where('id',$request->id)->delete();
        if ($deleted==true) {
            return redirect('/zonal-franchise/districtpartner/')->with('success', 'Deleted Successfully');
        }
    }
    
    //Block Partner
    
    public function view_blockpartner()
    {
        return view('zonal-franchise.blockpartner.view');
    }
    public function view_employee()
    {
        return view('zonal-franchise.employee.view');
    }
    public function view_merchant()
    {
        return view('zonal-franchise.merchant.view');
    }
    
    
}